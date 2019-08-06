<?php
if (!isset($_SESSION['userid'])) {
    echo "<h3>Login First</h3>";
    exit();
}
$GROUP_ID = $_SESSION['groups'];
if (QUERY::c("select count(*) from groups where groupid=$GROUP_ID && permission IN ('*','editmusic')")=="0") {
    echo "<h3>Permission Denied.</h3>";
    exit();
}
?>
<?php
$MUSIC_TITLE = QUERY::c("select title from music where musicid=$MUSICID");
$MUSIC_DESC = QUERY::c("select descrption from music where musicid=$MUSICID");
$MUSIC_IMG = QUERY::c("select img from music where musicid=$MUSICID");
$MUSIC_WAVEFORM = QUERY::c("select waveimg from music where musicid=$MUSICID");
$MUSIC_URL = QUERY::c("select url from music where musicid=$MUSICID");
$MUSIC_TAG = QUERY::c("select tagname from tag where musicid=$MUSICID");
$_MUSICID = explode(".", $MUSIC_IMG);
$_MUSICID = array_shift($_MUSICID);
?>
<h1>Music - Edit</h1>
<p></p>
<div>Title</div>
<p></p>
<input type="text" value="<?php echo $MUSIC_TITLE;?>" id="editMusicTitle" class="input"/>
<p></p>
<div>Description</div>
<p></p>
<input type="text" value="<?php echo $MUSIC_DESC;?>" id="editMusicDesc" class="input"/>
<p></p>
<div>URL</div>
<p></p>
<input type="text" value="<?php echo $MUSIC_URL;?>" id="editMusicURL" class="input"/>
<p></p>
<div>Tags</div>
<p></p>
<input type="text" value="<?php echo $MUSIC_TAG;?>" id="editMusicTag" class="input"/>
<p></p>
<div>Image</div>
<p></p>
<img src="/upload/image/<?php echo $MUSIC_IMG;?>" width="200" height="200"/>
<p></p>
<div>Waveform</div>
<p></p>
<img src="/upload/waveform/<?php echo $MUSIC_WAVEFORM;?>" style="background: #FFF;" width="600" height="200"/>
<p></p>
<input type="button" value="Update" onclick="editMusic('<?php echo $_MUSICID;?>')" class="input loginButton"/>
<p></p>



