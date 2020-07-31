<?php
include ("includes/connect_geobasis.php");
include ("includes/connect_i_procedure_mse.php");
include ("includes/portal_functions.php");
require_once ("classes/karte.class.php");
require_once ("classes/legende_geo.class.php");

$layer_legende_2="Kreisgrenze_msp";
$layer_legende_3="msp_outline_gemkg";
$stichtag=$_GET["stichtag"];
if (!isset($stichtag))
     {
	   $query="SELECT DISTINCT stichtag from population.g_bevoelkerung ORDER BY stichtag DESC LIMIT 1";
	   $result = $dbqueryp($connectp,$query);
	   $r = $fetcharrayp($result);
	   $stichtag = $r[0];
	  }
 $temp=explode('.',$stichtag);
 $jahrgang=$temp[2];

$layer_demografie='Bevoelkerungsdichte'.'_'.$jahrgang;
$label_auswahl="Gemeinde";
$beschriftung_demografie="Einwohnerdichte";


//globale Varibalen
$titel='Einwohnerdichte ('.$stichtag.')';

$datei=$_SERVER["PHP_SELF"];
$tabelle="population.g_bevoelkerung";
$kuerzel="ez";
$layerid="84910";

$log=write_i_log($db_link,$layerid);

$gemeinde_id=$_GET["$kuerzel"];

if ($gemeinde_id < 1)
    { 
		$query="SELECT COUNT(*) AS anzahl FROM $tabelle WHERE stichtag='$stichtag'";	  
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
             echo $geoportal_karte->zeigeKarteBoxDemografie($box_mse_gesamt,'685','510','orka','1','0','0','0','0',$beschriftung_karte,'',$beschriftung_demografie,$layer_demografie);			 
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
									
									<td align="center" valign="top" height=30><br>
										<h3>Einwohnerdichte*</h3>
										<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="stichtag">
							Stichtag:
							
								<select name="stichtag" onchange="document.stichtag.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
									 $query="SELECT DISTINCT stichtag FROM population.g_bevoelkerung ORDER BY stichtag DESC";
									 $result = $dbqueryp($connectp,$query);

									  while($r = $fetcharrayp($result))
									   {
									   echo "<option";if ($stichtag == $r['stichtag']) echo " selected"; echo ' value=',$r["stichtag"],'>',$r["stichtag"]
													,'</option>\n';
										}
									?>
								</select>								
							</form>
									</td>
									<td width=30 rowspan=8></td>
									<td border=0 valign=top align=center rowspan=7 colspan=3>
										<br>
										<div style="margin:1px" id="map"></div>
									</td>
								</tr>
								<tr>
									<td align="center"  height=60 colspan=2>
										Gemeinde ausw&auml;hlen:
									</td>
								</tr>
								<tr>
									<td align="center" height=40 colspan=2>
										<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
										<input type=hidden name="stichtag" value="<? echo $stichtag ?>">
										<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
											<?php
												$query="SELECT gemeinde, gem_schl FROM $tabelle WHERE stichtag='$stichtag' ORDER BY gemeinde";
												$result = $dbqueryp($connectp,$query);
												echo "<option>-- Bitte ausw&auml;hlen --</option>\n";
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
								     echo $legende_geo->zeigeLegendeDemografie($layer_demografie,$layer_legende_2,'','','');
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
	  $query="SELECT name, amts_sf FROM kataster.amtsbereiche as a, $tabelle as b WHERE b.stichtag='$stichtag' AND ST_INTERSECTS(st_transform(a.the_geom,2398),st_buffer(b.the_geom,-10)) AND b.gem_schl='$gemeinde_id' ORDER by b.gemeinde";
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];
	  
	  
	  $query="SELECT flaeche, gem_schl, gemeinde, gesamt, km2, maennlich as mann, anteil_m as mann_quote, weiblich as frau, anteil_w as frau_quote, box(st_transform(the_geom,25833)) as etrsbox, st_transform(the_geom,25833) as geom_25833  FROM $tabelle WHERE stichtag='$stichtag' AND gem_schl='$gemeinde_id'";	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bildname = $r["ziel"];
	  $gemeindename = $r["gemeinde"];
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
		<? include ("includes/bilder_popup.php"); ?>
		<?
             $geoportal_karte= new karte;
             echo $geoportal_karte->zeigeKarteBoxDemografie($etrsbox,'685','510','orka','1','0','0','0','0',$gemeindename,$gemeinde_id,$beschriftung_demografie,$layer_demografie);			 
            ?>		
		<script language="javascript">
			function klappe (Id){
			  if (document.getElementById) {
				var mydiv = document.getElementById(Id);
				mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
			  }
			}
		</script>
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
											<? echo $font_farbe ;?><? echo $r["gemeinde"]; ?>
											<form action="<? echo $_SERVER["PHP_SELF"];?>" method="get" name="stichtag">
											<input type=hidden name="<? echo $kuerzel ?>" value="<? echo $gemeinde_id ?>" >
							Stichtag:<? echo $font_farbe_end ;?>
							
								<select name="stichtag" onchange="document.stichtag.submit();" style="font-family:Arial; font-size: 8pt; font-weight: bold">
								    <option>Bitte auswählen</option>
									<?php
									 $query="SELECT DISTINCT stichtag FROM population.g_bevoelkerung ORDER BY stichtag DESC";
									 $stresult = $dbqueryp($connectp,$query);

									  while($st = $fetcharrayp($stresult))
									   {
									   echo "<option";if ($stichtag == $st['stichtag']) echo " selected"; echo ' value=',$st["stichtag"],'>',$st["stichtag"]
													,'</option>\n';
										}
									?>
								</select>								
							</form>
										</td>
										<td width=30 rowspan=7></td>
										<td border=0 align=center rowspan="6" colspan=3>
											<div style="margin:1px" id="map"></div>
										</td>										
									</tr>
									<tr>
										<td align="center" height="35" valign=center colspan="2" bgcolor=<? echo $element_farbe; ?>>
											<b>Amt: <? echo "<a href=\"aemter_msp.php?amt=",$amt,"\">",$amtname,"</a> ";?></b><br>											
										</td>
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">Gemeinde ausw&auml;hlen:</td>										
									</tr>
									<tr>
										<td align="center" height="25" colspan="2">
											<form action="<? echo $datei;?>" method="get" name="<? echo $kuerzel;?>">
											    <input type=hidden name="stichtag" value="<? echo $stichtag ?>" >
												<select name="<? echo $kuerzel;?>" onchange="document.<? echo $kuerzel;?>.submit();" style="width: 200px;">
													<?php
														$query="SELECT gemeinde, gem_schl FROM $tabelle WHERE stichtag='$stichtag' ORDER BY gemeinde";
														$result = $dbqueryp($connectp,$query);														
														while($e = $fetcharrayp($result))
														{
														 echo "<option";if ($gemeinde_id == $e["gem_schl"]) echo " selected"; echo ' value="',$e["gem_schl"],'" title="',$e["gemeinde"],'">',$e["gemeinde"],'</option>\n';
														}
													?>
												</select>
											</form>
										</td>
									</tr>
									<tr>										
										<td align=center colspan=2 bgcolor=<? echo $header_farbe; ?>>
											<a href="<? echo $datei;?>"><? echo $font_farbe ;?>alle Gemeinden<? echo $font_farbe_end ;?></a>
										</td>										
									</tr>									
								<!-- Zeile für die Legende -->
								
								<tr>									
 			                       <td valign=bottom align=left >
							       <table class="table_legende" >
								    <B>Kartenlegende :</B>
								    <?php
								     $legende_geo= new legende_geo;
								     echo $legende_geo->zeigeLegendeDemografie($layer_demografie,$layer_legende_2,'','','');
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
								<table border=0 cellspacing=0 valign=top>
									<tr height="35">
										<td colspan=3  width="620" bgcolor=<? echo $header_farbe ;?>>&nbsp;&nbsp;<? echo $font_farbe ;?><font size="+1"><a name="anker"><? echo $gemeindename." - ".$stichtag ;?></a><? echo $font_farbe_end ;?></td>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Fl&auml;che in km&sup2;:</td>
										<td colspan=2 bgcolor=<? echo $element_farbe ?>><b><? echo $r["flaeche"]." km²" ;?></b></td>													
									</tr>
									<tr height="30">
										<td>Einwohner gesamt:</td>
										<td width=40%><b><? echo $r["gesamt"]." </td><td><b><a href=\"#anker\" onclick=\"klappe('eintrag_1')\" title=\"aufklappen/zuklappen\">andere Jahre im Vergleich</a>";?>
										<div id="eintrag_1" style="display: none">
										<? 
										  $query="SELECT gesamt,stichtag from $tabelle WHERE gem_schl='$gemeinde_id' ORDER BY stichtag";
										  $subresult = $dbqueryp($connectp,$query);
									      while($stx = $fetcharrayp($subresult))
									       {
											 echo '<small>',$stx["stichtag"],' : </small>',$stx["gesamt"],'<br>';
										    }
										?>
										</b></td></div>													
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Einwohner/km&sup2;:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["km2"]." Einw/km&sup2; </td><td bgcolor=$element_farbe><b><a href=\"#anker\" onclick=\"klappe('eintrag_2')\" title=\"aufklappen/zuklappen\">andere Jahre im Vergleich</a>";?>																		
										<div id="eintrag_2" style="display: none">
										<? 
										  $query="SELECT km2,stichtag from $tabelle WHERE gem_schl='$gemeinde_id' ORDER BY stichtag";
										  $subresult = $dbqueryp($connectp,$query);
									      while($stx = $fetcharrayp($subresult))
									       {
											 echo '<small>',$stx["stichtag"],' : </small>',$stx["km2"],'<br>';
										    }
										?>
										</b></td></div>
									</tr>
									<tr height="30">
										<td>M&auml;nner:</td>
										<td><b><? echo $r["mann"]." </td><td><b><a href=\"#anker\" onclick=\"klappe('eintrag_3')\" title=\"aufklappen/zuklappen\">andere Jahre im Vergleich</a>";?>
										<div id="eintrag_3" style="display: none">
										<? 
										  $query="SELECT maennlich as mann,stichtag from $tabelle WHERE gem_schl='$gemeinde_id' ORDER BY stichtag";
										  $subresult = $dbqueryp($connectp,$query);
									      while($stx = $fetcharrayp($subresult))
									       {
											 echo '<small>',$stx["stichtag"],' : </small>',$stx["mann"],'<br>';
										    }
										?>
										</b></td></div>														
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">M&auml;nneranteil in Prozent:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["mann_quote"]."% </td><td bgcolor=$element_farbe><b><a href=\"#anker\" onclick=\"klappe('eintrag_4')\" title=\"aufklappen/zuklappen\">andere Jahre im Vergleich</a>";?>
										<div id="eintrag_4" style="display: none">
										<? 
										  $query="SELECT anteil_m as mann_quote,stichtag from $tabelle WHERE gem_schl='$gemeinde_id' ORDER BY stichtag";
										  $subresult = $dbqueryp($connectp,$query);
									      while($stx = $fetcharrayp($subresult))
									       {
											 echo '<small>',$stx["stichtag"],' : </small>',$stx["mann_quote"],'%<br>';
										    }
										?>
										
										</b></td></div>													
									</tr>
									<tr height="30">
										<td>Frauen:</td>
										<td><b><? echo $r["frau"]." </td><td><b><a href=\"#anker\" onclick=\"klappe('eintrag_5')\" title=\"aufklappen/zuklappen\">andere Jahre im Vergleich</a>";?>
										<div id="eintrag_5" style="display: none">
										<? 
										  $query="SELECT weiblich as frau,stichtag from $tabelle WHERE gem_schl='$gemeinde_id' ORDER BY stichtag";
										  $subresult = $dbqueryp($connectp,$query);
									      while($stx = $fetcharrayp($subresult))
									       {
											 echo '<small>',$stx["stichtag"],' : </small>',$stx["frau"],'<br>';
										    }
										?>
										
										</b></td></div>												
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">Frauenanteil in Prozent:</td>
										<td bgcolor=<? echo $element_farbe ?>><b><? echo $r["frau_quote"]."% </td><td bgcolor=$element_farbe><b><a href=\"#anker\" onclick=\"klappe('eintrag_6')\" title=\"aufklappen/zuklappen\">andere Jahre im Vergleich</a>";?>
										<div id="eintrag_6" style="display: none">
										<? 
										  $query="SELECT anteil_w as frau_quote,stichtag from $tabelle WHERE gem_schl='$gemeinde_id' ORDER BY stichtag";
										  $subresult = $dbqueryp($connectp,$query);
									      while($stx = $fetcharrayp($subresult))
									       {
											 echo '<small>',$stx["stichtag"],' : </small>',$stx["frau_quote"],'%<br>';
										    }
										?>
										</b></td></div>
									</tr>
									<tr height="30">
										<td bgcolor=<? echo $element_farbe ?> width="30%">zur Gemeinde (Kataster):</td>
										<td colspan=2 bgcolor=<? echo $element_farbe ?>><b><? echo "<a href=\"gemeinden_msp.php?gemeinde=",$r['gem_schl'],"\">",$r['gemeinde'],"</a> ";?></b></td>													
									</tr>
								</table>
							</td>
							<td valign=top align=center width="350">
								<? echo geo_punkt($geom_25833,$connectp,$dbqueryp,$fetcharrayp) ?>		
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

