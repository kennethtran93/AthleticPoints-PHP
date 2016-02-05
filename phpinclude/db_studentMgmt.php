<?php
/*
 *  filename:       db_studentMgmt.php
 */

include_once('config.php');
include_once('db.php');
$methodType = $_SERVER['REQUEST_METHOD'];
$data = ["status" => "Fail", "msg" => "$methodType"];
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['last_active'] = time();

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
// AJAX call
    if ($methodType === "GET") {
// Answer GET call and get data sent
// To get student Profile Info
	$studentID;
	if ($_SESSION['usergroup'] == 1) {
	    if (isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
		$studentID = $_SESSION['UserID'];
	    } else {
		$data = ["status" => "Fail", "msg" => "For some reason your student ID was not properly retrieved.  Please logout and login again."];
		echo json_encode($data, JSON_FORCE_OBJECT);
		return;
	    }
	} elseif ($_SESSION['usergroup'] == 99) {
	    if (isset($_GET['StudentID']) && !empty($_GET['StudentID'])) {
		$studentID = $_GET['StudentID'];
	    } else {
		$data = ["status" => "Fail", "msg" => "Missing Student ID - select a student from the dropdown list and try again"];
		echo json_encode($data, JSON_FORCE_OBJECT);
		return;
	    }
	} else {
	    $data = ["status" => "Fail", "msg" => "User Request Restricted"];
	    echo json_encode($data, JSON_FORCE_OBJECT);
	    return;
	}
	try {
	    $profile = $conn->prepare("SELECT studentNo, S_FirstName AS firstName, S_LastName as lastName, homeroom, gender, S_BirthDate AS DOB, S_Email AS email, S_CellNumber AS mobileNumber, S_HomeNumber AS homeNumber FROM Student WHERE StudentNo = :studentNo");
	    $profile->bindParam(":studentNo", $studentID, PDO::PARAM_INT);
	    $profile->execute();

	    $result = $profile->fetch();
	    $data = ["status" => "Success", "profile" => $result];
	    echo json_encode($data);
	    return;
	} catch (PDOException $e) {
	    $data["msg"] = "Server Error - Please try again later.";
	}
    } else if ($methodType === "POST") {
// Answer POST call and get data sent
// To update student Profile Info
	$updateProfile;
	$studentID;
	if ($_SESSION['usergroup'] == 1) {
	    if (isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
		$studentID = $_SESSION['UserID'];
	    } else {
		$data = ["status" => "Fail", "msg" => "For some reason your student ID was not properly retrieved.  Please logout and login again."];
		echo json_encode($data, JSON_FORCE_OBJECT);
		return;
	    }
	    $updateProfile = $conn->prepare("UPDATE Student SET S_Email = :email, S_CellNumber = :mobile, S_HomeNumber = :home WHERE StudentNo = :studentNo");
	} elseif ($_SESSION['usergroup'] == 99) {
	    if (isset($_POST['oldStudentNo']) && !empty($_POST['oldStudentNo'])) {
		$studentID = $_POST['oldStudentNo'];
	    } else {
		$data = ["status" => "Fail", "msg" => "Missing Student ID - select a student from the dropdown list and try again"];
		echo json_encode($data, JSON_FORCE_OBJECT);
		return;
	    }
	    $updateProfile = $conn->prepare("UPDATE Student SET StudentNo = :newStudentNo, S_FirstName = :firstName, S_LastName = :lastName, Homeroom = :homeroom, Gender = :gender, S_Birthdate = :dob, S_Email = :email, S_CellNumber = :mobile, S_HomeNumber = :home WHERE StudentNo = :studentNo");

	    $updateProfile->bindParam(":newStudentNo", $_POST['studentNo'], PDO::PARAM_INT);
	    $updateProfile->bindParam(":firstName", $_POST['firstName'], PDO::PARAM_STR);
	    $updateProfile->bindParam(":lastName", $_POST['lastName'], PDO::PARAM_STR);
	    $updateProfile->bindParam(":homeroom", $_POST['homeroom'], PDO::PARAM_STR);
	    $updateProfile->bindParam(":gender", $_POST['gender'], PDO::PARAM_STR);
	    $updateProfile->bindParam(":dob", $_POST['DOB'], PDO::PARAM_STR);
	} else {
	    $data = ["status" => "Fail", "msg" => "User Request Restricted"];
	    echo json_encode($data, JSON_FORCE_OBJECT);
	    return;
	}

	$updateProfile->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
	$updateProfile->bindParam(":mobile", $_POST['mobileNumber'], PDO::PARAM_STR);
	$updateProfile->bindParam(":home", $_POST['homeNumber'], PDO::PARAM_STR);
	$updateProfile->bindParam(":studentNo", $studentID, PDO::PARAM_INT);
	

	$updateProfile->execute();

	$affected = $updateProfile->rowCount();

	$data["status"] = "Success";
	if ($affected) {
	    $data['msg'] = "Student Profile Updated.";
	} else {
	    $data['msg'] = "No changes were detected.";
	}
	
    } else {
//$data = ["msg" => "Error: Only GET or POST requests allowed."];
	$data = ["msg" => "Error:  Invalid Request."];
    }
} else {
//$data = ["msg" => "Only AJAX calls supported."];
    $data = ["msg" => "Error:  Invalid Request."];
}


echo json_encode($data, JSON_FORCE_OBJECT);
?>

