<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
include ("includes/connect_i_procedure_mse.php");
require_once ("classes/karte_1.class.php");

require_once ("classes/legende_geo.class.php");

//globale Varibalen
//$box_mse_gesamt,$v_breite,$v_hoehe,
$beschriftung_karte="Zust&auml;ndiger Pflegest&uuml;tzpunkt";

$titel="Zust&auml;ndiger Pflegest&uuml;tzpunkt ";
$titel2="Zust&auml;ndigkeitsbereiche";
$v_auswahl="Postleitzahlbereich";
$v_breite="700";
$v_hoehe="490";

$v_auswahl="Postleitzahlbereich";

// Legenden - Layer - msp.map - 2 spaltig - Standard|Themen 
$breite1="90";
$breite2="130";
$layer="pflege_gebiete";
$layer7="pflegestuetzpunkte";
$layer1="pflege_gebiete_fl";
$layer2="Kreisgrenze_msp";
$layer3="aemter_msp_outline";
$layer4="msp_outline_gem";
$layer5="msp_outline_gemkg";
$layer6="Postleitzahlbereiche";
$layer99="";

// Datenbank
//.
$tabelle="pflege_gebiete";
$tabelle2="pflegestuetzpunkte";
$tabelle3="fd_plz";
$schema="health";
$kuerzel="plz";
$plz_id=$_GET["plz"];
$stu_id=$_GET["sp"];
$layerid=91020;

$gemeinde_id=$_GET["$kuerzel"];

$log=write_i_log($db_link,$layerid);

// Ebene 1
if ($plz_id < 1 AND $stu_id < 1)
    { 
		

		$lon=367630;
		$lat=5939535;
		
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
           $geotopkarte= new karte_1;
           echo $geotopkarte->zeigeKarteBox($box_mse_gesamt,$v_breite,$v_hoehe,'orka','0','0','0','0','0','1','0','0',$beschriftung_karte,$layer);
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
							<? echo $v_auswahl ;?> ausw&auml;hlen:
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2>
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="<? echo $kuerzel;?>">
							  <select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
								
								<option>Bitte auswählen</option>
								<?php
									$query="SELECT DISTINCT a.plz FROM osm.plz as a,health.pflege_gebiete as b WHERE st_intersects(st_centroid(a.geom),b.the_geom) ORDER BY plz";
									$result = $dbqueryp($connectp,$query);

									while($r = $fetcharrayp($result))
										{
											echo "<option value=\"$r[0]\">$r[0]</option>\n";
										}
								?>
								
							</select>
							</form>
						</td>
					</tr>
					<? include ("includes/meta_i_aktualitaet.php"); ?>
					<!-- Tabelle für Legende -->
                    <td valign=bottom align=right>
                        <table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
                            <B>Kartenlegende :</B>
                            <?php
                                 $legende_geo= new legende_geo;
                                 echo $legende_geo->zeigeLegende2th($breite1,$breite2,$layer6,$layer99,$layer99,$layer1,$layer99,$layer99)
                            ?>
						</table> 
                    </td>
					<!-- ENDE Tabelle für Legende --> 
					         <? include ("includes/block_1_uk.php"); ?>   
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
  <?} 

  // Ebene 2
  if ($plz_id > 0)
   {     
	  $query="SELECT box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, st_astext(st_centroid(st_transform(a.the_geom, 25833))) as utm, st_astext(st_centroid(st_transform(a.the_geom, 4326))) as geo, st_astext(st_centroid(st_transform(a.the_geom, 31468))) as rd83, st_astext(st_transform(a.the_geom, 2398)) as koordinaten, st_perimeter(a.the_geom) as umfang, a.stuetzpunkte_id FROM $schema.$tabelle as a,osm.plz as b WHERE b.plz='$plz_id' AND st_intersects(st_centroid(b.geom),a.the_geom)";	 
      #echo $query;	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
      $stuetzpunkt=$r["stuetzpunkte_id"];	 
	  $area=$r["area"];
	  $s4283 = $r["koordinaten"];
	  $rd83 = $r["rd83"];
	  $utm = $r["utm"];
	  $geo = $r["geo"];
	  $box=$r["box"];
	  $umfang = $r["umfang"];
	  $boxstring = $r["box"];
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  $koordinaten = explode(",",$boxstring);
	  $rechts_range = $koordinaten[0]-$koordinaten[2];
	  $hoch_range = $koordinaten[1]-$koordinaten[3];
	     
	  $query="SELECT oid,gid,plz,ort,strasse,tel_s,tel_p,fax,e_mail,hompage,oeffnungszeiten_2,oeffnungszeiten_4,the_geom FROM $schema.$tabelle2 WHERE gid='$stuetzpunkt'";	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	
	  $plz=$r["plz"];
	  $ort=$r["ort"];
	  $strasse=$r["strasse"];
	  $tel_s=$r["tel_s"];
	  $tel_p=$r["tel_p"];
	  $fax=$r["fax"];
	  $e_mail=$r["e_mail"];
	  $hompage=$r["hompage"];
	  $oeffnungszeiten_2=$r["oeffnungszeiten_2"];
	  $oeffnungszeiten_4=$r["oeffnungszeiten_4"];	
	  
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
            $geotopkarte= new karte_1;
            echo $geotopkarte->zeigeKarteBox($boxstring,$v_breite,$v_hoehe,'orka','0','0','0','0','0','1','0','0',$beschriftung_karte,$layer);
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
										<td height="20" align="center" valign=center width=250 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><H2>Pflegest&uuml;tzpunkte </H2><? echo $font_farbe_End ;?></td>
										<td width=30 rowspan=7></td>
										<td border=0 align=center rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
									
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">Einen weiteren Postleitzahlbereich ausw&auml;hlen:</td>										
									</tr>
									<tr>
										<td align="center" height="40" valign="center" colspan="2">
											<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="<? echo $kuerzel;?>">												
												<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();">
													<?php														
															$query="SELECT DISTINCT a.plz FROM osm.plz as a,health.pflege_gebiete as b WHERE st_intersects(st_centroid(a.geom),b.the_geom) ORDER BY plz";
															$result = $dbqueryp($connectp,$query);

															while($e = $fetcharrayp($result))
														{
														 echo "<option";if ($plz_id == $e["plz"]) echo " selected"; echo ' value="',$e["plz"],'">',$e["plz"],'</option>\n';
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									
									<tr>										
										<td align=center height="10" colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="<? echo $_SERVER["PHP_SELF"];?>"><? echo $font_farbe ;?>zur&uuml;ck zur Gesamtansicht<? echo $font_farbe_end ;?></a>;
																				
										</td>										
									</tr>									
									<tr>										
										<!-- Tabelle für Legende -->
                                        <td valign=bottom align=right>
                                            <table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
                                            <B>Kartenlegende :</B>
                                                <?php
                                                    $legende_geo= new legende_geo;
                                                    echo $legende_geo->zeigeLegende2th($breite1,$breite2,$layer6,$layer99,$layer99,$layer1,$layer99,$layer99)
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
					<!-- Beginn grosse Tabelle unterer Block -->
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td border="0" valign=top>
								<table width="100%" border="0" valign="top">
									<tr height="35">
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1">Zust&auml;ndiger Pflegest&uuml;tzpunkt <? echo $font_farbe_end ;?></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?> height=30>Ort:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["plz"];?>&nbsp;&nbsp;<? echo $r["ort"];?> </b></td>													
									</tr>
									<tr>
									    <td height=30>Stra&szlig;e:</td>
										<td><b><? echo $r["strasse"] ;?></b></td>													
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top height=30>Tel. Sozialberater:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["tel_s"] ;?><b></td>
									</tr>									
									<tr>
										<td valign=top height=30>Tel. Pflegeberater:</td>
										<td><b><? echo $r["tel_p"] ;?><b></td>
									</tr>									
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top height=30>Fax:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["fax"] ;?><b></td>
									</tr>
									<tr>
										<td valign=top height=30>E-Mail:</td>
										<td><b><a href="mailto: <? echo $r["e_mail"] ;?> ?subject=Anfrage an Pflegest&uuml;tzpunkt <? echo $r["ort"] ;?>"</a><? echo $r["e_mail"] ;?><b></td>		
										
									</tr>																		
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top height=30>Internet:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><a href=" <? echo $r["hompage"] ;?> "</a><? echo $r["hompage"] ;?> <b></td>
																	
										
									</tr>																	
									<tr>
										<td valign=top height=30>&Ouml;ffnungszeiten:</td>
										<td><b><? echo $r["oeffnungszeiten_2"] ;?><b></td>
									</tr>																	
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top height=30></td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["oeffnungszeiten_4"] ;?><b></td>
									</tr>																										
								</table>
								<td valign=top align=center width="250">
									<? include ("includes/geo_flaeche.php") ?>
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
		<?} 

// Ebene 3  Luftbild
if ($stu_id > 0 )
   {
      $query="SELECT box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, st_astext(st_centroid(st_transform(a.the_geom, 25833))) as utm, st_astext(st_centroid(st_transform(a.the_geom, 4326))) as geo, st_astext(st_centroid(st_transform(a.the_geom, 31468))) as rd83, st_astext(st_transform(a.the_geom, 2398)) as koordinaten, st_perimeter(a.the_geom) as umfang, a.gid FROM $schema.$tabelle2 as a WHERE a.gid='$stu_id' ";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $stuetzpunkt=$r["stuetzpunkte_id"];	 
	  $area=$r["area"];
	  $s4283 = $r["koordinaten"];
	  $rd83 = $r["rd83"];
	  $utm = $r["utm"];
	  $geo = $r["geo"];
	  $box=$r["box"];
	  $umfang = $r["umfang"];
	  $boxstring = $r["box"];
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  $koordinaten = explode(",",$boxstring);
	  $rechts_range = $koordinaten[0]-$koordinaten[2];
	  $hoch_range = $koordinaten[1]-$koordinaten[3];
	  
	  
	  $query="SELECT oid,gid,strasse,plz,ort,tel_s,tel_p,fax,e_mail,hompage,oeffnungszeiten_2,oeffnungszeiten_4 FROM $schema.$tabelle2 WHERE gid='$stu_id' "; 
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	
	  $plz=$r["plz"];
	  $ort=$r["ort"];
	  $strasse=$r["strasse"];
	  $tel_s=$r["tel_s"];
	  $tel_p=$r["tel_p"];
	  $fax=$r["fax"];
	  $e_mail=$r["e_mail"];
	  $hompage=$r["hompage"];
	  $oeffnungszeiten_2=$r["oeffnungszeiten_2"];
	  $oeffnungszeiten_4=$r["oeffnungszeiten_4"];	
					
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
		<? include ("includes/meta_popup.php");		?>

		<?php
            $geotopkarte= new karte_1;
            echo $geotopkarte->zeigeKarteBox($boxstring,$v_breite,$v_hoehe,'dop','0','0','0','0','0','0','0','0',$beschriftung_karte,$layer7);
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
										<td height="35" align="center" valign=center width=250 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><H2>Pflegest&uuml;tzpunkte </H2><? echo $font_farbe_End ;?>
										</td>
										<td width="30" rowspan="7"></td>
										<td border="5" align=center rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
								
									<tr>
										<td align="center" height="25" colspan="2">Einen weiteren Postleitzahlbereich ausw&auml;hlen:</td>										
									</tr>
									<tr>
										<td align="center" height="40" valign="center" colspan="2">
											<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="<? echo $kuerzel;?>">												
												<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();">
													<?php														
															$query="SELECT DISTINCT a.plz FROM osm.plz as a,health.pflege_gebiete as b WHERE st_intersects(st_centroid(a.geom),b.the_geom) ORDER BY plz";
															$result = $dbqueryp($connectp,$query);

															while($e = $fetcharrayp($result))
														{
														 echo "<option";if ($plz_id == $e["plz"]) echo " selected"; echo ' value="',$e["plz"],'">',$e["plz"],'</option>\n';
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr>										
										<td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="<? echo $_SERVER["PHP_SELF"];?>"><? echo $font_farbe ;?>zur&uuml;ck zur Gesamtansicht<? echo $font_farbe_end ;?></a>;
										</td>										
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>											
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1">Zust&auml;ndiger Pflegest&uuml;tzpunkt <? echo $font_farbe_end ;?></td>
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?> height=30>Ort:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r[plz];?>&nbsp;&nbsp;<? echo $r[ort];?> </b></td>													
									</tr>
									<tr>
									    <td height=30>Stra&szlig;e:</td>
										<td><b><? echo $r["strasse"] ;?></b></td>													
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top height=30>Tel. Sozialberater:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["tel_s"] ;?><b></td>
									</tr>									
									<tr>
										<td valign=top height=30>Tel. Pflegeberater:</td>
										<td><b><? echo $r["tel_p"] ;?><b></td>
									</tr>									
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top height=30>Fax:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["fax"] ;?><b></td>
									</tr>
									<tr>
										<td valign=top height=30>E-Mail:</td>
										<td><b><a href="mailto: <? echo $r["e_mail"] ;?> ?subject=Anfrage an Pflegest&uuml;tzpunkt <? echo $r["ort"] ;?>"</a><? echo $r["e_mail"] ;?><b></td>		
										
									</tr>																		
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top height=30>Internet:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><a href=" <? echo $r["hompage"] ;?> "</a><? echo $r["hompage"] ;?> <b></td>
																	
										
									</tr>																	
									<tr>
										<td valign=top height=30>&Ouml;ffnungszeiten:</td>
										<td><b><? echo $r["oeffnungszeiten_2"] ;?><b></td>
									</tr>																	
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top height=30></td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["oeffnungszeiten_4"] ;?><b></td>
									</tr>																										
								</table>
								<td valign=top align=center width="250">
									<? include ("includes/geo_flaeche.php") ?>
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
<?} ?>