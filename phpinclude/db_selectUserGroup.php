<?php
/*
 *  filename:       db_selectUserGroup.php
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
	if (isset($_GET['getUserGroup'], $_SESSION['username'], $_SESSION['pw'], $_SESSION['usergroup']) && !empty($_GET['getUserGroup']) && !empty($_SESSION['username']) && !empty($_SESSION['pw']) && !empty($_SESSION['usergroup'])) {
	    if ($_GET['getUserGroup'] == "true") {
		try {
		    $stmtGroups = $conn->prepare("SELECT * FROM GroupRole");
		    $stmtGroups->execute();
		    $groups = $stmtGroups->fetchAll();

		    $data = ["status" => "Success", "groups" => $groups];
		} catch (PDOException $e) {
		    $data["msg"] = "Server Error - Please try again later.";
		}
	    } else {
		$data["msg"] = "Invalid Parameter Request";
	    }
	} else {
	    $data["msg"] = "Parameters Missing.";
	}
    } else {
	//$data["msg"] = "Only AJAX calls supported.";
	$data["msg"] = "Error:  Invalid Request.";
    }
} else {
    //$data["msg"] = "Error: Only GET requests allowed.";
    $data["msg"] = "Error:  Invalid Request.";
}

echo json_encode($data, JSON_FORCE_OBJECT);
?>

