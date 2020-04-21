
<?
	include ("includes/portal_functions.php");
	include ("includes/connect_geobasis.php");

	$ip=getenv('REMOTE_ADDR');
	$ip_array=explode(".",$ip);
	$relief=($_GET['relief']);
	
if ($relief < 1)
   { 	
		
	$query="SELECT box(st_transform(the_geom,2398)) as box, box(st_transform(the_geom,25833)) as etrsbox, area(st_transform(the_geom,2398)) as area, st_perimeter(st_transform(the_geom,2398)) as umfang, astext(st_transform(st_centroid(the_geom), 4326)) as geo, astext(st_transform(st_centroid(the_geom), 25833)) as etrs FROM fd_kreis WHERE 1=1"; 
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $etrs = $r[etrs];							//ETRS89 Koordinaten ermitteln (Polygonschwerpunkt)
	  $etrs2 = trim($etrs,"POINT(");
	  $etrs3 = trim($etrs2,")");
	  $etrs4 = explode(" ",$etrs3);
	  $etrs_lon = substr($etrs4[0],0,7);
	  $etrs_lat = substr($etrs4[1],0,7);
	  $geo = $r[geo];							//geografische Koordinaten ermitteln (Polygonschwerpunkt)
	  $geo2 = trim($geo,"POINT(");
	  $geo3 = trim($geo2,")");
	  $geo4 = explode(" ",$geo3);
	  $geo_lon = substr($geo4[0],0,7);
	  $geo_grad = substr($geo4[0],0,2);
	  $geo_minute_berechnung = $geo_lon-$geo_grad;
	  $geo_minute_berechnung1 = $geo_minute_berechnung*60;
	  $geo_minute_berechnung2 = explode(".",$geo_minute_berechnung1);
	  $geo_minute = $geo_minute_berechnung2[0];
	  $geo_sekunde_berechnung = $geo_minute_berechnung1-$geo_minute;
	  $geo_sekunde_berechnung1 = $geo_sekunde_berechnung*60;
	  $geo_sekunde_berechnung2 = explode(".",$geo_sekunde_berechnung1);
	  $geo_sekunde = $geo_sekunde_berechnung2[0];
	  $coord_string_lon=$geo_grad."�&nbsp;". $geo_minute."'&nbsp;". $geo_sekunde."''";
	  $geo_lat = substr($geo4[1],0,7);
	  $geo_grad_lat = substr($geo4[1],0,2);
	  $geo_minute_lat = $geo_lat-$geo_grad_lat;
	  $geo_minute_lat1 = $geo_minute_lat*60;
	  $geo_minute_lat2 = explode(".",$geo_minute_lat1);
	  $geo_minute_lat3 = $geo_minute_lat2[0];
	  $geo_sekunde_lat = $geo_minute_lat1-$geo_minute_lat3;
	  $geo_sekunde_lat1 = $geo_sekunde_lat*60;
	  $geo_sekunde_lat2 = explode(".",$geo_sekunde_lat1);
	  $geo_sekunde_lat3 = $geo_sekunde_lat2[0];
	  $coord_string_lat=$geo_grad_lat."�&nbsp;". $geo_minute_lat3."'&nbsp;". $geo_sekunde_lat3."''";
	  $umfang = $r[umfang];						//Umfang ermitteln
	  $umfang2 = explode(".",$umfang);
	  $umfang3 = $umfang2[0];
      $umfang4 = $umfang3/1000;
	  $umfang5 = explode(".",$umfang4);
	  $umfang6 = $umfang5[0];
	  $flaeche = $r[area]/1000000;				//Fl�che wird geteilt durch 1.000.000 um km� zu ermitteln
	  $flaeche2 = explode(".",$flaeche);		//Fl�che wird zerlegt in zwei Arrays
	  $flaeche3 = $flaeche2[0];					//Ausgabe der Fl�che ohne Kommastellen
	  $boxstring = $r[etrsbox];						//Ausdehnung ermitteln
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  $koordinaten = explode(",",$boxstring);
	  $lur = $koordinaten[0];
	  $lur1 = explode(".",$lur);
	  $lur2 = $lur1[0];
	  $luh = $koordinaten[1];
	  $luh1 = explode(".",$luh);
	  $luh2 = $luh1[0];
	  $ror = $koordinaten[2];
	  $ror1 = explode(".",$ror);
	  $ror2 = $ror1[0];
	  $roh = $koordinaten[3];
	  $roh1 = explode(".",$roh);
	  $roh2 = $roh1[0];
	  $rechts_range = $koordinaten[0]-$koordinaten[2];
	  $rechts = $rechts_range/1000;
	  $rechts1 = explode(".",$rechts);
	  $rechts2 = $rechts1[0];
	  $hoch_range = $koordinaten[1]-$koordinaten[3];
	  $hoch = $hoch_range/1000;
	  $hoch1 = explode(".",$hoch);
	  $hoch2 = $hoch1[0];
	  
	  $query="SELECT COUNT(*) AS anzahl FROM gemeinden WHERE kreis_id = 13071;";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count_gemeinden = $r[anzahl];
		
	  $query="SELECT COUNT(*) AS anzahl FROM gemarkung;";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count_gemarkungen = $r[anzahl];
		
	  $query="SELECT COUNT(*) AS anzahl FROM fd_amtsbereiche;";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count_aemter = $r[anzahl];		
	  
	  $query="SELECT einwohner, mann, mann_quote, frau, frau_quote, aktualitaet as stand FROM fd_kreis;";	  
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$count_einwohner = $r[einwohner];
		$mann = $r[mann];
		$frau = $r[frau];
		$mann_quote = $r[mann_quote];
		$frau_quote = $r[frau_quote];
		
		$stand = $r[stand];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>	
<head>
<meta http-equiv="X-UA-Compatible" content="text/html" charset="iso-8859-1">
<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

		<? include ("ajax.php"); ?>
		<? include ("includes/zeit.php"); ?>
		<script src=<? echo $openlayers_url; ?> type="text/javascript"></script>
			<link rel="stylesheet" href=<? echo $olstyle_url; ?> type="text/css" />
    <script type="text/javascript">
    var lon   = <?php echo $etrs_lon; ?>;
	var lat   = <?php echo $etrs_lat; ?>;
	var zoom  = 0;

    var map, info, measureControls;
	
	OpenLayers.Feature.Vector.style['default']['strokeWidth'] = '2';

    function load() {
        map = new OpenLayers.Map({
            div: "map",
            projection: "EPSG:25833",
			scales: [500000,400000,300000,200000,100000,50000,40000,30000,20000,10000,5000,2500,1000,500],
			//maxResolution: "auto",
      		maxExtent:  new OpenLayers.Bounds(<? echo $ror2; ?>,<? echo $roh2; ?>,<? echo $lur2; ?>,<? echo $luh2; ?>),
      		units: 'm'
        });
		
		var osm_citymap = new OpenLayers.Layer.WMS.Untiled("OSM Stadtplan",
            <? echo $osm_citymap_url; ?>,
            {'layers': 'stadtplan', transparent: true, format: 'image/png'},
            {isBaseLayer: true}
        );
		
        var webatlasde = new OpenLayers.Layer.WMS.Untiled("WebatlasDE",
            <? echo $webatlasde_url; ?>,
            {'layers': 'WebAtlasDE_MV_farbe', transparent: true, format: 'image/gif'},
            {isBaseLayer: true}
        );

        var dop = new OpenLayers.Layer.WMS.Untiled("Luftbild",
		 		            <? echo $dop_url; ?>,
		 		            {'layers': 'adv_dop', transparent: true, format: 'image/png'},
		 		            {isBaseLayer: true}
        );
		
		var amt_outline = new OpenLayers.Layer.WMS.Untiled("�mter Grenze",
								 <? echo $map_msp_url;?>,
								 {layers: 'aemter_msp_outline', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);	
		
		var amtssitz = new OpenLayers.Layer.WMS.Untiled("Amtsverwaltungen",
		                 <?php echo $map_msp_url;?>,
		                 {layers: 'Amtssitze_msp', transparent: true, format: 'image/png'},
		                 {isBaseLayer: false, visibility: false}
				);
				
		var kreissitz = new OpenLayers.Layer.WMS.Untiled("RST Landkreis",
		                 <?php echo $map_msp_url;?>,
		                 {layers: 'Kreissitze_msp', transparent: true, format: 'image/png'},
		                 {isBaseLayer: false, visibility: false}
				);

        var kreisgrenze = new OpenLayers.Layer.WMS.Untiled("Kreisgrenze",
		                 <?php echo $map_msp_url;?>,
		                 {layers: 'Kreisgrenze_msp', transparent: true, format: 'image/png'},
		                 {isBaseLayer: false}
        );		
		
		var schablone = new OpenLayers.Layer.WMS.Untiled("Schablone",
		                 <?php echo $map_msp_url;?>,
		                 {layers: 'lk_schablone', transparent: true, format: 'image/png'},
		                 {isBaseLayer: false}
        );
		
        map.addLayers([osm_citymap,webatlasde,dop,schablone,amt_outline,kreisgrenze,amtssitz,kreissitz]);	
		
        info = new OpenLayers.Control.WMSGetFeatureInfo({
			layers: [amtssitz,kreissitz],
            url: '<? echo $featureinfo_msp_url; ?>',
            title: 'Identify features by clicking',
			queryVisible: true,
            eventListeners: {
                getfeatureinfo: function(event) {
                    map.addPopup(new OpenLayers.Popup.FramedCloud(
                        "chicken",
                        map.getLonLatFromPixel(event.xy),
                        null,
                        event.text,
                        null,
                        true
                    ));
                }
            }
        });	
		
        map.addControl(info);		
        info.activate();		

        map.addControl(new OpenLayers.Control.LayerSwitcher());
		map.addControl(new OpenLayers.Control.Permalink());
		map.addControl(new OpenLayers.Control.OverviewMap({"ascending":false}));		
		map.addControl(new OpenLayers.Control.MousePosition());		
		var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:25833"), map.getProjectionObject());
		map.setCenter(lonLat,zoom);
 
	}	
</script>
<script type="text/javascript">
			function hilfe_popup (url) {
				fenster = window.open(url, "Popupfenster", "width=675,height=855,resizable=yes");
				fenster.focus();
				return false;
			}
</script>
<style type="text/css">
 #map {width:630px;height: 630px;border: 1px solid white;}
</style>
<style type="text/css">
			td.rand {border: solid #000000 2px;}
		</style>
<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
<script language="javascript">
function klappe (Id){
  if (document.getElementById) {
	var mydiv = document.getElementById(Id);
	mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
  }
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
			<!--<tr>
				<td colspan=2>
					<h2><u>Willkommen</u></h2>
				</td>
			</tr>-->
			<tr>
				<td width="100%">
					<table border=0 align=center>
						<tr>							
							<td valign="top" align=center rowspan=2>
								<div style="margin:1px" id="map" align=center></div>																		
							</td>
							<td valign=top width=350>
								<table border=0 width=350>
									<tr bgcolor=<? echo $header_farbe ?>>
										<td height=45>
											<font size="2" color=white><b>&nbsp;&nbsp;LK Mecklenburgische Seenplatte<br>&nbsp;&nbsp;in Zahlen und Fakten</b></font>
										</td>
										<td align=center width=45>
											<a href="#" onclick="klappe('eintraege')" title="aufklappen/zuklappen"><img src="buttons/klapp.gif" border=0></a>
										</td>
									</tr>
								</table>
									<div id="eintraege">
										<table width=350 border=0>
											<tr bgcolor=<? echo $element_farbe ?>>
												<td height=25>
													&nbsp;&nbsp;Bundesland:										
												</td>
												<td>
													&nbsp;&nbsp;<b>Mecklenburg-Vorpommern</b>&nbsp;&nbsp;
												</td>
											</tr>
											<tr>
												<td height=25>
													&nbsp;&nbsp;Kreisstadt:
												</td>
												<td>
													&nbsp;&nbsp;<b>Neubrandenburg</b>&nbsp;&nbsp;
												</td>
											</tr>
											<tr bgcolor=<? echo $element_farbe ?>>
												<td height=25>
													&nbsp;&nbsp;Einwohner:
												</td>
												<td>
													&nbsp;&nbsp;<b><? echo $count_einwohner." <small>(Zensus: ".$stand.")</small><br>&nbsp;&nbsp;".$mann." M�nner <small>(Quote: ".$mann_quote."%)</small><br>&nbsp;&nbsp;".$frau." Frauen <small>(Quote: ".$frau_quote."%)</small>"; ?></b>&nbsp;&nbsp;
												</td>
											</tr>
											<tr>
												<td height=25>
													&nbsp;&nbsp;Bev�lkerungsdichte:
												</td>
												<td>
													&nbsp;&nbsp;<b>47 Einw. pro km�</b>&nbsp;&nbsp;
												</td>
											</tr>
											<tr bgcolor=<? echo $element_farbe ?>>
												<td height=25>
													&nbsp;&nbsp;KFZ-Kennzeichen:
												</td>
												<td>
													&nbsp;&nbsp;<b>DM, MST, M�R, NB, AT,<br>&nbsp;&nbsp;MC, NZ, RM, WRN, MSE</b>&nbsp;&nbsp;
												</td>
											</tr>
											<tr>
												<td height=25>
													&nbsp;&nbsp;Kreisschl�ssel:
												</td>
												<td>
													&nbsp;&nbsp;<b>13 0 71</b>&nbsp;&nbsp;
												</td>
											</tr>
											<tr bgcolor=<? echo $element_farbe ?>>
												<td height=25>
													&nbsp;&nbsp;�mter:
												</td>
												<td>
													&nbsp;&nbsp;<b><? echo $count_aemter; ?></b>&nbsp;&nbsp;
												</td>
											</tr>
											<tr>
												<td height=25>
													&nbsp;&nbsp;Gemeinden:
												</td>
												<td>
													&nbsp;&nbsp;<b><? echo $count_gemeinden; ?></b>&nbsp;&nbsp;
												</td>
											</tr>
											<tr bgcolor=<? echo $element_farbe ?>>
												<td height=25>
													&nbsp;&nbsp;Gemarkungen:
												</td>
												<td>
													&nbsp;&nbsp;<b><? echo $count_gemarkungen; ?></b>&nbsp;&nbsp;
												</td>
											</tr>
											<tr>
												<td height=25>
													&nbsp;&nbsp;Landrat:
												</td>
												<td>
													&nbsp;&nbsp;<b>Herr Heiko K&auml;rger</b>&nbsp;&nbsp;
												</td>
											</tr>
											<tr bgcolor=<? echo $element_farbe ?>>
												<td height=25>
													&nbsp;&nbsp;Homepage:
												</td>
												<td valign=top>
													&nbsp;&nbsp;<b><a href="http://www.lk-mecklenburgische-seenplatte.de" target=blank>www.lk-mecklenburgische-<br>&nbsp;&nbsp;seenplatte.de</a>&nbsp;&nbsp;
												</td>
											</tr>
										</table>									
								</div>									
							</td>
						</tr>						
						<tr>
							<td align=center valign=top>
								<table width=350 border=0>
										<tr bgcolor=<? echo $header_farbe ?>>
											<td height=45 width=300>
												<font size="2" color=white><b>&nbsp;&nbsp;Geod�tische Daten<br>&nbsp;&nbsp;(gerechnet und gerundet)</b></font>
											</td>
											<td width=45 align=center>
												<a href="#" onclick="klappe('eintraege2')" title="aufklappen/zuklappen"><img src="buttons/klapp.gif" border=0></a>
											</td>
										</tr>
								</table>
								<div id="eintraege2">
										<table width=350 border=0>
											<tr bgcolor=<? echo $element_farbe ?>>
												<td height=25>&nbsp;&nbsp;Fl�che Landkreis:&nbsp;&nbsp;</td>
												<td><b>&nbsp;&nbsp;<? echo $flaeche3 ?> km�&nbsp;&nbsp;</b></td>
											</tr>
											<tr>
												<td width="200" height=25>&nbsp;&nbsp;Nord-S�d Ausdehnung:&nbsp;&nbsp;</td>
												<td><b>&nbsp;&nbsp;<? echo $hoch2 ?> km&nbsp;&nbsp;</b></td>
											</tr>
											<tr bgcolor=<? echo $element_farbe ?>>
												<td height=25>&nbsp;&nbsp;Ost-West Ausdehnung:&nbsp;&nbsp;</td>
												<td><b>&nbsp;&nbsp;<? echo $rechts2 ?> km&nbsp;&nbsp;</b></td>
											</tr>
											<tr>
												<td height=25>&nbsp;&nbsp;Grenzl�nge des Landkreises:&nbsp;&nbsp;</td>
												<td><b>&nbsp;&nbsp;<? echo $umfang6 ?> km&nbsp;&nbsp;<b></td>
											</tr>
											<tr bgcolor=<? echo $element_farbe ?>>
												<td height=25>&nbsp;&nbsp;Mittelpunkt<br>&nbsp;&nbsp;(Polygonschwerpunkt):&nbsp;&nbsp;</td>
												<td><b>&nbsp;&nbsp;<? echo $coord_string_lon;?></b><br><b>&nbsp;&nbsp;<? echo $coord_string_lat;?></b></td>
											</tr>
										</table>
								</div>
							</td>						
						</tr>
						<tr>
							<td>
								<small><? echo $cr; ?>|&nbsp;<a href="../both/wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>		
							</td>
						</tr>
					</table>
				</td>				
			</tr>
		</table>
	</div>
  </div>
  <div id="navigation">
    <table border="0" align="left">
		<tr>
			<td>
				<script type="text/javascript" language="JavaScript1.2" src="menu_msp_i.js" charset="iso-8859-1"></script>
			</td>
		</tr>
	</table>
  </div>
  <div id="extra">
	<?
		include("includes/news.php");
	?>
</div>
  <div id="footer">    
  </div>
</div>
</body>
</html>
<?  }





else
    { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>	
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<? include ("ajax.php"); ?>
		<? include ("zeit.php"); ?>
<script type="text/javascript">
			function hilfe_popup (url) {
				fenster = window.open(url, "Popupfenster", "width=675,height=855,resizable=yes");
				fenster.focus();
				return false;
			}
		</script>
<style type="text/css">
 #map {width:630px;height: 550px;border: 1px solid white;}
</style>
<style type="text/css">
			td.rand {border: solid #000000 2px;}
		</style>
<script type="text/javascript" language="JavaScript1.2" src="um_menu.js"></script>
</head>
<body onload="init();">
<div id="container">
  <div id="header">
    <?php
		head_portal();
	?>
  </div>
  <div id="wrapper">
    <div id="content">
		<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
			<!--<tr>
				<td colspan=2>
					<h2><u>Willkommen</u></h2>
				</td>
			</tr>-->
			<tr>
				<td width="100%">
					<table border=0 align=center>
						<tr>							
							<td width="630" height="550" valign="top" align=center rowspan=2>
								<img src="images/relief.jpg" height=540>																	
							</td>
							<td valign=top>
								<table border=0>
									<tr>
										<td colspan=2 height=50 bgcolor=<? echo $header_farbe ?>>
											<font size="2" color=white><b>&nbsp;&nbsp;Regionalstandort Waren (M�ritz) in Zahlen und<br>&nbsp;&nbsp;Fakten</b></font>
										</td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td height=25>
											&nbsp;&nbsp;Land:
										</td>
										<td>
											&nbsp;&nbsp;<b>Mecklenburg-Vorpommern</b>&nbsp;&nbsp;
										</td>
									</tr>
									<tr>
										<td height=25>
											&nbsp;&nbsp;Verwaltungssitz:
										</td>
										<td>
											&nbsp;&nbsp;<b>Waren</b>&nbsp;&nbsp;
										</td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td height=25>
											&nbsp;&nbsp;Einwohner:
										</td>
										<td>
											&nbsp;&nbsp;<b>65.210 (Stand: 31.12.2009)</b>&nbsp;&nbsp;
										</td>
									</tr>
									<tr>
										<td height=25>
											&nbsp;&nbsp;Bev�lkerungsdichte:
										</td>
										<td>
											&nbsp;&nbsp;<b>38 Einw. pro km�</b>&nbsp;&nbsp;
										</td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td height=25>
											&nbsp;&nbsp;KFZ-Kennzeichen:
										</td>
										<td>
											&nbsp;&nbsp;<b>M�R</b>&nbsp;&nbsp;
										</td>
									</tr>
									<tr>
										<td height=25>
											&nbsp;&nbsp;Kreisschl�ssel:
										</td>
										<td>
											&nbsp;&nbsp;<b>13 0 71</b>&nbsp;&nbsp;
										</td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td height=25>
											&nbsp;&nbsp;�mter:
										</td>
										<td>
											&nbsp;&nbsp;<b>5</b>&nbsp;&nbsp;
										</td>
									</tr>
									<tr>
										<td height=25>
											&nbsp;&nbsp;Gemeinden:
										</td>
										<td>
											&nbsp;&nbsp;<b>59</b>&nbsp;&nbsp;
										</td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td height=25>
											&nbsp;&nbsp;Gemarkungen:
										</td>
										<td>
											&nbsp;&nbsp;<b>188</b>&nbsp;&nbsp;
										</td>
									</tr>
									<tr>
										<td height=25>
											&nbsp;&nbsp;Landrat:
										</td>
										<td>
											&nbsp;&nbsp;<b>614</b>&nbsp;&nbsp;
										</td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ?>>
										<td height=25>
											&nbsp;&nbsp;Homepage:
										</td>
										<td valign=top>
											&nbsp;&nbsp;<b><a href="http://www.lk-mecklenburgische-seenplatte.de" target=blank>www.lk-mecklenburgische-<br>&nbsp;&nbsp;seenplatte.de</a>&nbsp;&nbsp;
										</td>
									</tr>
									<tr>
										<td valign=top>
											&nbsp;&nbsp;Wappen:
										</td>
										<td valign=top>
											&nbsp;&nbsp;<b>?</b>
										</td>
									</tr>
								</table>
							</td>
						</tr>						
						<tr>
							<td align=center>
								<table border=0>
										<tr>
											<td colspan=2 height=30 width=320 bgcolor=<? echo $header_farbe ?>><font size="2" color=white><b>&nbsp;&nbsp;Geod�tische Daten (gerechnet und gerundet)</b></font></td>
										</tr>
										<tr bgcolor=<? echo $element_farbe ?>>
											<td height=25>&nbsp;&nbsp;Fl�che Landkreis:&nbsp;&nbsp;</td>
											<td><b>&nbsp;&nbsp;1718 km�&nbsp;&nbsp;</b></td>
										</tr>
										<tr>
											<td width="200" height=25>&nbsp;&nbsp;Nord-S�d Ausdehnung:&nbsp;&nbsp;</td>
											<td><b>&nbsp;&nbsp;56 km&nbsp;&nbsp;</b></td>
										</tr>
										<tr bgcolor=<? echo $element_farbe ?>>
											<td height=25>&nbsp;&nbsp;Ost-West Ausdehnung:&nbsp;&nbsp;</td>
											<td><b>&nbsp;&nbsp;60 km&nbsp;&nbsp;</b></td>
										</tr>
										<tr>
											<td height=25>&nbsp;&nbsp;Grenzl�nge des Landkreises:&nbsp;&nbsp;</td>
											<td><b>&nbsp;&nbsp;299 km&nbsp;&nbsp;<b></td>
										</tr>
								</table>
							</td>						
						</tr>
						<tr>
							<td>
								<small><? echo $cr; ?>|&nbsp;<a href="wissenswertes/kartehilfe.php" target="_blank" onclick="return hilfe_popup(this.href)">Hilfe zur Kartennutzung</a>&nbsp;|&nbsp;<a href="index.php" target="_self">Kartenansicht</a>		
							</td>
						</tr>
					</table>
				</td>				
			</tr>
		</table>
	</div>
  </div>
  <div id="navigation">
    <table border="0" align="left">
		<tr>
			<td>
				<script type="text/javascript" language="JavaScript1.2" src="menu.js"></script>
			</td>
		</tr>
	</table>
  </div>
  <div id="extra">
	<table border='0' width='100%'>
		<tr>
			<td><b>
				<small><a href=\"javascript:ajaxpage('hinweise_ie.php', 'content')\">Hinweise f�r Internet Explorer-Nutzer</a>
			</td>
			<td align='right'><b>
				<small><a href=\"javascript:ajaxpage('kontakt.php', 'content')\">Kontakt</a>&nbsp;|&nbsp;<a href=\"javascript:ajaxpage('sitemap.php', 'content')\">Sitemap</a>&nbsp;|&nbsp;<a href=\"javascript:ajaxpage('impressum.php', 'content')\">Impressum</a>&nbsp;|&nbsp;&copy;Landkreis Mecklenburgische Seenplatte&nbsp;&nbsp;
			</b></td>
		</tr>
	</table>
</div>
  <div id="footer">    
  </div>
</div>
</body>
</html>
<?	} ?>
