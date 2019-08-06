<?php

/*
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require ('classAudioFile.php');
  $files1 = scandir("audio");
  for ($i = 2; $i < count($files1); $i++) {
  $no =$files1[$i];
  $no = explode(".", $no);
  $no = array_shift($no);
  $target_file = "audio/$no.mp3";
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
  }
 * 
 */
//echo exec("ffmpeg -i audio/67ec995423100e2ee63193af2f5f1b55.mp3 -acodec libmp3lame -b:a 8k -ac 1 -ar 11025 tempaudio/67ec995423100e2ee63193af2f5f1b55.mp3");
$ffmpeg = trim(shell_exec('ffmpeg -version')); // or better yet:
if (empty($ffmpeg)) {
    die('ffmpeg not available');
} else {
    echo "Installed";
}
?>