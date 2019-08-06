<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);
include_once "../session/session_start.php";
include_once "../class/query.php";
$PAGE_ORI = $_POST['page'];
$PAGE_EXPLODE = explode("/", $PAGE_ORI);
$_PAGE = $PAGE_EXPLODE[0];
if($_PAGE=="stats"){
    include "ajax/stats.php";  
}else if($_PAGE=="adminmusic"){
    $PAGE_NUMBER = $PAGE_EXPLODE[1];
    $PAGE_NUMBER = (is_numeric($PAGE_NUMBER))?$PAGE_NUMBER:1;
    include "ajax/adminmusic.php";  
}else if($_PAGE=="adminuser"){
    $PAGE_NUMBER = $PAGE_EXPLODE[1];
    $PAGE_NUMBER = (is_numeric($PAGE_NUMBER))?$PAGE_NUMBER:1;
    include "ajax/adminuser.php";  
}else if($_PAGE=="adminerror"){
    $PAGE_NUMBER = $PAGE_EXPLODE[1];
    $PAGE_NUMBER = (is_numeric($PAGE_NUMBER))?$PAGE_NUMBER:1;
    include "ajax/adminerror.php";  
}else if($_PAGE=="music"){
    $MUSICURL = $PAGE_EXPLODE[1];
    $MUSICID = QUERY::c("select musicid from music where url='{$MUSICURL}'");
    include "ajax/musicindivisual.php";   
}else if($_PAGE=="user"){
    $USERNAME = $PAGE_EXPLODE[1];
    $USERID = QUERY::c("select userid from usersignup where username='{$USERNAME}'");
    $USERSTATUS = QUERY::c("select status from usersignup where username='{$USERNAME}'");
    $USERGROUPID = QUERY::c("select groups from usersignup where username='{$USERNAME}'");
    $USERGROUPNAME = QUERY::c("select groupname from groups where groupid=$USERGROUPID");
    include "ajax/userindivisual.php";   
}


?>