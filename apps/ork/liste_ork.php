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
$koerperschaft=$_POST["koerperschaft"];
if ($koerperschaft=='x') unset($koerperschaft);
$k_amt=$_POST["k_amt"];
if ($k_amt=='x') unset($k_amt);
$k_gemeinde=$_POST["k_gemeinde"];
if ($k_gemeinde=='x') unset($k_gemeinde);
$k_koerperschaft=$_POST["k_koerperschaft"];
if ($k_koerperschaft=='x') unset($k_koerperschaft);

$art=$_POST["art"];
if ($art=='x') unset($art);
$bereich=$_POST["bereich"];
if ($bereich=='x') unset($bereich);


if (!isset($koerperschaft) AND !isset($vstatus) AND !isset($region)) $label='Gesamtliste';
  else $label="";
if (isset($koerperschaft)) $label=$koerperschaft." ";
if (isset($k_amt)) $label=$k_amt." ";
if (isset($k_gemeinde)) $label=$k_gemeinde." ";
if (isset($k_koerperschaft)) $label=$k_koerperschaft." ";
if (isset($art)) $label=$label.", ".$art." ";
if (isset($bereich)) $label=$label.", Bereich: ".$bereich." ";
	


$query="SET search_path = management; SELECT oid,gid,koerperschaft_art,gebiet_voll,aktiv,amtname,amt_schl,gem_name,gem_schl,koerperschaft,art,unterart,ausschrift_unterart,titel,internetseite,inkraft_getreten_am,bearbeitungsstand,nutzer,bearbeitungsdatum FROM ork where (1=1)";
		if (isset($koerperschaft)) $query=$query." AND koerperschaft_art LIKE '$koerperschaft' ";
		if (isset($k_amt)) $query=$query." AND amtname = '$k_amt' ";
		if (isset($k_gemeinde)) $query=$query." AND gem_name ='$k_gemeinde' ";
		if (isset($k_koerperschaft)) $query=$query." AND koerperschaft ='$k_koerperschaft' ";
		if (isset($art)) $query=$query." AND art ='$art' ";
		if (isset($bereich)) $query=$query." AND unterart ='$bereich' ";
		$query=$query."	ORDER BY gid;";
		#echo $query;
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $bd[$z]=$r;
		   $z++;
		   $count=$z;	
		}

		


		
?>
<SCRIPT language="javascript">


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
<h2> Ortsrechtskataster - Stand: <? echo $heute ?></h2>
<? 
  
	  echo "<h3>",$label,"  - ";
	  if (!isset($count)) echo "keine";
	  if ($count == 1) echo $count," Eintrag ";
	  if ($count != 1) echo $count," Einträge ";
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
  </td><td>Körperschaft (Art)</td>';
  if ($koerperschaft == 'Amt') echo '<td>Amt</td>';
  if ($koerperschaft == 'Gemeinde') echo '<td>Gemeinde</td>';
  if ($koerperschaft == 'Körperschaft') echo '<td>Körperschaft</td>';
  echo '<td>Art</td><td>Bereich</td>';
  echo '</tr>
  <tr><td></td>';
  
  echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="koerperschaft_form">';
  if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
  if (isset($bereich)) echo '<input type="hidden" name="bereich" value="',$bereich,'">';
  echo '<select  name="koerperschaft" onchange="document.koerperschaft_form.submit();">
            <option value="x" >alle</option>';
			echo '<option value="Amt"';
			if ($koerperschaft == 'Amt') echo ' selected';
            echo'>Amt</option>';
			echo '<option value="Gemeinde"';
			if ($koerperschaft == 'Gemeinde') echo ' selected';
            echo'>Gemeinde</option>';
			echo '<option value="Körperschaft"';
			if ($koerperschaft == 'Körperschaft') echo ' selected';
            echo'>Körperschaft</option>';
			echo "</select></form></td>";  

  if ($koerperschaft == 'Amt')
    {
	echo '<td>
	     <form action="',$_SERVER["PHP_SELF"],'" method=POST name="k_amt_form">
	     <input type="hidden" name="koerperschaft" value=',$koerperschaft,'>';
		 if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
		 if (isset($bereich)) echo '<input type="hidden" name="bereich" value="',$bereich,'">';
	echo '<select  name="k_amt" onchange="document.k_amt_form.submit();">
			<option value="x" >alle Amtsbereiche</option>';
			$query="SELECT DISTINCT amtname FROM management.ork WHERE koerperschaft_art = 'Amt' ORDER BY amtname";
	        $result = $dbqueryp($connectp,$query);
             while($r = $fetcharrayp($result))
		      {
  		       echo "<option ";
		       echo" value=\"$r[amtname]\"";
		       if ($r[amtname] == $k_amt) echo "selected";
		       echo ">";
		       echo "$r[amtname]</option>\n";
		      }
		    echo "</select></form></td>";
     }
  if ($koerperschaft == 'Gemeinde')
    {
	echo '<td>
	     <form action="',$_SERVER["PHP_SELF"],'" method=POST name="k_gemeinde_form">
	     <input type="hidden" name="koerperschaft" value=',$koerperschaft,'>';
		 if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
		 if (isset($bereich)) echo '<input type="hidden" name="bereich" value="',$bereich,'">';
	echo '<select  name="k_gemeinde" onchange="document.k_gemeinde_form.submit();">
			<option value="x" >alle Gemeinden</option>';
			$query="SELECT DISTINCT gem_name FROM management.ork WHERE koerperschaft_art = 'Gemeinde' ORDER BY gem_name";
	        $result = $dbqueryp($connectp,$query);
             while($r = $fetcharrayp($result))
		      {
  		       echo "<option ";
		       echo" value=\"$r[gem_name]\"";
		       if ($r[gem_name] == $k_gemeinde) echo "selected";
		       echo ">";
		       echo "$r[gem_name]</option>\n";
		      }
		    echo "</select></form></td>";
     }
  if ($koerperschaft == 'Körperschaft')
    {
	echo '<td>
	     <form action="',$_SERVER["PHP_SELF"],'" method=POST name="k_koerperschaft_form">
	     <input type="hidden" name="koerperschaft" value=',$koerperschaft,'>';
		 if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
		 if (isset($bereich)) echo '<input type="hidden" name="bereich" value="',$bereich,'">';
	echo '<select  name="k_koerperschaft" onchange="document.k_koerperschaft_form.submit();">
			<option value="x" >alle Körperschaften</option>';
			$query="SELECT DISTINCT koerperschaft FROM management.ork WHERE koerperschaft_art = 'Körperschaft' ORDER BY koerperschaft";
	        $result = $dbqueryp($connectp,$query);
             while($r = $fetcharrayp($result))
		      {
  		       echo "<option ";
		       echo" value=\"$r[koerperschaft]\"";
		       if ($r[koerperschaft] == $k_koerperschaft) echo "selected";
		       echo ">";
		       echo "$r[koerperschaft]</option>\n";
		      }
		    echo "</select></form></td>";
     }
  echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="art_form">';
  if (isset($koerperschaft)) echo '<input type="hidden" name="koerperschaft" value="',$koerperschaft,'">';
  if (isset($k_amt)) echo '<input type="hidden" name="k_amt" value="',$k_amt,'">';
  if (isset($k_gemeinde)) echo '<input type="hidden" name="k_gemeinde" value="',$k_gemeinde,'">';
  if (isset($k_koerperschaft)) echo '<input type="hidden" name="k_koerperschaft" value="',$k_koerperschaft,'">';
  if (isset($bereich)) echo '<input type="hidden" name="bereich" value="',$bereich,'">';
  echo '<select  name="art" onchange="document.art_form.submit();">
            <option value="x" >alle</option>';
			echo '<option value="Satzung"';
			if ($art == 'Satzung') echo ' selected';
            echo'>Satzung</option>';
			echo '<option value="Ordnung"';
			if ($art == 'Ordnung') echo ' selected';
            echo'>Ordnung</option>';
			echo '<option value="öffentlich rechtlicher Vertrag"';
			if ($art == 'öffentlich rechtlicher Vertrag') echo ' selected';
            echo'>öffentlich rechtlicher Vertrag</option>';
			echo '<option value="Gebietsänderungsvertrag"';
			if ($art == 'Gebietsänderungsvertrag') echo ' selected';
            echo'>Gebietsänderungsvertrag</option>';
			
			echo "</select></form></td>";  
			
  echo '<td>
  <form action="',$_SERVER["PHP_SELF"],'" method=POST name="bereich_form">';
  if (isset($koerperschaft)) echo '<input type="hidden" name="koerperschaft" value="',$koerperschaft,'">';
  if (isset($k_amt)) echo '<input type="hidden" name="k_amt" value="',$k_amt,'">';
  if (isset($k_gemeinde)) echo '<input type="hidden" name="k_gemeinde" value="',$k_gemeinde,'">';
  if (isset($k_koerperschaft)) echo '<input type="hidden" name="k_koerperschaft" value="',$k_koerperschaft,'">';
  if (isset($art)) echo '<input type="hidden" name="art" value="',$art,'">';
  echo '<select  name="bereich" onchange="document.bereich_form.submit();">
			<option value="x" >alle Bereiche</option>';
			$query="SELECT DISTINCT bezeichnung FROM management.ork_katalog ORDER BY bezeichnung";
	        $result = $dbqueryp($connectp,$query);
             while($r = $fetcharrayp($result))
		      {
  		       echo "<option ";
		       echo" value=\"$r[bezeichnung]\"";
		       if ($r[bezeichnung] == $bereich) echo "selected";
		       echo ">";
		       echo "$r[bezeichnung]</option>\n";
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
echo "<td height=30 width=100><b>Körperschaft (Art)</b></td>
	<td  align=center height=30 width=150><b>Name</b></td>
	<td align=center height=30 width=30><b>Gebiet voll</b></td>
	<td align=center height=30 width=30><b>aktiv</b></td>
	<td  align=center height=30 width=120><b>Art</b></td>
	<td  align=center height=30 width=150><b>Bereich</b></td>
	<td  align=center height=30 width=150><b>Unterart</b></td>
	<td  align=center height=30 width=150><b>Titel</b></td>
	<td align=center height=30 width=60><b>gültig seit</b></td>
	<td align=center height=30 width=100><b>Bearbeiter</b></td>
	<td align=center height=30 width=60><b>Datum</b></td>
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
			    <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=Layer-Suche_Suchen&operator_gid==&selected_layer_id=155000&value_gid=',$bd[$v][gid],'"><img src="../../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
				
			  }
			  
			echo '<td align=center>',$bd[$v][koerperschaft_art],'</td>';
			if ($bd[$v][koerperschaft_art] == 'Amt') echo '<td align=left>',$bd[$v][amtname],'</td>';
			if ($bd[$v][koerperschaft_art] == 'Gemeinde') echo '<td align=left>',$bd[$v][gem_name],'</td>';
			if ($bd[$v][koerperschaft_art] == 'Körperschaft') echo '<td align=left>',$bd[$v][koerperschaft],'</td>';
			if ($bd[$v][gebiet_voll] == 't') echo '<td align=center>x</td>';
			  else echo '<td align=center></td>';
			if ($bd[$v][aktiv] == 't') echo '<td align=center>x</td>';
			  else echo '<td align=center></td>';

			echo '<td align=left> ',$bd[$v][art],'</td>';
			echo '<td align=left> ',$bd[$v][unterart],'</td>';
			echo '<td align=left>',$bd[$v][ausschrift_unterart],'</td>';
			echo '<td align=left>',$bd[$v][titel],'</td>';
			echo '<td align=left>',$bd[$v][inkraft_getreten_am],'</td>';
			echo '<td align=right>',$bd[$v][nutzer],'</td>';
			echo '<td align=right>',$bd[$v][bearbeitungsdatum],'</td>';
	    echo '</tr>';
	}
	
echo "</table>";
 
?>
</body>
</html>