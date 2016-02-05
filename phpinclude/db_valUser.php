<?php
/*
 *  filename:       db_valUser.php
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('config.php');
include_once('db.php');
$methodType = $_SERVER['REQUEST_METHOD'];
$data = ["msg" => "$methodType"];

if ($methodType === "GET") {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	// AJAX call
	// Answer GET call and get data sent

	if (isset($_GET['form_token']) && !empty($_GET['form_token'])) {
	    if ($_GET['form_token'] != $_SESSION['GET_FORM_TOKEN']) {
		$data = ["status" => "Fail", "msg" => "Error:  Invalid Form Submission.  Refresh the page and try again."];
		echo json_encode($data, JSON_FORCE_OBJECT);
		return;
	    }
	} else {
	    $data = ["status" => "Fail", "msg" => "Error:  Missing Form Token.  Refresh the page and try again."];
	    echo json_encode($data, JSON_FORCE_OBJECT);
	    return;
	}

	if (isset($_GET['txtID'], $_GET['txtFirstName'], $_GET['txtLastName'], $_GET['selectUserType']) && !empty($_GET['txtID']) && !empty($_GET['txtFirstName']) && !empty($_GET['txtLastName']) && !empty($_GET['selectUserType'])) {
	    // valid data
	    $stmt;
	    try {
		if ($_GET['selectUserType'] === "Coach") {
		    $stmt = $conn->prepare("CALL ValidateCoachRecord(:id, :lname, :fname, @Valid, @registered)");
		} else if ($_GET['selectUserType'] === "Student") {
		    $stmt = $conn->prepare("CALL ValidateStudentRecord(:id, :lname, :fname, @Valid, @registered)");
		} else {
		    $data = ["status" => "Fail", "msg" => "Error:  Incorrect User Role specified."];
		    echo json_encode($data, JSON_FORCE_OBJECT);
		    return;
		}
		$stmt->bindparam(':id', $_GET['txtID'], PDO::PARAM_INT);
		$stmt->bindparam(':lname', $_GET['txtLastName'], PDO::PARAM_STR);
		$stmt->bindparam(':fname', $_GET['txtFirstName'], PDO::PARAM_STR);
		$stmt->execute();

		$result = $conn->query("SELECT @Valid, @registered")->fetch();
		$data = ["status" => "Success", "valid" => $result['@Valid'], "registered" => $result['@registered']];
	    } catch (PDOException $e) {
		$data = ["status" => "Fail", "msg" => "Server Error - Please try again later."];
	    }
	} else {
	    $data = ["status" => "Fail", "msg" => "Error:  Parameter(s) missing."];
	}
    } else {
	//$data = ["msg" => "Only AJAX calls supported."];
	$data = ["status" => "Fail", "msg" => "Error:  Invalid Request."];
    }
} else {
    //$data = ["msg" => "Error: Only GET requests allowed."];
    $data = ["status" => "Fail", "msg" => "Error:  Invalid Request."];
}

echo json_encode($data, JSON_FORCE_OBJECT);
?>

