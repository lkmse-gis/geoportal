<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="HS-Kataster";
$layer_legende_2="Kreisgrenze_msp";
$layer="HS-Kataster";
$label_auswahl="Haltestelle";
$beschriftung_karte="Haltestelle";


//globale Varibalen

$layername_mapfile="Hs-Kataster";
$titel="Haltestellen";
$titel_plural="Haltestellen";
$titel_legende="Haltestellen";

$v_breite="700";
$v_hoehe="490";



$schema="traffic";
$tabelle="haltestellen_kataster";

$get_themenname="haltestelle";
$layerid="70320";

$ortslage_id=$_GET["ortslage"];
$themen_id=$_GET["$get_themenname"];
$linie_id=$_GET["linie"];

if (isset($linie_id))
  {
   $query="SELECT linie ,verlauf, fahrplan FROM traffic.buslinien WHERE gid='$linie_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $linie_bezeichnung=$r["linie"];
	  $linie_verlauf=$r["verlauf"];
	  $fahrplan=$r["fahrplan"];
  }

$log=write_i_log($db_link,$layerid);

// Ebene 1
if ($themen_id < 1 AND $ortslage_id < 1 AND $linie_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle";
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r["anzahl"];
	
	?>
		
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <!--   FEHLER CSS , IE7 emuliert, IE7 unterstützt CSS nicht-->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
		<head>
		
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
		<?
           $portalkarte= new karte;
           echo $portalkarte->zeigeKarteBoxBuslinien($box_mse_gesamt,$v_breite,$v_hoehe,'orka','1','0','0','0','0',$beschriftung_karte,'');
        ?>
		<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
		

    
   
     </head>
			<body onload="init();load();">
			<div id="container">
					<div id="header">';
					<? head_portal(); ?>
					</div><div id="wrapper">
			  
			
			
				<div id="content">
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0" >
							<? echo "
								<tr>							
								<td width=\"30%\" align=\"center\" valign=\"top\" height=30 colspan=2><br>
								<h3>$titel*</h3>
								Zu diesem Thema befinden sich<br>
								<b>$count</b> Datens&auml;tze in der Datenbank.
								</td>
								<td rowspan=9 width=\"5%\">
								<td width=\"75%\" border=0 valign=top rowspan=8 colspan=3>
								<br>
								<div style=\"margin:1px\" id=\"map\"></div>
								</td>
								</tr>"; ?>
							<tr><td align=center><a href="haltestellenliste.php" target=_blank><small>Druckansicht Gesamtliste</a></td></tr>
						<tr>
							<td align="center" height=50 colspan=2">
								Gemeinde/Ort/Ortsteil ausw&auml;hlen:
								<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="ortslage">
								<select class='select_ort' name="ortslage" onchange="document.ortslage.submit();">
								<option >Bitte auswählen</option>
									<?php
										$query="SELECT ortslage,typ,gid FROM  management.suchfeld_schnellsprung_ortslagen ORDER BY ortslage";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option ";
												#if ($r[typ] == 'Gemeinde') echo "class=bld ";
												echo" value=\"$r[gid]\">";
												
												echo "$r[ortslage]</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2 style="option:nth-child(1), option:nth-child(4) {font-weight:bold;}">								
							Linie auswählen:
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="linie">
								<select class='select_ort'  name="linie" onchange="document.linie.submit();">
								<option>Bitte auswählen</option>
									<?php
										$query="SELECT linie ||' (' || verlauf || ')' as label,gid FROM  traffic.buslinien ORDER BY linie";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option ";
												echo" value=\"$r[gid]\">";
												echo "$r[label]</option>\n";
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
							   
					           <? include ("includes/block_1_1_uk.php"); ?>			</table>
				</div>
			</div>
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

// Ebene 2a
if ($ortslage_id > 0 AND isset($themen_id) == FALSE)
   { 	  
	  $query="SELECT a.* FROM $schema.$tabelle as a, management.ot_lt_rka as b WHERE ST_intersects(a.geometrie, b.the_geom) AND b.gid='$ortslage_id'  ORDER BY a.hs_name";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $haltestelle[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  
	  
	  $query="SELECT box(st_transform(a.the_geom,25833)) as etrsbox, st_astext(st_transform(st_centroid(a.the_geom),25833)) as etrscenter, box(a.the_geom) as box, area(a.the_geom) as area, st_astext(st_centroid(a.the_geom)) as center, a.ortsteil,a.gem_name,a.typ FROM management.ot_lt_rka as a WHERE a.gid='$ortslage_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $ortslage = $r["gem_name"].', '.$r["ortsteil"];
	  $boxstring = $r["etrsbox"];
	  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <!--   FEHLER CSS , IE7 emuliert, IE7 unterstützt CSS nicht-->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
		<head>

		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php");		?>
		<?php
            $portalkarte= new karte;
            echo $portalkarte->zeigeKarteBoxBuslinien($boxstring,$v_breite,$v_hoehe,'orka','0','0','0','0','0',$beschriftung_karte,'');
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
										<td height="40" align="center" valign=center width=270 colspan="2" >
										  <? 
										     echo "<h3>Liste der<br>",$titel,"</h3> in der Ortslage"; 
											?>
											</td>
										<td width=10 rowspan="6"></td>
										<td border=0 valign=top align=left rowspan="5" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									
									<tr>
									<td height="auto" align="center" valign=top width=270>
									<?
									 echo "<h3>",$r['ortsteil'],"</h3>";
											 if ($r["typ"] != 'Gemeinde') echo "Gemeinde: ",$r['gem_name'];
											 echo '<br><br><hr>','<a href="#liste">';
											 if ($count > 0) echo $count;
											   else echo "keine";
											 if ($count > 1) echo " Haltestellen </a>";
											   else echo " Haltestelle </a>";
											 echo " gefunden.<br><hr>";
											?>
									</td>
									</tr>
									
							<tr>
							<td align="center" height=40 colspan=2>	
                                einen anderen Ort/Ortsteil wählen:							
								<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="ortslage">
								<select class='select_ort' name="ortslage" onchange="document.ortslage.submit();">
									<option>Bitte auswählen</option>
									<?php
										$query="SELECT ortslage,typ,gid FROM  management.suchfeld_schnellsprung_ortslagen ORDER BY ortslage";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option ";
												
												echo ' value="',$r["gid"],'"';
												if ($r["gid"] == $ortslage_id) echo "selected";
												echo ">";
												
												echo $r["ortslage"],'</option>\n';
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
									<tr>
									<!-- Tabelle für Legende -->
										<td valign=bottom align=left>
											<table class="table_legende_ebenen">
											<B>Kartenlegende :</B>
											<?php
												$legende_geo= new legende_geo;
												echo $legende_geo->zeigeLegende($layername_mapfile,'','','','');
											?>
											</table> 
										</td>
									<!-- ENDE Tabelle für Legende --> 
									</tr>
									<? include ("includes/block_2_uk_ortslage.php"); ?>	
									
								</table>
							</td>
						</tr>
					</table>
					<!-- Beginn grosse Tabelle unterer Block -->
					<?php
					if ($count > 0)
					{
					?>
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td>
							    <!-- Beginn Sachdatentabelle -->
								<table border=0 width="100%" valign=top>
								<?
                                  echo "<tr><td colspan=4 align=\"center\" height=50 bgcolor=$header_farbe><b><font color='white'>	Ihre Suchanfrage lieferte  $count Treffer<br><small>Wählen Sie einen Eintrag aus der Liste um weitere Informationen zu erhalten.</font></td></tr>";
								?>
											
									<tr>

										<td align=center  height=30><a name="Liste"></a><b>Haltestelle</b></td>
										
										<td align=center height=30><b>Foto</b></td>
										<td align=center height=30><b>Linien</b></td>
										<td align=center height=30><b>Richtung</b></td>
										
										
									</tr>
												<?php for($v=0;$v<$z;$v++)
													{   echo "<tr ";
													    if ($v % 2 == 0) echo "bgcolor=$element_farbe";
														echo ">";
														$bild_array=explode("/",$haltestelle[$v]["hs_foto"]);
														$bild_name=$bild_array[6];
														$bild_array2=explode(".",$bild_name);
														$bild_datei=$bild_array2[0];
														$linien=explode("-",$haltestelle[$v]["hs_linien"]);
														$bildpfad='pictures/haltestellen_kataster/'.$bild_datei.'_thumb.jpg';
													    
														echo '<td align=center><a href=',$_SERVER["PHP_SELF"],'?',$get_themenname,'=',$haltestelle[$v]["gid"],'&ortslage=',$ortslage_id,'>',$haltestelle[$v]["hs_name"],'</a></td>';
														echo "<td align=center><img src=\"",$bildpfad,"\" width=50></td>";
														echo "
														      <td align=center>";
															  foreach ($linien as $index => $linie) if ($linie != '')
											                    {
												                 $query="SELECT fahrplan FROM traffic.buslinien WHERE linie = '$linie'";
													             $result = $dbqueryp($connectp,$query);
													             $xr = $fetcharrayp($result);
													             $fahrplan=$xr["fahrplan"];
													             if ($fahrplan != '') echo "<a href=\"",$fahrplan,"\" target=_blank title=\"zum Fahtplan\">",$linie,"</a>&nbsp;&nbsp;&nbsp;";
												                 else echo $linie,"&nbsp;&nbsp;&nbsp;";
													 
													            }
													 
														echo "</td>
															   <td align=center>",$haltestelle[$v]["hs_richtungen"],"</td>
															   </td></tr>";
													}
												?>																																				
								</table>
							</td>
						</tr>
					</table>
					<?php
					}
					?>
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

// Ebene 2b  Auswahl über die Buslinie
if ($linie_id > 0 AND isset($themen_id) == FALSE)
   { 
      
	  $layername_mapfile="linie_".$linie_bezeichnung;
      $beschriftung_karte="Linie ".$linie_bezeichnung;	  
      $query="SELECT * FROM $schema.$tabelle WHERE hs_linien LIKE '%-$linie_bezeichnung-%'  ORDER BY hs_name";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $haltestelle[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT box(st_union(st_buffer(geometrie,500))) as etrsbox FROM $schema.$tabelle WHERE hs_linien LIKE '%-$linie_bezeichnung-%'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $boxstring = $r["etrsbox"];
	  ?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <!--   FEHLER CSS , IE7 emuliert, IE7 unterstützt CSS nicht-->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php"); ?>
		
		<?php
            $portalkarte= new karte;
            echo $portalkarte->zeigeKarteBoxBuslinien($boxstring,$v_breite,$v_hoehe,'orka','0','0','0','0','0',$beschriftung_karte,$layername_mapfile);
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
										<td height="40" align="center" valign=center width=270 colspan="2" >
										  <? 
										     echo "<h3>Liste der<br>",$titel,"</h3> der Buslinie"; 
											?>
											</td>
										<td width=10 rowspan="6"></td>
										<td border=0 valign=top align=left rowspan="5" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									
									<tr>
									<td height="auto" align="center" valign=top width=270>
									<?
									 echo "<h3>",$linie_bezeichnung,"</h3>";
											  echo $linie_verlauf;
											 echo '<br><br><hr>','<a href="#liste">';
											 if ($count > 0) echo $count;
											   else echo "keine";
											 if ($count > 1) echo " Haltestellen </a>";
											   else echo " Haltestelle </a>";
											 echo " gefunden.<br><hr>";
											?>
									<br>
									<? if ($fahrplan != '') echo "<a href=\"",$fahrplan,"\" target=_blank><img src=\"buttons/pdf.png\" width=20> zum Fahrplan </a>";
									?>
									</td>
									</tr>
									
							<tr>
							<td align="center" height=40 colspan=2 style="option:nth-child(1), option:nth-child(4) {font-weight:bold;}">								
							eine andere Linie auswählen:
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="linie">
								<select class='select_ort'  name="linie" onchange="document.linie.submit();">
								<option>Bitte auswählen</option>
									<?php
										$query="SELECT linie ||' (' || verlauf || ')' as label,gid FROM  traffic.buslinien ORDER BY linie";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option ";
												
												echo ' value="',$r["gid"],'"';
												if ($r["gid"] == $linie_id) echo "selected";
												echo ">";
												echo $r["label"],'</option>\n';
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
									<tr>
									<!-- Tabelle für Legende -->
										<td valign=bottom align=left>
											<table class="table_legende_ebenen">
											<B>Kartenlegende :</B>
											<?php
												$legende_geo= new legende_geo;
												echo $legende_geo->zeigeLegendeBusLinien($layername_mapfile,'Hs-Kataster','','','');
											?>
											</table> 
										</td>
									<!-- ENDE Tabelle für Legende --> 
									</tr>
									<? include ("includes/block_2_uk_buslinie.php"); ?>	
									
								</table>
							</td>
						</tr>
					</table>
					<!-- Beginn grosse Tabelle unterer Block -->
					<?php
					if ($count > 0)
					{
					?>
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td>
							    <!-- Beginn Sachdatentabelle -->
								<table border=0 width="100%" valign=top>
								<?
                                  echo "<tr><td colspan=4 align=\"center\" height=50 bgcolor=$header_farbe><b><font color='white'>	Ihre Suchanfrage lieferte  $count Treffer<br><small>Wählen Sie einen Eintrag aus der Liste um weitere Informationen zu erhalten.</font></td></tr>";
								?>
											
									<tr>

										<td align=center  height=30><a name="Liste"></a><b>Haltestelle</b></td>
										
										<td align=center height=30><b>Foto</b></td>
										<td align=center height=30><b>Linien</b></td>
										<td align=center height=30><b>Richtung</b></td>
										
										
									</tr>
												<?php for($v=0;$v<$z;$v++)
													{   echo "<tr ";
													    if ($v % 2 == 0) echo "bgcolor=$element_farbe";
														echo ">";
														$bild_array=explode("/",$haltestelle[$v]["hs_foto"]);
														$bild_name=$bild_array[6];
														$bild_array2=explode(".",$bild_name);
														$bild_datei=$bild_array2[0];
														$linien=explode("-",$haltestelle[$v]["hs_linien"]);
														$bildpfad='pictures/haltestellen_kataster/'.$bild_datei.'_thumb.jpg';
													    
														echo '<td align=center><a href=',$_SERVER["PHP_SELF"],'?',$get_themenname,'=',$haltestelle[$v]["gid"],'&linie=',$linie_id,'>',$haltestelle[$v]["hs_name"],'</a></td>';
														echo "<td align=center><img src=\"",$bildpfad,"\" width=50></td>";
														echo "
														      <td align=center>";
															  foreach ($linien as $index => $linie) if ($linie != '')
											                    {
												                 $query="SELECT fahrplan FROM traffic.buslinien WHERE linie = '$linie'";
													             $result = $dbqueryp($connectp,$query);
													             $xr = $fetcharrayp($result);
													             $fahrplan=$xr["fahrplan"];
													             if ($fahrplan != '') echo "<a href=\"",$fahrplan,"\" target=_blank title=\"zum Fahtplan\">",$linie,"</a>&nbsp;&nbsp;&nbsp;";
												                 else echo $linie,"&nbsp;&nbsp;&nbsp;";
													 
													            }
														echo "</td>
															   <td align=center>",$haltestelle[$v]["hs_richtungen"],"</td>
															   </td></tr>";
													}
												?>																																				
								</table>
							</td>
						</tr>
					</table>
					<?php
					}
					?>
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
       if (!isset($ortslage_id))
	     {
		   $query="SELECT a.gid FROM management.ot_lt_rka as a,traffic.haltestellen_kataster as b WHERE st_intersects(b.geometrie,a.the_geom) AND b.gid='$themen_id' AND a.typ = 'Gemeinde'";
		   $result = $dbqueryp($connectp,$query);
	       $r = $fetcharrayp($result);
		   $ortslage_id=$r["gid"];
		 }
		 
       $query="SELECT ortslage,typ,gid FROM  management.suchfeld_schnellsprung_ortslagen WHERE gid = '$ortslage_id' ";
	   $result = $dbqueryp($connectp,$query);
	   $r = $fetcharrayp($result);
	   $ortslage=$r["ortslage"];
	   
      $query="SELECT box(geometrie) as etrsbox, geometrie as geom_25833,gid,hs_nr, hs_name, hs_foto, hs_linien, hs_richtungen, hs_betreiber, 
       hs_baulast, hs_amt, hs_gemeinde, hs_art, hs_wartehaus, hs_sitzen, 
       hs_abfall, hs_beleuchtung, hs_zuwegung, hs_info_fahrplan, hs_info_liniennetzplan, 
       hs_info_tarif, hs_ausstattung, hs_bordhoehe_cm, hs_taktile_kante, 
       hs_taktile_zuwegung, hs_barrierefreie_info, geometrie, status, 
       befestigung, fahrrad, baulast_auto_art, baulast_auto_distance, 
       baulast_auto_hst_gid FROM $schema.$tabelle  WHERE gid='$themen_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $linien=explode("-",$r["hs_linien"]);
	  
	  $bildname=$r["hs_foto"];
	  $boxstring = $r["etrsbox"];
	  $geom_25833 = $r["geom_25833"];
	  
	  
	  


		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> <!--   FEHLER CSS , IE7 emuliert, IE7 unterstützt CSS nicht-->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"></meta>
		<head>

		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<? include ("includes/meta_popup.php");		?>
		<?php
            $portalkarte= new karte;
            echo $portalkarte->zeigeKarteBoxBuslinien($boxstring,$v_breite,$v_hoehe,'orka','0','0','0','0','0',$beschriftung_karte,'');
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
										<td height="40" align="center" valign=center width=270 colspan="2" >
											<h3>Haltestelle:<br> <? echo $r["hs_name"];; ?>
										</td>
										<td width=10 rowspan="5"></td>
										<td border=0 valign=top align=left rowspan="4" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									
								
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center>
											<a href="<? echo $_SERVER["PHP_SELF"];?>"><? echo $font_farbe ;?>alle <? echo $titel ;?><? echo $font_farbe_end ;?></a>
										</td>

									</tr>
									<tr>
										
										<td align=center height="50" colspan=2>
										<?
										  if (isset($ortslage_id))
										     echo "<a href=\"",$_SERVER["PHP_SELF"],"?ortslage=",$ortslage_id,"\">zu allen ",$titel_plural," in</a><h3>",$ortslage,"</h3>";
										  if (isset($linie_id))
										     echo "<a href=\"",$_SERVER["PHP_SELF"],"?linie=",$linie_id,"\">zu allen ",$titel_plural," der <br><b>Linie ",$linie_bezeichnung,"</b></a><h3>",$linie_verlauf,"</h3>";	
										?>
										</td>
										
									</tr>
									<tr>										
									<!-- Tabelle für Legende -->
										<td valign=bottom align=left>
											<table class="table_legende_ebenen">
											<B>Kartenlegende :</B>
											<?php
												$legende_geo= new legende_geo;
												echo $legende_geo->zeigeLegende($layername_mapfile,'','','','');
											?>
											</table> 
										</td>
									<!-- ENDE Tabelle für Legende --> 
									</tr>
									
									<? include ("includes/block_3_1_uk.php"); ?>	
                                 </table>
								 
								<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
								<tr>
								<td valign=top>											
									<table border=0 valign=top>
										<tr height="35">
											<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $label ;?><? echo $font_farbe_end ;?></td>													
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Ort:</td>
											<td width="100%" bgcolor=<? echo $element_farbe ?>><b><? echo $r["hs_name"] ;?></b></td>												
											<?											
												$bildname1 = explode("&",$bildname);
												$bildname2 = $bildname1[0];
												$bildname3 = explode("/",$bildname2);
												$bild="pictures/".$bildname3[5]."/".$bildname3[6];											
												if(strlen($bildname) < 1 OR $oeffentlich == 'nein')
													{
														echo "<td valign=center align=right rowspan=8 width=420 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b>kein Bild verfügbar<br>oder nicht freigegeben</b></font></td></tr></table></td>";	
													} 
												else 
													{
														echo "<td valign=top align=right rowspan=8 width=420><a href=$bild target='_blank' onclick='return popup(this.href);'><img height='235' src=$bild height='30'></a></td>";
													}
											?>
										</tr>
										<tr>
											<td>Linien/Fahrpläne:</td>
											<td><b><? foreach ($linien as $index => $linie) if ($linie != '')
											       {
												    $query="SELECT fahrplan FROM traffic.buslinien WHERE linie = '$linie'";
													$result = $dbqueryp($connectp,$query);
													$xr = $fetcharrayp($result);
													$fahrplan=$xr["fahrplan"];
													if ($fahrplan != '') echo "<a href=\"",$fahrplan,"\" target=_blank title=\"zum Fahtplan\">",$linie,"</a>&nbsp;&nbsp;&nbsp;";
												     else echo $linie,"&nbsp;&nbsp;&nbsp;";
													 
													 }
													 ?>
													 </b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Richtungen:</td>
											<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["hs_richtungen"] ;?></b></td>																									
										</tr>
										<tr>
											<td>Betreiber:</td>
											<td><b><? echo $r["hs_betreiber"] ;?></b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Art:</td>
											<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["hs_art"] ;?></b></td>																										
										</tr>
										<tr>
											<td>Bordhöhe in cm:</td>
											<td><b><? echo $r["hs_bordhoehe_cm"] ;?></b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Wartehaus:</td>
											<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["hs_wartehaus"] ;?></b></td>																									
										</tr>
										<tr>
											<td>Sitzgelegenheit vorhanden:</td>
											<td><b><? echo $r["hs_sitzen"] ;?></b></td>																									
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
			<?php 
				echo div_navigation(); 
				echo div_extra(); 
				echo div_footer(); 
			?>
		</div>
		</body>
		</html>
<?  }

