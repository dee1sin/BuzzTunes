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
$DO = trim($_POST['do']);
if (QUERY::c("select privacy from music where music like '{$musicid}____'") != "0") {
    $response = array("status" => 3, "message" => "Permission Denied.");
    echo json_encode($response);
    exit();
}
if ($DO == "like") {
    $MUSICID = QUERY::c("select musicid from music where music like '{$musicid}____'");
    if (QUERY::c("select count(*) from music_like where userid=$userid && musicid=$MUSICID") == "0") {
        $TIME = time();
        QUERY::query("insert into music_like(userid,musicid,time) values($userid,$MUSICID,$TIME)");
        $response = array("status" => 1, "message" => "Liked.","musicid"=>$musicid);
        echo json_encode($response);
        exit();
    } else {
        $response = array("status" => 4, "message" => "Already Liked.");
        echo json_encode($response);
        exit();
    }
}else if ($DO == "dislike") {
    $MUSICID = QUERY::c("select musicid from music where music like '{$musicid}____'");
    if (QUERY::c("select count(*) from music_like where userid=$userid && musicid=$MUSICID") == "1") {
        QUERY::query("delete from music_like where userid=$userid && musicid=$MUSICID");
        $response = array("status" => 1, "message" => "Disliked.","musicid"=>$musicid);
        echo json_encode($response);
        exit();
    } else {
        $response = array("status" => 5, "message" => "Not In Collection.");
        echo json_encode($response);
        exit();
    }
}
?>