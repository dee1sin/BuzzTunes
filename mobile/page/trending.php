<?php
include_once "../../session/session_start.php";
include_once "../../class/query.php";
include "../mobileMusic.php";
include "../../log.php";
$PAGE_NUM = (isset($_POST["pagenumber"]))?is_numeric($_POST["pagenumber"])?$_POST["pagenumber"]:0:0;
$MUSIC_PER_PAGE_LOAD = 10;
$START_FROM = $PAGE_NUM*$MUSIC_PER_PAGE_LOAD;
$result = QUERY::query("select musicid,userid,music,img,waveimg,title,name,time,url,privacy from music where privacy=0 order by view desc limit $START_FROM,$MUSIC_PER_PAGE_LOAD");
$musicModel = new MobileMusicModel;
$COUNT = 0;
while ($res = mysqli_fetch_array($result)) {
    extract($res);
    $COUNT++;
    $musicModel->id = $musicid;
    $musicModel->userid = $userid;
    $musicModel->userName = QUERY::c("select username from usersignup where userid=$userid");
    $musicModel->filename = $music;
    $musicModel->imageName = $img;
    $musicModel->imageWave = $music;
    $musicModel->title = $title;
    $musicModel->name = $name;
    $musicModel->time = $time;
    $musicModel->url = $url;
    $musicModel->privacy = $privacy;
    $musicModel->playlistClass = "TRENDING";
    MobileMusicView::output($musicModel);
}
echo "<div class='clearFix'></div>";
if($COUNT==10){
    echo "<div onclick='loadTrendingPage()' class='loadMore'><div id='loadMoreText'>Load More</div><div id='loadMoreImg' style='display:none;'><img src='/image/loader.gif' width='50' height='50'/></div></div>";
}  else {
    echo "<div class='loadMore'>No More Sound.</div>";
}
?>