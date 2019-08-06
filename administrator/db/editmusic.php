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
if (QUERY::c("select count(*) from groups where groupid=$GROUP_ID && permission IN ('*','editmusic')")=="0") {
    $response = array("status" => 3, "message" => "Permission Denied.");
    echo json_encode($response);
    exit();
}



$TITLE = $_POST['title'];
$TITLE = htmlspecialchars($TITLE);
$TITLE = mysqli_escape_string(QUERY::$con, $TITLE);
$TITLE = ucwords($TITLE);

$DESC = $_POST['description'];
$DESC = htmlspecialchars($DESC);
$DESC = mysqli_escape_string(QUERY::$con, $DESC);
$DESC = ucfirst($DESC);

$TAG = $_POST['tag'];
$TAG = htmlspecialchars($TAG);
$TAG = mysqli_escape_string(QUERY::$con, $TAG);

$URL = $_POST['url'];
$URL = strtolower($URL);
$URL = preg_replace("![^a-z0-9]+!i", "-", $TITLE);
if (QUERY::c("select count(*) from music where url='{$URL}'") != "0") {
    $URL = $URL . "-" . time();
}
$_MUSICID = $_POST['musicid'];
$_MUSICID = mysqli_escape_string(QUERY::$con, $_MUSICID);
$MUSICID = QUERY::c("select musicid from music where music like '{$_MUSICID}____'");

QUERY::query("update music set title='{$TITLE}', descrption='{$DESC}', url='{$URL}' where musicid=$MUSICID");
QUERY::query("update tag set tagname='{$TAG}' where musicid=$MUSICID");
$response = array("status" => 1, "message" => "Suucessfull");
echo json_encode($response);
exit();
?>