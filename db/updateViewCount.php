<?php
include_once "../session/session_start.php";
include_once "../class/query.php";
$musicid = trim($_POST['musicid']);
QUERY::query("update music set view=view + 1 where music like '{$musicid}____'");
$originalmusicid = QUERY::c("select musicid from music where music like '{$musicid}____'");

$result = QUERY::query("select musicid,userid,music,img,waveimg,title,name,time,url,privacy from music where musicid=$originalmusicid");
$res = mysqli_fetch_array($result);
extract($res);
$USERNAME = QUERY::c("select username from usersignup where userid=$userid");
$PRIVACY = ($privacy==0)?"public":"private";
if($privacy==0){
    $MUSIC = "/upload/audio/$PRIVACY/$music";
}else{
    $MUSIC = "/upload/servePrivate.php?musicid=$music";
}
$response= array("status"=>1,"title"=>$title,"image"=>"/upload/image/".$img,"username"=>$USERNAME,"music"=>$MUSIC);
echo json_encode($response);		
exit();	
?>