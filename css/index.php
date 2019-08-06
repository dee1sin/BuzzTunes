<?php
if(!empty($COLOR)){
    $_COLOR = $COLOR;
}else if($_GET['color']){
    $_COLOR =  $_GET['color'];
}  else {
    $_COLOR = "4885ed";
}

?>
html,body{
background: #FFF;
color:#000;
padding: 0px;
margin: 0px;
width: 100%;
height: 100%;
font-family: 'Roboto', sans-serif;
}

a{
text-decoration: none;
color:#000;
}
.none{
display:none;   
}
h3{
font-family: arial ;   
}
.vl,.hl{
list-style: none;
padding: 0px;
margin: 0px;
}
.hl > li{
float: left;
list-style: none;

}
.clearFix{
clear: both;   
}
.body{
min-height: 75%; 
background: #DDD;
}
.header{
height: 50px;
    
background:#FFF;
color:#000;
}
.footer{
height: 50px;
border-top: 1px solid #ccc;
background:#FFF;
color:#000;
line-height: 50px;
}
.page,.outputSearchResult,.relatedMusicContiner,.profileAudio{
width: 70%;
box-shadow: 0 0 8px rgba(0,0,0,0.2);
margin: 0 auto;
background: #FFF;
overflow: hidden;
min-height: 500px;
}
.footer > ul > li > a{
padding: 0px 10px;
margin-right: 10px; 
}
.footer> ul{
width: 70%;
margin: 0 auto;
min-width: 950px;
}

.header > ul{
width: 70%;
margin: 0 auto;
min-width: 950px;
}
.header > ul {
line-height: 50px;   
}

.header  .headerSearch{
outline:none;
padding:2px 10px;
margin-top: 10px;
}
.searchButton{
padding: 0px 10px; 
font-weight: bold;
margin-right: 10px;
cursor: pointer;
}
.homeButton{
padding: 0px 10px; 
font-weight: bold;
margin-right: 10px;
}
.loginButton{
padding: 0px 10px; 
font-weight: bold;
margin-right: 10px;
}
.uploadButton{
padding: 0px 10px; 
font-weight: bold;
margin-right: 10px;
}
.moreButton{
padding: 0px 10px; 
font-weight: bold;
margin-right: 10px;
position: relative;
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}
.hiddenMore{
position: absolute;
top:100%;
display: none;
  box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
min-width: 150px;
z-index: 1;
background: #FFF;  
}
.hiddenMore > li {
MARGIN: 0px 20PX;
     border-bottom: 1px solid #999999;
}
.hiddenMore > li > a {
display: block; 
color: #666;
}
.hiddenMore > li:hover  a{
color:   #<?php echo $_COLOR;?>;
}
.moreButton:hover{
  box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
}
.moreButton:hover .hiddenMore{
display: block;   
}
.seekDownArrow::before{
content: "";
border-top: 5px solid rgba(0,0,0,0.8);
border-left: 5px solid transparent;
border-right: 5px solid transparent;
left:27.5px;
top:100%;
position: absolute;
}
.bottomPlayList{
position: absolute;
bottom: 140%;
background: rgba(0,0,0,0.8);
left:-150px;
display: none;
}
.bottomPlayList::before{
content: "";
border-top: 10px solid rgba(0,0,0,0.8);
border-left: 10px solid transparent;
border-right: 10px solid transparent;
left:160px;
top:100%;
position: absolute;
}
.bottomPlayList > li{
padding: 10px 25px;
color:#FFF;
width: 300px;
cursor: pointer;
}
.bottomPlayList > li:hover{
background: rgba(120,120,120,0.8);
color:#FFF;
}
.page > ul,.outputSearchResult > ul,.relatedMusicContiner > ul,.profileAudio>ul{
float: left;
min-width: 18%;
/*min-width: 150px;*/
margin-right:1%; 
margin-left: 1%;
}
.musicSortCard{
overflow: hidden;  
  border-radius: 2px;
  margin: 1rem;
  box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}
.musicSortCard:hover {
    
  box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
}

.musicSortCardDetailContainer {
    padding: 10px;
    
font-family: 'Roboto', sans-serif;
    height: 50px;
}

.bottomVolumeArrow::before{
content: "";
border-top: 10px solid #333;
border-left: 10px solid transparent;
border-right: 10px solid transparent;
left:10px;
top:90%;
position: absolute; 
}
.bottomPlayer > li{
margin-right: 5px;
}
.footer > ul > li >  a{
display: block;
}

.footer > ul > li:hover  a{

}
.loginBox,.signupBox{
min-width: 300px;
max-width: 500px;
width: 40%;
margin: 0 auto;
background: #FFF;
margin-top: 100px;
}
.loginBoxContainer,.signupBoxContainer{
padding: 50px 50px;
font-family: 'Roboto', sans-serif;
border: 1px solid #<?php echo $_COLOR;?>;;
}
.loginTitle,.signupTitle{
text-align: center;  
margin-bottom: 25px;
    color: grey;
font-size: 2em;
}
.input{
width: 100%;
    height: 30px;
padding: 1%;   
}

.loginButton{
background: #67ae55;
color: #FFF;
    height: 40px;
border: 0px none #005500;
}
.loginButton:hover{
background: #679e55;
}
.searchBoxLeftLine{
content: "";
width: 2px;
position: absolute;
left:0px;
height: 10px;
bottom: 0px;
background: #<?php echo $_COLOR;?>;
}
.searchBoxRightLine{
content: "";
width: 2px;
position: absolute;
right:0px;
height: 10px;
bottom: 0px;
background: #<?php echo $_COLOR;?>;
}
.outputSearchResult{
transition: opacity 0.5s;
-webkit-transition: opacity 0.5s;
-o-transition: opacity 0.5s;
-moz-transition: opacity 0.5s;
-ms-transition: opacity 0.5s;
}
.searchBoxShowContiner,.page{
transition: opacity 0.2s;
-webkit-transition: opacity 0.2s;
-o-transition: opacity 0.2s;
-moz-transition: opacity 0.2s;
-ms-transition: opacity 0.2s;
}

.privacy,.cookie,.about,.help{
font-family: arial,sans-serif;
font-weight: bold;
}
.privacy p,.cookie p,.about p,.help p,.help ol{
color:#666;

}
input[type="text"],input[type="password"],textarea{
border: 1px solid #999;
outline: none;
padding: 2%;
width: 95.5%;
}
input[type="text"]:hover,input[type="password"]:hover,textarea:hover{
border: 1px solid #111;
}
input[type="text"]:focus,input[type="password"]:focus,textarea:focus{
border: 1px solid rgba(0,100,200,0.9);
}
.error{
color: rgba(200,0,0,0.8);   
}
.profileList > li{
padding: 20px 10px;
background: #FFF;
color:#000;
font-weight: bold;
border-bottom: 1px solid #FFF;
margin-right: 20px;
}
.profileList > li >a{
display: block;
color:#000;

}
.profileList > li:hover{
border-bottom: 1px solid #<?php echo $_COLOR;?>;
}

.profilePicUploadInputContiner{
transition: opacity 0.4s;
-webkit-transition: opacity 0.4s;
-ms-transition: opacity 0.4s;
-o-transition: opacity 0.4s;
-moz-transition: opacity 0.4s;
}
::selection {
background: #<?php echo $_COLOR;?>; /* WebKit/Blink Browsers */
}
::-moz-selection {
background: #<?php echo $_COLOR;?>; /* Gecko Browsers */
}
.addPlayListBorderHighlight{
border-bottom:2px solid  #<?php echo $_COLOR;?>;   
}
.addPlayListBorderNormal{
border-bottom:2px solid  #FFF;   
}
.addedPlaylistButton{
background: #67ae55;
color: #FFF;
border: 1px solid #005500;
padding: 3px;
}
.playlistSettingOption{
background: #EEE;
padding: 10px 0px;
border: 1px solid #<?php echo $_COLOR;?>;
}
.playlistSettingOption >li{
padding: 5px 20px;
font-size: 0.7em;
cursor: pointer;
}
.playlistSettingOption >li:hover{
background: #DDD;
}
.homebanner{
transition: left 1s;
-webkit-transition: left 1s;
-ms-transition: left 1s;
-moz-transition: left 1s;
-o-transition: left 1s;
}
.musicSettingOption{
display:none;position: absolute;bottom: 100%;right: 0px;
background: rgba(20,20,20,0.8);color:#FFF;;width:130px;text-align: right;
}
.musicSettingOption .options{
cursor: pointer; 
font-size: 0.8em;
border-bottom: 1px solid rgb(20,20,20);
padding: 5px 2px;
}
.musicSettingOption .options:hover{
border-bottom: 1px solid rgba(0,0,0,0.8);
background: rgb(40,40,40);
}
.pagingButton{
margin-left: 10px;
padding: 3px 10px;
margin-right: 10px;
background: #DDD;
border: 1px solid #999;
}
.socialButton{
padding:0px;padding-top:10px;
}
.fullScreenMusic{
position: fixed;top:0px;left:0px;background: #FFF;opacity: 1;width: 100%;height: 100%;z-index: 12;display: none;
}
.addPlayListContainer{
position: fixed;top:0px;left:0px;background: #FFF;opacity: 0.9;width: 100%;height: 100%;z-index: 11;display: none;
}
.searchBoxContainer{
position: fixed;top:0px;left:0px;background: #FFF;width: 100%;height: 100%;z-index: 10;display: none;
}
.mediaPlayerContainer{
z-index: 11;
    display: none;
    position:fixed;
    bottom: 0px;
    height:55px;
    background:rgba(255,255,255,0.95);
    width: 100%;
    box-shadow: 0 0 8px 8px rgba(0,0,0,0.2);
    padding-top: 2.5px;
}
.shareDialogContainer{
position: fixed;top:0px;left:0px;background: #FFF;width: 100%;height: 100%;z-index: 10;display: none;
}
.mainMusicOption{

}
.mainMusicOption > li{
line-height: 50px;  
padding:0px 20px;
cursor: pointer;
min-width: 100px;
text-align: center;
background: #FFF;
}
.mainMusicOption > li:hover{
opacity: 0.5;
}
.messageBox{
  box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
    padding: 20px;
    overflow: hidden;
    width: 200px;
    border-radius: 2px;
    color: white;
    opacity: 0;
    transition: opacity 0.5s;
    -webkit-transition: opacity 0.5s;
    -o-transition: opacity 0.5s;
    -ms-transition: opacity 0.5s;
    -moz-transition: opacity 0.5s;
}
            
.messageBox .close{
    float: right;color:#fff;
    cursor: pointer;
}
.messageBox .close:hover{
    color:#fff;
}
.messageBoxGreen{
    background-color: green;
}
.messageBoxRed{
    background: #ff3232;
}
.bannerNumber{
    background:#CCC;
}
.bannerNumberHighlight{
    background:#<?php echo $_COLOR;?>;
}
.bannerText{
    position: absolute;top:50px;left:100px;color:#<?php echo $_COLOR;?>;font-size: 2em;font-family: fantasy;
}
.trendingBorder{
    border-bottom: 2px solid #<?php echo $_COLOR;?>;
}
.uploadBox{
    min-width: 300px;margin: 0 auto;width: 75%;background: #FFF;border: 1px solid #<?php echo $_COLOR;?>;margin-top: 100px;padding: 10px;
}
.uploadMusicProgress{
    width: 0%;height: 25px;background: #<?php echo $_COLOR;?>;
}
.hashTagsTitle{
    font-size: 100px;color:#<?php echo $_COLOR;?>;opacity: 0.6;
}
.profileList .profileMenuBorder{
    border-bottom-color:#<?php echo $_COLOR;?>;
}
.searchBoxContainer .searchBoxInput{
outline: none;padding: 1%;font-weight: bold;border: 0px;font-size: 3em;border-bottom: 2px solid #<?php echo $_COLOR;?>;width:98%;
}
.searchBoxContainer .searchBoxInput:focus{
    border:none;
    border-bottom: 2px solid #<?php echo $_COLOR;?>;
}
 .searchBoxContainer .searchBoxInput:hover{
    border:none;
    border-bottom: 2px solid #<?php echo $_COLOR;?>;
 }
.audioProgressBottom{
    background: #<?php echo $_COLOR;?>;
}
.homeMusicTitle{
    color:#<?php echo $_COLOR;?>;
}
