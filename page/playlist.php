<div style="padding-left: 10px;">
<h1>
    <?php
    $diplayName = str_replace("-", " ", $PLAY_LIST_NAME);
    echo ucfirst($diplayName);
    $PAGE_TITLE = ucwords($diplayName) . " by " . "".  ucfirst($USER_NAME);
    ?>
</h1>
    <div style="font-size: 0.8em;color:#999;">created by <span><a href="/user/<?php echo $USER_NAME;?>/overview"><?php echo ucfirst($USER_NAME); ?></a></span></div>
</div>
<hr/>

<?php
$result = QUERY::query("select musicid,userid,music,img,waveimg,title,name,time,url,privacy from music where privacy=0 && musicid in (select musicid  from playlist where playlistid=(select playlistid from playlistname where name='{$PLAY_LIST_NAME}' && userid=(select userid from usersignup where username='{$USER_NAME}')))");
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
    $musicModel->playlistClass = "MAIN_PLAYLIST";

    MusicView::output($musicModel);
}
?>

