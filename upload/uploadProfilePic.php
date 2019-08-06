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
$USERID = $_SESSION['userid'];
$target_dir = "profile/pic/";
$musicPicExten = explode(".", $_FILES["profilePic"]["name"]);
$musicPicExten = array_pop($musicPicExten);
$allowedExtension = array("jpg", "jpeg", "png", "gif");
if (!in_array($musicPicExten, $allowedExtension)) {
    $response = array("status" => 3, "message" => "Only JPG, PNG and GIF Files");
    echo json_encode($response);
    exit();
}
$random_number = md5(time() + "MUSIC");
$random_number_image = $random_number . ".$musicPicExten";
$target_music_file = $target_dir . $random_number_image;
move_uploaded_file($_FILES["profilePic"]["tmp_name"], "$target_music_file");
$imagick = new Imagick($target_music_file);
$imagick->resizeImage(200, 200, imagick::FILTER_LANCZOS, 1, true);
$imagick->writeImage($target_music_file);
$imagick->destroy();
$PREVIOUS_IMG = QUERY::c("select img from usersignup where userid=$USERID");
if ($PREVIOUS_IMG != "default.jpg") {
    unlink($target_dir . $PREVIOUS_IMG);
}
QUERY::query("update usersignup set img='{$random_number_image}' where userid=$USERID");

$response = array("status" => 1, "message" => "Success");
echo json_encode($response);
?>