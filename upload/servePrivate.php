
<?php
include_once "../session/session_start.php";
include_once "../class/query.php";
if(!isset($_SESSION['userid'])){
    echo "LOGIN FIRST";
    exit();
}
$userid=$_SESSION['userid'];
$musicid=trim($_GET['musicid']);
if(QUERY::c("select count(*) from usersignup where music='{$musicid}'")=="0"){
    echo "FILE Not Available";
    exit();
}
if(QUERY::c("select count(*) from usersignup where music='{$musicid}' && privacy=1 && userid=$userid")=="0"){
    echo "Permission Not Allowed";
    exit();
}

$track = "audio/private/$musicid";

if(file_exists($track)) {
    header('Content-Disposition: attachment; filename="sometrack.mp3"');
    header('Content-type: audio/mpeg');
    header('Content-length: ' . filesize($track));
    header('Content-Disposition: filename="sometrack.mp3"');
    header('X-Pad: avoid browser bug');
    header('Cache-Control: no-cache');
    print file_get_contents($track);
} else {
    echo "no file";
}
?>