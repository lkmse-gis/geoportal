<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="Tankstellen";
$layer_legende_2="Kreisgrenze_msp";
$layer_legende_3="msp_outline_gem";
$layer="Tankstellen";
$label_auswahl="Tankstelle";
$beschriftung_karte="Tankstelle";

//globale Varibalen
$layername_mapfile="Tankstellen";
$titel="Tankstellen";

$scriptname=$_SERVER["PHP_SELF"];
$tabelle="geoportal_tankstellen";
$schema="geoportal";
$get_themenname="tankstelle";
$layerid="80170";

$gemeinde_id=$_GET["gemeinde"];
$themen_id=$_GET["$get_themenname"];

$log=write_i_log($db_link,$layerid);

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
             echo $geoportal_karte->zeigeKarteBox($box_mse_gesamt,'700','510','orka','1','0','0','0','0',$beschriftung_karte,$layer);			 
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
							<form action="<? echo $scriptname;?>" method="get" name="<? echo $get_themenname;?>">
								<select name="gemeinde" onchange="document.<? echo $get_themenname;?>.submit();">
									<option>Bitte auswählen</option>
									<?php
										$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $schema.$tabelle as a, gemeinden as b WHERE ST_WITHIN(st_transform(a.wkb_geometry,2398), b.the_geom) ORDER BY gemeinde";
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


if ($gemeinde_id > 0)
   { 	  
	  $query="SELECT a.* FROM $schema.$tabelle as a, gemeinden as b WHERE ST_WITHIN(st_transform(a.wkb_geometry,2398), b.the_geom) AND b.gem_schl='$gemeinde_id' ORDER BY a.bezeichnung";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $tankstelle[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT amt, amt_id FROM gemeinden WHERE gem_schl='$gemeinde_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];
	  
	  $query="SELECT box(st_transform(the_geom,25833)) as etrsbox, st_transform(the_geom,25833) as geom_25833, a.gemeinde as name FROM gemeinden as a WHERE a.gem_schl='$gemeinde_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemeindename = $r["name"];
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
										<td height="40" align="center" valign=center width=270 bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $titel ;?> in <br> <? echo $gemeindename ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
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
											<form action="<? echo $scriptname;?>" method="get" name="<? echo $get_themenname;?>">
												Stadt:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $get_themenname;?>.submit();">
													<?php
														$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $schema.$tabelle as a, gemeinden as b WHERE ST_WITHIN(st_transform(a.wkb_geometry,2398), b.the_geom) ORDER BY gemeinde";
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
											<a href="<? echo $scriptname;?>"><? echo $font_farbe ;?>alle <? echo $titel ;?><? echo $font_farbe_end ;?></a>
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
							   
					           <? include ("includes/block_1_1_uk.php"); ?>	
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
													<td align=center height=30></td>
													<td align=center height=30><a name="Liste"></a><b>Name:</b></td>
													<td align=center height=30><b>Betreiber:</b></td>
													<td align=center height=30><b>Anschrift:</b></td>
												    <td align=center height=30><b>Telefon:</b></td>
													<td align=center height=30><b>Fax:</b></td>
												</tr>
												<?php for($v=0;$v<$z;$v++)
													{ 
														$adresse=$tankstelle[$v]["geoportal_anschrift"];
														$adresse1 = explode(";",$adresse);
														$anschrift = $adresse1[0]."<br>".$adresse1[1]."<br>".$adresse1[2];
														$bildname = $tankstelle[$v]["bild"];
														$bildname1 = explode("&",$bildname);
														$bildname2 = $bildname1[0];
														$bildname3 = explode("/",$bildname2);
														$bild="pictures/".$bildname3[5]."/".$bildname3[6];
														echo "<tr bgcolor=",get_farbe($v),">";
														if(strlen($bildname) < 1 OR $tankstelle[$v]["oeffentlich"] == 'nein')
															{
																echo "<td></td>";
															} 
														else 
															{
																echo "<td align='center'><a href=$bild target='_blank' onclick='return popup(this.href);'><img src=$bild height='30'></a></td>";
															}
														echo "
														<td align='center' height='30'><a href=\"$scriptname?$get_themenname=",$tankstelle[$v]['gid'],"\">",$tankstelle[$v]['bezeichnung'],"</a></td>",
														"<td align='center'>",$tankstelle[$v]['betreiber'],"</td>",
														"<td align='center'>",$anschrift,"</td>",
														"<td align='center'>",$tankstelle[$v]['tel'],"</td>",
														"<td align='center'>",$tankstelle[$v]['fax'],"</td></tr>";
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

 if ($themen_id > 0)
   {   
	  $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid, b.gid FROM gemeinden as a, $schema.$tabelle as b WHERE ST_WITHIN(st_transform(b.wkb_geometry,2398), a.the_geom) AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r["amt"];
	  $amt=$r["amt_id"];
	  $gem_id=$r["gemeindeid"];
	  $gemeindename=$r["gemeinde"];
	  
	  $query="SELECT box(wkb_geometry) as etrsbox,wkb_geometry as geom_25833, gid, fa_adressschluessel, bezeichnung, geoportal_anschrift, betreiber, tel, fax, oeffnungszeiten, bild, oeffentlich, copyright, bilddatum, ausstattung FROM $schema.$tabelle WHERE gid='$themen_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bildname=$r["bild"];
	  $oeffentlich=$r["oeffentlich"];
	  $adresse=$r["geoportal_anschrift"];
	  $adresse1 = explode(";",$adresse);
	  $anschrift = $adresse1[0]."<br>".$adresse1[1]."<br>".$adresse1[2];
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
											<? echo $font_farbe ;?><? echo $r["bezeichnung"]; ?><? echo $font_farbe_end ;?>
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
											<form action="<? echo $scriptname;?>" method="get" name="<? echo $get_themenname;?>">
												Stadt:&nbsp;
												<select name="gemeinde" onchange="document.<? echo $get_themenname;?>.submit();">
													<?php
														$query="SELECT DISTINCT b.gem_schl, b.gemeinde FROM $schema.$tabelle as a, gemeinden as b WHERE ST_WITHIN(st_transform(a.wkb_geometry,2398), b.the_geom) ORDER BY gemeinde";
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
											<a href="<? echo $scriptname;?>"><? echo $font_farbe ;?>zu allen <? echo $titel;?><br><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center height="50" colspan=2>
											<a href="<? echo $scriptname;?>?gemeinde=<? echo $gem_id; ?>"><? echo $font_farbe ;?>zu allen <? echo $titel;?><br><? echo $gemeindename ?><? echo $font_farbe_end ;?></a>
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
								 
								<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
								<tr>
								<td valign=top>
									<table border=0 valign=top>
										<tr height="35">
											<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r["bezeichnung"] ;?><? echo $font_farbe_end ;?></td>
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Anschrift:</td>
											<td width="100%" bgcolor=<? echo $element_farbe ?>><b><? echo $anschrift ;?></b></td>
											<?
												$bildname1 = explode("&",$bildname);
												$bildname2 = $bildname1[0];
												$bildname3 = explode("/",$bildname2);
												$bild="pictures/".$bildname3[5]."/".$bildname3[6];
												if(strlen($bildname) < 1 OR $oeffentlich == 'nein')
													{
														echo "<td valign=center align=right rowspan=7 width=420 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b>kein Bild verfügbar<br>oder nicht freigegeben</b></font></td></tr></table></td>";	
													} 
												else 
													{
														echo "<td valign=top align=right rowspan=7 width=420><a href=$bild target='_blank' onclick='return popup(this.href);'><img height='235' src=$bild height='30'></a></td>";
													}
											?>
										</tr>
										<tr>
											<td>Betreiber:</td>
											<td><b><? echo $r["betreiber"] ;?></b></td>
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Telefon:</td>
											<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["tel"] ;?></b></td>
										</tr>
										<tr>
											<td>Fax:</td>
											<td><b><? echo $r["fax"] ;?></b></td>
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Ausstattung:</td>
											<td bgcolor=<? echo $element_farbe ?>><b><a href="<? echo $r["ausstattung"] ;?>" target=blank><? echo $r["ausstattung"] ;?></a></b></td>
										</tr>
										<tr>
											<td>Öffnungszeiten:</td>
											<td><b><? echo $r["oeffnungszeiten"] ;?></b></td>
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

