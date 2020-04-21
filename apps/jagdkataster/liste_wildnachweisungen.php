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

## Filteroptionen übernehmen

$wnw=$_POST["wnw"];
if (!isset($wnw)) $wnw='ja';

$hg_id=$_POST["hg_id"];
if ($hg_id=='x') unset($hg_id);
$region_id=$_POST["region_id"];
if ($region_id=='x') unset($region_id);
$jahrgang=$_POST["jahrgang"];
if (!isset($jahrgang)) $jahrgang=$year;
if (!isset($hg_id) AND !isset($region_id)) $label='Gesamtliste';
  else $label="";

if (isset($region_id))
  {
    $query="SELECT name from government.regionen WHERE gid='$region_id'";
	$result = $dbqueryp($connectp,$query);
	$r = $fetcharrayp($result);
	$region_name=$r[name];
	$label=$label." Region:".$region_name.", ";
  }

  
if (isset($hg_id))
  {
    $query="SELECT name from jagdkataster.jb_hegegemeinschaften WHERE hege_id='$hg_id'";
	$result = $dbqueryp($connectp,$query);
	$r = $fetcharrayp($result);
	$hg_name=$r[name];
	$label=$label." ".$hg_name.", ";
  }

  


$query="SELECT a.oid, a.new_gid,a.name,a.art,c.jahrgang,c.eintr_dat,c.main_label,c.gid,b.jab_typ FROM jagdkataster.jagdbezirke as a LEFT JOIN jagdkataster.jb_stammdaten as b ON (a.new_gid=b.new_gid) LEFT JOIN jagdkataster.jb_wildnachweisung as c ON (a.new_gid=c.new_gid AND (substr(c.jahrgang,6,4))='$jahrgang') ";
        if (isset($region_id)) $query=$query.",government.regionen as r ";
		$query=$query." WHERE (1=1)";
		if ($wnw == 'nein') $query=$query." AND c.gid IS NULL AND b.jab_typ != 'Verzicht' AND b.jab_typ != 'ruht' AND b.jab_typ != 'Teiljagdbezirke'";
		   else $query=$query." AND c.gid IS NOT NULL";
		if (isset($hg_id)) $query=$query." AND b.hege_id='$hg_id'";
		if (isset($region_id)) $query=$query." AND st_intersects(st_transform(a.the_geom,25833),r.the_geom) AND r.gid='$region_id'";
		$query=$query."	AND (a.art='gjb' OR a.art= 'ejb' OR a.art='tjb') ORDER BY a.name;";
		#echo $query;
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $bd[$z]=$r;
		   $z++;
		   $count=$z;	
		}

		#echo $query."<br>";



		
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
<h2> Jagdbezirke und Wildnachweisungen - Stand: <? echo $heute ?></h2>
<? 
   if ($wnw == 'nein')
     {
	  echo "<h3>",$label," ",$jahrgang-1,"/",$jahrgang," - ";
	  if (!isset($count)) echo "keine";
	  if ($count == 1) echo $count," Jagdbezirk ohne Wildnachweisung";
	  if ($count != 1) echo $count," Jagdbezirke ohne Wildnachweisung";
	  echo "</h3>";
     }
     else
      {
	  echo "<h3>",$label," ",$jahrgang-1,"/",$jahrgang," - ";
	  if (!isset($count)) echo "keine";
	  if ($count == 1) echo $count," Wildnachweisung";
	  if ($count != 1) echo $count," Wildnachweisungen";
	  echo "</h3>";
	  }
    }	 
?>
<div align=center>
<table border=0>

<tr><td valign=top align=left>
<? 

 if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap"><img src="../../kvwmap/graphics/back.png" width=20 title="zurück zu kvwmap" border=0></a> ';
 
	echo '
<a href="javascript:window.print()"><img src="../../kvwmap/graphics/button_drucken.gif" width=20 title="Seite ausdrucken. Bitte Querformat einstellen!" border=0></a>
  </td><td>Jahrgang</td><td>Hegegemeinschaft</td><td>Wildnachweisung</td><td>Region</td></tr>
  <tr><td></td>';
  
  echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="jahrgang_form">';
  if (isset($hg_id)) echo '<input type="hidden" name="hg_id" value="',$hg_id,'">';
  if (isset($wnw)) echo '<input type="hidden" name="wnw" value="',$wnw,'">';
  if (isset($region_id)) echo '<input type="hidden" name="region_id" value="',$region_id,'">';
  echo '<select  name="jahrgang" onchange="document.jahrgang_form.submit();">';
			echo '<option value="2018"';
			if ($jahrgang == '2018') echo ' selected';
            echo'>2017/2018</option>';
			echo '<option value="2019"';
			if ($jahrgang == '2019') echo ' selected';
            echo'>2018/2019</option>';
			echo "</select></form></td>";  
  
  
  echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="hg_form">
  <input type="hidden" name="jahrgang" value=',$jahrgang,'>';
  if (isset($wnw)) echo '<input type="hidden" name="wnw" value="',$wnw,'">';
  if (isset($region_id)) echo '<input type="hidden" name="region_id" value="',$region_id,'">';
  echo '<select  name="hg_id" onchange="document.hg_form.submit();">
			<option value="x" >egal</option>';
			$query="SELECT hege_id,name FROM jagdkataster.jb_hegegemeinschaften ORDER BY name";
	        $result = $dbqueryp($connectp,$query);
             while($r = $fetcharrayp($result))
		      {
  		       echo "<option ";
		       echo" value=\"$r[hege_id]\"";
		       if ($r[hege_id] == $hg_id) echo "selected";
		       echo ">";
		       echo "$r[name]</option>\n";
		      }
		    echo "</select></form></td>";
  echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="wnw_form">
  <input type="hidden" name="jahrgang" value=',$jahrgang,'>';
  if (isset($hg_id)) echo '<input type="hidden" name="hg_id" value="',$hg_id,'">';
  if (isset($region_id)) echo '<input type="hidden" name="region_id" value="',$region_id,'">';
  echo '<select  name="wnw" onchange="document.wnw_form.submit();">';
			
			echo "<option ";
		       echo' value="ja"';
		       if ($wnw == "ja") echo "selected";
		       echo ">";
		       echo "vorhanden</option>\n";
		    echo "<option ";
		       echo' value="nein"';
		       if ($wnw == "nein") echo "selected";
		       echo ">";
		       echo "nicht vorhanden</option>\n";  
		    echo "</select></form></td>";
			
  echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="region_form">
  <input type="hidden" name="jahrgang" value=',$jahrgang,'>';
  if (isset($wnw)) echo '<input type="hidden" name="wnw" value="',$wnw,'">';
  if (isset($hg_id)) echo '<input type="hidden" name="hg_id" value="',$hg_id,'">';
  echo '<select  name="region_id" onchange="document.region_form.submit();">
			<option value="x" >egal</option>';
			$query="SELECT gid,name FROM government.regionen ORDER BY name";
	        $result = $dbqueryp($connectp,$query);
             while($r = $fetcharrayp($result))
		      {
  		       echo "<option ";
		       echo" value=\"$r[gid]\"";
		       if ($r[gid] == $region_id) echo "selected";
		       echo ">";
		       echo "$r[name]</option>\n";
		      }
		    echo "</select></form></td>";
  
 
?>  

</tr>
</table>
<table border=0>
<?php
echo '<tr bgcolor="#3264af" >';
// bg_color für Überschrift Tabelle

if ($status == 'angemeldet') echo '<td width=30></td>';
echo "<td align=center height=30 width=80><b>Az</b></td>
	<td  align=center height=30 width=200><b>Jagdbezirk</b></td>
	<td align=center height=30 width=220><b>Art der Jagdausübung</b></td>
	<td align=center height=30 width=100><b>Jahrgang</b></td>
	<td  align=center height=30 width=120><b>Datum</b></td>
	<td  align=center height=30 width=120><b>Bemerkung</b></td>
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
			   echo '<td align=center>';
			   if ($wnw == 'nein') echo '
			    <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=Layer-Suche_Suchen&operator_new_gid==&selected_layer_id=60040&value_new_gid=',$bd[$v][new_gid],'"><img src="../../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
				else echo ' <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=Layer-Suche_Suchen&operator_gid==&selected_layer_id=60051&value_gid=',$bd[$v][gid],'"><img src="../../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
			  }
			  
			echo '<td align=center>',$bd[$v][new_gid],'</td>';
			echo '<td align=left>',$bd[$v][name],'</td>';
			echo '<td align=left>',$bd[$v][jab_typ],'</td>';
			echo '<td align=left>',$bd[$v][jahrgang],'</td>';
			echo '<td align=left> ',$bd[$v][eintr_dat],'</td>';
			echo '<td align=left> ',$bd[$v][main_label],'</td>';
	    echo '</tr>';
	}
	
echo "</table>";
 
?>
</body>
</html>