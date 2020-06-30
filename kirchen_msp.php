<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");
$layer_legende="Kirchen";
$layer_legende_2="Kreisgrenze_msp";
$layer_legende_3="msp_outline_gemkg";
$layer="Kirchen";
$label_auswahl="Kirche";
$beschriftung_karte="Kirchen";

//globale Varibalen
$titel="Kirchen";

$datei=$_SERVER["PHP_SELF"];
$tabelle="tourism.kirchen";
$kuerzel="kirche";
$layerid="131320";


$gemarkung_id=$_GET["gemarkung"];
$kirchen_id=$_GET["$kuerzel"];
$themen_id=$kirchen_id;

$log=write_i_log($db_link,$layerid);

if ($themen_id < 1 AND $gemarkung_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $tabelle";	  
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
             echo $geoportal_karte->zeigeKarteBox($box_mse_gesamt,'695','510','orka','1','0','0','0','0',$beschriftung_karte,$layer);			 
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
		                <td width="30%" align="center" valign="top" height=30 colspan=1><br>
			            <h3><? echo $titel ?>*</h3>
				        Zu diesem Thema befinden sich<br>
				        <b><? echo $count ?></b> Datens&auml;tze in der Datenbank.
		               </td>
		               <td rowspan=8 width="5%"></td>
		               <td width="75%" border=0 valign=top rowspan=7 colspan=3>
			     		<div style="margin:1px" id="map"></div>
		               </td>
	                  </tr>
						<tr>
							<td align="center" height=50 colspan=2>
								Ort ausw&auml;hlen:
							</td>
						</tr>
						<tr>
							<td align="center" height=40 colspan=2>								
								<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
								<select name="gemarkung" onchange="document.<? echo $kuerzel;?>.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
										$query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM show_gemarkungen as a, kataster.gemarkung as b,$tabelle as c WHERE ST_WITHIN(c.the_geom,b.the_geom) AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option value=\"$r[gemkgschl]\">$r[gemarkung]</option>\n";
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


if ($gemarkung_id > 0)
   { 	  
	  $query="SELECT a.* FROM $tabelle as a, kataster.gemarkung as b WHERE ST_WITHIN (a.the_geom, b.the_geom) AND CAST(b.geographicidentifier AS INTEGER)='$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $kirche[$z]=$r;
		   $z++;
		   $count=$z;	
		}
	  
	  $query="SELECT a.name, a.amts_sf FROM kataster.amtsbereiche as a, kataster.gemarkung as b WHERE ST_WITHIN (ST_BUFFER(b.the_geom,-10), a.the_geom) AND CAST(b.geographicidentifier AS INTEGER)='$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $i = $fetcharrayp($result);
	  $amtname = $i[0];
	  $amt = $i[1];
	  
	  $query="SELECT box(a.geom_25833) as etrsbox, a.geom_25833, a.gemarkungsname_kurz as name FROM kataster.gemarkung as a WHERE CAST(a.geographicidentifier AS INTEGER)='$gemarkung_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkungsname = $r["name"];
	  $etrsbox=$r["etrsbox"];
	  $geom_25833=$r["25833"];
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
             echo $geoportal_karte->zeigeKarteBox($etrsbox,'700','520','orka','1','0','0','1','0',$beschriftung_karte,$layer);			 
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
											<? echo $font_farbe ;?><? echo $titel;?> in <? echo $gemarkungsname ?><? echo $font_farbe_end ;?><br><a href="#liste"><? echo $font_farbe ;?>(<? echo $count; ?> Treffer)<? echo $font_farbe_end ;?></a>
										</td>
										<td width=30 rowspan="8"></td>
										<td border=0 valign=top align=left rowspan="7" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
										<td align="center" height="30" valign=center bgcolor=<? echo $element_farbe; ?>>
											<b>(Amt: <a href="aemter_msp.php?amt=<? echo $amt; ?>"><? echo $amtname ?></a>)</b>
										</td>
									</tr>
									<tr>
										<td align="center" height=30 colspan=2>
											Ort ausw&auml;hlen:
										</td>
									</tr>
									<tr>
										<td align="center" height="40">
											<form action="<? echo $datei;?>" method="get" name="gemarkung">								
												<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
													<option>Bitte auswählen</option>
													<?php
													 $query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM show_gemarkungen as a, kataster.gemarkung as b,$tabelle as c WHERE ST_WITHIN(st_transform(c.the_geom,2398),b.the_geom) AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
													 $result = $dbqueryp($connectp,$query);

													  while($r = $fetcharrayp($result))
													   {
													   echo "<option";if ($gemarkung_id == $r["gemkgschl"]) echo " selected"; echo ' value="',$r["gemkgschl"],'">',$r["gemarkung"],'</option>\n';
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
									<? head_trefferliste($count,4,$header_farbe);?><!-- Header für Trefferlichte wird geladen -->											
									<tr>
									<!-- Überschrift für Sachdaten -->
													<? if ($count>0) echo "
															<td align=center height=30></td>
															<td align=center height=30><a name=\"liste\"></a><b>Name:</b></td>													
															<td align=center height=30><b>Ortsteil:</b></td>
															<td align=center height=30><b>Glaubensrichtung:</b></td>
														";
													?>
												</tr>
												<?php for($v=0;$v<$z;$v++)
													{ 
													    $bild=get_bild_name($kirche[$v]["bild"]);
														#$bildname = $kirche[$v]["bild"];
														#$bildname1 = explode("&",$bildname);
														#$bildname2 = $bildname1[0];
														#$bildname3 = explode("/",$bildname2);
														#$bild="pictures/".$bildname3[5]."/".$bildname3[6];
														echo "<tr bgcolor=",get_farbe($v),">";															
														if(strlen($bild) < 1 OR $kirche[$v]["oeffentlich"] == 'nein')
															{
																echo "<td></td>";	
															} 
														else 
															{
																echo "<td align='center'><a href=$bild target='_blank' onclick='return popup(this.href);'><img src=$bild height='30'></a></td>";
															}
														echo "
														<td align='center'><a href=\"kirchen_msp.php?kirche=",$kirche[$v]['gid'],"\">",$kirche[$v]['name']." ".$kirche[$v]['name1'],"</a></td>",													
														"<td align='center'>",$kirche[$v]['ortsteil'],"</td>",
														"<td align='center'>",$kirche[$v]['anmerk'],"</td>",																												
														"</tr>";
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
	  $query="SELECT a.gemarkungsname_kurz, a.geographicidentifier as gemarkungid, b.gid FROM kataster.gemarkung as a, $tabelle as b WHERE ST_WITHIN(b.the_geom, a.the_geom) AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkung_id=$r["gemarkungid"];
	  $gemarkungname=$r["gemarkungsname_kurz"];

	  $query="SELECT a.name, a.amts_sf FROM kataster.amtsbereiche as a, $tabelle as b WHERE ST_WITHIN(b.the_geom, a.the_geom) AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $i = $fetcharrayp($result);
	  $amtname = $i[0];
	  $amt = $i[1];
	  
	  $query="SELECT box(st_transform(the_geom,25833)) as etrsbox,st_transform(the_geom,25833) as geom_25833, gid, ortsteil, name, name1, epoche, anmerk, bemerkung, bild, oeffentlich, urheber FROM $tabelle WHERE gid='$themen_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bild=get_bild_name($r["bild"]);
	  $oeffentlich=$r["oeffentlich"];
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
             echo $geoportal_karte->zeigeKarteBox($etrsbox,'700','520','orka','1','0','0','1','0',$beschriftung_karte,$layer);			 
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
										<td height="40" align="center" valign=center width=250 colspan="2" bgcolor=<? echo $header_farbe; ?>>
											<? echo $font_farbe ;?><? echo $r['name']." ".$r['name1']; ?><? echo $font_farbe_end ;?>
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
											<form action="<? echo $datei;?>" method="get" name="gemarkung">
												Ort:&nbsp;
												<select name="gemarkung" onchange="document.gemarkung.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
													<option>Bitte auswählen</option>
													<?php
													 $query="SELECT DISTINCT a.gemarkung,a.gemkgschl FROM show_gemarkungen as a, kataster.gemarkung as b,$tabelle as c WHERE ST_WITHIN(st_transform(c.the_geom,2398),b.the_geom) AND CAST(b.geographicidentifier as INTEGER)=a.gemkgschl ORDER BY gemarkung";
													 $result = $dbqueryp($connectp,$query);

													  while($e = $fetcharrayp($result))
													   {
													   echo "<option";if ($gemarkung_id == $e["gemkgschl"]) echo " selected"; echo ' value="',$e["gemkgschl"],'">',$e["gemarkung"],
														'</option>\n';
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
											<a href="<? echo $datei;?>?gemarkung=<? echo $gemarkung_id; ?>"><? echo $font_farbe ;?>alle <? echo $titel;?><br><? echo $gemarkungname ?><? echo $font_farbe_end ;?></a>
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
										<td colspan=3 width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><? echo $r['name']." ".$r['name1']; ?><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?>>Ortsteil:</td>
										<td width="100%" bgcolor=<? echo $element_farbe ?>><b><? echo $r['ortsteil'] ;?></b></td>
										<?											
											
											if(strlen($bild) < 1 OR $oeffentlich == 'nein')
												{
													echo "<td valign=center align=right rowspan=5 width=420 height=235><table border=0 cellpadding=50><tr><td class='rand'><font color=red><b>kein Bild verfügbar<br>oder nicht freigegeben</b></font></td></tr></table></td>";	
												} 
											else 
												{
													echo "<td valign=top align=right rowspan=5 width=420><a href=$bild target='_blank' onclick='return popup(this.href);'><img height='235' src=$bild height='30'></a></td>";
												}
										?>
									</tr>
									<tr height="30">
										<td>Epoche:</td>
										<td><b><? echo $r['epoche'] ;?></b></td>																									
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?>>Baustil:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r['bemerkung'] ;?></b></td>									
									</tr>
									<tr height="30">
										<td>Glaubensrichtung:</td>
										<td><b><? echo $r['anmerk'] ;?></b></td>																									
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?>>Urheber (Bild):</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r['urheber'] ;?></b></td>									
									</tr>
								</table>
							</td>									
							<td valign=top align=center width="350">
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

