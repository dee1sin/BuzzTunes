<?php
ob_start();
include_once "../session/session_start.php";
include_once "../class/query.php";
include_once "../class/music.php";
$search=$_POST['search'];

$result = QUERY::query("select musicid,userid,music,img,waveimg,title,name,time,url,privacy from music where title like '%$search%' limit 0,10");
$musicModel = new MusicModel;
while($res = mysqli_fetch_array($result))
{
    extract($res);
    $musicModel->id=$musicid;
    $musicModel->userid=$userid;
    $musicModel->userName = QUERY::c("select username from usersignup where userid=$userid");
    $musicModel->filename = $music;
    $musicModel->imageName = $img;
    $musicModel->imageWave = $music;
    $musicModel->title = $title;
    $musicModel->name = $name;
    $musicModel->time = $time;
    $musicModel->url = $url;
    $musicModel->privacy = $privacy;
    $musicModel->playlistClass = "SEARCH";
    MusicView::output($musicModel);
}
$contents = ob_get_contents();
ob_end_clean();
if($contents==""){
    echo "<h2>No Result Found.</h2>";
}else{
    echo $contents;
}

?>