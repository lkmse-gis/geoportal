<?php
// standortinfo.php
// Datum: 2018-08-31
// Angepasst durch: Uwe Popp	[noch nicht fertig!
// Listenfunktionen für die Themen der Wirtschaftsförderung
// 
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
$region_id=$_POST["region"];
unset($ejb);
unset($gjb);
$filter=$_POST["filter"];
$art=$_POST["art"];
$hg=$_POST["hg"];



if ($region_id >= 1)
  {
    $query="SELECT name FROM government.regionen WHERE gid='$region_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $region=$r[name];
	  	
//		$query="SELECT oid, wf_gid, bezeichnung, wf_gesamt_fl, nutzung, comment_nutzung, ge_gemeinde, bplan_mp, geaendert, beschreibung, wf_ap, anspr_bauaufsicht_mp, anspr_immission_mp, wf_grz, wf_gfz, wf_bmz, wf_bh, freie_flaeche_gesamt, brw_mp, freie_flaechen_mp, freie_flaechen_biggest, freie_flaechen_smallst, CASE WHEN wf_fl_teibar::boolean = 'TRUE' THEN 'Ja'::text ELSE 'Nein'::text END AS v_wf_fl_teibar, 'http://www.geoport-lk-mse.de/geoportal/pictures/gew_standorte/' || substr(wf_bilder,36,30) as pic_url, 'http://www.geoport-lk-mse.de/geoportal/pictures/gew_standorte/' || substr(wf_weitere_dokumente,36,30) as pdf_url, hebesatz_gewerbest, hebesatz_grundst_b, strassenanschluss, stromanschluss_nied,stromanschluss_mittel, wasserversorgung, abwasserentsorgung, erdgasversorgung, fernwaermeversorgung, telefon_internet, bandbreite_mbit_s, nae_autobahn_auff_km, nae_bahnhof_km, nae_oepnv_hh_km, nae_flughafen_km, nae_gleisan_verlade_km, nae_seehafen_km, nae_binnenhafen_km, wf_wdze, altlasten_vorh, k_belastet_mp, k_beraeumt_mp, bestand_immob_mp, the_geom FROM economy.auskunft_gewerbestandorte

//   DATA "the_geomb from (SELECT wf_best_gid, bezeichnung, anschrift, nutzflaeche, ge_gemeinde, bplan, geaendert_datum, beschreibung, wf_ap_best, anspr_eigentuemer, freie_buerofl_m2, freie_ladenfl_m2, freie_produktfl_m2, freie_lichte_hoehe_prod_m, freie_lagerfl_m2, weitere_details_besond, 'http://www.geoport-lk-mse.de/geoportal/pictures/gew_standorte/' || substr(wf_bilder,36,30) as pic_url, 'http://www.geoport-lk-mse.de/geoportal/pictures/gew_standorte/' || substr(wf_weitere_dokumente,36,30) as pdf_url, kauf_miete_pacht, kaufpreis_eur_m2, miete_pacht_eur_pro_jahr, hebesatz_gewerbest, hebesatz_grundst_b, strassenanschluss, stromanschluss_nied, stromanschluss_mittel, wasserversorgung, abwasserentsorgung, erdgasversorgung, fernwaermeversorgung, telefon_internet, bandbreite_mbit_s, nae_autobahn_auff_km, nae_bahnhof_km, nae_oepnv_hh_km, nae_flughafen_km, nae_gleisan_verlade_km, nae_seehafen_km, nae_binnenhafen_km, uebergeord_gewerbestandort, the_geomb FROM economy.auskunft_bestandsimmobilien WHERE 1=1) as foo using unique wf_best_gid using srid=25833"

//DATA "the_geomf from (SELECT oid, wf_freieflae_gid, wf_gid, bezeichnung, freie_flaeche, a_freie_flaeche, nutzung,comment_nutzung, ge_gemeinde, bplan, bplan_mp, fr_geaendert, beschreibung, wf_ap, anspre_eigentuemer, anspr_bauaufsicht, anspr_bauaufsicht_mp, anspr_immission, anspr_immission_mp, fr_grz, fr_gfz, fr_bmz, fr_bh, freie_flaeche_gesamt, CASE WHEN fr_fl_teibar::boolean = 'TRUE' THEN 'Ja'::text ELSE 'Nein'::text END AS v_fr_fl_teibar, vollgeschosse, fr_bilder as url_pic, fr_weitere_dokumente as pdf_url, kauf_miete_pacht, kaufpreis_eur_m2,miete_pacht_eur_pro_jahr, hebesatz_gewerbest, hebesatz_grundst_b, strassenanschluss, stromanschluss_nied, stromanschluss_mittel, wasserversorgung, abwasserentsorgung, erdgasversorgung, fernwaermeversorgung, telefon_internet, bandbreite_mbit_s, nae_autobahn_auff_km, nae_bahnhof_km, nae_oepnv_hh_km, nae_flughafen_km, nae_gleisan_verlade_km, nae_seehafen_km, nae_binnenhafen_km, altlasten_vorh, k_belastet_mp, k_beraeumt_mp, bestand_immob_mp, the_geomf FROM economy.auskunft_freie_flaechen WHERE 1=1) as foo using unique oid using srid=25833"

		
		$query="SELECT a.oid, a.wf_gid, a.bezeichnung, a.wf_gesamt_fl, a.gemeinde, a.the_geom FROM economy.auskunft_gewerbestandorte as a WHERE (a.gemeindeart=c.art) AND st_intersects(st_transform(a.the_geom,25833),b.the_geom) AND b.gid='$region_id'";
		
        if (strlen($filter) > 0) $query=$query." AND a.name LIKE '%$filter%' ";
		if (isset($art)) $query=$query. " AND a.art = '$art' ";
		if (isset($hg)) $query=$query. " AND h.hege_id IS NOT NULL ";
		$query=$query."	ORDER BY a.name";
		
		
	
	$result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $bd[$z]=$r;
		   $z++;
		   $count=$z;	
		}
  }
  else 
  {
   $region="Gesamtliste";
   if ($modus != 'kvwmap')
   {
	   	$query="SELECT a.oid, a.wf_gid, a.nutzung, c.bezeichnung, a.wf_gesamt_fl, a.comment_nutzung, a.gemeinde FROM economy.auskunft_gewerbestandorte as a WHERE (a.nutzung='$id_nutzung')";
		
		if (isset($art)) $query=$query. "AND a.nutzung = '$id_nutzung' ";
		$query=$query."	ORDER BY a.nutzung";
		
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $bd[$z]=$r;
		   $z++;
		   $count=$z;	
		}
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
<h2> Liste der Gewerbestandorte - Stand: <? echo $heute ?></h2>
<? 
  if ($modus == 'kvwmap')
    {
	 echo 'Region: 
	       <form action="',$_SERVER["PHP_SELF"],'" method="post" name="region">
	        
			<select class="select_ort" name="region" onchange="document.region.submit();">
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
	  if ($count == 1) echo $count," Gewerbestandort ";
	  if ($count != 1) echo $count," Gewerbestandorte ";
	  echo "</h3>";
    }	  
?>
<div align=center>
<table border=0>
<tr><td colspan=8 valign=top align=left>
<? 

 if ($status == 'angemeldet') echo '<a href="https://geoport-lk-mse.de/kvwmap"><img src="../../kvwmap/graphics/back.png" width=20 title="zurück zu kvwmap" border=0></a> ';
 if ($modus != 'kvwmap') echo '<a href="',$_SERVER["PHP_SELF"],'?modus=kvwmap"><img src="../../kvwmap/graphics/rows.png" width=20 title="andere Gemeinde oder Ortslage wählen" border=0></a>';
 if ($modus != 'kvwmap' AND isset($count))
 {
	echo '
<a href="javascript:window.print()"><img src="../../kvwmap/graphics/button_drucken.gif" width=20 title="Seite ausdrucken. Bitte Querformat einstellen!" border=0></a>
  </td>
</tr>
<tr>';
?>
<td colspan=2><form action="<?php echo $_SERVER["PHP_SELF"] ?>" method=POST name="filter">
    <input type=hidden name="region" value=<?php echo $region_id ?>>
    Name: <input  type=text name="filter" value="<?php echo $filter ?>" length=50>
	</td>
	<td colspan=3> 
	
	<input type=radio id_nutzung="GE" name="art" value="GE" <?php if ($art == 'GE') echo " checked" ?>> GE
	<input type=radio id_nutzung="GI" name="art" value="GI" <?php if ($art == 'GI') echo " checked" ?>> GI
	<input type=radio id_nutzung="MI" name="art" value="MI" <?php if ($art == 'MI') echo " checked" ?>> MI
	<input type=radio id_nutzung="SO" name="art" value="SO" <?php if ($art == 'SO') echo " checked" ?>> SO
	
	</form>
</td></tr>
<?php
echo '<tr bgcolor="#3264af" >';
// bg_color für Überschrift Tabelle

if ($status == 'angemeldet') echo '<td width=150></td>';
echo "<td height=30 width=80><b>Nutzung</b></td>
	  <td align=center height=30 width=300><b>Bezeichnung</b></td>
	  <td align=center height=30 width=300><b>Kommentar der Nutzung</b></td>
	  <td align=center height=30 width=80><b>Fläche</b></td>
	  <td align=center height=30 width=200><b>Gemeinde</b></td>
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
		  if ($bd[$v][ziel_status] == 'in Bearbeitung') 
		     {
			   echo '<td align=center>
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=false"><img src="../../kvwmap/graphics/zoom_highlight.png" width=20 title="Zoom auf Objekt und Objekt hervorheben" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=zoomonly"><img src="../../kvwmap/graphics/zoom_normal.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=true"><img src="../../kvwmap/graphics/zoom_select.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=Layer-Suche_Suchen&operator_new_gid==&selected_layer_id=60040&value_new_gid=',$bd[$v][new_gid],'"><img src="../../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
			  }
			  else
			  {
			   echo '<td align=center>
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=false"><img src="../../kvwmap/graphics/zoom_highlight.png" width=20 title="Zoom auf Objekt und Obhekt hervorheben" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=zoomonly"><img src="../../kvwmap/graphics/zoom_normal.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=zoomtoPolygon&oid=',$bd[$v][oid],'&layer_tablename=jagdbezirke&layer_columnname=the_geom&layer_id=60040&selektieren=true"><img src="../../kvwmap/graphics/zoom_select.png" width=20 title="Zoom auf Objekt" border=0></a> 
			   <a href="https://geoport-lk-mse.de/kvwmap/index.php?go=Layer-Suche_Suchen&operator_new_gid==&selected_layer_id=60040&value_new_gid=',$bd[$v][new_gid],'"><img src="../../kvwmap/graphics/button_ansicht.png" width=20 title="Objekt bearbeiten" border=0></a></td>';
			  }
			echo '<td align=center>',$bd[$v][nutzung],'</td>';
			echo '<td align=left>',$bd[$v][bezeichnung],'</td>';
			echo '<td align=left> ',$bd[$v][comment_nutzung],'</td>';
			echo '<td align=left>',$bd[$v][wf_gesamt_fl],' ha</td>';
			echo '<td align=left>',$bd[$v][bezeichnung],'</td>';
	    echo '</tr>';
	}
	
echo "</table>";
 }
}
else echo "Zugiff nicht erlaubt...";
?>
</body>
</html>