
<div class="loginBox">
    <div class="loginBoxContainer">
        <div class="loginTitle">   <b>Login Page</b> </div>
        <p></p>
        <div id="loginProcessing" style="display: none;text-align: center;" ><img src="/image/loader.gif" width="50"/></div>
        <div class="error" id="wrongpassword"></div>
        <p></p>
        <div>   Username   </div>
        <div><input type="text" class="input autofocus" placeholder="Enter Your Username" id="loginName" autofocus="autofocus"/></div>
        <p></p>
        <div>   Password   </div>
        <div><input type="password" class="input" placeholder="Enter Your Password" id="loginPass"/></div>
        <p></p>
        <div><input type="checkbox" id="logincheckbox" /> remember password</div>
        <p></p>
        <div><input type="button" id="loginButton" class="input loginButton" value="Log in" onclick="login()"/></div>
        <p></p>
        <div><div><a href="/signup" class="link">Create account?</a></div></div>
    </div>
</div>
