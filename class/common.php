<?php
class common{
	public static $con;
	public static $pathname;
	public static $sitepath;
	public static $sitename;
	public static $isloggedin = false;
function __construct(){
	$host="localhost";
	$user="root";
	$pass="";
	$db="initedit_music";
	$con=mysqli_connect($host,$user,$pass,$db);
	if(!$con){
	  echo mysqli_error($con);
	  exit();
	}
	common::$con=$con;	
	common::$pathname="http://buzztunes.com/";
	common::$sitepath=common::$pathname."s/";
	common::$sitename="InIt";
	if(isset($_SESSION['username'])){
	  common::$isloggedin=true;	
	}
}	
}
?>
