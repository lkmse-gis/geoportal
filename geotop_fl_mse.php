<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");

//Variablen
$titel="Geotope (Flächen)";
$layer_name="geotope_fl_2016";
$layer_legende="geotope_fl_2016";
$layer_legende_2="Kreisgrenze_msp";
$beschriftung_karte="Geotope";
$tabelle="sg_geotope_fl_2016";
$schema="environment";
$layerid="32055";

$log=write_i_log($db_link,$layerid);

$objekt_id=$_GET["wert"];

if ($objekt_id < 1)
    { 
	    
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r["anzah"];
	
		
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
             echo $geotopkarte->zeigeKarteBox($box_mse_gesamt,'730','490','orka','1','0','0','0','0',$beschriftung_karte,$layer_name);			 
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
									
									<td align="center" valign="top" height=30 colspan=2>
									    <?php
										  echo get_i_mp_link($db_link,$layerid);
										?>
									
										<h3><? echo $titel; ?>*</h3>
										Zu diesem Thema befinden sich<br>
										<b><? echo $count; ?></b> Datens&auml;tze in der Datenbank.
									</td>
									<td width=30 rowspan=8></td>
									<td border=0 valign=top align=center rowspan=7 colspan=3>
										<br>
										<div style="margin:1px" id="map"></div>
									</td>
								</tr>
								<tr>
									<td align="center"  height=60 colspan=2>
										Geotop ausw&auml;hlen:
									</td>
								</tr>
								<tr>
									<td align="center" height=40 colspan=2>
										<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="wert">
										<select name="wert" onchange="document.wert.submit();" style="width: 200px;">
											<?php
												$query="SELECT a.geotop_nr || ': ' ||c.gemarkungsname_kurz || ', ' || b.sg_bezeichnung as geotop_bez, a.gid FROM $schema.$tabelle as a, $schema.sg_geotope_code_zuordn as b, gemarkung as c WHERE a.geotoptyp=b.sg_code AND st_intersects(st_transform(st_centroid(a.geom),2398),c.the_geom) ORDER BY geotop_bez";
												$result = $dbqueryp($connectp,$query);
												echo "<option>Bitte ausw&auml;hlen</option>\n";
												while($r = $fetcharrayp($result))
													{
														echo "<option value=\"$r[gid]\">$r[geotop_bez]</option>\n";
													}
											?>
										</select>										
										</form>
									</td>									
								</tr>
			<!-- Einbindung eines Snippets mit der Verknüpfung zu den Metadaten (3 Zeilen)-->
			
						<? include ("includes/meta_i_aktualitaet.php"); ?>
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
<?	}


if ($objekt_id > 0)
   {   
	  $query="SELECT a.name, a.amts_sf FROM kataster.amtsbereiche as a, $schema.$tabelle as b WHERE ST_INTERSECTS(b.geom,a.geom_25833) AND b.gid='$objekt_id' ORDER by a.name";
	  $result = $dbqueryp($connectp,$query);
	  $i=0;
	  while($r = $fetcharrayp($result))
	    {
	       $aemter[$i]=$r;
		   $i++;
		   $count=$i;
		}

	  $query="SELECT a.gem_schl, a.gemeinde FROM gemeinden as a, $schema.$tabelle as b WHERE ST_INTERSECTS(b.geom,st_transform(a.the_geom,25833)) AND b.gid='$objekt_id' ORDER by a.gemeinde";
	  $result = $dbqueryp($connectp,$query);
	  $k=0;
	  while($r = $fetcharrayp($result))
	    {
	       $gemeinden[$k]=$r;
		   $k++;
		   $count=$k;
		}
	  
	  $query="SELECT  box(a.geom) as box,a.gid, a.geotop_nr, a.geotoptyp, a.legende,b.sg_bezeichnung as geotoptyp_bez,a.geotop_nr || ': ' || c.gemarkungsname_kurz || ', ' || b.sg_bezeichnung as geotop_bez,a.geom as geometrie FROM $schema.$tabelle as a, $schema.sg_geotope_code_zuordn as b, gemarkung as c WHERE a.geotoptyp=b.sg_code AND st_intersects(st_transform(a.geom,2398),c.the_geom) AND a.gid='$objekt_id'";	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $geometrie=$r["geometrie"];	  
	  $boxstring = $r["box"];
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
				
              $geotopkarte= new karte;
              echo $geotopkarte->zeigeKarteBox($boxstring,'730','490','orka','1','1','1','0','0',$beschriftung_karte,$layer_name);
             ?>
			
			 <style type="text/css">
			td.rand {border: solid #000000 2px;}
			td.rahmen {border: solid #000000 1px;}
		</style> 
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
										<td height="40" align="center" valign=center width=250 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $r["geotop_bez"]; ?><? echo $font_farbe_End ;?>
										</td>
										<td width=30 rowspan=7></td>
										<td border=0 align=center rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>Typ: <? echo $r["geotoptyp_bez"]; ?></b><br>											
										</td>
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">Geotop:</td>										
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">
											<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="wert">
												<select name="wert" onchange="document.wert.submit();" style="width: 200px;">
													<?php
												$query="SELECT a.geotop_nr || ': ' || c.gemarkungsname_kurz || ', ' || b.sg_bezeichnung as geotop_bez, a.gid FROM $schema.$tabelle as a, $schema.sg_geotope_code_zuordn as b, gemarkung as c WHERE a.geotoptyp=b.sg_code AND st_intersects(st_transform(a.geom,2398),c.the_geom) ORDER BY geotop_bez";
												$result = $dbqueryp($connectp,$query);
												echo "<option>Bitte ausw&auml;hlen</option>\n";
												while($e = $fetcharrayp($result))
													{
														echo "<option";if ($objekt_id == $e["gid"]) echo " selected"; echo ' value="',$e["gid"],'">',$e["geotop_bez"],'</option>\n';
													}
											?>
												</select>
												
											</form>
										</td>
									</tr>
									<tr>										
										<td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="<? echo $_SERVER["PHP_SELF"];?>"><? echo $font_farbe ;?>alle <? echo $titel;?><? echo $font_farbe_end ;?></a>
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
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						    <tr>
							<td valign=top>											
								<table border=0 valign=top>
									<tr height="35">
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r["geotop_bez"] ;?><? echo $font_farbe_end ;?></td>													
									</tr>
									
									<tr>
										<td height=30>Geotop-Nummer:</td>
										<td><b><? echo $r["geotop_nr"] ;?></b></td>													
									</tr>
									<tr>
										<td bgcolor=<? echo $element_farbe ?> height=30>Bezeichnung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["geotoptyp_bez"] ;?></b></td>													
									</tr>
									
									<tr>
										<td valign=top><? echo $titel2;?> schneidet folgende<br>&Auml;mter des Kreises:</td>
										<td><b>
											<?php 
												for($x=0;$x<$i;$x++)
												{ echo "<a href=\"aemter_msp.php?amt=",$aemter[$x][1],"\">",$aemter[$x][0],"</a><br>";}
											?></b>
										</td>													
									</tr>
									<tr>
										<td  bgcolor=<? echo $element_farbe ?> valign=top><? echo $titel2;?> schneidet folgende<br>Gemeinden des Kreises:</td>
										<td bgcolor=<? echo $element_farbe ?>><b>
											<?php 
												for($y=0;$y<$k;$y++)
												{echo "<a href=\"gemeinden_msp.php?gemeinde=",$gemeinden[$y][0],"\">",$gemeinden[$y][1],"(".$gemeinden[$y][0].")</a><br>";}
											?></b>
										</td>
									</tr>																		
								</table>
							</td>
							<td width=30></td>
							<td valign=top align=center width="250">
								<? echo geo_flaeche($geometrie,$connectp,$dbqueryp,$fetcharrayp) ?>
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
<?  }

