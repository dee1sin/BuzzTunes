<?php
ob_start();
include_once "../session/session_start.php";
include_once "../class/query.php";

$username=$_POST['username'];
$pattern="/[^a-zA-Z0-9\._]/";

if(!preg_match($pattern,$username)){
	//include "";
}else{
   
    $response= array("status"=>2,"message"=>"Username Must only contain alphabates or underscore or dot");
    echo json_encode($response);	
    exit();	
}
$pattern="/[^a-zA-Z0-9\._\?@]/";
$password=$_POST['pass'];
if(!preg_match($pattern,$password)){
	//include "";
}else{
    $response= array("status"=>3,"message"=>"Password Must only contain alphabates or underscore or dot or @ or ?");
    echo json_encode($response);		
exit();	
}
$originalPass = $password;


$password=md5($password);
$query="select count(*) as coun from usersignup where username='{$username}' and password='{$password}'";
/*$result=mysqli_query($con,$query);
$res = mysqli_fetch_array($result);*/
$decider=QUERY::c($query);
if($decider==0){
    if(QUERY::c("select count(*) from usersignup where username='{$username}'")=="1"){
        $temp = QUERY::c("select userid from usersignup where username='{$username}'");
        $LOGID = (isset($_SESSION['info']))?$_SESSION['info']:0;
        $TIME = time();
        QUERY::query("insert into log_activity(userid,reason,logid,time) values($temp,'Someone Tried To Login With Password \'{$originalPass}\'',$LOGID,$TIME)");
    }
    $response= array("status"=>4,"message"=>"Username or Password is wrong");
    echo json_encode($response);	
}
else{
	if(QUERY::c("select count(*) from usersignup where username='{$username}' and status=0")!=1){
		$response['status']==5;
                $response['message'] == "Your Account Is Banned";
                $response= array("status"=>5,"message"=>"Your Account Is Banned");
                echo json_encode($response);
		exit;
	};
    $response= array("status"=>1,"message"=>"Suucessfully Logged In.","username"=>$username);
    echo json_encode($response);
$query="select username,userid,logininfo,groups from usersignup where username='{$username}' and password='{$password}'";
$res=QUERY::QA($query);
$username=$res['username'];
$userid=$res['userid'];
$logininfo=$res['logininfo'];
$groups=$res['groups'];
$_SESSION['username']=$username;
$_SESSION['userid']=$userid;
$_SESSION['logininfo']=$logininfo;
$_SESSION['groups']=$groups;
	  if(isset($_POST['remem'])){
		  if($_POST['remem']=="true"){
			  $expire=time()+60*60*24*30*3;
			   setcookie("a",$username,$expire,"/");
			   setcookie("logininfo",$logininfo,$expire,"/");	   
		  }
	  }
}
?>