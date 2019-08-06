<div class="signupBox">
    <div class="signupBoxContainer">
        <div class="signupTitle">   <b>Sign Up </b></div>
        <p></p>
        <div id="signupProcessing" style="display: none;text-align: center;" ><img src="/image/loader.gif" width="50"/></div>
        <div class="error" id="signuperror"></div>
        <div>   Username   <span id="errorusername" class="error"></span></div>
        <div><input type="text" placeholder="Enter Your Username" class="input autofocus" id="signUpName" autofocus="autofocus"/></div>
        <p></p>
        <div>   Password   <span id="errorSignUpPassword" class="error"></span></div>
        <div><input type="password" placeholder="Enter Your Password" class="input" id="signUpPass"/></div>
        <p></p>
        <div>   Confirm password   <span id="errorSignUpPassword" class="error"></span></div>
        <div><input type="password" placeholder="Enter Password Again" class="input" id="signUpConfirm"/></div>
        <p></p>
        <div><input type="button" id="signupButton" value="Signup" class="input loginButton" onclick="signup()"/></div>
        <p></p>
        <div><div><a href="/login" class="link">Log in?</a></div></div>
    </div>
</div>
