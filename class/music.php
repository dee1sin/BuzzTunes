<?php

class MusicModel {

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

class MusicView {

    static $COUNT = 0;

    static function output(MusicModel $model) {
        $temp = explode(".", $model->filename);
        $model->filename = array_shift($temp);

        $temp = "setting_" . md5(time() + MusicView::$COUNT);
        MusicView::$COUNT++;

        if ($model->userid == @$_SESSION['userid']) {
            $owener = true;
        } else {
            $owener = false;
        }
        $settingOptionPrivate = "display:none;";
        if ($owener) {
            $settingOptionPrivate = "display:block;";
        }
        $settingOptionIsPublic = "display:block;";
        $settingOptionIsPrivate = "display:none;";
        if ($model->privacy == 1) {
            $settingOptionIsPublic = "display:none;";
            $settingOptionIsPrivate = "display:block;";
        }
        ?>
    <ul class="vl musicSortCard" style="overflow: visible;" id="musicSortCard_<?php echo $model->filename; ?>">
            <li class="eh"  data-musicid="<?php echo $model->filename; ?>" style="position: relative;cursor: pointer;">
                <div  class="musicSortCardImageHolder <?php echo $model->playlistClass; ?>"  data-playlistclass="<?php echo $model->playlistClass; ?>" data-img="/upload/image/<?php echo $model->imageName; ?>" data-name="<?php echo $model->userName; ?>" data-filename="<?php echo $model->filename; ?>" data-musicid="<?php echo $model->filename; ?>" data-title="<?php echo $model->title; ?>" id="audio_<?php echo $model->filename; ?>" style="background: url(/upload/image/<?php echo $model->imageName; ?>);min-height:150px;min-width:100px;background-repeat: no-repeat;background-size: cover;background-color: #CCC;" ></div>
                
            </li>
            <li class="musicSortCardDetailContainer" >
                <ul class="hl" >
                    <li>
                        <ul class="vl">
                            <li style="font-size: 0.9em;width: 100px;font-weight:500;overflow: hidden;height: 20px"><a href="/music/<?php echo $model->url; ?>" style="word-break: break-all;"><?php echo $model->title; ?></a></li>
                            <li style="font-size: 0.7em;">by <a href="/user/<?php echo $model->userName; ?>/overview"><?php echo $model->userName; ?></a></li>
                        </ul>
                    </li>
                    <li style="float: right;">
                        <div style="position: relative; padding-top: 15px;">
                            <i class="sprite sprite-moreIcon_16 MUSIC_SETTING" onclick="toggleMusicIndivisualSetting()" data-settingid="<?php echo $temp; ?>"></i>
                            <ul id="<?php echo $temp; ?>" class="vl musicSettingOption">
                                <li onclick="addToPlayList('<?php echo $model->filename; ?>')"  class="options">Add To Playlist</li>
                                <li onclick="addToCurrentPLayingPlayList('<?php echo $model->filename; ?>')"  class="options">Add To Current Playlist</li> 
                                <li class="rms">
                                    <ul class="vl" style="<?php echo $settingOptionPrivate; ?>">
                                        <li style="<?php echo $settingOptionIsPublic; ?>;" id="settingPublic_<?php echo $model->filename; ?>" onclick="chnageIndivisualMusicToPrivate('<?php echo $model->filename; ?>')" class="options">Public</li>
                                        <li style="<?php echo $settingOptionIsPrivate; ?>;" id="settingPrivate_<?php echo $model->filename; ?>" onclick="chnageIndivisualMusicToPublic('<?php echo $model->filename; ?>')" class="options">Private</li>
                                        <li style="" id="deleteMusic_<?php echo $model->filename; ?>" onclick="deleteIndivisualMusic('<?php echo $model->filename; ?>')" class="options">Delete</li>
                                        
                                    </ul>
                                </li>
                                <li class="options" onclick="showShareDialog('<?php echo $model->filename; ?>')">Share</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>

        </ul>
        <?php
    }

}
?>