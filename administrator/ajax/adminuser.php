<?php
if (!isset($_SESSION['userid'])) {
    echo "<h3>Login First</h3>";
    exit();
}
$GROUP_ID = $_SESSION['groups'];
if (QUERY::c("select count(*) from groups where groupid=$GROUP_ID && permission IN ('*','edituser')")=="0") {
    echo "<h3>Permission Denied.</h3>";
    exit();
}
?>
<h2>User's List</h2>
<table>
    <?php
    $query = "select userid,username,groups,status,time from usersignup";
    $COUNT_QUERY = $query;
    $MUSIC_PER_PAGE = 10;
    $START_FROM = ($PAGE_NUMBER-1)*$MUSIC_PER_PAGE;
    $result = QUERY::query("$query order by time desc limit $START_FROM,$MUSIC_PER_PAGE");
    while ($res = mysqli_fetch_array($result)) {
        extract($res);
        $PERMISSION = QUERY::c("select groupname from groups where groupid=$groups");
        $STATUS = ($status==0)?"Enabled":"Disabled";
        $TIME = date("F j, Y, g:i a",$time); 
        ?>
        <tr>
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;"><?php echo $username; ?></span></td>
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;"><?php echo $STATUS; ?></span></td> 
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;"><?php echo $PERMISSION; ?></span></td>
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;"><?php echo $TIME; ?></span></td>
            
            <td style="background: #333;color:#FFF;padding: 10px;"><a href="/user/<?php echo $username;?>" target="_blank">View</a></td>
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;" onclick="loadAdminPage('user/<?php echo $username;?>')">Edit</span></td>   
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
        <li><a onclick='loadAdminPage("adminmusic/<?php echo $PAGE_NUMBER-1;?>")'><input type="button" class="pagingButton" value="previous"/></a></li>
        <?php } ?>
        <?php if ($PAGE_NUMBER*$MUSIC_PER_PAGE < $TOTAL_COUNT) { ?>
        <li><a onclick='loadAdminPage("adminmusic/<?php echo $PAGE_NUMBER+1;?>")'><input type="button" class="pagingButton" value="next"/></a></li>
        <?php } ?>
    </ul>
</div>
