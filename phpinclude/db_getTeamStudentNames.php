<?php
/*
 *  filename:       db_getTeamStudentNames.php
 */


include_once('config.php');
include_once('db.php');
$methodType = $_SERVER['REQUEST_METHOD'];
$data = ["msg" => "$methodType"];
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['last_active'] = time();

if ($methodType === "GET") {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	// AJAX call
	// Answer GET call and get data sent

	if (isset($_GET['getTeammates'], $_SESSION['username'], $_SESSION['pw'], $_SESSION['usergroup']) && !empty($_GET['getTeammates']) && !empty($_SESSION['username']) && !empty($_SESSION['pw']) && !empty($_SESSION['usergroup'])) {
	    if ($_GET['getTeammates'] == "true") {
		if ($_SESSION['usergroup'] == 1 || $_SESSION['usergroup'] == 10 || $_SESSION['usergroup'] == 99) {
		    try {
			$list = $conn->prepare('SELECT r.StudentNo, S_FirstName, S_LastName FROM student s INNER JOIN roster r ON s.StudentNo = r.StudentNo INNER JOIN team t ON r.Team_ID = t.Team_ID WHERE r.Team_ID = :TeamID ORDER BY S_FirstName, S_LastName ASC');
			$list->bindParam(":TeamID", $_GET['teamid'], PDO::PARAM_INT);
			$list->execute(); //execute the query  

			$result = $list->fetchAll();
			$data = ["status" => "Success", "count" => count($result), "names" => $result]; //create the array  
		    } catch (Exception $ex) {
			$data = ["status" => "Fail", "msg" => "Server Error - Please try again later."];
		    }
		} else {
		    $data = ["status" => "Fail", "msg" => "User Request Restricted"];
		}
	    } else {
		$data = ["status" => "Fail", "msg" => "Invalid Parameter Request"];
	    }
	} else {
	    $data = ["status" => "Fail", "msg" => "Parameter missing"];
	}
    } else {
	//$data = ["msg" => "Only AJAX calls supported."];
	$data = ["status" => "Fail", "msg" => "Error:  Invalid Request."];
    }
} else {
    //$data = ["msg" => "Error: Only GET requests allowed."];
    $data = ["status" => "Fail", "msg" => "Error:  Invalid Request."];
}




//built in PHP function to encode the data in to JSON format  
echo json_encode($data, JSON_FORCE_OBJECT);
?>