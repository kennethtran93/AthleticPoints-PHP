<?php
/*
 *  filename:       db_editAccount.php
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
	if (isset($_POST['oldUsername'], $_POST['name'], $_SESSION['username'], $_SESSION['pw'], $_SESSION['usergroup']) && !empty($_POST['oldUsername']) && !empty($_POST['name']) && !empty($_SESSION['username']) && !empty($_SESSION['pw']) && !empty($_SESSION['usergroup'])) {
	    if ($_SESSION['usergroup'] == 99) {
		// Server-side data checks
		// check username
		if (isset($_POST['editUsername']) && !empty($_POST['editUsername'])) {
		    // New Username field value exists
		    if (strlen($_POST['editUsername']) > 30 || strlen($_POST['editUsername']) < 5) {
			$data["msg"] = "Error:  Incorrect length for username.<br />";
		    } else {
			// valid new username
			$data["msg"] = "Username passed validation.<br />";
			$data["validUsername"] = TRUE;
		    }
		} else {
		    // No new username given
		    $data["msg"] = "Username remains the same.<br />";
		    $data["validUsername"] = FALSE;
		}

		// Check Password
		if (isset($_POST['editPassword']) && !empty($_POST['editPassword'])) {

		    // New Password field value exists
		    if (strlen($_POST['editPassword']) < 5) {
			$data["msg"] .= "Error:  Incorrect length for password.";
		    } else {
			// new Password is valid
			$data["msg"] .= "Password passed validation.";
			$data["validPassword"] = TRUE;
		    }
		} else {
		    // No new password given
		    $data["msg"] .= "Password remains the same.  ";
		    $data["validPassword"] = FALSE;
		}

		// check Access Status
		$access;
		if (isset($_POST['editAccess'])) {
		    // Access granted - checkbox returns "on"
		    $access = 1;
		} else {
		    $access = 0;
		}

		try {
		    $stmtChange;
		    if ($data['validUsername'] && $data['validPassword']) {
			// Change both username and password (and access)
			$stmtChange = $conn->prepare("UPDATE UserAccess SET Username = :newUsername, UserPW = :newPassword, LastUpdated = NOW(), GrantAccess = :access WHERE Username = :oldUsername");
			$stmtChange->bindparam(':newUsername', $_POST['editUsername'], PDO::PARAM_STR);
			$stmtChange->bindparam(':newPassword', password_hash($_POST['editPassword'], PASSWORD_DEFAULT), PDO::PARAM_STR);
		    } else if ($data['validUsername'] && !$data['validPassword']) {
			// Only username change (and access)
			$stmtChange = $conn->prepare("UPDATE UserAccess SET Username = :newUsername, LastUpdated = NOW(), GrantAccess = :access WHERE Username = :oldUsername");
			$stmtChange->bindparam(':newUsername', $_POST['editUsername'], PDO::PARAM_STR);
		    } else if (!$data['validUsername'] && $data['validPassword']) {
			// Only Password Change (and access)
			$stmtChange = $conn->prepare("UPDATE UserAccess SET UserPW = :newPassword, LastUpdated = NOW(), GrantAccess = :access WHERE Username = :oldUsername");
			$stmtChange->bindparam(':newPassword', password_hash($_POST['editPassword'], PASSWORD_DEFAULT), PDO::PARAM_STR);
		    } else {
			// Access change only
			$stmtChange = $conn->prepare("UPDATE UserAccess SET LastUpdated = NOW(), GrantAccess = :access WHERE Username = :oldUsername");
		    }

		    $stmtChange->bindparam(':access', $access, PDO::PARAM_INT);
		    $stmtChange->bindparam(':oldUsername', $_POST['oldUsername'], PDO::PARAM_STR);

		    $stmtChange->execute();

		    $affected = $stmtChange->rowCount();

		    if ($affected) {
			$data["status"] = "Success";
			$data["msg"] = "User Account for " . $_POST['name'] . " was successfully updated.";
		    } else {
			$data["msg"] = "Sorry, we couldn't update that person's account at the moment - Please try again later.";
		    }
		} catch (PDOException $e) {
		    if ($e->getCode() == 23000) {
			$data["msg"] = "Username already taken.  Type in another username and try again.";
		    } else {
			$data["msg"] = "Server Error - Please try again later.";
		    }
		}
	    } else {
		$data["msg"] = "Error:  User Request Restricted";
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

