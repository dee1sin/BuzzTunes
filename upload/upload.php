<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../class/query.php";
include_once "../session/session_start.php";
if (!isset($_SESSION['userid'])) {
    $response = array("status" => 2, "message" => "Login First.");
    echo json_encode($response);
    exit();
}


$target_dir = "tmp/";

if (!file_exists($target_dir)) {
    mkdir($target_dir);
}

if (!file_exists("audio")) {
    mkdir("audio/private");
}

if (!file_exists("audio/public")) {
    mkdir("audio/public");
}

if (!file_exists("waveform")) {
    mkdir("waveform");
}

$INSERT_FILE_NAME = $_FILES["audiofile1"]["name"];
$explodes = explode(".", $_FILES["audiofile1"]["name"]);
$exten = array_pop($explodes);
$IS_CONVERT_REQUIRED = false;
if ($exten != "mp3") {

    $IS_CONVERT_REQUIRED = true;

//    $response = array("status" => 3, "message" => "Sound File Format Is  Not Support");
//    echo json_encode($response);
//    exit();
}
$extension = "." . $exten;
$isImageUploaded = false;
if (isset($_FILES["musicfile1"]["size"])) {
    if ($_FILES["musicfile1"]["size"] > 0) {
        $musicPicExten = explode(".", $_FILES["musicfile1"]["name"]);
        $musicPicExten = array_pop($musicPicExten);
        $picSupport = array("png", "jpg", "jpeg", "PNG", "JPEG", "JPG");
        if (!in_array($musicPicExten, $picSupport)) {
            $response = array("status" => 4, "message" => "Music Pic Format Is Not Suppoted.");
            echo json_encode($response);
            exit();
        }
        $isImageUploaded = true;
    } else {
        $musicPicExten = "png";
    }
} else {
    $musicPicExten = "png";
}

$random_number = md5(time() + "MUSIC");
$random_file_name = $random_number . $extension;
$random_number_image = $random_number . ".$musicPicExten";
$INSERT_FILE_THUMBNAIL_IMAGE = $random_number_image;
$target_file = $target_dir . $random_file_name;
$target_music_file = $target_dir . $random_number_image;

if (!file_exists($target_dir)) {
    mkdir($target_dir);
}

move_uploaded_file($_FILES["audiofile1"]["tmp_name"], "$target_file");
if ($isImageUploaded)
    move_uploaded_file($_FILES["musicfile1"]["tmp_name"], "$target_music_file");

if($IS_CONVERT_REQUIRED)
{
    try {
        exec("ffmpeg -i $target_file -f mp3 tmp/$random_number.mp3");
        $extension=".mp3";
        $random_file_name = $random_number . $extension;
        $random_number_image = $random_number . ".$musicPicExten";
        $INSERT_FILE_THUMBNAIL_IMAGE = $random_number_image;
        $target_file = $target_dir . $random_file_name;
        $target_music_file = $target_dir . $random_number_image;
    }catch(Exception $ex)
    {

    }
}


/*
  require ('classAudioFile.php');

  try{
  $AF = new AudioFile;
  $AF->loadFile("$target_file");
  if ($AF->wave_id == "RIFF") {
  $AF->visual_width = 1200;
  $AF->visual_height = 500;
  $AF->getVisualization(substr("$target_file", 0, strlen("$target_file") - 4) . ".png");
  }
  }catch(Exception $ex){

  }
 */
/*
  include "getid3/getid3.php";
  $getID3 = new getID3;
  $OldThisFileInfo = $getID3->analyze("tmp/$random_file_name");
  print_r($OldThisFileInfo);

  if (isset($OldThisFileInfo['comments']['picture'][0]['data'])) {
  try {
  $data = base64_encode($OldThisFileInfo['comments']['picture'][0]['data']);
  $im = imagecreatefromstring($data);
  if ($im) {
  imagepng($im, "image/$random_number_image");
  } else {
  copy("tmp/default.png", "image/$random_number_image");
  }
  } catch (Exception $ex) {
  copy("tmp/default.png", "image/$random_number_image");
  }
  } else {
  copy("tmp/default.png", "image/$random_number_image");
  }
 */
$IS_AUTO_DETECT_ON = true;
if (!file_exists("image")) {
    mkdir("image");
}

if ($isImageUploaded) {
    copy("$target_music_file", "image/$random_number_image");
} else {
    if (!$IS_AUTO_DETECT_ON) {
        copy("tmp/default.jpg", "image/$random_number_image");
    } else {
        include "getid3/getid3.php";
        $getID3 = new getID3;
        $OldThisFileInfo = $getID3->analyze("tmp/$random_file_name");
        // print_r($OldThisFileInfo);
        try {
            exec("ffmpeg -i tmp/$random_file_name image/$random_number_image");
        } catch(Exception $ex)  {

        }
        if(!file_exists("image/$random_number_image")) {
            if (isset($OldThisFileInfo['comments']['picture'][0]['data'])) {
                try {
                    $data = base64_encode($OldThisFileInfo['comments']['picture'][0]['data']);
                    $base64 = $data;
                    $imageBlob = base64_decode($base64);

                    $imagick = new Imagick();
                    $imagick->readImageBlob($imageBlob);
                    $imagick->writeImage("image/$random_number_image");
                    $imagick->destroy();
                } catch (Exception $ex) {
                    copy("tmp/default.jpeg", "image/$random_number_image");
                }
            } else {
                copy("tmp/def.jpg", "image/$random_number_image");
            }
        }
    }
}
$MUSIC = $random_file_name;
$USERID = $_SESSION['userid'];
$IMG = $random_number_image;
$WAVEIMG = $random_number . ".png";

$TITLE = $_POST['title'];
$TITLE = htmlspecialchars($TITLE);
$TITLE = mysqli_escape_string(QUERY::$con, $TITLE);
$TITLE = ucwords($TITLE);

$DESC = $_POST['description'];
$DESC = htmlspecialchars($DESC);
$DESC = mysqli_escape_string(QUERY::$con, $DESC);
$DESC = ucfirst($DESC);

$TAG = $_POST['tag'];
$TAG = htmlspecialchars($TAG);
$TAG = mysqli_escape_string(QUERY::$con, $TAG);

$URL = strtolower($TITLE);
$URL = preg_replace("![^a-z0-9]+!i", "-", $TITLE);
if (QUERY::c("select count(*) from music where url='{$URL}'") != "0") {
    $URL = $URL . "-" . time();
}
require('classAudioFile.php');
$NAME = $INSERT_FILE_NAME;
$TIME = time();
$LOGID = (isset($_SESSION['info'])) ? $_SESSION['info'] : 0;
$musicPrivacy = trim($_POST['privacy']);
if ($musicPrivacy == "false") {
    $musicPrivacy = 0;
} else {
    $musicPrivacy = 1;
}
QUERY::query(""
    . "insert into music(music,userid,img,waveimg,title,name,time,descrption,url,logid,privacy) "
    . "values('{$MUSIC}',$USERID,'{$IMG}','{$WAVEIMG}','{$TITLE}','{$NAME}',$TIME,'{$DESC}','{$URL}',$LOGID,$musicPrivacy)");
rename("tmp/$random_file_name", "audio/public/$random_file_name");


$no = $random_number;
$target_file = "audio/public/$no.mp3";
$target_wave = "waveform/$no.wav";
exec("ffmpeg -i $target_file -acodec pcm_s16le $target_wave");
try {
    $AF = new AudioFile;
    $AF->loadFile("$target_wave");
    if ($AF->wave_id == "RIFF") {
        $AF->visual_width = 1200;
        $AF->visual_height = 200;
        $WAVE_PATH = substr("$target_wave", 0, strlen("$target_wave") - 4) . ".png";
        $AF->getVisualization($WAVE_PATH);

        $imagick = new Imagick($WAVE_PATH);
        $imagick->cropImage(1200, 100, 0, 0);
        $imagick->writeImage($WAVE_PATH);
        $imagick->destroy();
        unlink($target_wave);
    }
} catch (Exception $ex) {

}


if ($musicPrivacy == 1 || $musicPrivacy == "1") {
    rename("audio/public/$random_file_name", "audio/private/$random_file_name");
}


$musicid = QUERY::c("select musicid from music where userid=$USERID and time=$TIME");
QUERY::query("insert into tag(tagname,musicid,time) values('{$TAG}',$musicid,$TIME)");

$response = array("status" => 1, "message" => "Sucessfully Uploaded.");
echo json_encode($response);
//rename("tmp/$random_number_image", "waveform/$random_number_image");
?>