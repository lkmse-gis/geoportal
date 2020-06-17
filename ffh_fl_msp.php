<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="Fauna Flora Habitat Gebiete";
$layer_legende_2="Kreisgrenze_msp";
$layer="Fauna Flora Habitat Gebiete";


$titel="Fauna Flora Habitat Gebiete";
$label_auswahl="FFH-Gebiet";
$beschriftung_karte="Fauna Flora Habitat Gebiet";
$datei=$_SERVER["PHP_SELF"];
$tabelle="sg_ffh_fl";
$schema="environment";
$kuerzel="ffh";
$layerid="32000";

$log=write_i_log($db_link,$layerid);

$ffh_id=$_GET["$kuerzel"];

if ($ffh_id < 1)
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
			<body onload="init();load();">
				<div id="container">
					<div id="header">
					<?php head_portal(); ?>
					</div>
					<div id="wrapper">
						<div id="content">
							<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
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
									<td align="center"  height=60 colspan=2>
										<? echo $label_auswahl; ?> ausw&auml;hlen:
									</td>
								</tr>
								<tr>
									<td align="center" height=40 colspan=2>
										<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
										<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
											<?php
												$query="SELECT name, gid FROM $schema.$tabelle ORDER BY name";
												$result = $dbqueryp($connectp,$query);
												echo "<option>Bitte ausw&auml;hlen</option>\n";
												while($r = $fetcharrayp($result))
													{
														echo '<option value="',$r["gid"],'">',$r["name"],'</option>\n';
													}
											?>
										</select>										
										</form>
									</td>									
								</tr>
								
								<!-- es folgt die Einbindung eines Snippets mit der Verknüpfung zu den Metadaten -->
								
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
				</div>  <!-- Ende Haupt-Container -->
			</body>
		</html>
<?	} 


if ($ffh_id > 0)
   {   
	  $query="SELECT a.name, a.amts_sf FROM kataster.amtsbereiche as a, $schema.$tabelle as b WHERE ST_INTERSECTS(st_transform(b.the_geom,2398),a.the_geom) AND b.gid='$ffh_id' ORDER by a.name";
	  $result = $dbqueryp($connectp,$query);
	  $i=0;
	  while($r = $fetcharrayp($result))
	    {
	       $aemter[$i]=$r;
		   $i++;
		   $count_amt=$i;
		}

	  $query="SELECT a.gem_schl, a.gemeinde FROM gemeinden as a, $schema.$tabelle as b WHERE ST_INTERSECTS(st_transform(b.the_geom,2398),a.the_geom) AND b.gid='$ffh_id' ORDER by a.gemeinde";
	  $result = $dbqueryp($connectp,$query);
	  $k=0;
	  while($r = $fetcharrayp($result))
	    {
	       $gemeinden[$k]=$r;
		   $k++;
		   $count_gemeinde=$k;
		}
	  
	  $query="SELECT st_transform(the_geom,25833) as geom_25833,box(st_transform(the_geom,25833)) as etrsbox,  gid, name,ha_etrs as area_ha, eu_nr, ffh_art1, ffh_art2, anz_art, bedeut,  managem, gis_code FROM $schema.$tabelle WHERE gid='$ffh_id'";	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bildname = $r["ziel"];
	  $ffh_karte= new karte;
      $ffh_karte->VariablenSetzen($r);  ?>
	  
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
        		 
		<script type="text/javascript">
			function popup (url) {
				fenster = window.open(url, "Popupfenster", "width=700,height=1000,resizable=yes");
				fenster.focus();
				return false;
			}
		</script>
		
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
									
									<!-- Spalte 1 -->
										<td height="40" align="center" valign=center width=250 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $r["name"]; ?><? echo $font_farbe_End ;?>
										</td>
									<!-- Spalte 2 (Zwischenspalte) -->
										<td width=30 rowspan=7></td>
									<!-- Spalte für die Karte -->
										<td border=0 align=center rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>EU-Nummer: <? echo $r["eu_nr"]; ?></b><br>											
										</td>
									</tr>
									<tr>
										<td align="center" height="25" colspan="2"><? echo $label_auswahl;?>:</td>										
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
												<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
													<?php
														$query="SELECT name, gid FROM $schema.$tabelle ORDER BY name";
														$result = $dbqueryp($connectp,$query);														
														while($e = $fetcharrayp($result))
														{
														 echo "<option";if ($ffh_id == $e["gid"]) echo " selected"; echo ' value="',$e["gid"],'" title="',$e["name"],'">',$e["name"],'</option>\n';
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr>										
										<td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $titel;?><? echo $font_farbe_end ;?></a>
										</td>										
									</tr>									
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
							</td>
						</tr>
					</table>
				<!-- Beginn Sachdatenanzeige und Geodätisches-->
				
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						    <tr>
						<!-- Sachdatenanzeige -->
							<td valign=top>											
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=2  width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r["name"] ;?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">FFH Art (Klasse 1):</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["ffh_art1"] ;?></b></td>													
									</tr>
									<tr height="30">
										<td>FFH Art (Klasse 2):</td>
										<td><b><? echo $r["ffh_art2"] ;?></b></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Bedeutung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["bedeut"] ;?></b></td>													
									</tr>
									
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Management:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["managem"] ;?></b></td>													
									</tr>
									<tr height="30">
										<td>Fl&auml;che in ha:</td>
										<td><b><? echo $r["area_ha"] ;?></b></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Artenanzahl:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["anz_art"] ;?></b></td>													
									</tr>
																	
									<tr>
										<td bgcolor=<? echo $element_farbe ?> valign=top><? echo $titel2;?> schneidet folgende<br>&Auml;mter des Kreises:</td>
										<td bgcolor=<? echo $element_farbe ?>><b>
											<?php 
												for($x=0;$x<$i;$x++)
												{ echo "<a href=\"aemter_msp.php?amt=",$aemter[$x][1],"\">",$aemter[$x][0],"</a><br>";}
											?></b>
										</td>													
									</tr>
									<tr>
										<td valign=top><? echo $titel2;?> schneidet folgende<br>Gemeinden des Kreises:</td>
										<td><b>
											<?php 
												for($y=0;$y<$k;$y++)
												{echo "<a href=\"gemeinden_msp.php?gemeinde=",$gemeinden[$y][0],"\">",$gemeinden[$y][1],"(".$gemeinden[$y][0].")</a><br>";}
											?></b>
										</td>
									</tr>																		
								</table>
							</td>
						<!-- Zwischenspalte -->	
							<td width=30></td>
						<!-- Spalte für Geodätisches -->	
							<td valign=top align=center width="350">
							<?php echo geo_flaeche($ffh_karte->geom_25833,$connectp,$dbqueryp,$fetcharrayp); ?>
							</td>
						</tr>
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
<?  }

