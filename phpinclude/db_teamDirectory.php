<?php
/*
 *  filename:       db_teamDirectory.php
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

        if (isset($_GET['tid']) && !empty($_GET['tid'])) {
            try {
                $row = $conn->prepare('SELECT null AS control, CONCAT(C_FirstName, " ", C_LastName) AS Name, C_Type AS Type, C_Email, C_WorkNumber FROM coach c JOIN coach_team ct ON c.Coach_ID = ct.Coach_ID WHERE Team_ID = :teamid');
                //JOIN team t ON ct.Team_ID = t.Team_ID
                $row->bindParam(":teamid", $_GET['tid'], PDO::PARAM_INT);
                $row->execute(); //execute the query  

                $result = $row->fetchAll();
                $data = ["status" => "Success", "coach" => $result]; //create the array  
            } catch (Exception $ex) {
                $data = ["status" => "Fail", "msg" => "Server Error - Please try again later."];
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
echo json_encode($data);
?>