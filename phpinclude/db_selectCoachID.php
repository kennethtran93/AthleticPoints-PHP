<?php
/*
 *  filename:       db_selectCoachID.php
 */

include_once('config.php');
include_once('db.php');
$methodType = $_SERVER['REQUEST_METHOD'];
$data = ["status" => "Fail", "msg" => "$methodType"];
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['last_active'] = time();

if ($methodType === "GET") {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	// AJAX call
	// Answer GET call and get data sent
	if (isset($_GET['getCoachList'], $_SESSION['username'], $_SESSION['pw'], $_SESSION['usergroup']) && !empty($_GET['getCoachList']) && !empty($_SESSION['username']) && !empty($_SESSION['pw']) && !empty($_SESSION['usergroup'])) {
	    if ($_GET['getCoachList'] == "true") {
		$coachList;
		try {
		    $stmtCoaches = $conn->prepare("SELECT CONCAT(C_LastName, ', ', C_FirstName) AS FullName, Coach_ID FROM Coach ORDER BY FullName");
		    $stmtCoaches->execute();
		    $coachList = $stmtCoaches->fetchAll();

		    $data = ["status" => "Success", "count" => count($coachList), "list" => $coachList];
		} catch (PDOException $e) {
		    $data = ["status" => "Fail", "msg" => "Server Error - Please try again later."];
		}
	    } else {
		$data = ["status" => "Fail", "msg" => "Invalid Parameter Request"];
	    }
	} else {
	    $data = ["status" => "Fail", "msg" => "Parameters Missing."];
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

