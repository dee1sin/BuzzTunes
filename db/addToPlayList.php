<?php
include_once "../session/session_start.php";
include_once "../class/query.php";
if (!isset($_SESSION['userid'])) {
    $response = array("status" => 2, "message" => "Login First.");
    echo json_encode($response);
    exit();
}
$userid = $_SESSION['userid'];
$playListName = trim($_POST['playlistname']);

$musicid = trim($_POST['musicid']);
$responseMusicid = $musicid;
if ($playListName == "" || $musicid == "") {
    $response = array("status" => 3, "message" => "Unknown Error. Try Refreshing Page.");
    echo json_encode($response);
    exit();
}
$playlistid = QUERY::c("select playlistid from playlistname where userid=$userid && name='{$playListName}'");
$musicid = QUERY::c("select musicid from music where music='{$musicid}.mp3'");
$TIME = time();
if (QUERY::c("SELECT COUNT(*)   from playlist where musicid=$musicid && playlistid=$playlistid") == "0") {
    $LOGID = (isset($_SESSION['info']))?$_SESSION['info']:0;
    QUERY::query("insert into playlist(userid,musicid,playlistid,time,logid) values($userid,$musicid,$playlistid,$TIME,$LOGID)");
    $response = array("status" => 1, "message" => "Success","musicid"=>$responseMusicid,"playlist"=>$playlistid);
    echo json_encode($response);
    exit();
}else{
    $response = array("status" => 4, "message" => "Already Added");
    echo json_encode($response);
    exit();
}
?>