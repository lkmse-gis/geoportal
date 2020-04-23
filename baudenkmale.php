<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");


//globale Varibalen
$beschriftung_karte="Baudenkmale";
$layername_mapfile="baudenkmale_2017";
$titel="Baudenkmale";
$titel_plural="Baudenkmalen";
$titel_legende="Baudenkmale";

$v_breite="700";
$v_hoehe="490";

// Legenden - Layer - msp.map - 2 spaltig - Standard|Themen 
$breite1="90";
$breite2="180";
$layer="baudenkmale_2017"; // beides
$layer1="Baudenkmalpunkte";
$layer2="Kreisgrenze_msp";
$layer3="aemter_msp_outline";
$layer4="msp_outline_gem";
$layer5="msp_outline_gemkg";
$layer6="Postleitzahlbereiche";
$layer7="Befall_EPS_Punkte_2017";
$layer8="gemeinden_msp";
$layer99="";

$schema="construction";
$tabelle="baudenkmale";

$get_themenname="baudm";
$layerid="40110";

$ortslage_id=$_GET["ortslage"];
$themen_id=$_GET["$get_themenname"];

$log=write_i_log($db_link,$layerid);

// Ebene 1
if ($themen_id < 1 AND $ortslage_id < 1)
    { 
	
		$query="SELECT COUNT(*) AS anzahl FROM $schema.$tabelle";
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count = $r["anzahl"];
	
	?>
		<?php
		$lon=368607;
		$lat=5937811;
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
           $geotopkarte= new karte;
           echo $geotopkarte->zeigeKarteBox($box_mse_gesamt,$v_breite,$v_hoehe,'orka','1','0','0','0','0',$beschriftung_karte,$layername_mapfile);
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
							<tr><td align=center><a href="baudenkmalliste.php" target=_blank><small>Druckansicht Gesamtliste</a></td></tr>
						<tr>
							<td align="center" height=50 colspan=2">
								Gemeinde/Ort/Ortsteil ausw&auml;hlen:
								<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="ortslage">
								<select class='select_ort' name="ortslage" onchange="document.ortslage.submit();">
								<option >Bitte auswählen</option>
									<?php
										$query="SELECT ortslage,typ,gid FROM  management.suchfeld_schnellsprung_ortslagen WHERE gemschl != '13071107' ORDER BY ortslage";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option ";
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
							Baudenkmal direkt auswählen:<br>(Listennummer-Lfd. Nr REGION)
							<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="bd_direkt">
								<select class='select_ort'  name="baudm" onchange="document.bd_direkt.submit();">
								<option>Bitte auswählen</option>
									<?php
										$query="SELECT nr ||'-' || lfdnr || ' ' || kuerzel as bd,typ,gid FROM  construction.baudenkmale ORDER BY nr,lfdnr,kuerzel";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option ";
												echo" value=\"$r[gid]\">";
												echo "$r[bd]</option>\n";
											}
									?>
								</select>
								</form>
							</td>
						</tr>							
						<? include ("includes/meta_i_aktualitaet.php"); ?>
						<!-- Tabelle für Legende -->
						<td valign=bottom align=left >
							<table class="table_legende" >
								<B>Kartenlegende :</B>
								<?php
								 $legende_geo= new legende_geo;
								 echo $legende_geo->zeigeLegende($layer,'','','','');
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
<?	} 

// Ebene 2
if ($ortslage_id > 0)
   { 	  
	  $query="SELECT a.* FROM $schema.$tabelle as a, management.ot_lt_rka as b WHERE ST_intersects(a.the_geom, b.the_geom) AND b.gid='$ortslage_id'  ORDER BY a.ort,a.strasse";
	  $result = $dbqueryp($connectp,$query);
	  $z=0;
	  while($r = $fetcharrayp($result))
	    {
	       $bd[$z]=$r;
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
            $bdkarte= new karte;
            echo $bdkarte->zeigeKarteBox($boxstring,$v_breite,$v_hoehe,'orka','0','0','0','0','0',$beschriftung_karte,$layername_mapfile);
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
										<td height="20" align="center" valign=bottom width=270 >
										  <? 
										     echo "<h3>Liste der<br>",$titel,"</h3> in der Ortslage"; 
											?>
											</td>
										<td width=10 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>
									</tr>
									<tr>
									
									</tr>
									<tr>
									<td height="auto" align="center" valign=top width=270>
									<?
									 echo "<h3>",$r["ortsteil"],"</h3>";
											 if ($r["typ"] != 'Gemeinde') echo "Gemeinde: ",$r["gem_name"];
											 echo '<br><br><hr>','<a href="#liste">';
											 if ($count > 0) echo $count;
											   else echo "kein";
											 if ($count > 1) echo " Baudenkmale </a>";
											   else echo " Baudenkmal </a>";
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
										$query="SELECT ortslage,typ,gid FROM  management.suchfeld_schnellsprung_ortslagen WHERE gemschl != '13071107' ORDER BY ortslage";
										$result = $dbqueryp($connectp,$query);

										while($r = $fetcharrayp($result))
											{
												echo "<option ";
												
												echo ' value="',$r["gid"],'"';
												if ($r["gid"] == $ortslage_id) echo "selected";
												echo '>',$r["ortslage"],'</option>\n';
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
	//											function zeigeLegende2($kreis,$aemter,$gemeinden,$gemeinde_gr,$gemarkung_gr,$Ortsteile_lt_rka,$layer,$layer2)
												echo $legende_geo->zeigeLegende2('0','0','0','1','0','0',$layer,'')
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
                                  echo "<tr><td colspan=2 bgcolor=$header_farbe align=center><a href='baudenkmalliste.php?ortslage=$ortslage_id' target=_blank><font color='white'>Druckansicht</a></td><td colspan=5 align=\"center\" height=50 bgcolor=$header_farbe><b><font color='white'>	Ihre Suchanfrage lieferte  $count Treffer<br><small>Wählen Sie einen Eintrag aus der Liste um weitere Informationen zu erhalten.</font></td></tr>";
								?>
											
									<tr>

										<td align=center height=30 width=40><a name="Liste"></a><b>Region</b></td>
										<td align=center height=30><b>Nummer</b></td>
										<td align=center height=30 width=40><b>lfd. Nr.</b></td>
										<td align=center height=30><b>Objekt</b></td>
										<td align=center height=30><b>Ort</b></td>
										<td align=center height=30><b>Straße</b></td>
										<td align=center height=30><b>Typ</b></td>
									</tr>
												<?php for($v=0;$v<$z;$v++)
													{   echo "<tr ";
													    if ($v % 2 == 0) echo "bgcolor=$element_farbe";
														echo ">";
														
													    echo "<td align=center>",$bd[$v]["kuerzel"],"</td>";
														echo '<td align=center><a href=',$_SERVER["PHP_SELF"],'?',$get_themenname,'=',$bd[$v]["gid"],'>',$bd[$v]["nr"],'</a></td>';
														echo "<td align=center>",$bd[$v]["lfdnr"],"</td>
														       <td align=center>",$bd[$v]["obj"],"</td>
															   <td align=center>",$bd[$v]["ort"],"</td>
															   <td align=center>",$bd[$v]["strasse"],"</td>
															   <td align=center>",$bd[$v]["typ"],"</td>
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
      $query="SELECT a.amt, a.amt_id, a.gemeinde, a.gem_schl as gemeindeid, b.gid,c.ortsteil,c.gemkg,c.gid FROM gemeinden as a, $schema.$tabelle as b, management.ot_lt_rka as c WHERE ST_intersects(b.the_geom, c.the_geom) AND CAST(a.gem_schl AS INTEGER)=c.gemschl AND c.typ != 'Gemeinde' AND b.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $ortslagen_count=1;
	  while($r = $fetcharrayp($result))
	  {
	    $ortslagen[$ortslagen_count]=$r;
		$ortslagen_count++;
	  }
	  $ortslage_id=$ortslagen[1]["gid"];
      $ortslage_name=$ortslagen[1]["ortsteil"];	  
	   
      $query="SELECT box(a.the_geom) as etrsbox, st_astext(st_centroid(a.the_geom)) as utm,astext(st_transform(st_centroid(a.the_geom),4326)) as geo, astext(st_transform(st_centroid(a.the_geom),2398)) as s4283, astext(st_transform(st_centroid(a.the_geom),31468)) as rd83,st_perimeter(a.the_geom) as umfang, area(the_geom) as flaeche,a.gid,a.kuerzel,a.nr,a.lfdnr,a.ort,a.strasse,a.obj,a.bild,a.typ,a.oeffentlich FROM $schema.$tabelle as a WHERE a.gid='$themen_id'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  
	  $label=$r["kuerzel"].'-'.$r["nr"].'-'.$r["lfdnr"];
	  $bildname=$r["bild"];
	  $oeffentlich=$r["oeffentlich"];
	  $utm=$r["utm"];
	  $s4283=$r["s4283"];
	  $rd83=$r["rd83"];
	  $geo=$r["geo"];
	  $umfang=$r["umfang"];
	  $area=$r["flaeche"];
	  $boxstring = $r["etrsbox"];
	  
	  $query="SELECT c.gid,a.label,a.mitarbeiter_telefon,a.mitarbeiter_fax,a.mitarbeiter_mail,a.sg_name,d.label as v_label,d.mitarbeiter_telefon as v_telefon,d.mitarbeiter_fax as v_fax,d.mitarbeiter_mail as v_mail,d.sg_name as v_sg_name FROM organisation.ma_gesamt as a, organisation.ma_gesamt as d, organisation.zustaendigkeiten as b,construction.baudenkmale as c WHERE st_within(c.the_geom,b.the_geom) AND a.mitarbeiter_id=CAST(b.mitarbeiter_id AS INTEGER) AND d.mitarbeiter_id=CAST(b.vertretung_mitarbeiter_id AS INTEGER) AND a.mitarbeiter_sg='60.1' AND d.mitarbeiter_sg='60.1' AND c.gid='$themen_id'";
	  $result = $dbqueryp($connectp,$query);
	  $ma = $fetcharrayp($result);
	  
	  

//	  echo $lon," ",$lat," ",$rechts_range," ",$hoch_range;
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
            $geotopkarte= new karte;
            echo $geotopkarte->zeigeKarteBox($boxstring,$v_breite,$v_hoehe,'dop','0','0','0','0','0',$beschriftung_karte,$layername_mapfile);
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
											<? echo $font_farbe ;?><h3>Baudenkmal:<br> <? echo $label; ?><? echo $font_farbe_end ;?>
										</td>
										<td width=10 rowspan="7"></td>
										<td border=0 valign=top align=left rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<?
											 echo "Das Baudenkmal";
											 if ($ortslagen_count > 2) echo " berührt mehrere Ortslagen:<br>";
											 else echo " liegt in der Ortslage:<br>";
											 for ($i=1;$i<=$ortslagen_count-1;$i++)
											    {
												 echo "<table border=0>
												       <tr><td colspan=2 align=center><b>",$ortslagen[$i]["ortsteil"],"</td></tr>
													   <tr><td>Gemarkung::</td><td><b>",$ortslagen[$i]["gemkg"],"</td></tr>
													   <tr><td>Gemeinde:</td><td><b>",$ortslagen[$i]["gemeinde"],"</td></tr>
												       <tr><td>Amt:</td><td><b>",$ortslagen[$i]["amt"],"</td></tr>
													   
													   
													   
													   </table>";
												}
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
										$query="SELECT ortslage,typ,gid FROM  management.suchfeld_schnellsprung_ortslagen WHERE gemschl != '13071107' ORDER BY ortslage";
										$result = $dbqueryp($connectp,$query);

										while($rx = $fetcharrayp($result))
											{
												echo "<option ";
												
												echo ' value="',$rx["gid"],'"';
												if ($rx["gid"] == $ortslage_id) echo " selected";
												echo ">";
												echo $rx["ortslage"],'</option>\n';
											}
									?>
								</select>
								</form>
							</td>
						</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center colspan=2>
											<a href="<? echo $_SERVER["PHP_SELF"];?>"><? echo $font_farbe ;?>zu allen <? echo $titel_plural;?><br><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr bgcolor=<? echo $header_farbe; ?>>
										
										<td align=center height="50" colspan=2>
											<a href="<? echo $_SERVER["PHP_SELF"];?>?ortslage=<? echo $ortslage_id; ?>"><? echo $font_farbe ;?>zu allen <? echo $titel_plural;?>  in <h3><? echo $ortslage_name ?><? echo $font_farbe_end ;?></a>
										</td>
										
									</tr>
									<tr>										
									<!-- Tabelle für Legende -->
										<td valign=bottom align=left>
											<table class="table_legende_ebenen">
											<B>Kartenlegende :</B>
											<?php
												$legende_geo= new legende_geo;
												echo $legende_geo->zeigeLegende2('1','0','0','0','0','0',$layer,'');
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
											<td width="100%" bgcolor=<? echo $element_farbe ?>><b><? echo $r["ort"] ;?></b></td>												
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
											<td>Straße:</td>
											<td><b><? echo $r["strasse"] ;?></b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Objekt:</td>
											<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["obj"] ;?></b></td>																									
										</tr>
										<tr>
											<td>Typ:</td>
											<td><b><? echo $r["typ"] ;?></b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>Region:</td>
											<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["kuerzel"] ;?></b></td>																										
										</tr>
										<tr>
											<td>Nummer:</td>
											<td><b><? echo $r["nr"] ;?></b></td>																									
										</tr>
										<tr>
											<td bgcolor=<? echo $element_farbe ?>>laufende Nummer:</td>
											<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["lfdnr"] ;?></b></td>																									
										</tr>
										<tr>
											<td valign=top>Kontakt:</td>
											<td><b><? echo $ma["label"],"<br>",$ma["sg_name"],"<br>Telefon: ",$ma["mitarbeiter_telefon"],"<br>Fax: ",$ma["mitarbeiter_fax"],"<br>E-Mail: <a href=mailto:",$ma["mitarbeiter_mail"],">",$ma["mitarbeiter_mail"];?></a>
											<br><br><small>Vertretung:</small><br>
											<? echo $ma["v_label"],"<br>",$ma["v_sg_name"],"<br>Telefon: ",$ma["v_telefon"],"<br>Fax: ",$ma["v_fax"],"<br>E-Mail: <a href=mailto:",$ma["v_mail"],">",$ma["v_mail"];?></a></b></td>																									
										</tr>										
									</table>
							</td>									
							<td valign=top align=center width="250">
							<? include("includes/geo_flaeche_25833.php"); ?>	
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

