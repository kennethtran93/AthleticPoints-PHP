<?php
/*
 *  filename:       db_changeAccount.php
 */

include_once('config.php');
include_once('db.php');
$methodType = $_SERVER['REQUEST_METHOD'];
$data = ["status" => "Fail", "msg" => "$methodType"];
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['last_active'] = time();

if ($methodType === "POST") {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
// AJAX call
// Answer POST call and get data sent
	if (isset($_POST['curUsername'], $_POST['curPassword']) && !empty($_POST['curUsername']) && !empty($_POST['curPassword'])) {
	    // Server-side data checks
	    if (strcasecmp($_POST['curUsername'], $_SESSION['username']) == 0 && password_verify($_POST['curPassword'], $_SESSION['pw'])) {
		// Current user validated
		// check username
		if (isset($_POST['newUsername'], $_POST['newUsername2']) && !empty($_POST['newUsername']) && !empty($_POST['newUsername2'])) {
		    // New Username field value exists
		    if (strcasecmp($_POST['newUsername'], $_POST['newUsername2']) == 0) {
			// string matches
			if (strlen($_POST['newUsername2']) > 30 || strlen($_POST['newUsername2']) < 5) {
			    $data["msg"] = "Error:  Incorrect length for username.<br />";
			} else {
			    // valid new username
			    $data["msg"] = "Username passed validation.<br />";
			    $data["validUsername"] = TRUE;
			}
		    } else {
			$data["msg"] = "Error:  New Username Fields Mismatch.<br />";
		    }
		} else {
		    // No new username given
		    $data["msg"] = "Username remains the same.<br />";
		    $data["validUsername"] = FALSE;
		}

		// Check Password
		if (isset($_POST['newPassword'], $_POST['newPassword2']) && !empty($_POST['newPassword']) && !empty($_POST['newPassword2'])) {

		    // New Password field value exists
		    if (strcasecmp($_POST['newPassword'], $_POST['newPassword2']) == 0) {
			// string matches
			if (strlen($_POST['newPassword2']) < 5) {
			    $data["msg"] .= "Error:  Incorrect length for password.";
			} else {
			    // new Password is valid
			    $data["msg"] .= "Password passed validation.";
			    $data["validPassword"] = TRUE;
			}
		    } else {
			$data["msg"] .= "Error:  New Password Fields Mismatch.";
		    }
		} else {
		    // No new password given
		    $data["msg"] .= "Password remains the same.  ";
		    $data["validPassword"] = FALSE;
		}

		// values should already exist as it's done server-side, but just in case.  Also only run if at least one of the values is true
		// Can't use empty() as FALSE is considered empty.
		if (isset($data["validUsername"], $data["validPassword"]) && ($data["validUsername"] || $data["validPassword"])) {

		    try {
			$stmtChange;
			if ($data['validUsername'] && $data['validPassword']) {
			    // Change both username and password
			    $stmtChange = $conn->prepare("UPDATE UserAccess SET Username = :newUsername, UserPW = :newPassword, LastUpdated = NOW() WHERE Username = :oldUsername");
			    $stmtChange->bindparam(':newUsername', $_POST['newUsername2'], PDO::PARAM_STR);
			    $stmtChange->bindparam(':newPassword', password_hash($_POST['newPassword2'], PASSWORD_DEFAULT), PDO::PARAM_STR);
			} else if ($data['validUsername'] && !$data['validPassword']) {
			    // Only username change
			    $stmtChange = $conn->prepare("UPDATE UserAccess SET Username = :newUsername, LastUpdated = NOW() WHERE Username = :oldUsername");
			    $stmtChange->bindparam(':newUsername', $_POST['newUsername2'], PDO::PARAM_STR);
			} else {
			    // Only Password Change
			    $stmtChange = $conn->prepare("UPDATE UserAccess SET UserPW = :newPassword, LastUpdated = NOW() WHERE Username = :oldUsername");
			    $stmtChange->bindparam(':newPassword', password_hash($_POST['newPassword2'], PASSWORD_DEFAULT), PDO::PARAM_STR);
			}

			$stmtChange->bindparam(':oldUsername', $_SESSION['username'], PDO::PARAM_STR);
			$stmtChange->execute();

			$affected = $stmtChange->rowCount();

			if ($affected) {
			    $data["status"] = "Success";
			    $data["msg"] = "User Account was successfully updated.";
			} else {
			    $data["msg"] = "Sorry, we couldn't update your user account at the moment - Please try again later.";
			}
		    } catch (PDOException $e) {
			if ($e->getCode() == 23000) {
			    $data["msg"] = "Username already taken.  Type in another username and try again.";
			} else {
			    $data["msg"] = "Server Error - Please try again later.";
			}
		    }
		} else {
		    // No new username or password to update
		    $data["msg"] = "No new changes detected.  Username and Password fields are both empty.";
		}
	    } else {
		$data["msg"] = "Error:  Current User Validation Failed.";
	    }
	} else {
	    $data["msg"] = "Error:  Parameter(s) missing.";
	}
    } else {
	//$data = ["msg" => "Only AJAX calls supported."];
	$data["msg"] = "Error:  Invalid Request.";
    }
} else {
    //$data = ["msg" => "Error: Only POST requests allowed."];
    $data["msg"] = "Error:  Invalid Request.";
}

unset($data['validUsername']);
unset($data['validPassword']);
echo json_encode($data, JSON_FORCE_OBJECT);
?>

