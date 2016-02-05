<?php
/*
 *  filename:       db_getTeamList.php
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

	if (isset($_GET['getReport'], $_SESSION['username'], $_SESSION['pw'], $_SESSION['usergroup']) && !empty($_GET['getReport']) && !empty($_SESSION['username']) && !empty($_SESSION['pw']) && !empty($_SESSION['usergroup'])) {
	    if ($_GET['getReport'] == "true") {
		if ($_SESSION['usergroup'] == 1 || $_SESSION['usergroup'] == 10 || $_SESSION['usergroup'] == 99) {
		    $ID;
		    if (!(isset($_GET['allTeams']) && !empty(['allTeams']) && $_GET['allTeams'] == "true")) {
			if ($_SESSION['usergroup'] == 1 || $_SESSION['usergroup'] == 10) {
			    if (isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
				$ID = $_SESSION['UserID'];
			    } else {
				$data = ["status" => "Fail", "msg" => "For some reason your ID was not properly retrieved.  Please logout and login again."];
				echo json_encode($data, JSON_FORCE_OBJECT);
				return;
			    }
			} elseif ($_SESSION['usergroup'] == 99) {
			    if (isset($_GET['StudentID']) && !empty($_GET['StudentID'])) {
				$ID = $_GET['StudentID'];
			    } elseif (isset($_GET['CoachID']) && !empty(['CoachID'])) {
				$ID = $_GET['CoachID'];
			    } else {
				$data = ["status" => "Fail", "msg" => "Missing ID - select someone from the dropdown list and try again"];
				echo json_encode($data, JSON_FORCE_OBJECT);
				return;
			    }
			}
		    }

		    try {
			$stmt;
			if (!(isset($_GET['allTeams']) && !empty(['allTeams']) && $_GET['allTeams'] == "true")) {
			    switch ($_SESSION['usergroup']) {
				case "1":
				    $stmt = $conn->prepare('SELECT t.Team_ID, Season_Description, s.Sport, DivisionName, TeamSubset FROM  team t INNER JOIN sport s ON t.sport_ID = s.sport_ID INNER JOIN season se ON t.Season_ID = se.Season_ID INNER JOIN roster r ON t.team_ID = r.team_ID WHERE r.studentNo = :ID ORDER BY se.Season_ID DESC, Sport');
				    break;
				case "10":
				    $stmt = $conn->prepare('SELECT t.Team_ID, Season_Description, s.Sport, DivisionName, TeamSubset FROM  team t INNER JOIN sport s ON t.sport_ID = s.sport_ID INNER JOIN season se ON t.Season_ID = se.Season_ID INNER JOIN coach_team ct ON t.team_ID = ct.team_ID WHERE ct.Coach_ID = :ID ORDER BY se.Season_ID DESC, Sport');
				    break;
				case "99":
				    if (isset($_GET['StudentID']) && !empty($_GET['StudentID'])) {
					$stmt = $conn->prepare('SELECT t.Team_ID, Season_Description, s.Sport, DivisionName, TeamSubset FROM  team t INNER JOIN sport s ON t.sport_ID = s.sport_ID INNER JOIN season se ON t.Season_ID = se.Season_ID INNER JOIN roster r ON t.team_ID = r.team_ID WHERE r.studentNo = :ID ORDER BY se.Season_ID DESC, Sport');
				    } elseif (isset($_GET['CoachID']) && !empty(['CoachID'])) {
					$stmt = $conn->prepare('SELECT t.Team_ID, Season_Description, s.Sport, DivisionName, TeamSubset FROM  team t INNER JOIN sport s ON t.sport_ID = s.sport_ID INNER JOIN season se ON t.Season_ID = se.Season_ID INNER JOIN coach_team ct ON t.team_ID = ct.team_ID WHERE ct.Coach_ID = :ID ORDER BY se.Season_ID DESC, Sport');
				    }
				    break;
			    }
			    $stmt->bindparam(':ID', $ID, PDO::PARAM_INT);
			} else {
			    $stmt = $conn->prepare('SELECT t.Team_ID, Season_Description, s.Sport, DivisionName, TeamSubset FROM  team t INNER JOIN sport s ON t.sport_ID = s.sport_ID INNER JOIN season se ON t.Season_ID = se.Season_ID ORDER BY se.Season_ID DESC, Sport');
			}
			$stmt->execute(); //execute the query  

			$result = $stmt->fetchAll();
			$data = ["status" => "Success", "count" => count($result), "teams" => $result]; //create the array  
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




//built in PHP function to encode the data in to JSON format  
echo json_encode($data, JSON_FORCE_OBJECT);
?>