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
$musicPrivacy = trim($_POST['privacy']);
if ($musicPrivacy == "public") {
    $musicPrivacy = 0;
} else {
    $musicPrivacy = 1;
}
$IS_MUSIC_BELONG = QUERY::c("select count(*) from music where music like '{$musicid}____' && userid=$userid");
if ($IS_MUSIC_BELONG == "0") {
    $response = array("status" => 3, "message" => "Music doesn't belongs to you.");
    echo json_encode($response);
    exit();
} else {

    $MUSIC = QUERY::c("select music from music where music like '{$musicid}____'");
    if ($musicPrivacy == 1) {
        $done = rename("../upload/audio/public/$MUSIC", "../upload/audio/private/$MUSIC");
    } else {
        $done = rename("../upload/audio/private/$MUSIC", "../upload/audio/public/$MUSIC");
    }
    if ($done) {
        QUERY::query("update music set privacy=$musicPrivacy where music like '{$musicid}____' && userid=$userid");
        $response = array("status" => 1, "message" => "Changed Privacy", "musicid" => $musicid, "done" => $done, "music" => $MUSIC);
        echo json_encode($response);
        exit();
    }  else {
        $response = array("status" => 4, "message" => "unable To Changed Privacy");
        echo json_encode($response);
        exit();
    }
}
?>