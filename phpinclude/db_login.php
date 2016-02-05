<?php
/*
 *  filename:       db_login.php
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('config.php');
include_once('db.php');
$methodType = $_SERVER['REQUEST_METHOD'];
$data = ["status" => "Fail", "msg" => "$methodType"];

if ($methodType === "POST") {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	// AJAX call
	// Answer POST call and get data sent
	if (isset($_POST['login_token']) && !empty($_POST['login_token'])) {
	    if ($_POST['login_token'] != $_SESSION['LOGIN_FORM_TOKEN']) {
		$data = ["status" => "Fail", "msg" => "Error:  Invalid Form Submission.  Refresh the page and try again.", "session" => $_SESSION];
		echo json_encode($data, JSON_FORCE_OBJECT);
		return;
	    }
	} else {
	    $data = ["status" => "Fail", "msg" => "Error:  Missing Form Token.  Refresh the page and try again."];
	    echo json_encode($data, JSON_FORCE_OBJECT);
	    return;
	}

	if (isset($_POST['username'], $_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
	    // Server-side data checks
	    $data = ["msg" => "Error:  "];
	    if (strlen($_POST['username']) > 30 || strlen($_POST['username']) < 5) {
		$data = ["status" => "Fail", "msg" => $data['msg'] . "Incorrect length for username.  "];
	    }
	    if (strlen($_POST['password']) < 5) {
		$data = ["status" => "Fail", "msg" => $data['msg'] . "Incorrect length for password.  "];
	    }

	    if ($data['msg'] == "Error:  ") {
		// No errors found.
		$stmt;

		try {
		    $stmt = $conn->prepare("SELECT Username, UserPW, UserGroup, GroupName, GrantAccess FROM UserAccess INNER JOIN GroupRole ON UserAccess.UserGroup = GroupRole.RoleID WHERE Username = :username");

		    $stmt->bindparam(':username', $_POST['username'], PDO::PARAM_STR);

		    $stmt->execute();

		    $result = $stmt->fetch();

		    if ($result) {
			if ($result['GrantAccess']) {

			    $valid = password_verify($_POST['password'], $result['UserPW']);

			    if ($valid) {
				$detail;
				$stmt2;
				switch ($result['UserGroup']) {
				    case 1:
					$stmt2 = $conn->prepare("SELECT StudentNo AS ID, S_FirstName AS FirstName, S_LastName AS LastName FROM student WHERE Username = :username");
					break;
				    case 10:
					$stmt2 = $conn->prepare("SELECT Coach_ID AS ID, C_FirstName AS FirstName, C_LastName AS LastName FROM coach WHERE Username = :username");
					break;
				    case 99:
					$stmt2 = $conn->prepare("SELECT null AS ID, FirstName, LastName FROM UserAccess WHERE Username = :username");
					break;
				}
				$stmt2->bindparam(':username', $result['Username'], PDO::PARAM_STR);
				$stmt2->execute();
				$detail = $stmt2->fetch();
				if (session_status() == PHP_SESSION_NONE) {
				    session_start();
				}
				$_SESSION['username'] = $result['Username'];
				$_SESSION['pw'] = $result['UserPW'];
				$_SESSION['usergroup'] = $result['UserGroup'];
				$_SESSION['Group'] = $result['GroupName'];
				$_SESSION['UserID'] = $detail['ID'];
				$_SESSION['FirstName'] = $detail['FirstName'];
				$_SESSION['LastName'] = $detail['LastName'];

				$data = ["msg" => "Success", "session_ID" => session_id(), "detail" => $detail];
			    } else {
				// Password incorrect, but we'll give general result.
				$data = ["msg" => "Invalid Username or Password.  Please try again."];
			    }
			} else {
			    // Account disabled.
			    $data = ["msg" => "This account is locked.  Please contact your school's athletic director for assistance."];
			}
		    } else {
			// Username incorrect, but we'll give general result.
			$data = ["msg" => "Invalid Username or Password.  Please try again."];
		    }
		} catch (PDOException $e) {
		    $data = ["msg" => "Server Error - Please try again later."];
		}
	    }
	} else {
	    $data = ["msg" => "Error:  Parameter(s) missing."];
	}
    } else {
	//$data = ["msg" => "Only AJAX calls supported."];
	$data = ["msg" => "Error:  Invalid Request."];
    }
} else {
    //$data = ["msg" => "Error: Only POST requests allowed."];
    $data = ["msg" => "Error:  Invalid Request."];
}

echo json_encode($data, JSON_FORCE_OBJECT);
?>

