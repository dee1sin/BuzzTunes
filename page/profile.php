<?php
$PROFILE_USERID = QUERY::c("select userid from usersignup where username='{$PROFILE_USERNAME}'");
$PROFILE_PIC = QUERY::c("select img from usersignup where userid=$PROFILE_USERID");
$DISPLAY_PROFILE_USERNAME = strtoupper($PROFILE_USERNAME);
$PROFILE_COVER = QUERY::c("select cover from usersignup where userid=$PROFILE_USERID");
?>
<div id="topProfileContainer" style="opacity:0;-webkit-transition:opacity 0.5s;-o-transition:opacity 0.5s;-ms-transition:opacity 0.5s;transition:opacity 0.5s;border-bottom:1px solid #111;z-index:5;display:none;width: 100%;position: fixed;top:0px;left:0px;height:70px;background: url(/image/background/profile_bg.jpeg?1) no-repeat center /cover ;">
    <ul class="hl" style="padding-top:10px;">
        <li style="margin-left: 10px;margin-right: 20px;">
            <img src="/upload/profile/pic/<?php echo $PROFILE_PIC; ?>" width="50" height="50"/>
        </li>
        <li>
            <ul class="vl" style="background-color:black; color: white; padding: 5px;">
                <li><?php echo $DISPLAY_PROFILE_USERNAME; ?></li>
            </ul>
        </li>
    </ul>
</div>
<div id="userProfileCoverPic" style="background: url(/image/background/profile_bg.jpeg?1) no-repeat center /cover ;overflow:hidden;min-height: 300px; ">
    <ul class="hl" style="padding-left: 50px;padding-top: 50px;">
        <li style="padding-right: 20px;position: relative;" class="profilePicUploadContiner" onmouseenter="$('.profilePicUploadInputContiner').css('display:block;opacity:0.9;')" onmouseleave="$('.profilePicUploadInputContiner').css('display:block;opacity:0;')">
            <img src="/upload/profile/pic/<?php echo $PROFILE_PIC; ?>" id="userProfilePic" style="max-width: 200px;max-height: 200px;min-width: 200px;min-height: 200px;"/>
            <?php
            if ($PROFILE_USERNAME === $LOGGED_USER_NAME) {
                ?>
                <img src="/image/loader.gif" width="200" height="200" style="display: none;position: absolute;top:0px;left: 0px;opacity: 0.7;" id="profilePicUplodeProgress"/>
                <div style="position: absolute;bottom: 20px;left: 50px;display: none;opacity: 0;" class="profilePicUploadInputContiner">
                    <button style="padding: 5px 10px;position: relative;">
                        Upload Image
                        <input type="file" accept="image/gif, image/jpeg, image/png" onchange="previewAndUpload()" id="uploadProfilePicInput"  style="padding: 5px 10px;opacity: 0;position: absolute;top:0px;left:0px;width: 100%;height: 100%;"/>
                    </button>
                </div>
                <?php
            }
            ?>
        </li>
        <li>
            <span style="background: #000;color:#FFF;padding:5px 10px;    display: block;"><?php echo $DISPLAY_PROFILE_USERNAME; ?></span>
        </li>
    </ul>
</div>
<div style="position: relative;padding-left: 15%;background:#FFF;overflow: hidden;">
    <ul class="hl profileList">
        <li <?php echo ($PROFILE_SUB_MENU == "overview") ? "class='profileMenuBorder' style=''" : "" ?>><a href="/user/<?php echo $PROFILE_USERNAME; ?>/overview">Overview</a></li>
        <li <?php echo ($PROFILE_SUB_MENU == "music") ? "class='profileMenuBorder' style=''" : "" ?>><a href="/user/<?php echo $PROFILE_USERNAME; ?>/music">Music</a></li>
        <li <?php echo ($PROFILE_SUB_MENU == "playlist") ? "class='profileMenuBorder' style=''" : "" ?>><a href="/user/<?php echo $PROFILE_USERNAME; ?>/playlist">Playlist</a></li>
        
        <?php
        if ($PROFILE_USERNAME === $LOGGED_USER_NAME) {
            ?>
            <li <?php echo ($PROFILE_SUB_MENU == "private") ? "class='profileMenuBorder' style=''" : "" ?>><a href="/user/<?php echo $PROFILE_USERNAME; ?>/private">Private</a></li>
            
        <?php } ?>
    </ul>
</div>
<div class="profileAudio" style="padding-top: 5px;">
    <?php
    if ($PROFILE_SUB_MENU == "music" || $PROFILE_SUB_MENU == "overview" || $PROFILE_SUB_MENU == "private" || $PROFILE_SUB_MENU == "liked") {
        if ($PROFILE_SUB_MENU == "overview") {
            $query = "select musicid,userid,music,img,waveimg,title,name,time,url,privacy from music where privacy=0 && userid=$PROFILE_USERID";
            $COUNT_QUERY = $query;
            $result = QUERY::query("$query order by time desc limit $START_FROM,$MUSIC_PER_PAGE");
        } else if ($PROFILE_SUB_MENU == "music") {
            $query = "select musicid,userid,music,img,waveimg,title,name,time,url,privacy from music where privacy=0 && userid=$PROFILE_USERID";
            $COUNT_QUERY = $query;
            $result = QUERY::query("$query order by time desc limit $START_FROM,$MUSIC_PER_PAGE");
            if (mysqli_num_rows($result) == 0) {
                echo "<h3 style='color:#666;'>Nothing To Show Here.</h3>";
            }
        } else if ($PROFILE_SUB_MENU == "private") {
            $query = "select musicid,userid,music,img,waveimg,title,name,time,url,privacy from music where privacy=1 && userid=$PROFILE_USERID";
            $COUNT_QUERY = $query;
            $result = QUERY::query("$query order by time desc limit $START_FROM,$MUSIC_PER_PAGE");
            if (mysqli_num_rows($result) == 0) {
                echo "<h3 style='color:#666;'>Private List Is Empty.</h3>";
            }
        } else if ($PROFILE_SUB_MENU == "liked") {
            $query = "select musicid,userid,music,img,waveimg,title,name,time,url,privacy from music where (privacy=0 || (privacy=1 && userid=$PROFILE_USERID)) && musicid IN (select musicid from music_like where music_like.musicid=music.musicid && userid=$PROFILE_USERID)";
            $COUNT_QUERY = $query;
            $result = QUERY::query("$query order by time desc limit $START_FROM,$MUSIC_PER_PAGE");
            if (mysqli_num_rows($result) == 0) {
                echo "<h3 style='color:#666;'>Save List Is Empty.</h3>";
            }
        }


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
            $musicModel->playlistClass = "PROFILE" . strtoupper($PROFILE_SUB_MENU);
            MusicView::output($musicModel);
        }
        $TOTAL_COUNT = QUERY::c("select count(*) from ($COUNT_QUERY) as temp");
        ?>
        <div class="clearFix"></div>
        <p></p>
        <div>
            <ul class="hl" style="float:right;">
                <?php if ($PAGE_NUMBER > 1) { ?>
                    <li><a href="/user/<?php echo $PROFILE_USERNAME; ?>/<?php echo $PROFILE_SUB_MENU; ?>/<?php echo $PAGE_NUMBER - 1; ?>" class="pagingButton">Previous</a></li>
                <?php } ?>
                <?php if ($PAGE_NUMBER * $MUSIC_PER_PAGE < $TOTAL_COUNT) { ?>
                    <li><a href="/user/<?php echo $PROFILE_USERNAME; ?>/<?php echo $PROFILE_SUB_MENU; ?>/<?php echo $PAGE_NUMBER + 1; ?>" class="pagingButton">Next</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="clearFix"></div>
        <p></p>
        <?php
    } else if ($PROFILE_SUB_MENU == "playlist") {
        $query = "select name as PLAYLISTNAME,playlistid,privacy from playlistname where userid=$PROFILE_USERID";
        $COUNT_QUERY = $query;
        $result = QUERY::query("$query  order by time desc limit $START_FROM_PLAYLIST,$PLAYLIST_PER_PAGE");
        if (mysqli_num_rows($result) == 0) {
            echo "<h3 style='color:#999;'>No Playlist Created Yet.</h3>";
        }
        while ($res = mysqli_fetch_array($result)) {
            extract($res);
            $COUNT_MUSIC_IN_PLAYLIST = QUERY::c("select count(*) from playlist where playlistid=$playlistid");
            $PRIVACY_PLAYLIST_PUBLIC = ($privacy == "0") ? "style='display:block;'" : "style='display:none;'";
            $PRIVACY_PLAYLIST_PRIVATE = ($privacy == "0") ? "style='display:none;'" : "style='display:block;'";
            echo "<h3 style='padding-left:10px;'><span><a href='/playlist/{$PROFILE_USERNAME}/{$PLAYLISTNAME}'>" . str_replace("-", " ", ucfirst($PLAYLISTNAME)) . "</a> </span><span style='color:#666;font-size:0.7em;'>($COUNT_MUSIC_IN_PLAYLIST Music" . (($COUNT_MUSIC_IN_PLAYLIST > 1) ? "'s" : "") . ")</span>"
            . "<span style='float:right;position:relative;' ><i class='sprite sprite-moreIcon_25' onclick='showPlaylistSettingOptionDialog(\"{$PLAYLISTNAME}\")'></i>"
            . "<ul class='vl playlistSettingOption' style='position:absolute;top:100%;right:0px;display:none;z-index:6;' id='playlistSettingOption_{$PLAYLISTNAME}'><li $PRIVACY_PLAYLIST_PUBLIC id='playlistSettingOptionPublic_{$PLAYLISTNAME}' onclick='changePrivacyToPrivatePlayList(\"{$PLAYLISTNAME}\")'>Public</li><li $PRIVACY_PLAYLIST_PRIVATE id='playlistSettingOptionPrivate_{$PLAYLISTNAME}' onclick='changePrivacyToPublicPlayList(\"{$PLAYLISTNAME}\")'>Private</li><li onclick='deletePlayList(\"{$PLAYLISTNAME}\")'>Delete</li></ul>"
            . "</span></h3>";
            $playlistResult = QUERY::query("select musicid,userid,music,img,waveimg,title,name,time,url,privacy from music where privacy=0 && musicid in (select musicid from playlist where playlistid=$playlistid) order by time desc limit 5");
            $musicModel = new MusicModel;
            while ($playlistRes = mysqli_fetch_array($playlistResult)) {
                extract($playlistRes);
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
                $musicModel->playlistClass = "PROFILE_PLAYLIST" . strtoupper($PLAYLISTNAME);
                MusicView::output($musicModel);
            }

            echo "<div class='clearFix'></div>";
            echo "<hr/>";
        }
        $TOTAL_COUNT = QUERY::c("select count(*) from ($COUNT_QUERY) as temp");
        ?>
        <div class="clearFix"></div>
        <p></p>
        <div>
            <ul class="hl" style="float:right;">
                <?php if ($PAGE_NUMBER > 1) { ?>
                    <li><a href="/user/<?php echo $PROFILE_USERNAME; ?>/<?php echo $PROFILE_SUB_MENU; ?>/<?php echo $PAGE_NUMBER - 1; ?>" class="pagingButton">Previous</a></li>
                <?php } ?>
                <?php if ($PAGE_NUMBER * $PLAYLIST_PER_PAGE < $TOTAL_COUNT) { ?>
                    <li><a href="/user/<?php echo $PROFILE_USERNAME; ?>/<?php echo $PROFILE_SUB_MENU; ?>/<?php echo $PAGE_NUMBER + 1; ?>" class="pagingButton">Next</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="clearFix"></div>
        <p></p>
        <?php
    } else if ($PROFILE_SUB_MENU == "setting") {
        echo "<h2>Setting Option Is Not Available.</h2>";
    }
    ?>
</div>