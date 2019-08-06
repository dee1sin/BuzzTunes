<?php
if (!isset($_SESSION['userid'])) {
    echo "<h3>Login First</h3>";
    exit();
}
$GROUP_ID = $_SESSION['groups'];
if (QUERY::c("select count(*) from groups where groupid=$GROUP_ID && permission IN ('*','error')")=="0") {
    echo "<h3>Permission Denied.</h3>";
    exit();
}
?>




<h2>Error List</h2>
<table>
    <?php
    $query = "select query,error,page,get_params,post_params,time from log_query_error";
    $COUNT_QUERY = $query;
    $MUSIC_PER_PAGE = 10;
    $START_FROM = ($PAGE_NUMBER-1)*$MUSIC_PER_PAGE;
    $result = QUERY::query("$query order by time desc limit $START_FROM,$MUSIC_PER_PAGE");
    if(mysqli_num_rows($result)==0){
        echo "<h3>:) Good ... We Didn't Caught Any Error.</h3>";
    }
    while ($res = mysqli_fetch_array($result)) {
        extract($res);
        $TIME = date("F j, Y, g:i a",$time); 
        ?>
        <tr>
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;"><?php echo $query; ?></span></td>
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;"><?php echo $error; ?></span></td> 
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;"><?php echo $page; ?></span></td>
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;"><?php echo $get_params; ?></span></td>
            <td style="background: #333;color:#FFF;padding: 10px;"><span style="margin-right: 25px;"><?php echo $post_params; ?></span></td>      
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
        <li><a onclick='loadAdminPage("adminerror/<?php echo $PAGE_NUMBER-1;?>")'><input type="button" class="pagingButton" value="previous"/></a></li>
        <?php } ?>
        <?php if ($PAGE_NUMBER*$MUSIC_PER_PAGE < $TOTAL_COUNT) { ?>
        <li><a onclick='loadAdminPage("adminerror/<?php echo $PAGE_NUMBER+1;?>")'><input type="button" class="pagingButton" value="next"/></a></li>
        <?php } ?>
    </ul>
</div>
