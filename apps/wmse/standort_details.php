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
$wf_gid=$_GET["wf_gid"];


    $query="SELECT oid, wf_gid, replace(bezeichnung,'\"','''') as bezeichnung_2, bezeichnung, wf_gesamt_fl, nutzung, comment_nutzung, ge_gemeinde, bplan_mp, geaendert, beschreibung, wf_ap, anspr_bauaufsicht_mp, anspr_immission_mp, wf_grz, wf_gfz, wf_bmz, wf_bh, freie_flaeche_gesamt, freie_flaechen_mp, freie_flaechen_biggest, freie_flaechen_smallst, CASE WHEN wf_fl_teibar::boolean = 'TRUE' THEN 'Ja'::text ELSE 'Nein'::text END AS v_wf_fl_teibar, 'http://www.geoport-lk-mse.de/geoportal/pictures/gew_standorte/' || substr(wf_bilder,36,30) as pic_url, 'http://www.geoport-lk-mse.de/geoportal/pictures/gew_standorte/' || substr(wf_weitere_dokumente,36,30) as pdf_url, brw_mp, hebesatz_gewerbest, hebesatz_grundst_b,  strassenanschluss, stromanschluss_nied, stromanschluss_mittel, wasserversorgung, abwasserentsorgung, erdgasversorgung, fernwaermeversorgung, telefon_internet, bandbreite_mbit_s, nae_autobahn_auff_km, nae_bahnhof_km, nae_oepnv_hh_km, nae_flughafen_km, nae_gleisan_verlade_km, nae_seehafen_km, nae_binnenhafen_km, altlasten_vorh, k_belastet_mp, k_beraeumt_mp, bestand_immob_mp, bestand_immob, the_geom FROM economy.auskunft_gewerbestandorte WHERE wf_gid='$wf_gid'";


 //   $query="SELECT * FROM economy.auskunft_gewerbestandorte WHERE wf_gid='$wf_gid'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bezeichnung=$r[bezeichnung];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <!--   FEHLER CSS , IE7 emuliert, IE7 unterst𴺴 CSS nicht-->
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
<h2> Details zum Gewerbestandort <?php echo $bezeichnung; ?> </h2>
<BR>

<table border=2 cellpadding=0 cellspacing=0 width=900 >
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 width=316 style='height:14.25pt;width:237pt'>&nbsp;Gesamtfläche (m²) : </td>
  <td align=left>&nbsp;<?php echo $r[wf_gesamt_fl]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Nutzung (BauNVO) : </td>
  <td align=left>&nbsp;<?php echo $r[nutzung]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Einschränkungen/Bemerkungen zur Nutzung
  :</td>
  <td align=left>&nbsp;<?php echo $r[comment_nutzung]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Gemeinde : </td>
  <td align=left>&nbsp;<?php echo $r[ge_gemeinde]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Bebauungsplan : </td>
  <td align=left height=19 style='font-size: 12px'><?php echo $r[bplan_mp]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Geändert am : </td>
  <td align=left>&nbsp;<?php echo $r[geaendert]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Beschreibung : </td>
  <td align=left>&nbsp;<?php echo $r[beschreibung]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Ansprechpartner Wirtschaftsförderung
  :</td>
  <td align=left>&nbsp;<?php echo $r[wf_ap]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Ansprechpartner Bauaufsicht : </td>
  <td align=left>&nbsp;<?php echo $r[anspr_bauaufsicht_mp]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Ansprechpartner Immissionsschutz : </td>
  <td align=left>&nbsp;<?php echo $r[anspr_immission_mp]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Grundflächenzahl (GRZ) : </td>
  <td align=left>&nbsp;<?php echo $r[wf_grz]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Geschossflächenzahl (GFZ) : </td>
  <td align=left>&nbsp;<?php echo $r[wf_gfz]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Baumasssenzahl (BMZ) : </td>
  <td align=left>&nbsp;<?php echo $r[wf_bmz]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Bauhöhe (m) : </td>
  <td align=left>&nbsp;<?php echo $r[wf_bh]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Verfügbare Fläche gesamt (m²) :</td>
  <td align=left>&nbsp;<?php echo $r[freie_flaeche_gesamt]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Verfügbare Flächen (m²) :</td>
  <td align=left>&nbsp;<?php echo $r[freie_flaechen_mp]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Größte verfügbare Fläche : </td>
  <td align=left>&nbsp;<?php echo $r[freie_flaechen_biggest]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Kleinste verfügbare:</td>
  <td align=left>&nbsp;<?php echo $r[freie_flaechen_smallst]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Fläche teilbar? : </td>
  <td align=left>&nbsp;<?php echo $r[v_wf_fl_teibar]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Weitere Dokumente : </td>
  <td align=left>&nbsp;<?php echo $r[pdf_url]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Bodenrichtwert : </td>
  <td align=left><?php echo $r[brw_mp]; ?></td>
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
  <td align=left height=19 style='height:14.25pt'>&nbsp;Ansässige Unternehmen : </td>
  <td align=left>&nbsp;<?php echo $r[ans_unternehmen]; ?></td>
 </tr>
 <tr height=19 style='height:14.25pt'>
  <td align=left height=19 style='height:14.25pt'>&nbsp;Bild</td>
  <td align=left>&nbsp;<?php echo $r[pic_url]; ?></td>
 </tr>

 </table>
</div>
</body>
</html>
