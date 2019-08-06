<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);
$IS_LOADED = true;
if(!extension_loaded('imagick')) {
    echo '<h1>Imagick id Not Loaded.</h1>';
    $IS_LOADED = false;
}
$ffmpeg = trim(shell_exec('ffmpeg -version')); // or better yet:
if (empty($ffmpeg)) {
    echo '<h1>ffmpeg not available on this server.INstall it first.</h1>';
    $IS_LOADED = false;
}
if(!$IS_LOADED){
    exit;
}
include_once "session/session_start.php";
include_once "class/query.php";
$p = $_SERVER['REQUEST_URI'];
$p = str_replace("http://", "", $p);
$pArray = explode("/", $p);
$useragent = $_SERVER['HTTP_USER_AGENT'];
$IS_MOBILE = false;
if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)))
    $IS_MOBILE = true;
if ($IS_MOBILE) {
    include "mobile/mobileMusic.php";
    include "mobile/mobileIndex.php";
    exit();
}
header('HTTP/1.0 200 Found');
$PAGE = "";
if (!isset($pArray[1]) || $pArray[1] == "" || is_numeric($pArray[1])) {
    $PAGE = "HOME";
} else if ($pArray[1] == "login") {
    if (isset($_SESSION['userid'])) {
        header("Location: /");
    } else {
        $PAGE = "LOGIN";
    }
} else if ($pArray[1] == "signup") {
    if (isset($_SESSION['userid'])) {
        header("Location: /");
    } else {
        $PAGE = "SIGNUP";
    }
} else if ($pArray[1] == "upload-music") {
    $PAGE = "UPLOAD";
} else if ($pArray[1] == "music") {
    $PAGE = "MUSIC";
} else if ($pArray[1] == "admin") {
    $PAGE = "ADMIN";
}
$IS_LOGGED_IN = false;
$CURRENT_USERNAME = "";
if (isset($_SESSION['userid'])) {
    $IS_LOGGED_IN = true;
    $CURRENT_USERNAME = $_SESSION['username'];
}
if ($PAGE == "ADMIN") {
    include "administrator/adminIndex.php";
    exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="language" content="english"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700|Shadows+Into+Light+Two" rel="stylesheet">
        <link rel="publisher" href="https://plus.google.com/107451468871433725729"/>
        <meta name="keywords" content="buzzntunes, tunes, buzz, music, playlist, upload"/>
        <meta name="description" content="Listen to our great collection and Upload your's and access it from anywhere you like"/>
        <?php if ($PAGE == "MUSIC") { ?>
            <?php
            $_MUSIC_ID = $pArray[2];
            $_MUSIC_IMG = QUERY::c("select img from music where url='{$_MUSIC_ID}'");
            $_MUSIC_MUSIC = QUERY::c("select music from music where url='{$_MUSIC_ID}'");
            $_MUSIC_TITLE = QUERY::c("select title from music where url='{$_MUSIC_ID}'");
            $_MUSIC_DESC = QUERY::c("select descrption from music where url='{$_MUSIC_ID}'");
            $_MUSIC_USERNAME = ucfirst(QUERY::c("select username from usersignup where userid=(select userid from music where url='{$_MUSIC_ID}')"));
            ?>
           
        <?php } ?>
        <title>BUZZnTUNES - Listen To Awesome Musics</title>
        <link rel="icon" href="/favicon.ico"/>
        <style>
           <?php $COLOR = "4885ed"; include "css/index.php";?>
        </style>
        <style>
            .sprite {
                background-repeat: no-repeat;
                width: 35px;
                height: 35px;
                display: block;
            }
            
            .sprite-disabled {
                opacity: 0.4;
            }

            .sprite-enabled {
                opacity: 1;
            }

            .sprite-facebook {
                width: 30px;
                height: 30px;
                background-image: url(/image/spritesheet3.png);
                background-position: -2px -2px;
            }

            .sprite-google {
                width: 30px;
                height: 30px;
                background-image: url(/image/spritesheet3.png);
                background-position: -36px -2px;
            }

            .sprite-hoverPauseIcon {
                width: 50px;
                height: 50px;
                background-image: url(/image/pauseIcon.png);
            }

            .sprite-hoverPlayIcon {
                background-image: url(/image/ic_play.png);
                width: 50px;
                height: 50px;
                
            }

/*
            .sprite-like-icon_20 {
                width: 20px;
                height: 20px;
                background-position: -2px -56px;
            }

            .sprite-liked-icon_20 {
                width: 20px;
                height: 20px;
                background-position: -26px -56px;
            }
*/

            .sprite-moreIcon {
                width: 20px;
                height: 20px;
                margin: 15px;
                background-size: contain;
                background-repeat: no-repeat;
                background-image: url(/image/more_dots.png);
            }

            .sprite-moreIcon_16 {
                width: 16px;
                height: 16px;
                background-size: contain;
                background-repeat: no-repeat;
                background-image: url(/image/more_dots.png);
            }

            .sprite-moreIcon_25 {
                width: 25px;
                height: 25px;
                background-size: contain;
                background-repeat: no-repeat;
                background-image: url(/image/more_dots.png);
            }

            .sprite-nextPlayIcon_35 {
                background-image: url(/image/ic_skip_next.png);
                background-size: contain;
                background-repeat: no-repeat;
            }

            .sprite-pauseIcon {
                width: 45px;
                height: 45px;
                margin-top: 5px;
                background-image: url(/image/ic_pause.png);
                background-size: contain;
                background-repeat: no-repeat;
            }

            .sprite-playIcon {
                width: 45px;
                height: 45px;
                margin-top: 5px;
                background-image: url(/image/ic_play.png);
                background-size: contain;
                background-repeat: no-repeat;
            }

            .sprite-played-icon_20 {
                width: 45px;
                height: 45px;
                background-image: url(/image/ic_play.png);
                background-size: contain;
                background-repeat: no-repeat;
            }

        

            .sprite-previousPlayIcon_35 {
                background-image: url(/image/ic_skip_previous.png);
                background-size: contain;
                background-repeat: no-repeat;
            }

/*
            .sprite-playlistIcon_20 {
                 margin-top: 5px;
                background-image: url(/image/ic_playlist.png);
                background-size: contain;
                width: 25px;
                height: 25px;
                background-repeat: no-repeat;
            }
*/

            .sprite-playlistIcon_35 {
                margin-top: 5px;
                
                background-image: url(/image/ic_playlist.png);
                background-size: contain;
                width: 25px;
                height: 25px;
                background-repeat: no-repeat;
            }
            
            .sprite-repeatIconEnabled_35 {
                margin-top: 5px;
                opacity: 1;
                background-image: url(/image/ic_repeat.png);
                background-size: contain;
                background-repeat: no-repeat;
                width: 23px;
                height: 23px;
            }

            .sprite-repeatIcon_35 {
                margin-top: 5px;
                opacity: 0.4;
                background-image: url(/image/ic_repeat.png);
                background-size: contain;
                background-repeat: no-repeat;
                width: 23px;
                height: 23px;
            }

            .sprite-soundIcon_35 {
                margin-top: 5px;
                background-image: url(/image/ic_volume_up.png);
                background-size: contain;
                width: 25px;
                height: 25px;
                background-repeat: no-repeat;
            }

            .sprite-search_30 {
                width: 30px;
                height: 30px;
                background-image: url(/image/spritesheet3.png);
                background-position: -197px -119px;
            }

            .sprite-share-icon {
                width: 24px;
                height: 20px;
                background-image: url(/image/spritesheet3.png);
                background-position: -201px -56px;
            }

            .sprite-twitter {
                width: 30px;
                height: 30px;
                background-image: url(/image/spritesheet3.png);
                background-position: -80px -153px;
            }



        </style>
        <script>
            function musicDisLike(id) {
                musicLikeXML = post("/db/toggleMusicLike.php", "musicid=" + id + "&do=dislike", true, function() {
                    if (this.readyState === 4 && this.status === 200) {
                        jsonObjectResponse = JSON.parse(this.responseText);
                        if (jsonObjectResponse.status == 1) {
                            addMessageBox(0,jsonObjectResponse.message);
                            $("#like_" + jsonObjectResponse.musicid).show();
                            $("#dislike_" + jsonObjectResponse.musicid).hide();
                        } else {
                            addMessageBox(1,jsonObjectResponse.message);
                        }
                    }
                });
            }
            function musicLike(id) {

                musicLikeXML = post("/db/toggleMusicLike.php", "musicid=" + id + "&do=like", true, function() {
                    if (this.readyState === 4 && this.status === 200) {
                        jsonObjectResponse = JSON.parse(this.responseText);
                        if (jsonObjectResponse.status == 1) {
                            addMessageBox(0,jsonObjectResponse.message);
                            $("#like_" + jsonObjectResponse.musicid).hide();
                            $("#dislike_" + jsonObjectResponse.musicid).show();
                        } else {
                            addMessageBox(1,jsonObjectResponse.message);
                        }
                    }
                });
            }
        </script>
        <script>
            function addMessageBox(type,msg){
                id = "messageBox_"+(new Date()).getTime() + Math.ceil(Math.random()*200);
                var boxMsg = '<div class="messageBox '+((type===0)?"messageBoxGreen":"messageBoxRed")+'" id="'+id+'">\
                <ul class="hl">\
                    <li>'+msg+'</li>\
                    <li class="close" onclick="closeMessageBox(\''+id+'\')">x</li>\
                </ul>\
            </div>';
                $("#rightMessageBox").appendStart(boxMsg);
                var msgid = {boxid:id};
                f = showMessageBox.bind(msgid);
                setTimeout(f,0);
            }
            function showMessageBox(){
                $("#"+this.boxid).css("opacity:1;");  
                f = hideMessageBox.bind(this);
                setTimeout(f,3000);
            }
            function hideMessageBox(){
                $("#"+this.boxid).css("opacity:0;");
                f = removeMessageBox.bind(this);
                setTimeout(f,500);
            }
            function removeMessageBox(){
                $("#"+this.boxid).remove();
                
            }
            function closeMessageBox(id){
                var msgid = {boxid:id};
                f = hideMessageBox.bind(msgid);
                setTimeout(f,0);
            }
        </script>
    </head>
    <body>
        <div class="none">
            <h1>Listen to our great collection and Upload yours </h1>
            <h2>Listen to our great collection and Upload yours </h2>
        </div>
        <div style="position: fixed;right: 50px;top:55px;z-index: 15000;" id="rightMessageBox">
            
        </div>
        <div class="shareDialogContainer" id="shareDialogContainer">

            <div style="position: absolute;left: 0px;top:0px;width:100%;height:100%;" id="shareDialogBox">

            </div>
            <div style="position: absolute;top:10px;right: 10px;cursor: pointer;" onclick="hideShareDialogBox()">
                close
            </div>

        </div>

        <div id="fullScreenMusic" class="fullScreenMusic">
            <div id="fullScreenMusicImage" style="position: absolute;top:0px;left:0px;background-repeat:no-repeat;background-size: cover;width:100%;height:100%;">

            </div>
            <div style="position: absolute;left: 0px;top:0px;width:100%;height:100%;transition:opacity 1s;-webkit-transition:opacity 1s;opacity: 0;" id="fullScreenOption">
                <div style="position: absolute;top:10px;right: 10px;cursor: pointer;" onclick="hideFullScreenMusic()">
                    close
                </div>
                <div style="width: 100%;height: 100%;position: absolute;top: 25%;left: 23%;" id="fullScreenMusicController">
                    <ul class="hl">
                        <li style="border-radius: 101px;border: 2px solid #18F3AD;margin-right: 25px;padding: 25px;margin-top: 50px;">
                            <button class="sprite sprite-previousPlayIcon_35" onclick="fullScreenMusicPreviousSound()" style="zoom: 3;outline: 0;border: none;    background-color: transparent;"></button>
                        </li>
                        <li style="    border-radius: 151px;border: 2px solid #18F3AD;margin-right: 25px;padding: 25px;">
                            <button class="sprite sprite-pauseIcon" id="fullScreenMusicPlayPause" onclick="fullScreenMusicPlay()" style="zoom: 5;outline: 0;border: none;    background-color: transparent;"></button>
                        </li>
                        <li style="    border-radius: 101px;border: 2px solid #18F3AD;margin-right: 25px;padding: 25px;margin-top: 50px;">
                            <button onclick="fullScreenMusicNextSound()" class="sprite sprite-nextPlayIcon_35" style="zoom: 3;outline: 0;border: none;    background-color: transparent;"></button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div  class="addPlayListContainer" id="addPlayListContainer">
            <div style="position: absolute;right: 20px;top: 20px;">
                <i onclick="hideAddPlayListBox()" style="font-weight: bold;cursor: pointer;">close</i>
            </div>
            <div id="addPlayListBox">

            </div>
        </div>

        <div class="searchBoxContainer" id="searchBoxContainer">
            <div class="searchBoxShowContiner" id="searchBoxShowContiner" style="opacity: 0.1">
                <div style="position: absolute;right: 10px;top:10px;cursor: pointer;" onclick="hideSearchBox()"><i>Close</i></div>
                <div style="margin-top: 50px;margin-left: 50px;margin-right: 50px;position: relative;">
                    <span class="searchBoxLeftLine"></span><input type="text" id="searchInput" class="input searchBox searchBoxInput" onkeyup="instantSearch()" placeholder="Search" style=""/>
                    <span class="searchBoxRightLine"></span>

                </div>
                <div style="margin-top: 20px;max-height:300px;overflow-y: auto;" class="outputSearchResult" id="outputSearchResult">
                    <h3>Result</h3>
                </div>
            </div>
        </div>
        <div class="mediaPlayerContainer" id="mediaPlayerContainer">
            <ul class="hl bottomPlayer" style="margin:0 auto;width: 70%;min-width: 950px;">
                <li class="previousSoundBottom" style="padding-top: 10px;"><i class="sprite sprite-previousPlayIcon_35" onclick="previousSound()"></i></li>
                <li id="playBottomButton" style="cursor: pointer;"><i class="sprite sprite-playIcon" onclick="playSound()"></i></li>
                <li id="pauseBottomButton" style="display: none;cursor: pointer;"><i class="sprite sprite-pauseIcon"  onclick="pauseSound()"></i></li>
                <li id="waitingBottomButton" style="display: none;"><img src="/image/loader.gif" alt="..." width="50" height="50" onclick="pauseSound()"/></li>
                <li class="nextSoundBottom" style="padding-top: 10px;"><i class="sprite sprite-nextPlayIcon_35"  onclick="nextSound()"></i></li>
                <li style="height: 100%;line-height: 55px; margin-left:30px;margin-right:10px;" id="audioCurrentTime">00:00</li>
                <li style="height: 55px;">
                    <div style="width:300px;height:100%;position: relative;" id="audioProgressContainer" onclick="changeAudioPlayTime()" onmouseout="hideShowTimeOnOverPos()" onmousemove="changeShowTimeOnOverPos()">
                        <div style="position: absolute;top:26px;width:100%;background: #111111;height:2px;"></div>
                        <div style="width:0%;height:2px;top:26px;position: absolute;" class="audioProgressBottom" id="audioProgress"></div>
                        <div class="seekDownArrow" style="position: absolute;bottom:35px;width:40px;height: 30px;padding:4px 10px;background:rgba(0,0,0,0.7);display: none;    text-align: center;color:#FFF;" id="showTimeOnhover"></div>

                    </div>
                </li>
                <li style="height: 100%;line-height: 55px; margin-left:10px;margin-right:30px;" id="audioEndTime">00:00</li>
                <li style="padding-top: 10px;">
                    <div style="position: relative;" onclick="toggleBottomPlayeList()" >
                        <i class="sprite sprite-playlistIcon_35"></i>
                        <ul class="vl bottomPlayList" id="bottomPlayList" >

                        </ul>
                    </div>
                </li>

                <li style="padding-top: 10px;">
                    <div style="position: relative;">
                        <i class="sprite sprite-soundIcon_35" onclick="toggleVolumeBottom()"></i>
                        <div style="position: absolute;bottom:120%;background:#CCC;left:0px;display: none;padding:5px 10px 0px 10px;background: #333;" class="bottomVolumeArrow" id="bottomVolumeContainer" >
                            <input type="range" min="0" max="100" value="100" oninput="changeVolumeFromBottom(this)"/>
                        </div>
                    </div>
                </li>

                <li style="padding-top: 10px;">
                    <i class="sprite sprite-repeatIcon_35" id="repeatModeBottom" onclick="toggleRepeatModeBottom()"></i>
                </li>
                <li style="background-color: #EEE;min-width: 100px;padding-left: 10px;padding-right: 10px;min-width: 200px;float:right;margin-right: 0px;">
                    <div >
                        <ul class="hl">
                            <li style="margin-right: 10px;"><img id="currentPlayingMusicIcon" onclick="showFullScreenMusic()" style="cursor: pointer;max-width:50px;width:50px;height: 50px;"/></li>
                            <li style="margin-top:10px">
                                <ul class="vl">
                                    <li id="currentPlayingMusicTitle" style="width:150px; font-size: 0.9em;width: 100px;font-weight:500;overflow: hidden;height: 20px"></li>
                                    <li style="font-size: 0.7em;"id="currentPlayingMusicUploader"></li>
                                </ul>
                            </li>
                        </ul>

                    </div>
                </li>
            </ul>
        </div>
        
        <div class="header">
            <ul class="hl">
                <li class="homeButton" style="font-family: 'Shadows Into Light Two', cursive;"><a href="/"> 
                    <span style="color:#555; " href="/">BUZZ</span>
                    <span style="color:rgba(0,0,0,0.5); " href="/">&amp;</span>
                    <span   style="" class="homeMusicTitle"href="/">TUNES</span></a>
                </li>
                <li class="searchButton" onclick="showSearchBox()" style="padding-top: 10px;">
                    <i class="sprite sprite-search_30" style="margin-right: 10px;"></i>
                </li>
                <li class="moreButton" style="float: right;margin-right: 0px;">
                    <i class="sprite sprite-moreIcon"></i>
                    <ul class="vl hiddenMore" style="right:0px;">
                        <li><a href="/upload-music"> Upload</a></li>
                        <?php if ($IS_LOGGED_IN) { ?>
                            <li class="LOGGEDIN" id="topSettingUsername"><a href="/user/<?php echo $CURRENT_USERNAME; ?>/overview"> Profile  </a></li>
                            <li class="LOGGEDIN"><a href="/logout"> Logout  </a></li>
                            <li class="NOTLOGGEDIN" style="display:none;"><a href="/login"> Login  </a></li>
                            <li class="NOTLOGGEDIN" style="display:none;"><a href="/signup"> Signup </a></li>
                        <?php } else {
                            ?>
                            <li class="LOGGEDIN" id="topSettingUsername" style="display:none;"><a href="/"> Profile  </a></li>
                            <li class="LOGGEDIN" style="display:none;"><a href="/logout" > Logout  </a></li>
                            <li class="NOTLOGGEDIN"><a href="/login"> Login  </a></li>
                            <li class="NOTLOGGEDIN"><a href="/signup"> Signup </a></li>
                        <?php }
                        ?>
                        <li><a href="/about">About us</a></li>
                        <li><a href="/help">Help</a></li>
                        <li><a href="/privacy">Privacy</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="clearFix"></div>

        <div class="body" style="position: relative;">
            <div id="fullScreenContent" style="min-height:900px;display: none;"></div>
            <div style="position: absolute;top:100px;left:45%;" id="loaderContiner"><img src="/image/loader.gif" width="128" height="128" alt="loading.."/></div>
            <div style="background: #FFF;width: 70%;margin: 0 auto;max-width: 90%;min-width: 950px;" id="pageContiner">

                <div class="page" style="width: 100%;">
                    <?php
                    ?>
                </div>
            </div>
        </div>
        <div class="clearFix"></div>
        <div class="footer" id="footer">
            <ul class="hl">
                <li><a href="/about">About us</a></li>
                <li><a href="/help">Help</a></li>
                <li><a href="/privacy">Privacy</a></li>
                <li><a href="/cookie">Cookie</a></li>
                <li style="float:right">
                    <ul class="hl" style="overflow: hidden;line-height: normal;padding-top: 10px;">
                        <li><a href="https://plus.google.com/107451468871433725729/about" class="ancharNewPage" target="_blank"  style=" padding:0px;padding-top:10px;"><i class="sprite sprite-google" style="margin-right: 10px;"></i></a></li>
                        <li><a href="https://www.facebook.com/" target="_blank" class="ancharNewPage" style=" padding:0px;padding-top:10px;"><i class="sprite sprite-facebook" style="margin-right: 10px;"></i></a></li>
                        <li><a href="https://twitter.com/" class="ancharNewPage" target="_blank" style=" padding:0px;padding-top:10px;"><i class="sprite sprite-twitter" style="margin-right: 10px;"></i></a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="clearFix"></div>
<script type="text/javascript"  src="/js/index.js?16"></script>
<script type="text/javascript"  src="/js/main.js?16"></script>

    </body>
</html>