<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
include ("includes/connect.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");

//globale Varibalen

$beschriftung_karte="Kindertagesstätte";
$titel="Kindertagesstätten";
$titel2="Kinderbetreuung";
$v_auswahl="Gemeinde, Ort oder Ortsteil";
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
$schema="geoportal";
$tabelle="geoportal_kitas";

$kita_gid=$_GET["kita_gid"];
$layerid=90810;

$orts_gid=$_GET["orts_gid"];

$log=write_log($db_link,$layerid);

// Ebene 1
if ($orts_gid < 1 AND $kita_gid < 1)
    { 
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle";
        $result = $dbqueryp($connectp,$query);
        $r = $fetcharrayp($result);
        $count = $r[anzahl];
				
		$lon=4567406;
		$lat=5938983; 
		?>
		<!DOCTYPE html>
		<html>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
		<head>
				
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
	    <?
           $geotopkarte= new karte;

           echo $geotopkarte->zeigeKarteBox($box_mse_gesamt,$v_breite,$v_hoehe,'orka','1','1','0','0','0',$beschriftung_karte,$layer);
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
							<? echo $v_auswahl ;?> ausw&auml;hlen :<br><br><small>(Es werden nur die Gemeinden/Orte/Ortsteile angeboten in denen sich <? echo $titel ;?> befinden)
						</td>
					</tr>
					
					<tr>
										<td align="center" height=60 colspan=2> 
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="gid_ortsl">
								<select name="orts_gid" onchange="document.gid_ortsl.submit();" style="width: 200px;">
									<option>Bitte auswählen</option>	
									 <?php
										$query="SELECT DISTINCT a.ortslage,a.typ,a.gid FROM  management.suchfeld_schnellsprung_ortslagen as a,$schema.$tabelle as b WHERE st_intersects(b.wkb_geometry,a.the_geom) ORDER BY a.ortslage";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option ";
												#if ($r[typ] == 'Gemeinde') echo "class=bld ";
												echo" value=\"$r[gid]\"";
												if ($r[gid] == $orts_gid) echo "selected";
												echo ">$r[ortslage]</option>\n";
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

// --- Ebene 2 --- 

if ($orts_gid > 0 AND $kita_gid < 1)
	{
    
	$query="SELECT gid_kitas,postleitzahl, adressschluessel, geoportal_anschrift, bezeichnung, amtsbereich_sr, kontaktperson, email, telefon, fax, bez_traeger, the_geom FROM $schema.$tabelle WHERE $orts_gid=gid_ortsl ";

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

	  $query="SELECT ortsteil,box(the_geom) as etrsbox, st_astext(st_centroid(the_geom)) as etrscenter, box(the_geom) as box, area(the_geom) as area, st_astext(st_centroid(the_geom)) as center, gemeinde_name as name FROM $schema.$tabelle WHERE $orts_gid=gid_ortsl";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
	  $ortslage = $r[ortsteil];
	  $boxstring = $r[etrsbox];
	 
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<head>
				
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
		
		<?
           $geotopkarte= new karte;
           echo $geotopkarte->zeigeKarteBox2($boxstring,$v_breite,$v_hoehe,'orka','1','0','0','0','0','0','0',$beschriftung_karte,$layer);
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
											<h3><? echo $font_farbe ;?><? echo $titel ;?> in </h3><h4> <? echo $ortslage ?><? echo $font_farbe_end ;?></h4><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=10 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
						             <td align="center" height=30 colspan=2>
							         <? echo $v_auswahl ;?> ausw&auml;hlen :<br><br><small>(Es werden nur die Gemeinden/Orte/Ortsteile angeboten in denen sich <? echo $titel ;?> befinden)
						             </td>
					                </tr>
									<tr>
										<td align="center" height=60 colspan=2> 
											<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="gid_ortsl">
												<select name="orts_gid" onchange="document.gid_ortsl.submit();" style="width: 200px;">
													<option>Bitte auswählen</option>	
													 <?php
														$query="SELECT DISTINCT a.ortslage,a.typ,a.gid FROM  management.suchfeld_schnellsprung_ortslagen as a,$schema.$tabelle as b WHERE st_intersects(b.wkb_geometry,a.the_geom) ORDER BY a.ortslage";
														$result = $dbqueryp($connectp,$query);

														while($r = $fetcharrayp($result))
															{
																echo "<option ";
																#if ($r[typ] == 'Gemeinde') echo "class=bld ";
																echo" value=\"$r[gid]\"";
																if ($r[gid] == $orts_gid) echo "selected";
																echo ">$r[ortslage]</option>\n";
															}
													?>
												</select>
											</form>
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
									<? head_trefferliste($count,7,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->
									<tr> 
										<td align=center height=30 ><a name="Liste"></a><b>Bezeichnung:</b></td>
										<td align=center height=30><b>Kontaktperson:</b></td>
										<td align=center height=30><b>Anschrift:</b></td>
										<td align=center height=30><b>Telefon:</b></td>
										<td align=center height=30><b>Fax:</b></td>
										<td align=center height=30><b>E-Mail:</b></td>
										<td align=center height=30><b>Träger:</b></td>
									</tr>
								<?php for($v=0;$v<$z;$v++)
								{
											$anschrift = $kitas_jahr[$v][geoportal_anschrift];
											$anschrift1 = explode(";",$anschrift);
											$anschrift2 = $anschrift1[0];
											$anschrift3 = $anschrift1[1];
											
								echo "<tr bgcolor=",get_farbe($v),">";
								echo "
									<td align='center' height='30'><a href=",$scriptname,"?kita_gid=",$kitas_jahr[$v][gid_kitas],"&orts_gid=",$orts_gid,">",$kitas_jahr[$v][bezeichnung],"</a></td>",
									"<td align='center'>",$kitas_jahr[$v][kontaktperson],"</td>",
									"<td align='center'>",$anschrift2," <BR> ",$anschrift3,"</td>",
									"<td align='center'>",$kitas_jahr[$v][telefon],"</td>",
									"<td align='center'>",$kitas_jahr[$v][fax],"</td>",
									"<td align='center'>",$kitas_jahr[$v][email],"</td>",
									"<td align='center'>",$kitas_jahr[$v][bez_traeger],"</td></tr>";
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
// echo $orts_gid; echo '|'; echo $kita_gid;

 $query="SELECT oid, gid_kitas, typ, ortsteil, adressschluessel, bezeichnung, postleitzahl || ' ' || ort as v_ort, strasse_name || ' ' || hausnummer || ' ' || hausnummer_zusatz as v_strasse, amtsbereich_sr,amt_name, kontaktperson, email, telefon, fax, konzept, oeffnungszeiten, bez_traeger, db_import_am, geoportal_anschrift, kvwmap_anschrift,box(st_transform(wkb_geometry,25833)) as box, area(wkb_geometry) as area, st_astext(st_centroid(st_transform(wkb_geometry,4326))) as geo, st_astext(st_centroid(wkb_geometry)) as center, st_astext(st_centroid(wkb_geometry)) as utm, st_perimeter(wkb_geometry) as umfang, st_astext(st_centroid(st_transform(wkb_geometry, 31468))) as rd83, st_astext( st_centroid(st_transform(wkb_geometry,2398))) as koordinaten4283 FROM $schema.$tabelle WHERE gid_kitas=$kita_gid AND gid_ortsl=$orts_gid";
  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);

	
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
	  

		$amtsbereich_sr = $r[$amtsbereich_sr];
		$bezeichnung = $r[bezeichnung];
		$kreis_name = $r[kreis_name];
		$kontaktperson = $r[kontaktperson];
		$v_ort = $r[v_ort];
		$v_strasse = $r[v_strasse];
		$amt_name = $r[amt_name];
		$bez_traeger = $r[bez_traeger];
		
		
		$anschrift = $r[geoportal_anschrift];
		$anschrift1 = explode(";",$anschrift);
		$anschrift_strasse = $anschrift1[0];
		$anschrift_ort = $anschrift1[1];
		$anschrift_ortsteil = $anschrift[2];

		$geo_anschrift = $r[geoportal_anschrift];
		
// echo $geo_anschrift;

		$oeffnungszeiten = $r[oeffnungszeiten];
		$telefon = $r[telefon];
		$fax = $r[fax];
		$email = $r[email];
		$ortsteil = $r[ortsteil];
		$typ = $r[typ];
		


		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	  <meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
	  <head>
	    
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
		
		<?php
            $geotopkarte= new karte;
			echo $geotopkarte->zeigeKarteBox2($boxstring,$v_breite,$v_hoehe,'dop','0','0','0','0','0','0','0',$beschriftung_karte,$layer);
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
                                            <? echo $font_farbe ;?> <? echo $beschriftung_karte ;?><br> <? echo $r[bezeichnung] ;?><? echo $font_farbe_end ;?></td>
                                        <td width=5 rowspan="9"></td>
                                        <td border=0 valign=center align=right rowspan=7 colspan=3>
										    <div style="margin:1px" id="map"></div>
										</td>
									</tr>
									

									<tr>
                                        <td align="center" height="50" colspan="2"><B><? foreach ($anschrift1 as $index => $anschrift_zeile)
										                                                   {
																						     echo $anschrift_zeile,'<br>';
																						   }
																					   ?></B></td>
                                    </tr>
									
									<tr bgcolor=<? echo $header_farbe; ?>>	
										<td align="center" height="10" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<a href="<? echo $scriptname;?>?orts_gid=<? echo $orts_gid ;?>">zu den <? echo $titel ;?> <BR> in: <? echo $ortsteil ;?><? echo $font_farbe_end ;?></a>
										</td>
									</tr>
									
									<tr>
										<td align="center" height="10" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<a href="<? echo $_SERVER["PHP_SELF"] ;?> " title="zurück">gesamten Landkreis anzeigen
											<? echo $font_farbe_end ;?></a>
										</td>
									</tr>
									<tr>
						             <td align="center" height=30 colspan=2>
							         <? echo $v_auswahl ;?> ausw&auml;hlen :<br><br><small>(Es werden nur die Gemeinden/Orte/Ortsteile angeboten in denen sich <? echo $titel ;?> befinden)
						             </td>
					                </tr>
									<tr>
										<td align="center" height=60 colspan=2> 
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="gid_ortsl">
								<select name="orts_gid" onchange="document.gid_ortsl.submit();" style="width: 200px;">
									<option>Bitte auswählen</option>	
									 <?php
										$query="SELECT DISTINCT a.ortslage,a.typ,a.gid FROM  management.suchfeld_schnellsprung_ortslagen as a,$schema.$tabelle as b WHERE st_intersects(b.wkb_geometry,a.the_geom) ORDER BY a.ortslage";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option ";
												#if ($r[typ] == 'Gemeinde') echo "class=bld ";
												echo" value=\"$r[gid]\"";
												if ($r[gid] == $orts_gid) echo "selected";
												echo ">$r[ortslage]</option>\n";
											}
									?>
								</select>
							</form>
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
										<td>&nbsp<? foreach ($anschrift1 as $index => $anschrift_zeile)
										                                                   {
																						     echo $anschrift_zeile,'<br>';
																						   }
																					   ?> </td>
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
									<tr bgcolor=<? echo $element_farbe ;?>>
										<th height=30>&nbspTräger: </th>
										<td>&nbsp<? echo $bez_traeger ;?> </td>
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
