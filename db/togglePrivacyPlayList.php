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
$playListName = trim($_POST['playlistname']);
$playListPrivacy = trim($_POST['playlistprivacy']);

if($playListPrivacy=="public"){
    $playListPrivacy=0;
}else {
    $playListPrivacy=1;
}
$IS_PLAYLIST_BELONG = QUERY::c("select count(*) from playlistname where name='{$playListName}' && userid=$userid");
if($IS_PLAYLIST_BELONG=="0"){
    $response = array("status" => 3, "message" => "Playlist doesn't belongs to you.");
    echo json_encode($response);
    exit();
}else{
    $PLAYLIST_ID = QUERY::c("select playlistid from playlistname where name='{$playListName}' && userid=$userid");
    QUERY::query("update playlistname set privacy=$playListPrivacy where playlistid=$PLAYLIST_ID");
    
    $response = array("status" => 1, "message" => "Changed Privacy","playlistname"=>$playListName);
    echo json_encode($response);
    exit();
}


?>