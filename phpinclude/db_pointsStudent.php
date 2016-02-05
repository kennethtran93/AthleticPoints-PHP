<?php
/*
 *  filename:       db_pointsStudent.php
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
	if (isset($_GET['getReport'], $_SESSION['username'], $_SESSION['pw'], $_SESSION['usergroup']) && !empty($_GET['getReport']) && !empty($_SESSION['username']) && !empty($_SESSION['pw']) && !empty($_SESSION['usergroup'])) {
	    if ($_GET['getReport'] == "true") {
		if ($_SESSION['usergroup'] == 1 || $_SESSION['usergroup'] == 99) {
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
		    }
		    try {
			$stmtPoints = $conn->prepare("SELECT Season_Description, Sport, DivisionName, TeamSubset, Point_Team, Point_Bonus, Point_Team + Point_Bonus AS SumPoints FROM Student INNER JOIN Roster ON Student.StudentNo = Roster.StudentNo INNER JOIN Team on Roster.Team_ID = Team.Team_ID INNER JOIN Sport ON Team.Sport_ID = Sport.Sport_ID INNER JOIN Season ON Team.Season_ID = Season.Season_ID WHERE Roster.StudentNo = :StudentNo ORDER BY Season.Season_ID DESC, Sport");
			$stmtPoints->bindParam(":StudentNo", $studentID, PDO::PARAM_INT);
			$stmtPoints->execute();
			$studentPoints = $stmtPoints->fetchAll();

			$sumPoints = array_column($studentPoints, "SumPoints");

			$data = ["status" => "Success", "count" => count($studentPoints), "points" => $studentPoints, "sumPoints" => array_sum($sumPoints)];
		    } catch (PDOException $e) {
			$data = ["status" => "Fail", "msg" => "Server Error - Please try again later."];
		    }
		} else {
		    $data = ["status" => "Fail", "msg" => "User Request Restricted"];
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

