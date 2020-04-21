<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
include ("includes/connect.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");

//globale Varibalen

$beschriftung_karte="Kindertagesstätte_2017";
$titel="Kindertagesstätten 2017";
$titel2="Kinderbetreuung";
$v_auswahl="Ort bzw. Ortsteil";
$v_breite="700";
$v_hoehe="490";

// Legenden - Layer - msp.map - 2 spaltig - Standard|Themen 
$breite1="180";
$breite2="180";
$layer="Kinderbetreuung2017";
$layer1="";
$layer2="Kreisgrenze_msp";
$layer3="aemter_msp_outline";
$layer4="msp_outline_gem";
$layer5="msp_outline_gemkg";
$layer6="Postleitzahlbereiche";
$layer7="Ortsteile_lt_rka";
$layer99="";

// Datenbank
$tabelle="kitas";
$schema="education";
$tabelle2="adresstabelle";
$schema2="address_registry";
$tabelle3="ot_lt_rka";
$schema3="management";

$kita_gid=$_GET["kita_gid"];
$layerid=90810;

$orts_gid=$_GET["orts_gid"];

$log=write_log($db_link,$layerid);

// Ebene 1
if ($orts_gid < 1 AND $kita_gid < 1)
    { 
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle WHERE db_import_am='2017-07-05'";      
        $result = $dbqueryp($connectp,$query);
        $r = $fetcharrayp($result);
        $count = $r[anzahl];
				
		$lon=4567406;
		$lat=5938983; 
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
	    <?
           $geotopkarte= new karte;
//		   function zeigeKarteBox2($box,$width,$height,$basiskarte,$landkreis,$aemter,$gemeinden,$gemarkungen,$adressen,$plz,$orts_teile,$beschriftung,$layer)
           echo $geotopkarte->zeigeKarteBox2($box_mse_gesamt,$v_breite,$v_hoehe,'orka','1','1','0','0','0','0','0',$beschriftung_karte,$layer);
        ?>
		<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
     </head>
            <body onload="init();load();">
                <div id="container">
                    <div id="header">
                    <?php
                        head_portal();
                    ?>
                    </div>
			      <div id="wrapper">
                   <div id="content">
                   <table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
                     <?include ("includes/uberschr_map.php"); ?>
					<tr>
						<td align="center" height=30 colspan=2>
							<? echo $v_auswahl ;?> ausw&auml;hlen :
						</td>
					</tr>
					
					<tr>
						<td align="center" height=60 colspan=2> 
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="gid">
								<select name="orts_gid" onchange="document.gid.submit();" style="width: 200px;">
									<option>Bitte aus auswählen</option>	
									 <?php

					$query="SELECT DISTINCT  a.gid, b.db_import_am, a.ortsteil || '(' || a.gem_name || ')' as ortslage FROM $schema3.$tabelle3 as a,$schema.$tabelle as b,$schema2.$tabelle2 as c WHERE b.adressschluessel=c.adressschluessel AND b.db_import_am='2017-07-05' AND st_within(c.wkb_geometry,a.the_geom) AND a.typ != 'Gemeinde' ORDER BY ortslage";

									$result = $dbqueryp($connectp,$query);
									 while($r = $fetcharrayp($result))
									   {
									   echo "<option value=\"$r[gid]\">$r[ortslage] $r[gid]</option>\n";
									   }
									?>
								</select>
							</form>
						</td>
					</tr>

					<? include ("includes/meta_aktualitaet.php"); ?>
<!-- Tabelle für Legende -->
                    <td valign=bottom align=right>
                        <table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
                            <B>Kartenlegende :</B>
                            <?php
                                 $legende_geo= new legende_geo;
//								 function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer99)
                                 echo $legende_geo->zeigeLegende2('1','1','0','0','0','0',$layer,$layer99)
                            ?>
                     </table> 
                    </td>
<!-- ENDE Tabelle für Legende --> 
				    <? include ("includes/block_1_uk.php");?>
					
					</table>
					
					</div>
					</div>
					<?php 
                echo div_navigation(); 
                echo div_extra(); 
                echo div_footer(); 
				
					?>
				</div>
			</body>
		</html>  
		
<? }

// --- Ebene 2 ---  Auflistung $count > 1 sonst Anzeigen!

if ($orts_gid > 0 AND $kita_gid < 1)
	{

	
	$query="SELECT b.gid, b.postleitzahl, b.adressschluessel, c.geoportal_anschrift, b.bezeichnung, b.amtsbereich_sr, b.kontaktperson, b.email, b.telefon, b.fax,a.the_geom FROM $schema3.$tabelle3 as a, $schema.$tabelle as b, $schema2.$tabelle2 as c WHERE b.adressschluessel=c.adressschluessel AND db_import_am='2017-07-05' AND st_within(c.wkb_geometry,a.the_geom) AND a.typ != 'Gemeinde' AND $orts_gid=a.gid ";
//echo $query;
		$result = $dbqueryp($connectp,$query);
		$z=0;
		
		while($r = $fetcharrayp($result))
			{
			$kitas_jahr[$z]=$r;
			$z++;
			$count=$z;
			}
		
//	  echo var_dump($r);

	  
	  $query="SELECT box(a.the_geom) as etrsbox, st_astext(st_centroid(a.the_geom)) as etrscenter, box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.gem_name as name FROM $schema3.$tabelle3 as a,$schema.$tabelle as b,$schema2.$tabelle2 as c WHERE b.adressschluessel=c.adressschluessel AND st_within(c.wkb_geometry,a.the_geom) AND a.typ != 'Gemeinde' AND $orts_gid=a.gid";
	  
	
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
	  $gemeinde_name = $r[name];
	  $boxstring = $r[etrsbox];
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  $koordinaten = explode(",",$boxstring);
	  $rechts_range = $koordinaten[0]-$koordinaten[2];
	  $hoch_range = $koordinaten[1]-$koordinaten[3];
	 
        $lon=$rechts;
		$lat=$hoch;
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
		
		<?
           $geotopkarte= new karte;
//		   function zeigeKarteBox2($boxstring,$width,$height,$basiskarte,$landkreis,$aemter,$gemeinden,$gemarkungen,$adressen,$plz,$orts_teile,$beschriftung,$layer)
           echo $geotopkarte->zeigeKarteBox2($boxstring,$v_breite,$v_hoehe,'orka','1','0','0','0','1','0','1',$beschriftung_karte,$layer);
        ?>
		
		<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
		
		</head>
		<body onload="init();load();">
		<div id="container">
		  <div id="header">
			<?php
				head_portal();
			?>
		  </div>
			<div id="wrapper">
				<div id="content">
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>
								<table border=0>
									<tr>
										<td height="40" align="center" valign=top width=270 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $titel ;?> in <br> <? echo $gemeinde_name ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=10 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="30" valign=center bgcolor=<? echo $element_farbe; ?>>
											<b>Amt: <? echo $kitas_jahr[0][amtsbereich_sr]; ?></b>
										</td>
									</tr>
									<tr>
										<td align="center" height="40">
										
										</td>										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										<td align=center>
											<a href="<? echo $_SERVER["PHP_SELF"];?>"><? echo $font_farbe ;?>alle <? echo $titel ;?><? echo $font_farbe_end ;?></a>
										</td>
									</tr>
									<tr><td  height=10></td></tr>
									<tr>
						<!-- Tabelle für Legende -->
						<td valign=bottom align=right>
							<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
								<B>Kartenlegende :</B>
								<?php
									$legende_geo= new legende_geo;
	//								 function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer99)
									echo $legende_geo->zeigeLegende2('1','0','0','0','0','1',$layer,$layer99)
								?>
							</table> 
						</td>
						<!-- ENDE Tabelle für Legende --> 
							</tr>								
							<? include ("includes/block_2_uk_gem.php"); ?>	
							</table> <!-- Ende innere Tablle oberer Block -->
					</td>
					</tr>
					</table>	<!-- Ende äußere Tablle oberer Block -->
					
					<!-- Beginn grosse Tabelle unterer Block -->
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td>
							    <!-- Beginn Sachdatentabelle -->
								<table border=0 width="100%" valign=top>
									<? head_trefferliste($count,6,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->
									<tr> 
										<td align=center height=30 ><a name="Liste"></a><b>Bezeichnung:</b></td>
										<td align=center height=30><b>Kontaktperson:</b></td>
										<td align=center height=30><b>Anschrift:</b></td>
										<td align=center height=30><b>Telefon:</b></td>
										<td align=center height=30><b>Fax:</b></td>
										<td align=center height=30><b>E-Mail:</b></td>
									</tr>
								<?php for($v=0;$v<$z;$v++)
								{
											$anschrift = $kitas_jahr[$v][geoportal_anschrift];
											$anschrift1 = explode(";",$anschrift);
											$anschrift2 = $anschrift1[0];
											$anschrift3 = $anschrift1[1];
											
								echo "<tr bgcolor=",get_farbe($v),">";
								echo "
									<td align='center' height='30'><a href=",$scriptname,"?kita_gid=",$kitas_jahr[$v][gid],"&orts_gid=",$orts_gid,">",$kitas_jahr[$v][bezeichnung],"</a></td>",
									"<td align='center'>",$kitas_jahr[$v][kontaktperson],"</td>",
									"<td align='center'>",$anschrift2," <BR> ",$anschrift3,"</td>",
									"<td align='center'>",$kitas_jahr[$v][telefon],"</td>",
									"<td align='center'>",$kitas_jahr[$v][fax],"</td>",
									"<td align='center'>",$kitas_jahr[$v][email],"</td></tr>";
								}
								?>
								</table>
							</td>
						</tr>
					</table>
					</td>
					</tr>
					<tr>
						
					</tr>
					</table>
				</div>
			</div>
			<?php 
                echo div_navigation(); 
                echo div_extra(); 
              //  echo div_footer(); 
            ?>
		</div>
		</body>
		</html>
<?  }

// Ebene 3 Adressschlüssel gesucht! Luftbild
if ($kita_gid > 0)
   { 
 //echo $orts_gid; echo '|'; echo $kita_gid;

 $query="SELECT box(st_transform(a.wkb_geometry,25833)) as box, area(a.wkb_geometry) as area, st_astext(st_centroid(st_transform(a.wkb_geometry,4326))) as geo, st_astext(st_centroid(a.wkb_geometry)) as center, st_astext(st_centroid(a.wkb_geometry)) as utm, st_perimeter(a.wkb_geometry) as umfang, st_astext(st_centroid(st_transform(a.wkb_geometry, 31468))) as rd83, st_astext( st_centroid(st_transform(a.wkb_geometry,2398))) as koordinaten4283, a.gemeinde_name, a.amt_name, b.gid, a.wkb_geometry FROM $schema2.$tabelle2 as a, $schema.$tabelle as b WHERE (a.adressschluessel=b.adressschluessel) AND b.gid=$kita_gid";
  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
// echo $query;
	
	  $area=$r[area];
	  $s4283 = $r[koordinaten4283];
	  $utm = $r[utm];
	  $geo = $r[geo];
	  $rd83 = $r[rd83];
	  $umfang = $r[umfang];
	  $boxstring = $r[box];
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  $koordinaten = explode(",",$boxstring);
	  
	  $gemeinde_name = $r[gemeinde_name];
	  $amt_name = $r[amt_name];
	  
		
		
		$query="SELECT a.oid, a.gid, b.ortsteil, b.adressschluessel, a.adressschluessel, a.bezeichnung, a.postleitzahl || ' ' || a.ort as v_ort, a.strasse || ' ' || a.hausnummer || ' ' || a.hausnummer_zusatz as v_strasse, a.amtsbereich_sr, a.kontaktperson, a.email, a.telefon, a.fax, a.ap_servicepool, a.ap_servicepool_email, a.ap_servicepool_telefon, a.ap_fa_fb, a.ap_fa_fb_email, a.ap_fa_fb_telefon, a.konzept, a.oeffnungszeiten, a.db_import_am, b.geoportal_anschrift, b.kvwmap_anschrift, b.kreis_name, b.amt_name, b.gemeinde_name, b.wkb_geometry FROM education.kitas as a, address_registry.adresstabelle as b WHERE a.adressschluessel = b.adressschluessel AND a.gid='$kita_gid'";
		
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
		$amtsbereich_sr = $r[$amtsbereich_sr];
		$bezeichnung = $r[bezeichnung];
		$kreis_name = $r[kreis_name];
		$kontaktperson = $r[kontaktperson];
		$v_ort = $r[v_ort];
		$v_strasse = $r[v_strasse];
		
		
		$anschrift = $r[geoportal_anschrift];
		$anschrift1 = explode(";",$anschrift);
		$anschrift2 = $anschrift1[0];
		$anschrift3 = $anschrift1[1];

		$geo_anschrift = $r[geoportal_anschrift];
		
		
		 // echo $geo_anschrift;

		$oeffnungszeiten = $r[oeffnungszeiten];
		$telefon = $r[telefon];
		$fax = $r[fax];
		$email = $r[email];
		$ortsteil = $r[ortsteil];
		
//echo var_dump($r);
//	  		bezeichnung, kontaktperson, geoportal_anschrift, telefon, fax, email, 

		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	  <head>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
		
		<?php
// function zeigeKarteBox($boxstring,$width,$height,$basiskarte,$landkreis,$aemter,$gemeinden,$gemarkungen,$adressen,$beschriftung,$layer)
            $geotopkarte= new karte;
 //           echo $geotopkarte->zeigeKarteBox($boxstring,$v_breite,$v_hoehe,'dop','0','0','1','0','0',$beschriftung_karte,$layer);
			echo $geotopkarte->zeigeKarteBox2($boxstring,$v_breite,$v_hoehe,'dop','0','0','1','0','1','0','1',$beschriftung_karte,$layer);
        ?>
		
		<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
	  </head>
		<body onload="init();load();">
		<div id="container">
			<div id="header">
			<?php
				head_portal();
			?>
			</div>
			<div id="wrapper">
				<div id="content">
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>
								<table border="0">
									<tr>
									   <td height="20" align="center" valign=center width=250 colspan="2" bgcolor=<? echo $header_farbe ; ?>> 
                                            <? echo $font_farbe ;?> Gemeinde <? echo $gemeinde_name ;?><? echo $font_farbe_end ;?></td>
                                        <td width=5 rowspan="8"></td>
                                        <td border=0 valign=center align=right rowspan=6 colspan=3>
										    <div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="35" valign=center bgcolor=<? echo $element_farbe ?>><b>Amt:  <? echo $amt_name ?></b></td>
									</tr>

									<tr>
                                        <td align="center" height="50" colspan="2"><B><? echo $titel2;?>: </B></td>
                                    </tr>
									
									<tr bgcolor=<? echo $header_farbe; ?>>	
										<td align="center" height="10" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<a href="<? echo $scriptname;?>?orts_gid=<? echo $orts_gid ;?>">zu den Kindertagesstätten <BR> im Ort/ Ortsteil: <? echo $ortsteil ;?><? echo $font_farbe_end ;?></a>
											
										</td>
									</tr>
									
									<tr>
										<td align="center" height="10" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<a href="<? echo $_SERVER["PHP_SELF"] ;?> " title="zurück">gesamten Landkreis anzeigen
											<? echo $font_farbe_end ;?></a>
										</td>
									</tr>
									<tr>
									<!-- Tabelle für Legende -->
										<td valign=bottom align=right>
											<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
                                            <BR><B>Kartenlegende :</B>
                                            <?php
                                                $legende_geo= new legende_geo;
	//											function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer2)
												echo $legende_geo->zeigeLegende2('0','1','0','1','0','0',$layer,$layer99)
                                            ?>
											</table> 
										</td>
									<!-- ENDE Tabelle für Legende --> 
									</tr>
									<? include ("includes/block_1_uk.php"); ?>
								</table>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td border="0" valign=top>
                                <table width="100%" border="0" valign="top">
									<tr height="35">
										<td colspan="2" align="center" height=30 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?>Kita - <? echo $bezeichnung ;?> - <? echo $font_farbe_end ;?>
										</td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<th height=30>&nbspKontaktperson: </th>
										<td>&nbsp<? echo $kontaktperson ;?> </td>
									</tr>
									<tr>
										<th height=30>&nbspAnschrift: </th>
										<td>&nbsp<? echo $anschrift2 ;?> <BR> <? echo $anschrift3 ;?> </td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?> >
										<th height=30>&nbspTelefon: </th>
										<td>&nbsp<? echo $telefon ;?> </td>
									</tr>
									<tr>
										<th height=30>&nbspFax: </th>
										<td>&nbsp<? echo $fax ;?> </td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<th height=30>&nbspE-Mail: </th>
										<td>&nbsp<a href="mailto:<? echo $email ;?> "> <? echo $email;?></a></td>
									</tr>
									<tr>
										<th height=30>&nbspÖffnungszeiten:</th>
										<td>&nbsp<? echo $oeffnungszeiten ;?> </td>
									</tr>
									
								</table>
								<td valign=top align=center width="350">
									<? include ("includes/geo_point2.php") ?>
								</td>
							</td>
						</tr>
					</table>
					
				</div>
			</div>
			<?php 
                echo div_navigation(); 
                echo div_extra(); 
                echo div_footer(); 
            ?>
		</div>
		</body>
	</html>
<? }
 ?>
