<h3 style="padding-left: 10px;"><a href="/Surprise">Surprise</a></h3>
<?php
$result = QUERY::query("select musicid,userid,music,img,waveimg,title,name,time,url,privacy from music where privacy=0 order by RAND() limit 0,20");
$musicModel = new MusicModel;
while ($res = mysqli_fetch_array($result)) {
    extract($res);
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
    $musicModel->playlistClass = "SURPRISE";

    MusicView::output($musicModel);
}
?>
<div class="clearFix"></div>
<p></p>