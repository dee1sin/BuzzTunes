<?php
include_once '../session/session_start.php';
include_once '../class/query.php';
include_once '../class/music.php';
include_once "../log.php";
$PAGE_EXPLODE = $_POST["page"];
$PAGE_EXPLODE = explode("/", $PAGE_EXPLODE);
$PAGE = (isset($PAGE_EXPLODE[3]))?$PAGE_EXPLODE[3]:"";
$PAGE_TITLE = "Music Initedit";
$PAGE_ID = 0;

$WAVEFORM_NAME = "";
$MUSIC_MUSIC = "";
$WAVEFORM_GENRATED = 1;
$IS_LOGGED_IN = (isset($_SESSION['username']))?true:false;
if($IS_LOGGED_IN)
    $LOGGED_USER_NAME = $_SESSION['username'];
ob_start();
if ($PAGE == "home" || $PAGE == "") {
    include_once 'home.php';
    $PAGE_TITLE = "BUZZ&TUNES";
    $PAGE_ID = 1;
} else if ($PAGE == "login") {
    if (!isset($_SESSION['username'])) {
        include_once 'login.php';
        $PAGE_TITLE = "Login";
        $PAGE_ID = 2;
    } else {
        echo "<h2>You Are Already Logged In.</h2>";
        $PAGE_TITLE = "Oops! Login";
    }
} else if ($PAGE == "signup") {
    if (!isset($_SESSION['username'])) {
        include_once 'signup.php';
        $PAGE_TITLE = "Signup";
        $PAGE_ID = 3;
    } else {
        echo "<h2>You Are Logged In.</h2>";
        $PAGE_TITLE = "Oops! Signup";
    }
} else if ($PAGE == "upload-music") {
    if (isset($_SESSION['username'])) {
        include_once 'upload.php';
        $PAGE_TITLE = "Upload Music";
        $PAGE_ID = 4;
    } else {
        echo "<h2>First Login.</h2>";
        echo '<div><a href="/login"><input type="button" class="loginButton" style="padding: 5px 15px;" value="Login Here"/></a></div>';
        $PAGE_TITLE = "Oops! Upload";
    }
} else if ($PAGE == "music") { 
    $MUSIC_ID = $PAGE_EXPLODE[4];
    $PAGE_TITLE = "Music";
    include "music.php";
    
    $PAGE_ID = 5;
}else if ($PAGE == "user") { 
    $PROFILE_USERNAME = $PAGE_EXPLODE[4];
    $PROFILE_SUB_MENU = isset($PAGE_EXPLODE[5])?$PAGE_EXPLODE[5]:"";
    $MUSIC_PER_PAGE = 15;
    $PLAYLIST_PER_PAGE = 5;
    $PAGE_NUMBER = (isset($PAGE_EXPLODE[6]))?is_numeric($PAGE_EXPLODE[6])?$PAGE_EXPLODE[6]:1:1;
    $START_FROM  = ($PAGE_NUMBER-1)*$MUSIC_PER_PAGE;
    $START_FROM_PLAYLIST = ($PAGE_NUMBER-1)*$PLAYLIST_PER_PAGE;
    if($PROFILE_SUB_MENU===""){ 
        $PROFILE_SUB_MENU = "overview";
    }
    include "profile.php";
    $PAGE_TITLE = "$PROFILE_USERNAME - My Awesome Music Profile";
    $PAGE_ID = 6;
}else if ($PAGE == "hash") { 
    $HASH_STRING = $PAGE_EXPLODE[4];
    $MUSIC_PER_PAGE = 20;
    $PAGE_NUMBER = (isset($PAGE_EXPLODE[5]))?is_numeric($PAGE_EXPLODE[5])?$PAGE_EXPLODE[5]:1:1;
    $START_FROM  = ($PAGE_NUMBER-1)*$MUSIC_PER_PAGE;
    include "hash.php";
    $PAGE_TITLE = "#$HASH_STRING";
    $PAGE_ID = 7;
}else if ($PAGE == "playlist") {
    $USER_NAME = $PAGE_EXPLODE[4];
    $PLAY_LIST_NAME = $PAGE_EXPLODE[5];
    $MUSIC_ID = $PAGE_EXPLODE[6];
    $PAGE_TITLE = "Playlist";
    include_once 'playlist.php';
}else if ($PAGE == "trending") {
    $PAGE_TITLE = "Trending Music";
    $MUSIC_PER_PAGE = 20;
    $PAGE_NUMBER = (isset($PAGE_EXPLODE[4]))?is_numeric($PAGE_EXPLODE[4])?$PAGE_EXPLODE[4]:1:1;
    $START_FROM  = ($PAGE_NUMBER-1)*$MUSIC_PER_PAGE;
    include_once 'trending.php';
    
}else if ($PAGE == "new") {
    $MUSIC_PER_PAGE = 20;
    $PAGE_NUMBER = (isset($PAGE_EXPLODE[4]))?is_numeric($PAGE_EXPLODE[4])?$PAGE_EXPLODE[4]:1:1;
    $START_FROM  = ($PAGE_NUMBER-1)*$MUSIC_PER_PAGE;
    include_once 'new.php';
    $PAGE_TITLE = "New Music";
}else if ($PAGE == "surprise") {
    include_once 'surprise.php';
    $PAGE_TITLE = "Surprise :)";
} else if ($PAGE == "about") {
    include_once 'about.php';
    $PAGE_TITLE = "About";
} else if ($PAGE == "help") {
    include_once 'help.php';
    $PAGE_TITLE = "Help";
} else if ($PAGE == "privacy") {
    include_once 'privacy.php';
    $PAGE_TITLE = "Privacy";
} else if ($PAGE == "cookie") {
    include_once 'cookie.php';
    $PAGE_TITLE = "Cookie";
}else if ($PAGE == "logout") {
    session_destroy();
    include_once 'logout.php';
    $PAGE_TITLE = "Logout";
    $PAGE_ID=8;
} else {
    echo "<h2>Page Not Found.</h2>";
    $PAGE_TITLE = "Page Not Found";
}
$contents = ob_get_contents();
ob_end_clean();
$output = array("status" => 200, "pageid" => $PAGE_ID, "title" => $PAGE_TITLE, "content" => $contents,"waveform"=>$WAVEFORM_NAME,"audiofile"=>$MUSIC_MUSIC,"wavegenrated"=>$WAVEFORM_GENRATED);
echo json_encode($output);
?>