<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../class/query.php";
include_once "../session/session_start.php";
$WAVE_NAME = trim($_POST['name']);
$img = trim($_POST['image']);
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$base64 = $img;
$imageBlob = base64_decode($base64);
$imagick = new Imagick();
$imagick->readImageBlob($imageBlob);
$imagick->writeImage("waveform/".$WAVE_NAME);
$imagick->destroy();
QUERY::query("update music  set wave_progress=1 where waveimg=' {$WAVE_NAME}'")
?>