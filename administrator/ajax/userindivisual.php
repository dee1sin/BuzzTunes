<?php
if (!isset($_SESSION['userid'])) {
    echo "<h3>Login First</h3>";
    exit();
}
$GROUP_ID = $_SESSION['groups'];
if (QUERY::c("select count(*) from groups where groupid=$GROUP_ID && permission IN ('*','user')")=="0") {
    echo "<h3>Permission Denied.</h3>";
    exit();
}
?>
<h1>User - Edit</h1>
<p></p>
<div><h3><?php echo $USERNAME; ?></h3></div>
<p></p>
<div>
    <h4>Account Status</h4>
</div>
<div>
    <select style="padding:10px 20px;" id="accountStatus">
        <option value="0">
            Enabled
        </option>
        <option <?php echo ($USERSTATUS!="0")?"selected":"";?> value="1">
            Disabled
        </option>
    </select>
</div>
<div><h4>Group (Adminship Level)</h4></div>
<div>
    <select style="padding:10px 20px;" id="adminshipLevel">
        <?php
        $USERGROUP = 
        $result = QUERY::query("select DISTINCT groupname  from groups");
        
        while ($res = mysqli_fetch_array($result)) {
            extract($res);
            if($groupname == $USERGROUPNAME){
            echo "<option selected>$groupname</option>";
            }else{
            echo "<option>$groupname</option>";
            }
        }
        ?>
    </select>
</div>
<p></p>
<input type="button" value="Update" onclick="editUser('<?php echo $USERNAME;?>')" class="input loginButton"/>
<p></p>