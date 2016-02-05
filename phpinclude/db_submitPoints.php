<?php
/*
 *  filename:       db_submitPoints.php
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
	if (isset($_POST['teamid'], $_SESSION['username'], $_SESSION['pw'], $_SESSION['usergroup']) && !empty($_POST['teamid']) && !empty($_SESSION['username']) && !empty($_SESSION['pw']) && !empty($_SESSION['usergroup'])) {
	    if ($_SESSION['usergroup'] == 10 || $_SESSION['usergroup'] == 99) {
		// Server-side data checks
		// check username
		$points = array();
		foreach ($_POST as $key => $value) {
		    $studentNum = substr($key, 1);
		    if (is_numeric($studentNum)) {

			if (strcasecmp(substr($key, 0, 1), "t") == 0) {
			    if ($value >= 0 && $value <= 5) {
				$points["$studentNum"]["Point_Team"] = $value;
			    } else {
				$data["msg"] = "One or more of the Team Points are out of range.  Team Points range between 0 and 5, while Bonus Points range between 0 and 3.";
				echo json_encode($data, JSON_FORCE_OBJECT);
				return;
			    }
			} elseif (strcasecmp(substr($key, 0, 1), "b") == 0) {
			    if ($value >= 0 && $value <= 3) {
				$points["$studentNum"]["Point_Bonus"] = $value;
			    } else {
				$data["msg"] = "One or more of the Bonus Points are out of range.  Team Points range between 0 and 5, while Bonus Points range between 0 and 3.";
				echo json_encode($data, JSON_FORCE_OBJECT);
				return;
			    }
			}
		    }
		}


		try {
		    $data["msg"] = "Team Roster Points Update Result:<br />";
		    $rowNum = 1;
		    foreach ($points as $sNum => $pp) {
			$stmtPoints = $conn->prepare("UPDATE Roster SET Point_Team = :PointTeam, Point_Bonus = :PointBonus WHERE Team_ID = :teamid AND StudentNo = :sNo");
			$stmtPoints->bindparam(':PointTeam', $pp["Point_Team"], PDO::PARAM_STR);
			$stmtPoints->bindparam(':PointBonus', $pp["Point_Bonus"], PDO::PARAM_INT);
			$stmtPoints->bindparam(':teamid', $_POST['teamid'], PDO::PARAM_INT);
			$stmtPoints->bindparam(':sNo', $sNum, PDO::PARAM_INT);
			$stmtPoints->execute();

			$affected = $stmtPoints->rowCount();

			if ($affected) {
			    $data["msg"] .= "row$rowNum: <b>Updated ( $sNum ) (Team: " . $pp["Point_Team"] . " ) (Bonus: " . $pp["Point_Bonus"] . " )</b><br />";
			} else {
			    $data["msg"] .= "row$rowNum: <i>No Change ( $sNum ) (Team: " . $pp["Point_Team"] . " ) (Bonus: " . $pp["Point_Bonus"] . " )</i><br />";
			}
			$rowNum++;
		    }
		} catch (PDOException $e) {
		    $data["msg"] = "Server Error - Please try again later.";
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

echo json_encode($data, JSON_FORCE_OBJECT);
?>

