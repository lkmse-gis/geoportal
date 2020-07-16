<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="Haltestellen_Schadstoffmobile";
$layer_legende_2="Kreisgrenze_msp";
$layer_legende_3="msp_outline_gem";
$layer="Haltestellen_Schadstoffmobile";
$label_auswahl="Wertstoffhöfe";
$beschriftung_karte="Haltestelle Schadstoffmobil";

// 2398
// globale Varibalen
$layername_mapfile="Haltestellen_Schadstoffmobile";
$titel="Haltestellen Schadstoffmobil";
$titel_plural="Haltestellen Schadstoffmobil";


$label_auswahl="Haltestelle Schadstoffmobil";
//Layer Name für die externen Programm Blöcke
$datei=$_SERVER["PHP_SELF"];
$schema="supply_and_disposal";
$tabelle="schadstoffmobile";
$kuerzel="haltestellen";
$get_themenname="haltestellen";
$layerid="80610";
// $bildpfad im "block_1_legende" --> portal_functions.php definiert!!!

$gemeinde_id=$_GET["gemeinde"];
$themen_id=$_GET["$kuerzel"];

$log=write_i_log($db_link,$layerid);


// Ebene 1
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
		<? include ("includes/meta_popup.php"); ?>
		<?
             $geoportal_karte= new karte;
             echo $geoportal_karte->zeigeKarteBox($box_mse_gesamt,'685','510','orka','1','0','0','0','0',$beschriftung_karte,$layer);			 
            ?>
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
							<? include ("includes/count_map.php"); ?>
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
								$query="SELECT DISTINCT b.gem_schl,b.gemeinde FROM gemeinden b, $schema.$tabelle as a WHERE st_intersects(a.the_geom,b.the_geom) ORDER BY gemeinde";
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

// Ebene 2 
if ($gemeinde_id > 0)
   { 	  
	 $query="SELECT a.gid,b.gemeinde,b.gem_schl,c.geographicidentifier,d.ortsteil,a.ort,a.strasse,a.datum,a.uhrzeit,a.bild,a.oeffentlich,a.the_geom FROM gemeinden b,gemarkung c,$schema.$tabelle as a Left Join Management.ot_lt_rka d ON ST_WITHIN(a.the_geom,st_transform(d.the_geom,2398)) WHERE b.gem_schl='$gemeinde_id' AND ST_WITHIN(a.the_geom,b.the_geom) AND ST_WITHIN(a.the_geom,c.the_geom) AND d.typ !='Gemeinde' AND d.typ != 'Ortslage' ORDER BY gemeinde";  
	 $result = $dbqueryp($connectp,$query);
	 
	 $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $hsm[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT DISTINCT amt,amt_id FROM gemeinden WHERE gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];
	  
	  $query="SELECT box(st_transform(the_geom,25833)) as etrsbox, st_transform(the_geom,25833) as geom_25833,  gemeinde as name FROM gemeinden WHERE gem_schl='$gemeinde_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemeindename = $r["name"];
	  $etrsbox = $r["etrsbox"];
	  $geom_25833 = $r["geom_25833"];		
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
             $geoportal_karte= new karte;
             echo $geoportal_karte->zeigeKarteBox($etrsbox,'700','520','orka','1','0','1','0','0',$beschriftung_karte,$layer);			 
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
											<? echo $font_farbe ;?>Haltestellen in <br> der Gemeinde <? echo $gemeindename ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=10 rowspan="7"></td>
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

														$query="SELECT DISTINCT b.gem_schl,b.gemeinde FROM gemeinden b, $schema.$tabelle as a WHERE st_intersects(st_transform(a.the_geom,2398),b.the_geom) ORDER BY gemeinde";
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
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle Haltestellen<? echo $font_farbe_end ;?></a>
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
							   <!-- Einbindung des Snippets für die Zeile unter der Karte -->
							   
					           <? include ("includes/block_1_1_uk.php"); ?>												</table>
							</td>
						</tr>
					</table>	<!-- Ende äußere Tablle oberer Block -->
					<!-- Beginn grosse Tabelle unterer Block -->
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td>
							    <!-- Beginn Sachdatentabelle -->
								<table border=0 width="100%" valign=top>
									<? head_trefferliste($count,7,$header_farbe);
									?>		<!-- Header für Trefferliste wird geladen -->											
												<tr>
													<td align=center height=30><b>Bild:</b></td>
													<td align=center height=30><b>GID:</b></td>
													<td height=30>&nbsp &nbsp<b>Strasse:</b></td>
													<td height=30>&nbsp &nbsp<b> Ort:</b></td>
													<td height=30>&nbsp &nbsp<b> Ortsteil:</b></td>
													<td height=30>&nbsp &nbsp<b> Datum:</b></td>
												    <td height=30>&nbsp &nbsp<b> Uhrzeit:</b></td>
																										
												</tr>												
												<?php for($v=0;$v<$z;$v++)
													{   $hsm_id=$hsm[$v]["gid"];
														$bildname = $hsm[$v]["bild"];
														$bildname1 = explode("&",$bildname);
														$bildname2 = $bildname1[0];
														$bildname3 = explode("/",$bildname2);
														$bild="pictures/".$bildname3[5]."/".$bildname3[6];
														$ord_temp=explode(".",$bild);
														$bild2=$ord_temp[0];
														$bild_thumb=$bild2."_thumb.jpg";
														
														echo "<tr bgcolor=",get_farbe($v),">";
															$bild_temp="Kein Bild verfügbar!";
														
															if(strlen($bildname) < 1 OR $hsm[$v]["oeffentlich"] == 'nein') 
															{
																echo "<td align=center > $bild_temp </td>";
															} 
															else 
															{
																echo "<td align='center'><a href=$bild target='_blank' onclick='return popup(this.href);'><img src=$bild_thumb height='30'></a></td>";
															}											
															echo "<td align='center' height='30'><a href=\"$datei?haltestellen=", $hsm[$v]["gid"],"\"><b><u>",$hsm[$v]["gid"],"</u></b></a></td>",
															      
																"<td>","&nbsp &nbsp",$hsm[$v]["strasse"],"</td>",
																"<td><a href=\"$datei?haltestellen=", $hsm[$v]["gid"],"\"><b><u>",$hsm[$v]["ort"],"</u></b></a></td>",
																"<td>","&nbsp &nbsp",$hsm[$v]["ortsteil"],"</td>",
																"<td>","&nbsp &nbsp",$hsm[$v]["datum"],"</td>",
																"<td>","&nbsp &nbsp",$hsm[$v]["uhrzeit"],"</td></tr>";
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
                echo div_footer(); 
            ?>
		</div>
		</body>
		</html>
<?  }
// Ebene 3 
if ($themen_id > 0)
   {   
// Text Amt:
	  $query="SELECT b.gemeinde,b.gem_schl,c.gen as amt,c.gid as amt_id FROM gemeinden b,kataster.amtsbereiche c,$schema.$tabelle as a  WHERE  ST_WITHIN(a.the_geom,b.the_geom) AND ST_WITHIN(a.the_geom,c.the_geom) AND a.gid=$themen_id"; 
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);

	  $amtname=$r["amt"];
	  $amt=$r["amt_id"];
	  $gem_id=$r["gem_schl"];
	  $gemeindename=$r["gemeinde"];
	  

// Text Ort...
	  $query="SELECT a.oid,box(st_transform(a.the_geom,25833)) as etrsbox,st_transform(a.the_geom,25833) as geom_25833,a.gid,a.ort,a.strasse,b.gemeinde,b.gem_schl,c.geographicidentifier,d.ortsteil,a.bild,a.datum,a.uhrzeit,a.oeffentlich,a.the_geom FROM gemeinden b,gemarkung c,$schema.$tabelle a Left Join Management.ot_lt_rka d ON st_intersects (a.the_geom,st_transform(d.the_geom,2398)) WHERE st_intersects(a.the_geom,b.the_geom) and st_intersects(a.the_geom,c.the_geom) AND a.gid=$themen_id AND d.typ !='Gemeinde' AND d.typ != 'Ortslage'";  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $ortsteil_1 = $r["ortsteil"];
	  $etrsbox=$r["etrsbox"];
	  $geom_25833=$r["geom_25833"];
	  
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
		<? include ("includes/bilder_popup.php"); ?>
		<?
             $geoportal_karte= new karte;
             echo $geoportal_karte->zeigeKarteBox($etrsbox,'700','520','orka','1','0','0','0','0',$beschriftung_karte,$layer);			 
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
										<td height="40" align="center" valign=center width=270 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?>Haltestelle <? echo $r["ortsteil"] ;?><? echo $font_farbe_end ;?>
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
												Stadt:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $kuerzel;?>.submit();">
													<?php

														$query="SELECT DISTINCT b.gemeinde,b.gem_schl FROM gemeinden b,$schema.$tabelle as a  WHERE st_intersects(st_transform(a.the_geom,2398),b.the_geom) ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);

														while($e = $fetcharrayp($result))
															{
																echo "<option";if ($gem_id == $e["gem_schl"]) echo " selected"; echo ' value="',$e["gem_schl"],'">',$e["gemeinde"],'</option>\n';
															}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center colspan=2>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?> zurück zu allen <br><?echo $titel; ?> <? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center height="50" colspan=2>
											<a href="<? echo $datei;?>?gemeinde=<? echo $gem_id; ?>"><? echo $font_farbe ;?>zurück zur Gemeinde: <br><? echo $gemeindename ?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
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
							   <!-- Einbindung des Snippets für die Zeile unter der Karte -->
							   
					           <? include ("includes/block_1_1_uk.php"); ?>												</table>
							</td>
						</tr>
                        </table>
								 
								<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
								<tr>
								<td valign=top>											
									<table border=0 valign=top>
										<tr height="35">
											<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $titel; $r["gemarkung"] ;?><? echo $font_farbe_end ;?></td>													
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>&nbsp;&nbsp;GID:</td><td width="100%" bgcolor=<? echo $element_farbe ?>><b>&nbsp&nbsp<? echo $r["gid"] ;?></b></td>
											<?			
														
														$bildname = $r["bild"];
														$bildname1 = explode("&",$bildname);
														$bildname2 = $bildname1[0];
														$bildname3 = explode("/",$bildname2);
														$bild="pictures/".$bildname3[5]."/".$bildname3[6];

											?>			
											<?			
												if(strlen($bildname) < 1 OR $r["oeffentlich"] == 'nein')										
													{
														echo "<td valign=center align=right rowspan=10 width=420 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b> kein Bild verfügbar<br>oder nicht freigegeben</b></font></td></tr></table></td>";
													} 
												else 
													{
														echo "<td valign=top align=right rowspan=10 width=420><a href=$bild target='_blank' onclick='return popup(this.href);'><img height='235' src=$bild height='30'></a></td>"; 
													}
											?>
										</tr>
										<tr>
											<td>&nbsp;Strasse:</td><td><b><? echo $r["strasse"] ?></b></td>
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>&nbsp;Ort: </td><td bgcolor=<? echo $element_farbe ?>><b><? echo $r["ort"] ?></b></td>
										</tr>										
										<tr>
											<td>&nbsp;Ortsteil:</td> <td><b><? echo $r["ortsteil"] ?></b> </td>
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>&nbsp;Datum:</td><td bgcolor=<? echo $element_farbe ?>><b><? echo $r["datum"] ?></b></td>
										</tr>
										<tr>
											<td>&nbsp;Uhrzeit:</td><td><b><? echo $r["uhrzeit"] ?></b></td>
										</tr>										
									</table>
							</td>									
							<td valign=top align=center width="250">
							<? echo geo_punkt($geom_25833,$connectp,$dbqueryp,$fetcharrayp) ?>	
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

