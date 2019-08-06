<?php

ob_start();
include_once "../session/session_start.php";
include_once "../class/query.php";
if (!$_SESSION['userid']) {
    $response = array("status" => 2, "message" => "Login First.");
    echo json_encode($response);
    exit();
}
$userid = $_SESSION['userid'];
$playListName = trim($_POST['playlistname']);
$playListName = preg_replace('/[^a-zA-Z0-9]+/', '-', $playListName);
$playlistPrivacy = trim($_POST['privacy']);
$musicid = trim($_POST['musicid']);
if ($playListName == "" || $playlistPrivacy == "") {
    $response = array("status" => 3, "message" => "Enter Playlist Name.");
    echo json_encode($response);
    exit();
}
if ($playlistPrivacy == "false") {
    $playlistPrivacy = 0;
} else {
    $playlistPrivacy = 1;
}
if (QUERY::c("select count(*) from playlistname where userid=$userid && name='{$playListName}'") == "1") {
    $response = array("status" => 3, "message" => "Playlist Already Exist With That Name");
    echo json_encode($response);
    exit();
}
$TIME = time();
$LOGID = (isset($_SESSION['info']))?$_SESSION['info']:0;
QUERY::query("insert into playlistname(userid,name,privacy,time,logid) values($userid,'{$playListName}',$playlistPrivacy,$TIME,$LOGID)");

$playlistid = QUERY::c("select playlistid from playlistname where userid=$userid && name='{$playListName}'");
$musicid = QUERY::c("select musicid from music where music='{$musicid}.mp3'");
QUERY::query("insert into playlist(userid,playlistid,musicid,time,logid) values($userid,$playlistid,$musicid,$TIME,$LOGID)");

$response = array("status" => 1, "message" => "Sucess");
echo json_encode($response);
exit();
?>