<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../../class/query.php";
include_once "../../session/session_start.php";
if (!isset($_SESSION['userid'])) {
    $response = array("status" => 2, "message" => "Login First.");
    echo json_encode($response);
    exit();
}
$GROUP_ID = $_SESSION['groups'];
if (QUERY::c("select count(*) from groups where groupid=$GROUP_ID && permission IN ('*','edituser')") == "0") {
    $response = array("status" => 3, "message" => "Permission Denied.");
    echo json_encode($response);
    exit();
}



$USERNAME = $_POST['username'];
$USERNAME = htmlspecialchars($USERNAME);
$USERNAME = mysqli_escape_string(QUERY::$con, $USERNAME);
$STATUS = $_POST['status'];
$ADMINSHIP = $_POST['adminship'];


if ($STATUS == "0") {
    $_STATUS = 0;
} else {
    $_STATUS = 1;
}
if (QUERY::c("select count(*) from groups where groupname='{$ADMINSHIP}'") == "0") {
    $response = array("status" => 4, "message" => "Adminship is not valid");
    echo json_encode($response);
    exit();
}
$ADMIN_GROUP_ID = $_SESSION['groups'];
if ($USERNAME == $_SESSION['username']) {
    $response = array("status" => 5, "message" => "Can Not Change Your Owen Privacy.");
    echo json_encode($response);
    exit();
}
$ADMINSHIP_ID = QUERY::c("select groupid from groups where groupname='{$ADMINSHIP}'");



QUERY::query("update usersignup set status=$_STATUS, groups=$ADMINSHIP_ID where username='{$USERNAME}'");
$response = array("status" => 1, "message" => "Suucessfull");
echo json_encode($response);
exit();
?>