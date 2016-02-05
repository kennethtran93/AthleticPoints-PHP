<?php
/*
 *  filename:       db_pointsReport.php
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
	if (isset($_GET['getReport']) && !empty($_GET['getReport'])) {
	    if ($_GET['getReport'] == "true") {
		$smallT;
		$bigT;
		$silverM;
		$goldM;
		try {
		    $stmt30 = $conn->prepare("SELECT Student.StudentNo, S_LastName AS LastName, S_FirstName AS FirstName, Homeroom, Gender, SUM(Point_Team + Point_Bonus) AS SumPoints FROM Roster INNER JOIN Student on Roster.StudentNo = Student.StudentNo GROUP BY Student.StudentNo, LastName, FirstName, Homeroom, Gender HAVING (SumPoints >= 30) AND (SumPoints < 45) ORDER BY LastName, FirstName");
		    $stmt30->execute();
		    $smallT = $stmt30->fetchAll();

		    $stmt45 = $conn->prepare("SELECT Student.StudentNo, S_LastName AS LastName, S_FirstName AS FirstName, Homeroom, Gender, SUM(Point_Team + Point_Bonus) AS SumPoints FROM Roster INNER JOIN Student on Roster.StudentNo = Student.StudentNo GROUP BY Student.StudentNo, LastName, FirstName, Homeroom, Gender HAVING (SumPoints >= 45) AND (SumPoints < 59) ORDER BY LastName, FirstName");
		    $stmt45->execute();
		    $bigT = $stmt45->fetchAll();

		    $stmt60 = $conn->prepare("SELECT Student.StudentNo, S_LastName AS LastName, S_FirstName AS FirstName, Homeroom, Gender, SUM(Point_Team + Point_Bonus) AS SumPoints FROM Roster INNER JOIN Student on Roster.StudentNo = Student.StudentNo GROUP BY Student.StudentNo, LastName, FirstName, Homeroom, Gender HAVING (SumPoints >= 60) AND (SumPoints < 74) ORDER BY LastName, FirstName");
		    $stmt60->execute();
		    $silverM = $stmt60->fetchAll();

		    $stmt75 = $conn->prepare("SELECT Student.StudentNo, S_LastName AS LastName, S_FirstName AS FirstName, Homeroom, Gender, SUM(Point_Team + Point_Bonus) AS SumPoints FROM Roster INNER JOIN Student on Roster.StudentNo = Student.StudentNo GROUP BY Student.StudentNo, LastName, FirstName, Homeroom, Gender HAVING (SumPoints >= 75) ORDER BY LastName, FirstName");
		    $stmt75->execute();
		    $goldM = $stmt75->fetchAll();

		    $data = ["status" => "Success", "smallTcount" => count($smallT), "smallT" => $smallT, "bigTcount" => count($bigT), "bigT" => $bigT, "silverMcount" => count($silverM), "silverM" => $silverM, "goldMcount" => count($goldM), "goldM" => $goldM];
		} catch (PDOException $e) {
		    $data = ["status" => "Fail", "msg" => "Server Error - Please try again later."];
		}
	    } else {
		$data = ["status" => "Fail", "msg" => "Invalid Parameter"];
	    }
	} else {
		$data = ["status" => "Fail", "msg" => "Parameter Missing"];
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

