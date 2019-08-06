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

$IS_PLAYLIST_BELONG = QUERY::c("select count(*) from playlistname where name=$playListName and userid=$userid");
if($IS_PLAYLIST_BELONG=="0"){
    $response = array("status" => 3, "message" => "Playlist doesn't belongs to you.");
    echo json_encode($response);
    exit();
}else{
    $PLAYLIST_ID = QUERY::c("select playlistid from playlistname where name='{$playListName}' && userid=$userid");
    QUERY::query("delete from playlistname where playlistid=$PLAYLIST_ID");
    QUERY::query("delete from playlist where playlistid=$PLAYLIST_ID");
    $response = array("status" => 1, "message" => "Deleted Successfuly.","profilePlaylistURL"=>"http://" . $_SERVER['SERVER_NAME']."/user/$username/playlist/");
    echo json_encode($response);
    exit();
}


?>