<?php
if (!isset($_SESSION['userid'])) {
    echo "<h3>Login First</h3>";
    exit();
}
$GROUP_ID = $_SESSION['groups'];
if (QUERY::c("select count(*) from groups where groupid=$GROUP_ID && permission IN ('*','stats')")=="0") {
    echo "<h3>Permission Denied.</h3>";
    exit();
}
?>


<?php
$TOTAL_USER = QUERY::c("select count(*) from usersignup");
$TOTAL_MUSIC = QUERY::c("select count(*) from music");
$TOTAL_PLAYLIST = QUERY::c("select count(*) from playlistname");
?>


<h2>General Statistics</h2>
<ul class="vl stats" >
    <li class="statItem">
        <ul class="hl itemContainer">
            <li>Users</li>
            <li><?php echo $TOTAL_USER; ?></li>
        </ul>
    </li>

    <li class="statItem">
        <ul class="hl itemContainer" >
            <li>Music</li>
            <li><?php echo $TOTAL_MUSIC; ?></li>
        </ul>
    </li>

    <li class="statItem">
        <ul class="hl itemContainer">
            <li>Playlist</li>
            <li><?php echo $TOTAL_PLAYLIST; ?></li>
        </ul>
    </li>
</ul>

<h2>Browser Statistics</h2>
<ul class="vl stats" >
    <?php
    $result = QUERY::query("select browsername ,count(*) as total from log_browser_os group by browsername order by total desc");
    while ($res = mysqli_fetch_array($result)) {
        extract($res);
        ?>
        <li class="statItem">
            <ul class="hl itemContainer">
                <li><?php echo ucwords($browsername);?></li>
                <li><?php echo $total; ?></li>
            </ul>
        </li>
        <?php
    }
    ?>
</ul>


<h2>OS Statistics</h2>
<ul class="vl stats" >
    <?php
    $result = QUERY::query("select os ,count(*) as total from log_browser_os group by os order by total desc");
    while ($res = mysqli_fetch_array($result)) {
        extract($res);
        ?>
        <li class="statItem">
            <ul class="hl itemContainer">
                <li><?php echo ucwords($os);?></li>
                <li><?php echo $total; ?></li>
            </ul>
        </li>
        <?php
    }
    ?>
</ul>

