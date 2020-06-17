<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="Fauna Flora Habitat (Punkte)";
$layer_legende_2="Kreisgrenze_msp";
$layer_legende_3="msp_outline_gem";
$layer="Fauna Flora Habitat (Punkte)";

//globale Varibalen
$titel="Fauna Flora Habitat (Punkte)";
$label_auswahl="FFH (Punkt)";
$beschriftung_karte="Fauna Flora Habitat Punkt";
$datei=$_SERVER["PHP_SELF"];
$tabelle="sg_ffh_pkt";
$schema="environment";
$kuerzel="ffhpkt";
$layerid="32250";

$log=write_i_log($db_link,$layerid);

$gemeinde_id=$_GET["gemeinde"];
$ffh_pkt=$_GET["$kuerzel"];
$themen_id=$ffh_pkt;

if ($themen_id < 1 AND $gemeinde_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r["anzahl"];
	
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
		<? include ("includes/meta_popup.php"); 
        $ffh_karte= new karte;
        echo $ffh_karte->zeigeKarteBox($box_mse_gesamt,'740','450','orka','1','0','0','0','0',$beschriftung_karte,$layer);?>
		<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
		
		</head>
		<body onload="load();init()">
		<div id="container">
			<div id="header">
				<?php
					head_portal();
				?>
			</div>
			<div id="wrapper">
				<div id="content">
					<table width="100%" border=0 cellpadding="0" align="center" cellspacing="0">
								<tr>
									<!-- linke Spalte mit Auswahlfeld, Kartenlegende usw. -->
									
									<td align="center" valign="top" height=30 colspan=2><br>
										<h3><? echo $titel; ?>*</h3>
										Zu diesem Thema befinden sich<br>
										<b><? echo $count; ?></b> Datens&auml;tze in der Datenbank.
									</td>
									
									<!-- schmale Zwischenspalte für den Abstand zur Karte -->
									
									<td width=30 rowspan=8></td>
									
									<!-- Spalte für die Karte, der Map-Container wird in der Klasse Karte erzeugt -->
									
									<td border=0 valign=top align=center rowspan=7 colspan=3>
										<br>
										<div style="margin:1px" id="map"></div>
									</td>
								</tr>
		<!-- es folgen 2 Zeilen für die Auswahl des Objektes -->
						<tr>
							<td align="center" height=50 colspan=2>
								Gemeinde ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
								<select name="gemeinde" onchange="document.<? echo $kuerzel;?>.submit();">
									<option>Bitte auswählen</option>
									<?php
										$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $schema.$tabelle as a, gemeinden as b WHERE ST_WITHIN(st_transform(a.geom,2398), b.the_geom) ORDER BY gemeinde";
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
			<!-- Einbindung eines Snippets mit der Verknüpfung zu den Metadaten (3 Zeilen)-->
			
						<? include ("includes/meta_i_aktualitaet.php"); ?>
						
			<!-- Zeile für die Legende -->
								
								<tr>									
 			                       <td valign=bottom align=left >
							       <table class="table_legende" >
								    <B>Kartenlegende :</B>
								    <?php
								     $legende_geo= new legende_geo;
								     echo $legende_geo->zeigeLegende($layer_legende,$layer_legende_2,'','','');
								     ?>
							       </table> 
						          </td>
    		                   	</tr>
																			

			 <!-- Einbindung des Snippets für die Zeile unter der Karte -->
							   
			    <? include ("includes/block_1_1_uk.php"); ?>				
			 </table>
			</div>  <!-- Ende Content-Container -->
		</div>  <!-- Ende Wrapper-Container -->			
		<div id="navigation">
		<? include ("includes/navigation.php"); ?>
		</div>
		<div id="extra">
		<? include ("includes/news.php"); ?>
		</div>
		<div id="footer">			
		</div>
		</div>
		</body>
		</html>
<?	} 


if ($gemeinde_id > 0)
   { 	  
	  $query="SELECT a.gid, a.eu_nr, a.name_zus, a.name_tg FROM $schema.$tabelle as a, gemeinden as b WHERE ST_WITHIN(st_transform(a.geom,2398), b.the_geom) AND b.gem_schl='$gemeinde_id' ORDER BY a.name_zus";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $ffhpkt[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT amt, amt_id FROM gemeinden WHERE gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];
	  
	  $query="SELECT box(st_transform(a.the_geom,25833)) as etrsbox, st_astext(st_transform(st_centroid(a.the_geom),25833)) as etrscenter, box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.gemeinde as name FROM gemeinden as a WHERE a.gem_schl='$gemeinde_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemeindename = $r["name"];
	  $ffh_karte= new karte;
      $ffh_karte->VariablenSetzenPolygon($r);  ?>
	  
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
		<? include ("includes/bilder_popup.php"); ?>
		<?php echo $ffh_karte->zeigeKarteBox($ffh_karte->etrsbox,'680','450','orka','1','0','1','0','0',$beschriftung_karte,$layer); ?>			 
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
										<td height="40" align="center" valign=top width=250 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $titel;?> in <br> <? echo $gemeindename ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=30 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="30" valign=center bgcolor=<? echo $element_farbe; ?>>
											<b>(Amt: <a href="aemter_msp.php?amt=<? echo $amt; ?>"><? echo $amtname ?></a>)</b>
										</td>
									</tr>
									<tr>
										<td align="center" height="40">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												Gemeinde:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $kuerzel;?>.submit();">
													<?php
														$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $schema.$tabelle as a, gemeinden as b WHERE ST_WITHIN(st_transform(a.geom,2398), b.the_geom) OR b.gemeinde='-- Bitte auswählen --' ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);

														while($r = $fetcharrayp($result))
															{
																echo "<option";if ($gemeinde_id == $r["gem_schl"]) echo " selected"; echo ' value="',$r["gem_schl"],'">',$r["gemeinde"],'</option>\n';
															}
													?>
												</select>
											</form>
										</td>										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $titel;?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr><td  height=10></td></tr>
								<!-- Zeile für die Legende -->
								
								   <tr>									
 			                       <td valign=bottom align=left >
							       <table class="table_legende" >
								    <B>Kartenlegende :</B>
								    <?php
								     $legende_geo= new legende_geo;
								     echo $legende_geo->zeigeLegende($layer_legende,$layer_legende_2,$layer_legende_3,'','');
								     ?>
							       </table> 
						          </td>
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
									<? head_trefferliste($count,4,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->											
									<tr>
													<td align=center height=30><a name="Liste"></a><b>EU-Nummer:</b></td>
													<td align=center height=30><b>Name:</b></td>
													<td align=center height=30><b>Namenszusatz:</b></td>
													
												</tr>												
												<?php for($v=0;$v<$z;$v++)
													{ 
														echo "<tr bgcolor=",get_farbe($v),">";																								
														echo "
														<td align='center' height='30'><a href=\"$datei?$kuerzel=",$ffhpkt[$v]["gid"],"\">",$ffhpkt[$v]["eu_nr"],"</a></td>",
														"<td align='center'>",$ffhpkt[$v]["name_zus"],"</td>",
														"<td align='center'>",$ffhpkt[$v]["name_tg"],"</td>";
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
			<div id="navigation">
				<? include ("includes/navigation.php"); ?>
			</div>
			<div id="extra">
				<? include ("includes/news.php") ?>			
			</div>
			<div id="footer">				
			</div>
		</div>
		</body>
		</html>
<?  }

 if ($themen_id > 0)
   {   
	  $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid, b.gid FROM gemeinden as a, $schema.$tabelle as b WHERE ST_WITHIN(st_transform(b.geom,2398), a.the_geom) AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r["amt"];
	  $amt=$r["amt_id"];
	  $gem_id=$r["gemeindeid"];
	  $gemeindename=$r["gemeinde"];
	  
	  $query="SELECT astext(st_transform(geom,2398)) as koordinaten, astext(st_transform(geom, 25833)) as utm, st_astext(st_centroid(st_transform(geom, 31468))) as rd83, box(st_transform(geom,25833)) as etrsbox, st_transform(geom,25833) as geom_25833, astext(st_transform(geom, 4326)) as geo, gid, eu_nr, name_zus, name_tg FROM $schema.$tabelle WHERE gid='$themen_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bildname = $r["ziel"];
	  $ffh_karte= new karte;
      $ffh_karte->VariablenSetzenPolygon($r);  ?>
	  
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
		<?php echo $ffh_karte->zeigeKarteBox($ffh_karte->etrsbox,'680','450','orka','1','0','0','0','0',$beschriftung_karte,$layer); ?>			 
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
										<td height="40" align="center" valign=center width=270 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $r["name_tg"]; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=10 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>Amt: <? echo $amtname; ?></b>
										</td>
									</tr>
									<tr>
										<td align="center" height="35" colspan="2">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												Gemeinde:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $kuerzel;?>.submit();">
													<?php
														$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $schema.$tabelle as a, gemeinden as b WHERE ST_WITHIN(st_transform(a.geom,2398), b.the_geom) OR b.gemeinde='-- Bitte auswählen --' ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);

														while($e = $fetcharrayp($result))
															{
																echo "<option";if ($gemeinde_id == $e["gem_schl"]) echo " selected"; echo ' value="',$e["gem_schl"],'">',$e["gemeinde"],'</option>\n';
															}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center colspan=2>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $titel;?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center height="50" colspan=2>
											<a href="<? echo $datei;?>?gemeinde=<? echo $gem_id; ?>"><? echo $font_farbe ;?>alle <? echo $titel;?><br><? echo $gemeindename ?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr>										
										<td valign=bottom align=right>
											<table border="1" rules="none" width="100%" valign=bottom align=right>					
												<tr>
													<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
												</tr>
												<tr>
													<td width=100 align=right><small><? echo $label_auswahl;?>: </td>
													<td align=right><img src="images/ffh_pkt.gif" width=20></td>
													<td align=right><small>Kreisgrenze: </td>
													<td align=right><img src="images/gemeindegrenze_2.png" width=20></td>
												</tr>																					
											</table>
										</td>
									</tr>
									<? include ("includes/block_3_uk.php"); ?>	
                                 </table>
								 
							 <table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td valign=top>											
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r["name_tg"] ;?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?>>EU-Nummer:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["eu_nr"] ;?></b></td>
									</tr>
									<tr height="30">
										<td>Name:</td>
										<td><b><? echo $r["name_zus"] ;?></b></td>																									
									</tr>
									
									
								</table>
							</td>									
							<td valign=top align=center width="250">
							<?php echo geo_punkt($ffh_karte->geom_25833,$connectp,$dbqueryp,$fetcharrayp); ?>	
							</td>
						</tr>
						</table>
						</td></tr>
					</table>
				</div>
			</div>
			<div id="navigation">
				<? include ("includes/navigation.php"); ?>
			</div>
			<div id="extra">
             <? include ("includes/news.php") ?>			
			</div>
			<div id="footer">				
			</div>
		</div>
		</body>
		</html>
<?  }

