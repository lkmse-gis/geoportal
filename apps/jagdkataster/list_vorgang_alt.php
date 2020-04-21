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

$sb=$_POST["sb"];
if ($sb=='x') unset($sb);
$region=$_POST["region"];
if ($region=='x') unset($region);
$huel=$_POST["huel"];
if ($huel=='x') unset($huel);
$vorgangsart=$_POST["vorgangsart"];
if ($vorgangsart=='x') unset($vorgangsart);
$art=$_POST["art"];
if ($art=='x') unset($art);
$vstatus=$_POST["vstatus"];
if ($vstatus=='x') unset($vstatus);
$jb_id=$_POST["jb_id"];
if ($jb_id=='x') unset($jb_id);
$jahrgang=$_POST["jahrgang"];
if ($jahrgang == 'x') unset($jahrgang);
if (!isset($jahrgang)) $jahrgang='alle';
if (!isset($sb) AND !isset($vstatus) AND !isset($region)) $label='Gesamtliste';
  else $label="";
if (isset($jb_id))
  {
    $query="SELECT name from jagdkataster.jagdbezirke WHERE new_gid='$jb_id'";
	$result = $dbqueryp($connectp,$query);
	$r = $fetcharrayp($result);
	$jb_name=$r[name];
	$label=$label." ".$jb_name;
  }
if (isset($sb)) $label=$label.$sb;
if (isset($region)) $label=$label." Region ".$region.":";
if (isset($art)) $label=$label." ".$art;
if (isset($vstatus)) $label=$label." ".$vstatus;
if (isset($vorgangsart)) $label=$label." ".$vorgangsart;
if (isset($huel)) $label=$label." mit HUEL";
	


#$query="SET search_path = jagdkataster; SELECT DISTINCT a.oid,a.gid, a.az,a.eingang,a.sb,a.art,a.vorgangsart,(SELECT status FROM vw_status2vorgang WHERE a.az=vw_status2vorgang.az ORDER by datum DESC LIMIT 1) as status,(SELECT datum FROM vw_status2vorgang WHERE a.az=vw_status2vorgang.az ORDER by datum DESC LIMIT 1) as datum_status,(SELECT gruppe FROM vw_status2vorgang WHERE a.az=vw_status2vorgang.az ORDER by datum DESC LIMIT 1) as status_gruppe,a.person,array_to_string(ARRAY( SELECT name::text || '<br>' FROM jagdbezirke,vorgangsverwaltung2jb  WHERE a.az=vorgangsverwaltung2jb.az AND vorgangsverwaltung2jb.new_gid=jagdbezirke.new_gid), ''::text) AS jagdbezirke,a.gebuehr,a.huel FROM vorgangsverwaltung as a LEFT JOIN vorgangsverwaltung2jb as b ON (a.az=b.az) WHERE ";
$query="SET search_path = jagdkataster; SELECT DISTINCT a.oid,a.gid, a.az,a.eingang,a.sb,a.art,a.vorgangsart,a.status,a.datum_status, a.status_gruppe,a.person, a.jagdbezirke,a.gebuehr,a.huel FROM vorgangsliste as a LEFT JOIN vorgangsverwaltung2jb as b ON (a.az=b.az) WHERE ";


        if ($jahrgang == 'alle') $query=$query. "(1=1) ";
		  else $query=$query."(substr(a.az,5,2)=substr($jahrgang::text,3,2)) ";
		if (isset($sb)) $query=$query." AND a.sb LIKE '$sb' ";
		if (isset($region)) $query=$query." AND a.region = '$region' ";
		if (isset($vorgangsart)) $query=$query." AND a.vorgangsart LIKE '$vorgangsart' ";
		if (isset($art)) $query=$query." AND a.art LIKE '$art' ";
		if (isset($huel)) $query=$query." AND a.huel != '' ";
		if (isset($vstatus)) $query=$query." AND status_gruppe LIKE '$vstatus' ";
		if (isset($jb_id)) $query=$query." AND b.new_gid='$jb_id' ";
		$query=$query."	AND a.erledigt IS NULL ORDER BY a.eingang;";
		#echo $query;
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $bd[$z]=$r;
		   $z++;
		   $count=$z;	
		}

		
$query="SELECT DISTINCT b.name,b.new_gid FROM jagdkataster.vorgangsverwaltung2jb as a,jagdkataster.jagdbezirke as b,jagdkataster.vorgangsliste as c WHERE a.new_gid=b.new_gid AND a.az=c.az ";	
        if ($jahrgang=='alle') $query=$query." AND (1=1) ";
           else $query=$query."  AND (substr(a.az,5,2)=substr($jahrgang::text,3,2)) ";		
		if (isset($sb)) $query=$query." AND c.sb LIKE '$sb' ";
		if (isset($region)) $query=$query." AND c.region = '$region' ";
		if (isset($vorgangsart)) $query=$query." AND c.vorgangsart LIKE '$vorgangsart' ";
		if (isset($huel)) $query=$query." AND c.huel != '' ";
		if (isset($art)) $query=$query." AND c.art LIKE '$art' ";
		if (isset($vstatus)) $query=$query." AND c.status_gruppe LIKE '$vstatus' ";
		$query=$query." AND c.erledigt IS NULL ORDER BY b.name;";
		#echo $query;
	  $result = $dbqueryp($connectp,$query);
	  $jb_z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $jb[$jb_z]=$r;
		   $jb_z++;
		}


		
?>
<SCRIPT language="javascript">
function sicher()
  {
   return window.confirm("Soll der Vorgang wirklich als erledigt markiert werden? Er wird danach in dieser Liste nicht mehr angezeigt.");
  }

</SCRIPT>

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
<h2> Vorgangsliste Jagdkataster - Stand: <? echo $heute ?></h2>
<? 
  
	  echo "<h3>",$label," ",$jahrgang," - ";
	  if (!isset($count)) echo "keine";
	  if ($count == 1) echo $count," Vorgang ";
	  if ($count != 1) echo $count," Vorgänge ";
	  echo "</h3>";
    }	  
?>
<div align=center>
<table border=0>

<tr><td valign=top align=left>
<? 

 if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap"><img src="../../kvwmap/graphics/back.png" width=20 title="zurück zu kvwmap" border=0></a> ';
 
	echo '
<a href="javascript:window.print()"><img src="../../kvwmap/graphics/button_drucken.gif" width=20 title="Seite ausdrucken. Bitte Querformat einstellen!" border=0></a>
  </td><td>Jahrgang</td><td width=30>Region:</td><td>SB:</td><td>Art:</td><td>Status:</td><td>Jagdbezirk:</td><td>Vorgangsart:</td><td width=100>HUEL vorhanden:</td></tr>
  <tr><td></td>';
  
  echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="jahrgang_form">';
  if (isset($sb)) echo '<input type="hidden" name="sb" value="',$sb,'">';
  if (isset($region)) echo '<input type="hidden" name="region" value="',$region,'">';
  if (isset($huel)) echo '<input type="hidden" name="huel" value="',$huel,'">';
  if (isset($vorgangsart)) echo '<input type="hidden" name="vorgangsart" value="',$vorgangsart,'">';
  if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
  if (isset($jb_id)) echo '<input type="hidden" name="jb_id" value="',$jb_id,'">';
  if (isset($vstatus)) echo '<input type="hidden" name="vstatus" value="',$vstatus,'">';
  echo '<select  name="jahrgang" onchange="document.jahrgang_form.submit();">';
			echo '<option value="x"';
			if ($jahrgang == 'alle') echo ' selected';
            echo'>alle</option>';

            echo '<option value="2018"';
			if ($jahrgang == '2018') echo ' selected';
            echo'>2018</option>';
			echo '<option value="2019"';
			if ($jahrgang == '2019') echo ' selected';
            echo'>2019</option>';
			echo '<option value="2020"';
			if ($jahrgang == '2020') echo ' selected';
            echo'>2020</option>';

			echo "</select></form></td>";  

  echo '<td width=30>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="region_form">
  <input type="hidden" name="jahrgang" value=',$jahrgang,'>';
  if (isset($sb)) echo '<input type="hidden" name="sb" value="',$sb,'">';
  if (isset($huel)) echo '<input type="hidden" name="huel" value="',$huel,'">';
  if (isset($vorgangsart)) echo '<input type="hidden" name="vorgangsart" value="',$vorgangsart,'">';
  if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
  if (isset($jb_id)) echo '<input type="hidden" name="jb_id" value="',$jb_id,'">';
  if (isset($vstatus)) echo '<input type="hidden" name="vstatus" value="',$vstatus,'">';
  echo '<select  name="region" onchange="document.region_form.submit();">
            <option value="x" >alle</option>';
			echo '<option value="MST/NB"';
			if ($region== 'MST/NB') echo ' selected';
            echo'>MST/NB</option>';
			echo '<option value="MÜR"';
			if ($region== 'MÜR') echo ' selected';
            echo'>MÜR</option>';
			echo '<option value="DM"';
			if ($region== 'DM') echo ' selected';
            echo'>DM</option>';
			
			echo "</select></form></td>";  
			
  
  echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="sb_form">
  <input type="hidden" name="jahrgang" value=',$jahrgang,'>';
  if (isset($region)) echo '<input type="hidden" name="region" value="',$region,'">';
  if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
  if (isset($huel)) echo '<input type="hidden" name="huel" value="',$huel,'">';
  if (isset($vorgangsart)) echo '<input type="hidden" name="vorgangsart" value="',$vorgangsart,'">';
  if (isset($jb_id)) echo '<input type="hidden" name="jb_id" value="',$jb_id,'">';
  if (isset($vstatus)) echo '<input type="hidden" name="vstatus" value="',$vstatus,'">';
  echo '<select  name="sb" onchange="document.sb_form.submit();">
			<option value="x" >alle Mitarbeiter</option>';
			$query="SELECT m_name FROM jagdkataster.jb_mitarbeiter ORDER BY m_name";
	        $result = $dbqueryp($connectp,$query);
             while($r = $fetcharrayp($result))
		      {
  		       echo "<option ";
		       echo" value=\"$r[m_name]\"";
		       if ($r[m_name] == $sb) echo "selected";
		       echo ">";
		       echo "$r[m_name]</option>\n";
		      }
		    echo "</select></form></td>";
  echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="art_form">
  <input type="hidden" name="jahrgang" value=',$jahrgang,'>';
  if (isset($region)) echo '<input type="hidden" name="region" value="',$region,'">';
  if (isset($sb)) echo '<input type="hidden" name="sb" value="',$sb,'">';
  if (isset($huel)) echo '<input type="hidden" name="huel" value="',$huel,'">';
  if (isset($vorgangsart)) echo '<input type="hidden" name="vorgangsart" value="',$vorgangsart,'">';
  if (isset($vstatus)) echo '<input type="hidden" name="vstatus" value="',$vstatus,'">';
  if (isset($jb_id)) echo '<input type="hidden" name="jb_id" value="',$jb_id,'">';
  echo '<select  name="art" onchange="document.art_form.submit();">
			<option value="x" >alle Arten</option>';
			echo "<option ";
		       echo' value="Antrag"';
		       if ($art == "Antrag") echo "selected";
		       echo ">";
		       echo "Antrag</option>\n";
		    echo "<option ";
		       echo' value="von Amts wegen"';
		       if ($art == "von Amts wegen") echo "selected";
		       echo ">";
		       echo "von Amts wegen</option>\n";  
		    echo "</select></form></td>";
			
   echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="status_form">
  <input type="hidden" name="jahrgang" value=',$jahrgang,'>';
  if (isset($region)) echo '<input type="hidden" name="region" value="',$region,'">';
  if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
  if (isset($huel)) echo '<input type="hidden" name="huel" value="',$huel,'">';
  if (isset($vorgangsart)) echo '<input type="hidden" name="vorgangsart" value="',$vorgangsart,'">';
  if (isset($sb)) echo '<input type="hidden" name="sb" value="',$sb,'">';
  if (isset($jb_id)) echo '<input type="hidden" name="jb_id" value="',$jb_id,'">';
  echo '<select  name="vstatus" onchange="document.status_form.submit();">
			<option value="x" >alle</option>';
			$query="SELECT DISTINCT gruppe FROM jagdkataster.vorgang_status ORDER BY gruppe";
	        $result = $dbqueryp($connectp,$query);
             while($r = $fetcharrayp($result))
		      {
  		       echo "<option ";
		       echo" value=\"$r[gruppe]\"";
		       if ($r[gruppe] == $vstatus) echo "selected";
		       echo ">";
		       echo "$r[gruppe]</option>\n";
		      }
		    echo "</select></form></td>";
			
   echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="jb_form">
  <input type="hidden" name="jahrgang" value=',$jahrgang,'>';
  if (isset($region)) echo '<input type="hidden" name="region" value="',$region,'">';
  if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
  if (isset($huel)) echo '<input type="hidden" name="huel" value="',$huel,'">';
  if (isset($vorgangsart)) echo '<input type="hidden" name="vorgangsart" value="',$vorgangsart,'">';
  if (isset($vstatus)) echo '<input type="hidden" name="vstatus" value="',$vstatus,'">';
  if (isset($sb)) echo '<input type="hidden" name="sb" value="',$sb,'">';
  echo '<select  name="jb_id" onchange="document.jb_form.submit();">
			<option value="x" >alle</option>';
			
			for ($s=0;$s<$jb_z;$s++)
		      {
  		       echo "<option ";
			   $value=$jb[$s][new_gid];
		       echo" value=\"$value\"";
		       if ($jb[$s][new_gid] == $jb_id) echo "selected";
		       echo ">";
			   $output=$jb[$s][name];
		       echo "$output</option>\n";
		      }
		    echo "</select></form></td>";
			
  echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="vorgangsart_form">
  <input type="hidden" name="jahrgang" value=',$jahrgang,'>';
  if (isset($region)) echo '<input type="hidden" name="region" value="',$region,'">';
  if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
  if (isset($huel)) echo '<input type="hidden" name="huel" value="',$huel,'">';
  if (isset($jb_id)) echo '<input type="hidden" name="jb_id" value="',$jb_id,'">';
  if (isset($sb)) echo '<input type="hidden" name="sb" value="',$sb,'">';
  if (isset($vstatus)) echo '<input type="hidden" name="vstatus" value="',$vstatus,'">';
  echo '<select  name="vorgangsart" onchange="document.vorgangsart_form.submit();">
			<option value="x" >alle Vorgangsarten</option>';
			$query="SELECT vorgangsart FROM jagdkataster.vorgangsarten ORDER BY gid";
	        $result = $dbqueryp($connectp,$query);
             while($r = $fetcharrayp($result))
		      {
  		       echo "<option ";
		       echo" value=\"$r[vorgangsart]\"";
		       if ($r[vorgangsart] == $vorgangsart) echo "selected";
		       echo ">";
		       echo "$r[vorgangsart]</option>\n";
		      }
		    echo "</select></form></td>";
			
			
 echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="huel_form">';
  if (isset($sb)) echo '<input type="hidden" name="sb" value="',$sb,'">';
  if (isset($region)) echo '<input type="hidden" name="region" value="',$region,'">';
  if (isset($vorgangsart)) echo '<input type="hidden" name="vorgangsart" value="',$vorgangsart,'">';
  if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
  if (isset($jb_id)) echo '<input type="hidden" name="jb_id" value="',$jb_id,'">';
  if (isset($vstatus)) echo '<input type="hidden" name="vstatus" value="',$vstatus,'">';
  echo '<select  name="huel" onchange="document.huel_form.submit();">';
            echo '<option value="x">egal</option>';
			echo '<option value="ja"';
			if ($huel == 'ja') echo ' selected';
            echo'>ja</option>';
			echo "</select></form></td>";  
  

?>  

</tr>
</table>
<table border=0>
<?php
echo '<tr bgcolor="#3264af" >';
// bg_color für Überschrift Tabelle

if ($status == 'angemeldet') echo '<td width=30></td>';
echo "<td height=30 width=80><b>Eingang</b></td>
	<td  align=center height=30 width=80><b>AZ</b></td>
	<td align=center height=30 width=120><b>Art</b></td>
	<td align=center height=30 width=300><b>Vorgangsart</b></td>
	<td  align=center height=30 width=120><b>SB</b></td>
	<td  align=center height=30 width=300><b>Jagdbezirk</b></td>
	<td  align=center height=30 width=150><b>Person(en)</b></td>
	<td  align=center height=30 width=80><b>Datum</b></td>
	<td align=center height=30 width=120><b>Status</b></td>
	<td align=center height=30 width=50><b>Gebühr</b></td>
	<td align=center height=30 width=120><b>HÜL</b></td>
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
			    <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=Layer-Suche_Suchen&operator_az==&selected_layer_id=60076&value_az=',$bd[$v][az],'"><img src="../../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a><a href="https://geoport-lk-mse.de/geoportal/apps/jagdkataster/liste_vorgang_del.php?delete_id=',$bd[$v][gid];
				if (isset($sb)) echo '&sb=',$sb;
				if (isset($huel)) echo '&huel=',$huel;
				if (isset($vorgangsart)) echo '&vorgangsart=',$vorgangsart;
				if (isset($art)) echo '&art=',$art;
				if (isset($status)) echo '&status=',$status;
				if (isset($jahrgang)) echo '&jahrgang=',$jahrgang;
				echo '"><img src="../../kvwmap/graphics/button_drop.png" width=10 title="Vorgang erledigt" onClick="return sicher()" border=0></a></td>';
			  }
			  
			echo '<td align=center>',$bd[$v][eingang],'</td>';
			echo '<td align=left>',$bd[$v][az],'</td>';
			echo '<td align=left>',$bd[$v][art],'</td>';
			echo '<td align=left>',$bd[$v][vorgangsart],'</td>';
			echo '<td align=left> ',$bd[$v][sb],'</td>';
			echo '<td align=left> ',$bd[$v][jagdbezirke],'</td>';
			echo '<td align=left>',$bd[$v][person],'</td>';
			echo '<td align=left>',$bd[$v][datum_status],'</td>';
			echo '<td align=left>',$bd[$v][status],'</td>';
			echo '<td align=right>',$bd[$v][gebuehr],'</td>';
			echo '<td align=right>',$bd[$v][huel],'</td>';
	    echo '</tr>';
	}
	
echo "</table>";
 
?>
</body>
</html>