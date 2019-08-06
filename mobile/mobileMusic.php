<?php

class MobileMusicModel {

    public $id;
    public $name;
    public $title;
    public $filename;
    public $imageName;
    public $imageWave;
    public $userId;
    public $userName;
    public $time;
    public $url;
    public $playlistClass;
    public $privacy;

}

class MobileMusicView {

    static $COUNT = 0;

    static function output(MobileMusicModel $model) {
        $temp = explode(".", $model->filename);
        $model->filename = array_shift($temp);
        ?>
        <ul class="vl mMusicCard">
            <li onclick="playSound('<?php echo $model->filename; ?>')" class="imgHolder">
                <div style="background: url(/upload/image/<?php echo $model->imageName; ?>);background-size: cover;" class="img"></div>
            </li>
            <li class="title"><?php echo $model->title; ?></li>
            <li class="username">by <?php echo $model->userName; ?></li>
        </ul>
        <?php
    }

}
?>