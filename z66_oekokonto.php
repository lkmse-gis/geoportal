<?php
include ("includes/connect_geobasis.php");
include ("includes/portal_functions.php");
include ("includes/connect_i_procedure_mse.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");

//globale Varibalen
$v_themen_id="11";
$beschriftung_karte="oekokonto";
$titel="Naturschutz/Landschaftspflege";
$titel2="Ökokonto";
$v_auswahl="Gemeinde";
$v_breite="700";
$v_hoehe="490";

// Legenden - Layer - msp.map - 2 spaltig - Standard|Themen 
$breite1="90";
$breite2="180";
$layer="oekokonto";
$layer1="";
$layer2="Kreisgrenze_msp";
$layer3="aemter_msp_outline";
$layer4="msp_outline_gem";
$layer5="msp_outline_gemkg";
$layer6="Postleitzahlbereiche";
$layer99="";

// Datenbank
$tabelle="zustaendigkeiten_66";
$schema="organisation";
$kuerzel="gemeinde";
$layerid=160500;
$gemeinde_id=$_GET["$kuerzel"];

$log=write_i_log($db_link,$layerid);

// <! Block 1 >
if ($gemeinde_id < '1')
    { 
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle";      
        $result = $dbqueryp($connectp,$query);
        $r = $fetcharrayp($result);
        $count = $r["anzahl"];
		
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
		   
           echo $geotopkarte->zeigeKarteBox($box_mse_gesamt,$v_breite,$v_hoehe,'orka','0','0','1','0','0',$beschriftung_karte,$layer);
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
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="gemeinde">
								<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
									<option>Bitte auswählen</option>	
									 <?php
									 $query="SELECT * FROM gemeinden WHERE kreis_id = '13071' ORDER BY gemeinde";
									 $result = $dbqueryp($connectp,$query);
									 
									 while($r = $fetcharrayp($result))
									   {
									   echo "<option value=\"$r[gem_schl]\">$r[gemeinde]</option>\n";
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
//								 function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer2)
                                 echo $legende_geo->zeigeLegende2('0','0','0','1','0','0',$layer,$layer99)
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
<?
}


// Ebene 2
if ($gemeinde_id > 0)
   { ?>
   <? include ("includes/amt_gemeinde_box.php"); ?>
   <?
	  
	   $query="SELECT a.mitarbeiter_titel,a.mitarbeiter_name,a.mitarbeiter_vorname,a.mitarbeiter_telefon,a.mitarbeiter_fax,a.mitarbeiter_mail,a.sg_name,a.sg_leiter_name,a.sg_leiter_vorname,a.sg_leiter_telefon,a.sg_leiter_mail,a.fachamt_name,a.fachamt_leiter,a.fachamt_leiter_telefon,a.fachamt_leiter_mail FROM organisation.ma_gesamt as a, $schema.$tabelle as b WHERE b.themen_id='$v_themen_id' AND a.mitarbeiter_id=CAST(b.mitarbeiter_id AS INTEGER) AND st_intersects(st_buffer('$gemeindeumring',-5),st_transform(b.the_geom,2398))";
	  
	   $i_sachbearbeiter=0;
	   $result = $dbqueryp($connectp,$query);
	    
		while($r = $fetcharrayp($result))
		 {
		  $sachbearbeiter[$i_sachbearbeiter]=$r;
		  $i_sachbearbeiter++;
		 }
		$sp_anz=2;
		IF ($i_sachbearbeiter > 1) $sp_anz = 4;		  
	  
	  
	  
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
		// 				function zeigeKarteBox($box,$width,$height,$basiskarte,$landkreis,$aemter,$gemeinden,$gemarkungen,$adressen,$beschriftung,$layer)
            $geotopkarte= new karte;
            echo $geotopkarte->zeigeKarteBox($boxstring,$v_breite,$v_hoehe,'orka','0','1','1','0','0',$beschriftung_karte,$layer);
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
									   <td height="20" align="center" valign=center width=250 colspan="2" bgcolor=<? echo $header_farbe ; ?>> 
                                            <? echo $font_farbe ;?> Gemeinde: <? echo $gemeindename ;?><? echo $font_farbe_end ;?></td>
                                        <td width=30 rowspan=7></td>
                                        <td border=0 valign=center align=right rowspan=6 colspan=3>
										    <div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<b>(Amt: <? echo $amtname ?>)</b>
										</td>
									</tr>
									<tr>
                                        <td align="center" height="25" colspan="2"><? echo $titel2;?>:</td>
                                    </tr>
									<tr>
										<td align="center" height=40 valign="center" colspan=2 >
											<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="gemeinde">
												Gemeinde:&nbsp;
												<select name="gemeinde" onchange="document.gemeinde.submit();">
													<?php
														$query="SELECT * FROM gemeinden WHERE kreis_id = '13071' ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);

														while($rx = $fetcharrayp($result))
														{
														 echo "<option";if ($gemeinde_id == $rx["gem_schl"]) echo " selected"; echo ' value="',$rx["gem_schl"],'">',$rx["gemeinde"],'</option>\n';
														}
													?>
												</select>
											</form>
										</td>
									</tr>
								
									<tr>
										<td align="center" height="10" valign=center colspan=2 bgcolor=<? echo $element_farbe ?>>
											<a href="<? echo $_SERVER["PHP_SELF"] ;?> " title="zurück"><U>gesamten Landkreis anzeigen</U>  </a>
											
										</td>
									</tr>
									<tr>
									<!-- Tabelle für Legende -->
										<td valign=bottom align=right>
											<table  width="100%" border="1" cellpadding="0" cellspacing="0" align="left">
                                            <B>Kartenlegende :</B>
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
							<? include ("includes/z66_mitarbeiter.php") ?>
							</td>
								<td valign=top align=center width="350">
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
<?  } ?>
