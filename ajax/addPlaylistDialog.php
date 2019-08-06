<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);
include_once "../session/session_start.php";
include_once "../class/query.php";
if(!isset($_SESSION['userid'])){
    echo "<h2 style='max-width:500px;margin:0 auto;padding-top:100px;'>Login To Create Your Own Playlist</h2>";
    exit;
}


$MUSICID = trim($_POST['musicid']);
$userid = $_SESSION['userid'];
?>
<div style="overflow: hidden;background: #FFF;max-width: 500px;margin: 0 auto;">
    <div style="overflow: hidden;" >
        <ul class="hl">
            <li style="margin-right: 50px;cursor: pointer;" onclick="changeToCreateNewPlaylist()" id="changeToCreateNewPlaylist">
                <h2>Add To PlayList</h2>
                <p class="addPlayListBorderHighlight" id="changeToCreateNewPlaylistBorder"></p>
            </li>
            <li style="cursor: pointer;" onclick="changeToAddToExistingPlaylist()" id="changeToAddToExistingPlaylist">
                <h2>Create New PlayList</h2>
                <p class="addPlayListBorderNormal" id="changeToAddToExistingPlaylistBorder"></p>
            </li>
        </ul>
    </div>
    <div id="addToPlayListPopulatedList">
        <div class="error" id="existingplayListError"></div>
        <ul class="vl" style="max-height: 500px;overflow-y: auto;">
            <?php
            $result = QUERY::query("select name,playlistid from playlistname where userid=$userid");
            if(mysqli_num_rows($result)==0){
                echo "<h3 style='color:#999;'>No Playlist Created Yet.</h3>";
                echo "<!--<input type='button' value='Create New Playlist' onclick='changeToCreateNewPlaylist()' class='input loginButton'/>-->";
               
            }
            while ($res = mysqli_fetch_array($result)) {
                extract($res);
                $musicidlocal = QUERY::c("select musicid from music where music='{$MUSICID}.mp3'"); //16
                $isAlready = QUERY::c("select count(*) from playlist where playlistid=$playlistid and musicid=$musicidlocal"); //0
                $style = "style='display:block;'";
                $style1 = "style='display:none;'";
                if ($isAlready == "1") {
                    $style1 = "style='display:block;'";
                    $style = "style='display:none;'";
                }

                echo "<li style='background:#333;color:#FFF;padding:10px 5px;margin-bottom:5px;'><span>$name</span><span style='float:right;'>"
                . "<input type='button' id='addtoplaylist_{$MUSICID}{$playlistid}' $style value='add to playlist' onclick=\"addToExistingPlayList('{$MUSICID}','{$name}')\"/>"
                . "<input type='button' class='addedPlaylistButton' id='addedtoplaylist_{$MUSICID}{$playlistid}' $style1 value='added' onclick=\"removeFromExistingPlayList('{$MUSICID}','{$name}')\"/>"
                . "</span></li>";
            }
            ?>
        </ul>
    </div>
    <div id="createNewPlayListPopulatedList" style="display: none;">
        <div class="error" id="newplayListError"></div>
        <p></p>
        <div style="font-weight: bold;">Playlist Title</div>
        <p></p>
        <div>
            <input type="text" placeholder="Enter Playlist name" id="newPlayListName" class="input"/>
        </div>
        <p></p>
        <div>
            <div style="font-weight: bold;">Playlist Will Be</div>
            <p></p>
            <div>
                <span>
                    <input type="radio" id="newPlayListPrivacy" value="1" name="playlistPrivacy" id="playlistPrivacy"/>Private
                </span>
                <span>
                    <input type="radio" checked="checked" value="0" name="playlistPrivacy" id="playlistPrivacy"/>Public
                </span>
            </div>
        </div>
        <p></p>
        <div>
            <input type="button" class="input loginButton" onclick="createNewPlayList('<?php echo $MUSICID; ?>')" value="Create New Playlist"/>
        </div>
    </div>
</div>