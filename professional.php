
<?


$ip=getenv('REMOTE_ADDR');
$ip_array=explode(".",$ip);

if ($ip != "192.168.101.18") 
   {
    $extern=0;
    $url="https://geoport.landkreis-mueritz.de/kvwmap\" onclick=\"window.open(this.href); return false;";
   }
   else
   {
    $extern=1;
    $url="http://www.landkreis-mueritz.de:443/gis/kvwmap\" onclick=\"window.open(this.href); return false;";
   }

session_destroy();

echo "<div align='center'><br><br>Sie werden automatisch zum Geoportal weitergeleitet....<br><br> <img src='images/ROTATI00.GIF'></div>
<head>
<meta http-equiv=\"refresh\" content=\"2; URL=$url\">
</head>";
?>
