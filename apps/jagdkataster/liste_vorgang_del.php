<?php
include ("/var/www/apps/geoportal/includes/connect_geobasis.php");
$ip=getenv('REMOTE_ADDR');
session_start();

$_SESSION['angemeldet'] = (isset($_SESSION['angemeldet'])?$_SESSION['angemeldet']:false);

if ($_SESSION['angemeldet'] === true)
{
	$_SESSION["pruef"] = (isset($_SESSION["pruef"])?$_SESSION["pruef"]:true);
	$status='angemeldet';
	


## Filteroptionen übernehmen

$sb=$_GET["sb"];
if ($sb=='x') unset($sb);
$huel=$_GET["huel"];
if ($huel=='x') unset($huel);
$vorgangsart=$_GET["vorgangsart"];
if ($vorgangsart=='x') unset($vorgangsart);
$art=$_GET["art"];
if ($art=='x') unset($art);
$vstatus=$_GET["vstatus"];
if ($vstatus=='x') unset($vstatus);
$e_status=$_GET["e_status"];
if ($e_status=='x') unset($e_status);
$jb_id=$_GET["jb_id"];
if ($jb_id=='x') unset($jb_id);
$jahrgang=$_GET["jahrgang"];
if ($jahrgang=='x') unset($jahrgang);
$jahrgang_status=$_GET["jahrgang_status"];
if ($jahrgang_status=='x') unset($jahrgang_status);

$delete_id=$_GET["delete_id"];

$query="UPDATE jagdkataster.vorgangsverwaltung SET erledigt=now() WHERE gid='$delete_id'";
$result = $dbqueryp($connectp,$query);

?>


	<head>
	<meta http-equiv=\"refresh\" content=\"0; URL=liste_vorgang.php\">
	</head>
    <body onLoad="document.form1.submit()">
<?
echo ' <form action="liste_vorgang.php" method=POST name="form1">';
  if (isset($sb)) echo '<input type="hidden" name="sb" value="',$sb,'">';
  if (isset($huel)) echo '<input type="hidden" name="huel" value="',$huel,'">';
  if (isset($vorgangsart)) echo '<input type="hidden" name="vorgangsart" value="',$vorgangsart,'">';
  if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
  if (isset($jb_id)) echo '<input type="hidden" name="jb_id" value="',$jb_id,'">';
  if (isset($vstatus)) echo '<input type="hidden" name="vstatus" value="',$vstatus,'">';
  if (isset($e_status)) echo '<input type="hidden" name="e_status" value="',$e_status,'">';
  if (isset($jahrgang)) echo '<input type="hidden" name="jahrgang" value="',$jahrgang,'">';
  if (isset($jahrgang_status)) echo '<input type="hidden" name="jahrgang_status" value="',$jahrgang_status,'">';
echo '</form>';
?>  
</body>

<?	
}

	
echo "</table>";
 
?>
</body>
</html>