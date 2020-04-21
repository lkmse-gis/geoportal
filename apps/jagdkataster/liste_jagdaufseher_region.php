<?php
include ("/var/www/apps/geoportal/includes/connect_geobasis.php");
$ip=getenv('REMOTE_ADDR');
session_start();

$_SESSION['angemeldet'] = (isset($_SESSION['angemeldet'])?$_SESSION['angemeldet']:false);

if ($_SESSION['angemeldet'] === true)
{
	$_SESSION["pruef"] = (isset($_SESSION["pruef"])?$_SESSION["pruef"]:true);
	$status='angemeldet';
	

$datum = getdate(time());
$year=$datum[year];
$month=$datum[mon];
$day=$datum[mday];
$hour=$datum[hours];
$minute=$datum[minutes];
$second=$datum[seconds];
if (strlen($month) == 1) $month='0'.$month;
if (strlen($day) == 1) $day='0'.$day;
if (strlen($hour) == 1) $hour='0'.$hour;
if (strlen($minute) == 1) $minute='0'.$minute;
if (strlen($second) == 1) $second='0'.$second;
$heute=$day.'.'.$month.'.'.$year;
$modus=$_GET["modus"];
$post_modus=$_POST["post_modus"];
if (!isset($modus) AND isset($post_modus)) $modus="kvwmap";
$region_id=$_POST["region"];
unset($ejb);
unset($gjb);
$filter=$_POST["filter"];
$art=$_POST["art"];
$count=0;


if ($region_id >= 1)
  {
    $query="SELECT name FROM government.regionen WHERE gid='$region_id'";
    $result = $dbqueryp($connectp,$query);
    $r = $fetcharrayp($result);
	$region=$r[name];
	  	
	$query="SELECT c.oid,a.gid,a.new_gid,a.inhaber,a.plz_ort,a.strasse_hnr,to_char(a.gueltig_bis,'dd.mm.yyyy') as datum, c.name  FROM jagdkataster.jagdbezirke as c , government.regionen as b, jagdkataster.jb_jagdaufseher as a WHERE  c.endet IS NULL AND (a.new_gid=c.new_gid)  AND st_intersects(st_transform(c.the_geom,25833),b.the_geom) AND b.gid='$region_id'";
        if (strlen($filter) > 0) $query=$query." AND a.inhaber LIKE '%$filter%' ";
	$query=$query."	ORDER BY a.inhaber";
  }
  else 
  {
   $region="Gesamtliste";
   
	   	$query="SELECT c.oid,a.gid,a.new_gid,a.inhaber,a.plz_ort,a.strasse_hnr,to_char(a.gueltig_bis,'dd.mm.yyyy') as datum, c.name  FROM jagdkataster.jagdbezirke as c , jagdkataster.jb_jagdaufseher as a WHERE  c.endet IS NULL AND (a.new_gid=c.new_gid)";
        if (strlen($filter) > 0) $query=$query." AND a.inhaber LIKE '%$filter%' ";
		$query=$query."	ORDER BY a.inhaber";
   }
if ($modus != 'kvwmap')
  {   	
  $result = $dbqueryp($connectp,$query);
  $z=0;
  while($r = $fetcharrayp($result))
	    {
	       $bd[$z]=$r;
		   $z++;
		   $count=$z;	
		}
  }	
	
  
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <!--   FEHLER CSS , IE7 emuliert, IE7 unterstützt CSS nicht-->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link href="css/style_css.php" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
	</head>
<body>

<div align=center>
<img src="../../images/geoportal_logo.png" width=1200 >
<table>
  <tr>
    <td width=200>
	<form action="liste_jagdkataster_region.php" method="POST" name="region2">
	  <?php if (isset($region_id)) echo '<input type=hidden name="region" value="',$region_id,'">';
	           else echo '<input type=hidden name="post_modus" value="kvwmap">';
      ?>
	  <input type=submit value="Jagdkataster-Liste">
	  </form>
	  </td>
	  <td width=200>
	  <form action="liste_vorstand_region.php" method="POST" name="region2">
	  <?php if (isset($region_id)) echo '<input type=hidden name="region" value="',$region_id,'">';
	           else echo '<input type=hidden name="post_modus" value="kvwmap">';
      ?>
	  <input type=submit value="Vorstandssuche">
	  </form>
	  </td>
  </tr>
</table>  
<h2> Liste der Jagdaufseher - Stand: <? echo $heute ?></h2>
<? 
  if ($modus == 'kvwmap')
    {
	 echo 'Region: 
	       <form action="',$_SERVER["PHP_SELF"],'" method="post" name="region">
	        
			<select  name="region" onchange="document.region.submit();">
			<option >Bitte auswählen</option>
			<option value="0">Gesamtliste</option>';
			
	  $query="SELECT name,gid FROM  government.regionen ORDER BY name";
	  $result = $dbqueryp($connectp,$query);
      while($r = $fetcharrayp($result))
		{
  		echo "<option ";
		
		echo" value=\"$r[gid]\"";
		if ($r[gid] == $region_id) echo "selected";
		echo ">";
		
		echo "$r[name]</option>\n";
		}
		echo "</select></form>";
	}
    else 
	{
	  echo "<h3>",$region," - ";
	  if (!isset($count)) echo "keine";
	  if ($count >= 1) echo $count," Jagdaufseher ";
	  echo "</h3>";
    }	  
?>
<div align=center>
<table border=0>
<tr><td valign=top align=left>
<? 

 if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap"><img src="../../kvwmap/graphics/back.png" width=20 title="zurück zu kvwmap" border=0></a> ';
 if ($modus != 'kvwmap') echo '<a href="',$_SERVER["PHP_SELF"],'?modus=kvwmap"><img src="../../kvwmap/graphics/rows.png" width=20 title="andere Gemeinde oder Ortslage wählen" border=0></a>';
 if ($modus != 'kvwmap' AND isset($count))
 {
	echo '
<a href="javascript:window.print()"><img src="../../kvwmap/graphics/button_drucken.gif" width=20 title="Seite ausdrucken. Bitte Querformat einstellen!" border=0></a>
  </td>

';
?>
<td colspan=2><form action="<?php echo $_SERVER["PHP_SELF"] ?>" method=POST name="filter">
    <input type=hidden name="region" value=<?php echo $region_id ?>>
    filtern nach Name: <input  type=text name="filter" value="<?php echo $filter ?>" length=50>
	
	</td>
</tr>
<?php
echo '<tr bgcolor="#3264af" >';
// bg_color für Überschrift Tabelle

if ($status == 'angemeldet') echo '<td width=150></td>';
echo "<td height=30 width=200><b>Jagdaufseher</b></td>
	<td  align=center height=30 width=300><b>PLZ/Ort</b></td>
	<td align=center height=30 width=100><b>Straße/Hausnummer</b></td>
	<td align=center height=30 width=100><b>gültig bis</b></td>
	<td align=center height=30 width=200><b>Jagdbezirk</b></td>
</tr>";

 for($v=0;$v<$z;$v++)
	{   
			$quot=$v;
			if($quot%2 != 0){
				echo "<tr bgcolor='#FCFCFC'";
			} else { 
			echo "<tr bgcolor='#d2e8ff'";
			}
		echo ">";
		
		if ($status == 'angemeldet') 
		   {
			   echo '<td align=center>
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=false"><img src="../../kvwmap/graphics/zoom_highlight.png" width=20 title="Zoom auf Jagdbezirk und Obhekt hervorheben" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=zoomonly"><img src="../../kvwmap/graphics/zoom_normal.png" width=20 title="Zoom auf Jagdbezirk" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=true"><img src="../../kvwmap/graphics/zoom_select.png" width=20 title="Zoom auf Jagdbezirk" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=Layer-Suche_Suchen&operator_gid==&selected_layer_id=60055&value_gid=',$bd[$v][gid],'"><img src="../../kvwmap/graphics/button_ansicht.png" width=20 title="Jagdaufseher bearbeiten" border=0></a></td>';
		   }
			echo '<td align=center>',$bd[$v][inhaber],'</td>';
			echo '<td align=center>',$bd[$v][plz_ort],'</td>';
			echo '<td align=center>',$bd[$v][strasse_hnr],'</td>';
			echo '<td align=left> ',$bd[$v][datum],'</td>';
			echo '<td align=left>',$bd[$v][name],'</td>';
	    echo '</tr>';
	}
	
echo "</table>";
 }
}
else echo "Zugiff nicht erlaubt...";
?>
</body>
</html>