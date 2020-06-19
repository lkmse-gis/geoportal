<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="Naturwald_fl_2018";
$layer_legende_2="Kreisgrenze_msp";
$layer="Naturwald_fl_2018";
$label_auswahl="Naturschutzgebiet";

//globale Varibalen
$titel="Naturwald";
$kuerzel="nw";
$datei=$_SERVER["PHP_SELF"];
$beschriftung_karte="Naturwald (Stand 2018)";

// Datenbank
$tabelle="sg_naturwald";
$schema="environment";
$layerid="32045";



$nat_wald_gebiet=$_POST["waldgebiet"];
$nat_wald_id=$_GET["$kuerzel"];

$log=write_i_log($db_link,$layerid);

// 1.Ebene
if (!isset($nat_wald_gebiet) AND !isset($nat_wald_id))
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
             echo $geoportal_karte->zeigeKarteBox($box_mse_gesamt,'750','510','orka','1','0','0','0','0',$beschriftung_karte,$layer);			 
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
						<tr>
							<td align="center" valign="top" height=30 colspan=2><br>
								<h3><? echo $titel;?>*</h3>
								Zu diesem Thema befinden sich<br>
								<b><? echo $count2; ?></b> Gebiete mit<br><b><? echo $count; ?></b> Teilfl&auml;chen in der Datenbank.
							</td>
							<td rowspan=8 width=30>
							<td border=0 valign=top rowspan=7 colspan=3>
								<br>
								<div style="margin:1px" id="map"></div>
							</td>
						</tr>
						<tr>
							<td align="center" height=50 colspan=2>
								<? echo $titel; ?> (Gebiet) ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>
								<form action="<? echo $datei;?>" method="post" name="waldgebiet">
								<select name="waldgebiet" onchange="document.waldgebiet.submit();" style="width: 200px;">
									<?php
										$query="SELECT DISTINCT name FROM $schema.$tabelle ORDER BY name";
										$result = $dbqueryp($connectp,$query);
										echo "<option>Bitte ausw&auml;hlen</option>\n";
										while($r = $fetcharrayp($result))
											{
												echo "<option value=\"$r[name]\">$r[name]</option>\n";
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

// 2.Ebene
if (isset($nat_wald_gebiet) AND !isset($nat_wald_id))
   { 	  
	  $query="SELECT gid, name, nr_num, abk_nr, area_ha FROM $schema.$tabelle WHERE name='$nat_wald_gebiet' ORDER BY name";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $nw[$z]=$r;
		   $z++;
		   $count=$z;	
		}  
	  
	  $query="SELECT a.oid,a.status,a.name as amtname,a.amt_schluessel,a.amts_sf,a.amtsvorsteher,a.lvb,a.lvb_tel,a.ansprechpartner,a.ap_email,a.ap_tel,a.gliederung,a.flaeche,a.einw_km,'' as nutzungsarten_link,a.geom_25833 FROM kataster.amtsbereiche as a, $schema.$tabelle as b WHERE ST_INTERSECTS(b.geom, a.geom_25833) AND b.name='$nat_wald_gebiet' ORDER by a.name";
	  $result = $dbqueryp($connectp,$query);
	  $i=0;
	  while($r = $fetcharrayp($result))
	    {
	       $amt[$i]=$r;
		   
		   $i++;
		   $count2=$i;	
		}
	  
	  $query="SELECT box(st_buffer(st_union(st_transform(geom,25833)),100)) as etrsbox,st_union(st_transform(geom,25833)) as geom_25833,name FROM $schema.$tabelle WHERE name='$nat_wald_gebiet' GROUP BY name";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
	  $etrsbox = $r["etrsbox"];
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
										<td height="40" align="center" valign=top width=250 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?>Naturwald-Gebiet<br>"<? echo $r["name"];?>"<? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=30 rowspan="8"></td>
										<td border=0 valign=top align=left rowspan="7" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="30" valign=center bgcolor=<? echo $element_farbe; ?>>
											<b>( Amt:<?php 
												 echo " <a href=\"aemter_msp.php?amt=",$amt[1]["amts_sf"],"\">",$amt[1]["amtname"],"</a>&nbsp;";
													?>)
											</b>
										</td>
									</tr>
									<tr>
										<td align="center" height=30 colspan=2>
											<? echo $titel; ?> (Gebiet):
										</td>
									</tr>
									<tr>
										<td align="center" height=40 colspan=2>
											<form action="<? echo $datei;?>" method="post" name="waldgebiet">
											<select name="waldgebiet" onchange="document.waldgebiet.submit();" style="width: 200px;">
												<?php
													$query="SELECT DISTINCT name FROM $schema.$tabelle ORDER BY name";
													$result = $dbqueryp($connectp,$query);
													while($r = $fetcharrayp($result))
															{
																echo "<option";if ($nat_wald_gebiet == $r["name"]) echo " selected"; echo ' value="',$r["name"],'">',$r["name"],'</option>\n';
															}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
									
										<td align=center>
											<a href="<? echo $_SERVER["PHP_SELF"] ;?> "><? echo $font_farbe ;?>alle <? echo $titel;?> Gebiete<? echo $font_farbe_end ;?></a>
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
								     echo $legende_geo->zeigeLegende($layer_legende,$layer_legende_2,'','','');
								     ?>
							       </table> 
						          </td>
    		                   	</tr>
							   <!-- Einbindung des Snippets für die Zeile unter der Karte -->
							   
					           <? include ("includes/block_1_1_uk.php"); ?>				</table>
							</td>
						</tr>
					</table>	<!-- Ende äußere Tablle oberer Block -->
					<!-- Beginn grosse Tabelle unterer Block -->
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						<tr>
							<td>
							    <!-- Beginn Sachdatentabelle -->
								<table border="0" width="100%" valign=top>
									<? head_trefferliste($count,4,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->
									<tr>
													<td align=center height=30><a name="Liste"></a><b>ID:</b></td>
													<td align=center height=30><b>Name:</b></td>
													<td align=center height=30><b>Schl&uuml;ssel:</b></td>
													<td align=center height=30><b>Fl&auml;che in ha:</b></td>
												</tr>
												<?php for($v=0;$v<$z;$v++)
													{ 
														echo "<tr bgcolor=",get_farbe($v),">";
														echo "
														<td align='center' height='30'><a href=\"$datei?$kuerzel=",$nw[$v]["gid"],"\">",$nw[$v]["gid"],"</a></td>",
														"<td align='center'>",$nw[$v]["name"],"</td>",
														"<td align='center'>",$nw[$v]["abk_nr"],"</td>",
														"<td align='center'>",$nw[$v]["area_ha"],"</td>";
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

// 3.Ebene
if (isset($nat_wald_id))
   {   
	  $query="SELECT a.gen,a.name,a.amts_sf FROM kataster.amtsbereiche as a, $schema.$tabelle as b WHERE ST_INTERSECTS(b.geom,a.geom_25833) AND b.gid='$nat_wald_id' ORDER by b.name";
	  $result = $dbqueryp($connectp,$query);
	  $i=0;
	  while($r = $fetcharrayp($result))
	    {
	       $aemter[$i]=$r;
		   $i++;
		   $count=$i;
		}

	  $query="SELECT a.gem_schl, a.gemeinde FROM gemeinden as a, $schema.$tabelle as b WHERE ST_INTERSECTS(b.geom,a.geom_25833) AND b.gid='$nat_wald_id' ORDER by a.gemeinde";
	  $result = $dbqueryp($connectp,$query);
	  $k=0;
	  while($r = $fetcharrayp($result))
	    {
	       $gemeinden[$k]=$r;
		   $k++;
		   $count=$k;
		}
		
	  
	  
	  $query="SELECT box(st_transform(geom,25833)) as etrsbox, st_transform(geom,25833) as geom_25833, gid, nr_num, recht_q, abk_nr, name, schl_gis_t, area_ha, oer_vo, oer_br, erl_fe, erl_nwr, foerdpro, uebtr_nne, dbk, zert_fsc, frei_wid, sonst, vo_datum, br_datum, erlass_nam, dbk_z_guns, meta_mv, entwertung, entw_jahr, entw_verur, entw_quell, quelle, bemerkung, pruef_lfoa, foa_detail, foa, aktual_14 FROM $schema.$tabelle WHERE gid='$nat_wald_id'";
	   
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $geom_25833 = $r["geom_25833"];
      $etrsbox = $r["etrsbox"];
	  $na_wald_gebiet=$r["name"];
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
             echo $geoportal_karte->zeigeKarteBox($etrsbox,'700','520','orka','1','0','0','0','0',$beschriftung_karte,$layer);			 
        ?> 
		
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
											<? echo $font_farbe ;?><? echo $r["name"]." ".$r["nr_num"]; ?><? echo $font_farbe_End ;?>
										</td>
										<td width=30 rowspan=9></td>
										<td border="0" align=center rowspan="8" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>Schl&uuml;ssel: <? echo $r["abk_nr"]; ?></b><br>
										</td>
									</tr>
									<tr>
										<td align="center" height=30 colspan=2>
											<? echo $titel; ?> (Gebiet):
										</td>
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">
											<form action="<? echo $_SERVER["PHP_SELF"];?>" method="post" name="waldgebiet">
												<select name="waldgebiet" onchange="document.waldgebiet.submit();" style="width: 200px;">
												<?php
													$query="SELECT DISTINCT a.name FROM $schema.$tabelle as a ORDER BY a.name";
													$result = $dbqueryp($connectp,$query);
													while($e = $fetcharrayp($result))
															{
															echo "<option"; if ($na_wald_gebiet == $e["name"]) echo " selected"; echo ' value="',$e[name],'">',$e["name"],'</option>\n'; 
															}
												?>
												</select>
										</td>
									</tr>
									<tr>
										<td align=center height=25 colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle <? echo $titel;?> Gebiete<? echo $font_farbe_end ;?></a>
										</td>
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										<td align=center width=250 height=50 colspan=2>
										  <?php echo $font_farbe ; echo "zu allen Flächen: "; echo $font_farbe_end ; ?> <BR>
										  <input type="hidden" value="<?php echo $na_wald_gebiet; ?>">
										  <input type="submit" value="<?php echo $na_wald_gebiet; ?>">
										</form>
										</td>
									</tr>
									<tr>
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
							   
					           <? include ("includes/block_1_1_uk.php"); ?>												</table>
							</td>
						</tr>
					</table>
					
					<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
						    <tr>
							<td valign=top>
								<table border="0" valign=top>
									<tr height="35">
										<td colspan=2  width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r["name"] ;?><? echo $font_farbe_end ;?></td>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">zuständiges Forstamt:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["foa"] ;?></b></td>
									</tr>
									</tr>
										<tr height="30">
										<td>Fl&auml;che in ha:</td>
										<td><b><? echo $r["area_ha"] ;?></b></td>
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Festsetzung Verordnung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["oer_vo"] ;?></b></td>
									</tr>
									<tr height="30">
										<td>Fl&auml;che in ha:</td>
										<td><b><? echo $r["area_ha"] ;?></b></td>
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Bemerkung:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["bemerkung"] ;?></b></td>
									</tr>
									<tr height="30">
										<td>Schl&uuml;ssel:</td>
										<td><b><? echo $r["abk_nr"] ;?></b></td>
									</tr>
									
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Metadaten:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><a href="<? echo $r["meta_mv"] ;?>" target=_blank><? echo $r["meta_mv"] ;?></a></b></td>
									</tr>
									<tr>
										<td valign=top><? echo $titel;?> schneidet folgende<br>&Auml;mter des Kreises:</td>
										<td><b>
											<?php 
												for($x=0;$x<$i;$x++)
												{ echo "<a href=\"aemter_msp.php?amt=",$aemter[$x][1],"\">",$aemter[$x][0],"</a><br>";}
											?></b>
										</td>
									</tr>
									<tr>
										<td  bgcolor=<? echo $element_farbe ?> width="30%" valign=top><? echo $titel;?> schneidet folgende<br>Gemeinden des Kreises:</td>
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
							
							<td valign=top align=center width="350">
								<? echo geo_flaeche($geom_25833,$connectp,$dbqueryp,$fetcharrayp) ?>
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

