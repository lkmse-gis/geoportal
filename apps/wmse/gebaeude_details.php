<?php
include ("/var/www/apps/geoportal/includes/connect_geobasis.php");
$ip=getenv('REMOTE_ADDR');

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
$wf_best_gid=$_GET['wf_best_gid'];

 $query="SELECT oid, wf_best_gid, bezeichnung, anschrift, nutzflaeche, ge_gemeinde, bplan, geaendert_datum, beschreibung, wf_ap_best, anspr_eigentuemer, freie_buerofl_m2, freie_ladenfl_m2, freie_produktfl_m2, freie_lichte_hoehe_prod_m, freie_lagerfl_m2, weitere_details_besond,
 'http://www.geoport-lk-mse.de/geoportal/pictures/gew_bestandsimmobilien/' || substr(wf_bilder,45,30) as pic_url,
 'http://www.geoport-lk-mse.de/geoportal/pictures/gew_bestandsimmobilien/' || substr(wf_weitere_dokumente,45,30) as pdf_url, kauf_miete_pacht, kaufpreis_eur_m2, miete_pacht_eur_pro_jahr, hebesatz_gewerbest, hebesatz_grundst_b, strassenanschluss, stromanschluss_nied, stromanschluss_mittel, wasserversorgung, abwasserentsorgung, erdgasversorgung, fernwaermeversorgung, telefon_internet, bandbreite_mbit_s, nae_autobahn_auff_km, nae_bahnhof_km, nae_oepnv_hh_km, nae_flughafen_km, nae_gleisan_verlade_km, nae_seehafen_km, nae_binnenhafen_km, uebergeord_gewerbestandort, the_geomb FROM economy.auskunft_bestandsimmobilien_wfs WHERE wf_best_gid='$wf_best_gid'";
   
// $query="SELECT * FROM economy.economy.auskunft_bestandsimmobilien_wfs WHERE wf_best_gid='$wf_best_gid'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bezeichnung=$r[bezeichnung];

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
<body link=blue vlink=purple>

<div align=center>
<img src="../../images/geoportal_logo.png" width=1200 >
<h2> Details zur Bestandsimmobilie <?php echo $bezeichnung; ?> </h2>
<BR>

<table border=1 cellpadding=0 cellspacing=0 width=900 >
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 width=316 style='height:14.25pt;width:237pt'>&nbsp;Anschrift : </td>
  <td align=left>&nbsp;<?php echo $r[anschrift]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Gesamt-Nutzfläche (m²) : </td>
  <td align=left>&nbsp;<?php echo $r[nutzflaeche]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Gemeinde : </td>
  <td align=left>&nbsp;<?php echo $r[ge_gemeinde]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Bebauungsplan : </td>
  <td align=left height=19 style='font-size: 12px'>&nbsp;<?php echo $r[bplan]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Geändert am : </td>
  <td align=left>&nbsp;<?php echo $r[geaendert_datum]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Beschreibung : </td>
  <td align=left><?php echo $r[beschreibung]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Ansprechpartner Wirtschaftsförderung : </td>
  <td align=left>&nbsp;<?php echo $r[wf_ap_best]; ?></td>
 </tr>
  <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Ansprechpartner Eigentümer : </td>
  <td align=left>&nbsp;<?php echo $r[anspr_eigentuemer]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Freie Bürofläche (m²) : </td>
  <td align=left>&nbsp;<?php echo $r[freie_buerofl_m2]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Freie Ladenfläche (m²) : </td>
  <td align=left>&nbsp;<?php echo $r[freie_ladenfl_m2]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Freie Produktionsfläche (m²) : </td>
  <td align=left>&nbsp;<?php echo $r[freie_produktfl_m2]; ?></td>
 </tr>
 
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Lichte Höhe prodfl.(m) : </td>
  <td align=left>&nbsp;<?php echo $r[freie_lichte_hoehe_prod_m]; ?></td>
 </tr>
 
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;freie Lagerfläche(m²) : </td>
  <td align=left>&nbsp;<?php echo $r[freie_lagerfl_m2]; ?></td>
 </tr>
 
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Weiter Details/Besonderheiten : </td>
  <td align=left><?php echo $r[weitere_details_besond]; ?></td>
 </tr>
 
  <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Weitere Dokumente : </td>
  <td align=left>&nbsp;<?php echo $r[pdf_url]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Kauf oder Miete/Pacht? : </td>
  <td align=left>&nbsp;<?php echo $r[kauf_miete_pacht]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Kaufpreis (EUR/m²) : </td>
  <td align=left>&nbsp;<?php echo $r[kaufpreis_eur_m2]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Miete/Pacht (EUR pro Jahr und m²) : </td>
  <td align=left>&nbsp;<?php echo $r[miete_pacht_eur_pro_jahr]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Gewerbesteuerhebesatz in % : </td>
  <td align=left>&nbsp;<?php echo $r[hebesatz_gewerbest]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Hebesatz Grundsteuer B in % : </td>
  <td align=left>&nbsp;<?php echo $r[hebesatz_grundst_b]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Straßenanschluss : </td>
  <td align=left>&nbsp;<?php echo $r[strassenanschluss]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Stromanschluss(Niederspannung) : </td>
  <td align=left>&nbsp;<?php echo $r[stromanschluss_nied]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Stromanschluss(Mittelspannung : </td>
  <td align=left>&nbsp;<?php echo $r[stromanschluss_mittel]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Wasserversorgung : </td>
  <td align=left>&nbsp;<?php echo $r[wasserversorgung]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Abwasserentsorgung : </td>
  <td align=left>&nbsp;<?php echo $r[abwasserentsorgung]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Erdgasversorgung : </td>
  <td align=left>&nbsp;<?php echo $r[erdgasversorgung]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Fernwärmeversorgung : </td>
  <td align=left>&nbsp;<?php echo $r[fernwaermeversorgung]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Telefon-/Internetanschluss : </td>
  <td align=left>&nbsp;<?php echo $r[telefon_internet]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Bandbreite (Mbits/s) : </td>
  <td align=left>&nbsp;<?php echo $r[bandbreite_mbit_s]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Nächste Autobahnauffahrt (km) : </td>
  <td align=left>&nbsp;<?php echo $r[nae_autobahn_auff_km]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Nächster Bahnhof (km) : </td>
  <td align=left>&nbsp;<?php echo $r[nae_bahnhof_km]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Nächster ÖPNV-Haltestelle (km) : </td>
  <td align=left>&nbsp;<?php echo $r[nae_oepnv_hh_km]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Nächster Flughafen (km) : </td>
  <td align=left>&nbsp;<?php echo $r[nae_flughafen_km]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Gleisanschluss/Verlademöglichkeit (km)
  :</td>
  <td align=left>&nbsp;<?php echo $r[nae_gleisan_verlade_km]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Seehafen (km) : </td>
  <td align=left>&nbsp;<?php echo $r[nae_seehafen_km]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Binnenhafen (km) : </td>
  <td align=left>&nbsp;<?php echo $r[nae_binnenhafen_km]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Altlasten vorhanden ? : </td>
  <td align=left>&nbsp;<?php echo $r[altlasten_vorh]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Kampfmittelbelastung? : </td>
  <td align=left>&nbsp;<?php echo $r[k_belastet_mp]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Kampfmittelbelastung beräumt? : </td>
  <td align=left>&nbsp;<?php echo $r[k_beraeumt_mp]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Liste der Bestandsimmobilien : </td>
  <td align=left>&nbsp;<?php echo $r[bestand_immob_mp]; ?></td>
 </tr>
  <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Bild</td>
  <td align=left>&nbsp;<?php echo $r[pic_url]; ?></td>
 </tr>
 </table>

</div>
</body>
</html>