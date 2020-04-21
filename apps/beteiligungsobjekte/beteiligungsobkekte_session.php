<?php

require_once "config.cfg";

function write_i_log($db_link,$log_thema_id)
   {
     $ip=getenv('REMOTE_ADDR');
     $uri=getenv('REQUEST_URI');
     $query="INSERT INTO u_consume_geoportal (time_id,log_ip,log_thema_id,request_uri) VALUES (now(),'$ip','$log_thema_id','$uri')";
     mysqli_query($db_link,$query) OR DIE ("Der Eintrag konnte nicht angelegt werden...");
     return true;
   }

session_start();


$_SESSION['angemeldet'] = (isset($_SESSION['angemeldet'])?$_SESSION['angemeldet']:false);

if ($_SESSION['angemeldet'] === true){
	$_SESSION["pruef"] = (isset($_SESSION["pruef"])?$_SESSION["pruef"]:true);
	include ('beteiligungsobjekte.php');

#$server=getenv('MYSQL_PORT_3306_TCP_ADDR');
$server="mysql-server";
$nutzer= $nutz;
$password= $pw;
$dbname= $db;

$db_link=mysqli_connect($server,$nutzer,$password);
if (!$db_link) {
    die('Verbindung nicht möglich : ' . mysql_error());
  }


mysqli_select_db($db_link,$dbname);

mysqli_query($db_link,"SET NAMES 'utf8'");
$log=write_i_log($db_link,'191400');
	
	
}else{
	
	include ('errorpage.php');
}
	
?>

