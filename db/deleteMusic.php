<?php

ob_start();
include_once "../session/session_start.php";
include_once "../class/query.php";
if (!isset($_SESSION['userid'])) {
    $response = array("status" => 2, "message" => "Login First.");
    echo json_encode($response);
    exit();
}
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
$musicid = trim($_POST['musicid']);
$IS_PLAYLIST_BELONG = QUERY::c("select count(*) from music where music like '{$musicid}____' and userid=$userid");
if ($IS_PLAYLIST_BELONG == "0") {
    $response = array("status" => 3, "message" => "Music doesn't belongs to you.");
    echo json_encode($response);
    exit();
} else {
    $_id = QUERY::c("select musicid from music where music like '{$musicid}____' and userid=$userid");
    $_music = QUERY::c("select music from music where music like '{$musicid}____' and userid=$userid");
    $_privacy = QUERY::c("select privacy from music where music like '{$musicid}____' and userid=$userid");
    $_img = QUERY::c("select img from music where music like '{$musicid}____' and userid=$userid");
    $_waveimg = QUERY::c("select waveimg from music where music like '{$musicid}____' and userid=$userid");
    
    if ($_privacy == "0") {
        unlink("../upload/audio/public/$_music");
    } else {
        unlink("../upload/audio/private/$_music");
    }
    unlink("../upload/image/$_img");
    unlink("../upload/waveform/$_waveimg");
    
    
    QUERY::query("delete from playlist where musicid=$_id");
    QUERY::query("delete from tag where musicid=$_id");
    QUERY::query("delete from music where music like '{$musicid}____' and userid=$userid");

    $response = array("status" => 1, "message" => "Deleted Successfuly.", "profilePlaylistURL" => "http://" . $_SERVER['SERVER_NAME'] . "/user/$username/playlist/","musicid"=>$musicid);
    echo json_encode($response);
    exit();
}
?>