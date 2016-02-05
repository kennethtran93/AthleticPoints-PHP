<?php
/*
 *  filename:       db_regUser.php
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
	if (isset($_POST['post_form_token']) && !empty($_POST['post_form_token'])) {
	    if ($_POST['post_form_token'] != $_SESSION['POST_FORM_TOKEN']) {
		$data = ["status" => "Fail", "msg" => "Error:  Invalid Form Submission.  Refresh the page and try again."];
		echo json_encode($data, JSON_FORCE_OBJECT);
		return;
	    }
	} else {
	    $data = ["status" => "Fail", "msg" => "Error:  Missing Form Token.  Refresh the page and try again."];
	    echo json_encode($data, JSON_FORCE_OBJECT);
	    return;
	}

	if (isset($_POST['txtEmail'], $_POST['txtUsername'], $_POST['txtPassword'], $_POST['txtPasswordAgain'], $_POST['txtID'], $_POST['selectUserType']) && !empty($_POST['txtEmail']) && !empty($_POST['txtUsername']) && !empty($_POST['txtPassword']) && !empty($_POST['txtPasswordAgain']) && !empty($_POST['txtID']) && !empty($_POST['selectUserType'])) {
	    // Server-side data checks
	    $data = ["msg" => "Error:  "];
	    if (strlen($_POST['txtUsername']) > 30 || strlen($_POST['txtUsername']) < 5) {
		$data = ["msg" => $data['msg'] . "Incorrect length for username.  "];
	    }
	    if (strlen($_POST['txtPassword']) < 5) {
		$data = ["msg" => $data['msg'] . "Incorrect length for password.  "];
	    }
	    if (strcmp($_POST['txtPassword'], $_POST['txtPasswordAgain'])) {
		$data = ["msg" => $data['msg'] . "Password does not match.  "];
	    }

	    if ($data['msg'] == "Error:  ") {
		// No errors found.
		$stmt;

		try {
		    if ($_POST['selectUserType'] === "Coach") {
			$stmt = $conn->prepare("CALL LoginLinkCoach(:username, :password, :id, :email)");
		    } else if ($_POST['selectUserType'] === "Student") {
			$stmt = $conn->prepare("CALL LoginLinkStudent(:username, :password, :id, :email)");
		    } else {
			$data = ["status" => "Fail", "msg" => "Error: Incorrect User Role specified."];
			echo json_encode($data, JSON_FORCE_OBJECT);
			return;
		    }

		    $stmt->bindparam(':id', $_POST['txtID'], PDO::PARAM_INT);
		    $stmt->bindparam(':username', $_POST['txtUsername'], PDO::PARAM_STR);
		    $stmt->bindparam(':password', password_hash($_POST['txtPassword'], PASSWORD_DEFAULT), PDO::PARAM_STR);
		    $stmt->bindparam(':email', $_POST['txtEmail'], PDO::PARAM_STR);

		    $result = $stmt->execute();

		    if ($result) {
			$data = ["status" => "Fail", "msg" => "User Account Registration Successful.  You may now login to the system with the username and password that you provided earlier."];
		    } else {
			$data = ["status" => "Fail", "msg" => "User Account Registration Failed. Please try again, or contact your school's Athletic Director for assistance."];
		    }
		} catch (PDOException $e) {
		    if ($e->getCode() == 23000) {
			$data = ["status" => "Fail", "msg" => "Username already taken.  Type in another username and try again."];
		    } else {
			$data = ["status" => "Fail", "msg" => "Server Error - Please try again later."];
		    }
		}
	    }
	} else {
	    $data = ["status" => "Fail", "msg" => "Error:  Parameter(s) missing."];
	}
    } else {
	//$data = ["msg" => "Only AJAX calls supported."];
	$data = ["status" => "Fail", "msg" => "Error:  Invalid Request."];
    }
} else {
    //$data = ["msg" => "Error: Only POST requests allowed."];
    $data = ["status" => "Fail", "msg" => "Error:  Invalid Request."];
}

echo json_encode($data, JSON_FORCE_OBJECT);
?>

