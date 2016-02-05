<?php
/*
 *  filename:       db_logout.php
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$methodType = $_SERVER['REQUEST_METHOD'];
$data = ["status" => "Fail", "msg" => $methodType];

if ($methodType === "POST") {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	// AJAX call
	// Answer POST call and get data sent
	if (isset($_POST['logout']) && !empty($_POST['logout'])) {
	    $logout = $_POST['logout'];
	    session_unset();
	    session_destroy();
	    $data = ["status" => "Success", "msg" => "You were successfully logged out."];
	} else {
	    $data = ["status" => "Fail", "msg" => "Error:  Parameter(s) missing."];
	}
    } else {
	//$data = ["msg" => "Only AJAX calls supported."];
	$data = ["status" => "Fail", "msg" => "Error:  Invalid Request."];
    }
} else {
    //$data = ["msg" => "Error: Only POST requests allowed."];
    $data = ["status" => "Fail", "msg" => "Error:  Invalid Request."];
}

echo json_encode($data, JSON_FORCE_OBJECT);
?>

