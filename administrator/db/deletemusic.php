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
if (QUERY::c("select count(*) from groups where groupid=$GROUP_ID && permission IN ('*','deletemusic')") == "0") {
    $response = array("status" => 3, "message" => "Permission Denied.");
    echo json_encode($response);
    exit();
}
$musicid=$_POST['musicid'];

$_id = QUERY::c("select musicid from music where music like '{$musicid}____'");
$_music = QUERY::c("select music from music where music like '{$musicid}____'");
$_privacy = QUERY::c("select privacy from music where music like '{$musicid}____'");
$_img = QUERY::c("select img from music where music like '{$musicid}____' ");
$_waveimg = QUERY::c("select waveimg from music where music like '{$musicid}____'");

if ($_privacy == "0") {
    unlink("../../upload/audio/public/$_music");
} else {
    unlink("../../upload/audio/private/$_music");
}
unlink("../../upload/image/$_img");
unlink("../../upload/waveform/$_waveimg");


QUERY::query("delete from playlist where musicid=$_id");
QUERY::query("delete from tag where musicid=$_id");
QUERY::query("delete from music where musicid=$_id");

$response = array("status" => 1, "message" => "Deleted Successfuly.", "profilePlaylistURL" => "http://" . $_SERVER['SERVER_NAME'] . "/user/$username/playlist/", "musicid" => $musicid);
echo json_encode($response);
exit();
?>