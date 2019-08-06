<?php
include_once "../class/query.php";
include_once "../session/session_start.php";

$username=$_POST['username'];
$pattern="/[^a-zA-Z0-9_\.]/";
if(!preg_match($pattern,$username)){

}else{
 $response= array("status"=>2,"message"=>"Username Must only contain alphabates ,numbers or underscore or dot");
 echo json_encode($response);	
exit();	
}
$pattern="/[^a-zA-Z0-9\._@\?]/";
$password=$_POST['pass'];
if(!preg_match($pattern,$password)){
}else{
$response= array("status"=>3,"message"=>"Password Must only contain alphabates ,numbers or underscore or dot or @ or ?");
echo json_encode($response);	
exit();	
}
if($username=="" || $password==""){
$response= array("status"=>4,"message"=>"Username And Password Are Required.");
echo json_encode($response);
exit();	
}
$privatename=array("editors","hash","search","blog","profile","etc","php","css","js","t","s","img","pimg","tags","login","activity","m","messages","signup","about","help","suggest","bottom","ar","default","mobile","link","text","dev","d","new","view","rising","top","hot","photos","albums","hash","tags","pages","page","api","admin","root");
if(in_array(strtolower($username),$privatename)){
$response= array("status"=>5,"message"=>"Username Already Exists.");
echo json_encode($response);
exit();	
}

$query="select count(*) as coun from usersignup where username='{$username}'";
$decider=QUERY::c($query);
if($decider!=0){
$response= array("status"=>6,"message"=>"Username Already Exists.");
echo json_encode($response);
exit();		
}
else{
$password=md5($password);	
$i=md5(rand());
$time = time();
$LOGID = (isset($_SESSION['info']))?$_SESSION['info']:0;
$query="insert into usersignup(username,password,logininfo,time,logid) values('$username','{$password}','{$i}',$time,$LOGID)";
$result=QUERY::insert($query);
$response= array("status"=>1,"message"=>"Suucessfully Account Created.");
echo json_encode($response);	  
}
?>