<?php
if (!isset($_SESSION['userid'])) {
    echo "<h3>Login First</h3>";
    exit();
}
$GROUP_ID = $_SESSION['groups'];
if (QUERY::c("select count(*) from groups where groupid=$GROUP_ID && permission IN ('*','editmusic')") == "0") {
    echo "<h3>Permission Denied.</h3>";
    exit();
}
$IS_DELETING_ALOOWED = QUERY::c("select count(*) from groups where groupid=$GROUP_ID && permission IN ('*','deletemusic')");
?>
<h2>Music List</h2>
<table>
    <?php
    $query = "select title,descrption,url,music from music";
    $COUNT_QUERY = $query;
    $MUSIC_PER_PAGE = 10;
    $START_FROM = ($PAGE_NUMBER - 1) * $MUSIC_PER_PAGE;
    $result = QUERY::query("$query order by time desc limit $START_FROM,$MUSIC_PER_PAGE");
    while ($res = mysqli_fetch_array($result)) {
        extract($res);
        $tmpMusicId = explode(".", $music);
        $tmpMusicId = array_shift($tmpMusicId);
        ?>
        <tr>
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;"><?php echo ucwords($title); ?></span></td>
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="width: 25px;background: #FFF;"></span></td>
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;"><?php echo $descrption; ?></span></td>
            <td style="background: #333;color:#FFF;padding: 10px;"><a href="/music/<?php echo $url; ?>" target="_blank">View</a></td>
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;" onclick="loadAdminPage('music/<?php echo $url; ?>')">Edit</span></td>
            <?php if ($IS_DELETING_ALOOWED != "0") { ?>
                <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;" onclick="deleteMusic('<?php echo $tmpMusicId; ?>')">Delete</span></td>
            <?php } ?>
        </tr>
        <?php
    }
    $TOTAL_COUNT = QUERY::c("select count(*) from ($COUNT_QUERY) as temp");
    ?>
</table>
<div class="clearFix"></div>
<p></p>
<div>
    <ul class="hl" style="float:left;">
        <?php if ($PAGE_NUMBER > 1) { ?>
            <li><a onclick='loadAdminPage("adminmusic/<?php echo $PAGE_NUMBER - 1; ?>")'><input type="button" class="pagingButton" value="previous"/></a></li>
        <?php } ?>
        <?php if ($PAGE_NUMBER * $MUSIC_PER_PAGE < $TOTAL_COUNT) { ?>
            <li><a onclick='loadAdminPage("adminmusic/<?php echo $PAGE_NUMBER + 1; ?>")'><input type="button" class="pagingButton" value="next"/></a></li>
                <?php } ?>
    </ul>
</div>
