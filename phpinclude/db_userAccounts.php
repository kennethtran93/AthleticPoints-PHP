<?php
/*
 *  filename:       db_userAcounts.php
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
	if (isset($_GET['getData'], $_GET['group'], $_SESSION['username'], $_SESSION['pw'], $_SESSION['usergroup']) && !empty($_GET['getData']) && !empty($_GET['group']) && !empty($_SESSION['username']) && !empty($_SESSION['pw']) && !empty($_SESSION['usergroup'])) {
	    if ($_GET['getData'] == "true") {
		if ($_SESSION['usergroup'] == 99) {
		    try {
			$stmtUsers;
			if ($_GET['group'] == 1) {
			    $stmtUsers = $conn->prepare("SELECT null AS control, S_LastName AS LastName, S_FirstName AS FirstName, StudentNo AS ID, UserAccess.Username, GrantAccess, DateRegistered, LastUpdated FROM UserAccess INNER JOIN Student ON UserAccess.Username = Student.Username WHERE UserGroup = :group ORDER BY LastName, FirstName");
			} elseif ($_GET['group'] == 10) {
			    $stmtUsers = $conn->prepare("SELECT null AS control, C_LastName AS LastName, C_FirstName AS FirstName, Coach_ID AS ID, UserAccess.Username, GrantAccess, DateRegistered, LastUpdated FROM UserAccess INNER JOIN Coach ON UserAccess.Username = Coach.Username WHERE UserGroup = :group ORDER BY LastName, FirstName");
			} elseif ($_GET['group'] == 99) {
			    $stmtUsers = $conn->prepare("SELECT null AS control, LastName, FirstName, NULL AS ID, Username, GrantAccess, DateRegistered, LastUpdated FROM UserAccess WHERE UserGroup = :group ORDER BY LastName, FirstName");
			} else {
			    $data["msg"] = "Invalid User Group";
			}

			$stmtUsers->bindParam(":group", $_GET['group'], PDO::PARAM_INT);
			$stmtUsers->execute();
			$accounts = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

			$data = ["status" => "Success", "count" => count($accounts), "accounts" => $accounts];
		    } catch (PDOException $e) {
			$data["msg"] = "Server Error - Please try again later.";
		    }
		} else {
		    $data["msg"] = "User Request Restricted";
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

echo json_encode($data);
?>

