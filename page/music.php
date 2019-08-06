<?php
$WAVEFORM_GENRATED = QUERY::c("select count(*) from music where url='{$MUSIC_ID}' and wave_progress=0");
$MUSIC_IMG = QUERY::c("select img from music where url='{$MUSIC_ID}'");
$MUSIC_MUSIC = QUERY::c("select music from music where url='{$MUSIC_ID}'");
$MUSIC_TITLE = QUERY::c("select title from music where url='{$MUSIC_ID}'");
$MUSIC_VIEW = QUERY::c("select view from music where url='{$MUSIC_ID}'");
 
$_ID = QUERY::c("select musicid from music where url='{$MUSIC_ID}'");
$_userid = (isset($_SESSION['userid']))?$_SESSION['userid']:-100;
$MUSIC_LIKE = QUERY::c("select count(*)  from music_like where musicid=$_ID && userid=$_userid");
$MUSIC_LIKE_COUNT = QUERY::c("select count(*)  from music_like where musicid=$_ID");
$PAGE_TITLE = $MUSIC_TITLE;
$WAVEFORM_NAME = QUERY::c("select waveimg from music where url='{$MUSIC_ID}'");
$MUSIC_RELATED_TITLE = $MUSIC_TITLE;
$MUSIC_TITLE = strtoupper($MUSIC_TITLE);
$MUSIC_USERNAME = QUERY::c("select username from usersignup where userid=(select userid from music where url='{$MUSIC_ID}')");
$MUSIC_USERNAME = ucfirst($MUSIC_USERNAME);
$TAGS = QUERY::c("select tagname from tag where musicid=(select musicid from music where url='{$MUSIC_ID}')");
$TAGS = "#" . $TAGS;
$TAGS = preg_replace("![^a-z0-9]+!i", " #", $TAGS);
$TAGS = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="/hash/$1" style="color: #FFF;">#$1</a>', $TAGS);
$TIME_SECOND = QUERY::c("select time from music where url='{$MUSIC_ID}'");
$PROFILE_PIC = QUERY::c("select img from usersignup where userid=(select userid from music where url='{$MUSIC_ID}')");
$MUSIC_MUSIC = array_shift(explode(".", $MUSIC_MUSIC));
$CURRENT_TIME = time();
$SECONDS = ($CURRENT_TIME - $TIME_SECOND);
$TIME_AGO = "";
if ($SECONDS < 10)
    $TIME_AGO = "Just Now";
else if ($SECONDS < 60)
    $TIME_AGO = "$SECONDS Seconds Ago";
else if ($SECONDS < 3600)
    $TIME_AGO = ceil($SECONDS / 60) . " Minutes Ago";
else if ($SECONDS < 3600 * 24)
    $TIME_AGO = ceil($SECONDS / 3600) . " Hours Ago";
else if ($SECONDS < 3600 * 30 * 7)
    $TIME_AGO = ceil($SECONDS / (3600 * 30)) . " Days Ago";
else if ($SECONDS < 3600 * 30 * 30)
    $TIME_AGO = ceil($SECONDS / (3600 * 30*7)) . " Weeks Ago";
else
    $TIME_AGO = "About Year Ago";
?>
<!--
<div id="topAudioContainer" style="opacity:0;-webkit-transition:opacity 0.5s;-o-transition:opacity 0.5s;-ms-transition:opacity 0.5s;transition:opacity 0.5s;border-bottom:1px solid #111;z-index:5;display:none;width: 100%;position: fixed;top:0px;left:0px;height:70px;;background-image: url('/upload/image/<?php echo $MUSIC_IMG; ?>');background-repeat: no-repeat;background-size: cover;" ">
    <ul class="hl" style="padding-top:10px;">
        <li style="margin-left: 10px;margin-right: 20px;">
            <img src="/upload/image/<?php echo $MUSIC_IMG; ?>" width="50" height="50"/>
        </li>
        <li>
            <ul class="vl">
                <li><?php echo $MUSIC_TITLE; ?></li>
                <li><a href="/user/<?php echo strtolower($MUSIC_USERNAME); ?>/"><?php echo $MUSIC_USERNAME; ?></a></li>
            </ul>
        </li>
    </ul>
</div>
<div style="position: absolute;top:0px;left:0px;width:100%;height: 100%;-webkit-filter: blur(5px);
     -moz-filter: blur(5px);
     -o-filter: blur(5px);
     -ms-filter: blur(5px);
     filter: blur(5px);
     background-image: url('/upload/image/<?php echo $MUSIC_IMG; ?>');background-repeat: no-repeat;background-size: cover;"></div>
<div style="background: #FFF;opacity: 0.5;width: 100%;min-height: 300px;">
    <ul class="hl" style="overflow: hidden;padding-top: 50px;padding-left: 50px;padding-right: 50px;">
        <li onclick="startAudioWaveform('<?php echo $MUSIC_MUSIC; ?>')" ><img src="/upload/image/<?php echo $MUSIC_IMG; ?>" style="width: 200px;height: 200px;cursor: pointer;"/></li>
        <li>
            <ul class="vl">
                <li style="background: #000;padding: 10px;margin-bottom: 10px;color:#FFF;font-weight: bold;"><?php echo $MUSIC_TITLE; ?></li>
                <li style="background: #000;padding: 10px;margin-bottom: 10px;color:#FFF;font-weight: bold;"><a href="/user/<?php echo strtolower($MUSIC_USERNAME);?>/overview" style="color:#FFF;"><?php echo $MUSIC_USERNAME; ?></a></li>  				
            </ul>
        </li>
        <li style="float:right;">
            <ul class="hl">
                <li>
                    <ul class="vl">
                        <li style="background: #000;padding: 10px;margin-bottom: 10px;color:#FFF;font-weight: bold;"><?php echo $TAGS; ?></li>
                        <li style="background: #000;padding: 10px;margin-bottom: 10px;color:#FFF;font-weight: bold;"><?php echo $TIME_AGO; ?></li>
                    </ul>                  
                </li>
                <li> <img src="/upload/profile/pic/<?php echo $PROFILE_PIC; ?>" style="max-width: 200px;max-height: 200px;min-width: 200px;min-height: 200px;"/></li>
            </ul>
        </li>
    </ul>
    <div style="position:absolute;top:150px;left:250px;" id="waveformContainer">
        <canvas id="waveformCanvas" width="600" height="100" style="position:absolute;top:0px;left:0px;;width:600px;height:100px;"></canvas>
        <canvas id="waveformCanvasPlayed" width="600" height="100" style="position:absolute;top:0px;left:0px;width:600px;height:100px;"></canvas>
        <canvas id="waveformCanvasSeek" onclick="seekFromWaveform()" onmouseout="seekPlayedWaveformOut()" onmousemove="seekPlayedWaveform()" width="600" height="100" style="position:absolute;top:0px;left:0px;width:600px;height:100px;"></canvas>

        <img src="/upload/waveform/<?php echo $WAVEFORM_NAME . "?time=" . time(); ?>" style="max-width:60%;display:none;" id="loadedWaveform" onload="updateWaveformCanvas()"/>
    </div>

</div>
<div style="height: 50px;width:100%;position: relative;">
    <ul class="hl mainMusicOption">
        <li style="height: 50px;width:50px;min-width: 50px;cursor: default;opacity: 1;padding: 0px;"></li>
        <li onclick="musicLike('<?php echo $MUSIC_MUSIC; ?>')" id="like_<?php echo $MUSIC_MUSIC; ?>" style="display:<?php echo ($MUSIC_LIKE=="1")?"none":"block"?>"><ul class="hl"><li style="padding-top: 15px;"><i class="sprite sprite-like-icon_20" style="margin-right: 10px;"></i></li><li>Like <?php echo ($MUSIC_LIKE_COUNT>0)?($MUSIC_LIKE=="1")?($MUSIC_LIKE_COUNT>1)?"(".($MUSIC_LIKE_COUNT-1).")":"":"($MUSIC_LIKE_COUNT)":"";?></li></ul></li>
        <li onclick="musicDisLike('<?php echo $MUSIC_MUSIC; ?>')" id="dislike_<?php echo $MUSIC_MUSIC; ?>" style="color:#18F3AD;display:<?php echo ($MUSIC_LIKE=="1")?"block":"none"?>"><ul class="hl"><li style="padding-top: 15px;"><i class="sprite sprite-liked-icon_20" style="margin-right: 10px;"></i></li><li>Liked <?php echo ($MUSIC_LIKE_COUNT>0)?($MUSIC_LIKE=="0")?($MUSIC_LIKE_COUNT>1)?"(".($MUSIC_LIKE_COUNT+1).")":"":"($MUSIC_LIKE_COUNT)":"";?></li></ul></li>
        <li onclick="showShareDialog('<?php echo $MUSIC_MUSIC; ?>')"><ul class="hl"><li style="padding-top: 15px;"><i class="sprite sprite-share-icon" style="margin-right: 10px;"></i></li><li>Share</li></ul></li>
        <li onclick="addToPlayList('<?php echo $MUSIC_MUSIC; ?>')" ><ul class="hl"><li style="padding-top: 15px;"><i class="sprite sprite-playlistIcon_20" style="margin-right: 10px;"></i></li><li>Add To Playlist</li></ul></li>
        <li><ul class="hl"><li style="padding-top: 15px;"><i class="sprite sprite-played-icon_20" style="margin-right: 10px;"></i></li><li><?php echo $MUSIC_VIEW; ?></li></ul></li>
        <li style="background:#FFF;overflow: hidden;float: none;height: 50px;opacity: 1;cursor: default;"></li>
    </ul>
</div>
<div style="position: relative;">
    <div class="relatedMusicContiner" style="background: transparent; position: relative;">
        <h3>Related To <?php echo $MUSIC_RELATED_TITLE; ?></h3>
        <?php
        $result = QUERY::query("select musicid,userid,music,img,waveimg,title,name,time,url,privacy from music where privacy=0 order by time desc limit 0,20");
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
            $musicModel->playlistClass = "RELATEDMUSIC";

            MusicView::output($musicModel);
        }
        ?>
    </div>

</div>


-->
