<?php

//############ Globale Variablen #################################################### 
 
//allgemeine Mapdatei 
$map_msp_url="\"/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&\"";

//Datei für Feature Info
$featureinfo_msp_url="../cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map";


//Kataster
$gemeindemap_url="\"../cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_gemeinden_wms.map&\""; 		//Gemeinden
$plzmap_url="\"../cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_plz_wms.map&\"";					//Postleitzahlbereiche
$regionmap_url="\"/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_regionen_wms.map&\"";			//Regionen
$gemarkungmap_url="\"/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_gemarkungen_wms.map&\"";		//Gemarkungen
$amtmap_url="\"../cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_aemter_wms.map&\"";				//Ämter
$dop_url="\"http://www.geodaten-mv.de/dienste/adv_dop20\"";							//Luftbilder (Dienst)
$topo_url="\"http://www.geodaten-mv.de/dienste/gdimv_dtk?\"";						//Topogafische Karte (Dienst)
$webatlasde_url="\"http://www.geodaten-mv.de/dienste/webatlasde_wms/service\"";		//Webatlas DE (Dienst)
$osm_citymap_url="\"http://www.orka-mv.de/geodienste/orkamv/wms\"";					//ORKA-MV
$orka_mv_url="\"http://www.orka-mv.de/geodienste/orkamv/wms\"";						//ORKA-MV
$orka_mv_layername="orkamv-gesamt";													//Layername der ORKA-MV
$dtk_url="\"http://www.geodaten-mv.de/dienste/gdimv_dtk\"";							//Topogafische Karte (Dienst)
$bevoelkerung_url="\"/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_bevoelkerung_wms.map&\"";	//Bevölkerungsgewichtung



//Verkehr
//$sbabmap_url="\"../cgi-bin/mapserv?map=/var/www/wms/sbab_msp.map&\"";				//Straßenbauamtsbereiche
$sbmbmap_url="\"../cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_sbmb_wms.map&\"";				//Straßenmeistereibereiche


//Open Layers Datei / Open Layers Style
$openlayers_url="\"../openlayers/OpenLayers.js\"";
$olstyle_url="\"../openlayers/theme/default/style.css\"";

//Copyright unter der Karte (Map)
$copyright="&copy; Landkreis Mecklenburgische Seenplatte&nbsp;| &nbsp;Kartendaten: &copy; GeoBasis-DE/M-V 2013&nbsp;";
$cr="&copy; Landkreis Mecklenburgische Seenplatte&nbsp;| &nbsp;Kartendaten: &copy; GeoBasis-DE/M-V 2013&nbsp;";

//Farben für Gestaltung
$header_farbe="#3264af";
const HEADER_FARBE = "#3264af";
$element_farbe="#d2e8ff";
const ELEMENT_FARBE="#d2e8ff";
$font_farbe="<font color=white><b>";
$font_farbe_end="</b></font>";
$link_farbe="<font color=white><i>";
$link_farbe_end="</i></font>";

//Bildpfad
$bildpfad="images/kvwmap/";

//Metadatenpfad
$metadatenpfad="metadaten/metadaten.php?Layer_ID=";

//Boxstring für gesamten Landkreis
$box_mse_gesamt="431881,5986576,296166,5891077";

$ip=getenv('REMOTE_ADDR');

###### Funktionen ###############################################



//Kopf der Dateien
function head_portal()
{
	$datum = getdate(time());
    $year=$datum["year"];
    $month=$datum['mon'];
    $day=$datum['mday'];
    $wday=$datum['wday'];
    if ($wday=='0') $wochentag="Sonntag";
    if ($wday=='1') $wochentag="Montag";
    if ($wday=='2') $wochentag="Dienstag";
    if ($wday=='3') $wochentag="Mittwoch";
    if ($wday=='3') $wochentag="Mittwoch";
    if ($wday=='4') $wochentag="Donnerstag";
    if ($wday=='5') $wochentag="Freitag";
    if ($wday=='6') $wochentag="Sonnabend";
    if (strlen($month) == 1) $month='0'.$month;
    if (strlen($day) == 1) $day='0'.$day;
    if (strlen($sec) == 1) $sec='0'.$sec;
    $print_datum=$day.".".$month.".".$year;
    $bday_datum=$month."-".$day;

	
echo "<div align=\"center\">
<table border='0' cellpadding='0' cellspacing='0' width=100%><tr><td><img src=\"images/geoportal_logo.png\" width='1200' ></td></tr></table>
</div>
<div style='width: 100%; background-color: #50aa19; height: 3px'><img src='images/trennlinie.gif' height='0' width='0'></div>
<table bgcolor='#3264af' border='0' width=100%>
<tr style=\"color: #ffffff; font-family:Arial; font-size: 11pt; font-weight: bold\">
<td width=10%>";

//echo "<form name='form1' method='get' action='suche.php'><input onfocus=\"if(this.value=='Suchbegriff eingeben')this.value='';\" type='text' name='suche' value='Suchbegriff eingeben' size='30'><input type='image' src='buttons/lupe.gif' value='Suche' width='19'></form>";
echo "</td>
<td width=20%></td>
<td width=20%><a href=\"https://geoport-lk-mse.de/kvwmap\" target=\"_blank\" onclick=\"window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,');return false;\"><img src='buttons/kvwmap_button.gif' border=0></a></td>
<td width=20% align='left'><a href=\"https://geoport-lk-mse.de/kvwmap/index.php?gast=50\" target=\"_blank\" onclick=\"window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,');return false;\"><img src='buttons/buergerportal_button.gif' border=0></a></td>
<td width=30% align='left'>".

"</td>
<td>&nbsp;&nbsp;".$wochentag."&nbsp;&nbsp;".$print_datum."&nbsp;&nbsp;<span id='zeit'></span></td>
</tr>
</table>
<div style='width: 100%; background-color: #50aa19; height: 3px'><img src='images/trennlinie.gif' height='0' width='0'></div>";

}

//Kopf für die Trefferliste
function head_trefferliste($i,$spalten,$header_farbe)
{
 echo "<tr><td colspan=$spalten align=\"center\" height=50 bgcolor=$header_farbe><b><font color='white'>	Ihre Suchanfrage lieferte  $i Treffer<br><small>Wählen Sie einen Eintrag aus der Liste um weitere Informationen zu erhalten.</font></td></tr>";
}

//zeilenweises gestalten mit unterschiedlichen Farben
function get_farbe($zeilennummer)
{
 $quot=$zeilennummer%2;
 if($quot ==1)$Farbe="#FCFCFC";
 else $Farbe="#d2e8ff";
 return $Farbe;
}

//Funktion zur Ermittlung des Rechtswertes (geografische Koordinaten)
function get_geocoordinates_long($geo)
{

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
	  
	  $coord_string=$geo_grad."&deg;&nbsp;". $geo_minute."'&nbsp;". $geo_sekunde."''<br>&nbsp;&nbsp;". $geo_lon."&deg; ";
	  return $coord_string;
}

//Funktion zur Ermittlung des Hochwertes (geografische Koordinaten)
function get_geocoordinates_lat($geo)
{
	  $geo2 = trim($geo,"POINT(");
	  $geo3 = trim($geo2,")");
	  $geo4 = explode(" ",$geo3);
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

	  $coord_string=$geo_grad_lat."&deg;&nbsp;". $geo_minute_lat3."'&nbsp;". $geo_sekunde_lat3."''<br>&nbsp;&nbsp;". $geo_lat."&deg;" ;
	  return $coord_string;
}

//Funktion zur Ermittlung des Hochwertes (UTM Koordinaten)
function get_utmcoordinates_lat($utm)
{
	  $utm2 = trim($utm,"POINT(");
	  $utm3 = trim($utm2,")");
	  $utm4 = explode(" ",$utm3);	  
	  $utm6 = explode(".",$utm4[1]);
	  $utm_lat = $utm6[0];

	  $coord_string=$utm_lat ;
	  return $coord_string;
}

//Funktion zur Ermittlung des Rechtswertes (UTM Koordinaten)
function get_utmcoordinates_lon($utm)
{
	  $utm2 = trim($utm,"POINT(");
	  $utm3 = trim($utm2,")");
	  $utm4 = explode(" ",$utm3);	  
	  $utm5 = explode(".",$utm4[0]);
	  $utm_lon = $utm5[0];

	  $coord_string=$utm_lon ;
	  return $coord_string;
}

//Funktion zur Ermittlung des Hochwertes (RD83 Koordinaten)
function get_rd83coordinates_lat($rd83)
{
	  $rd832 = trim($rd83,"POINT(");
	  $rd833 = trim($rd832,")");
	  $rd834 = explode(" ",$rd833);	  
	  $rd836 = explode(".",$rd834[1]);
	  $rd83_lat = $rd836[0];

	  $coord_string=$rd83_lat ;
	  return $coord_string;
}

//Funktion zur Ermittlung des Rechtswertes (RD83 Koordinaten)
function get_rd83coordinates_lon($rd83)
{
	  $rd832 = trim($rd83,"POINT(");
	  $rd833 = trim($rd832,")");
	  $rd834 = explode(" ",$rd833);	  
	  $rd835 = explode(".",$rd834[0]);
	  $rd83_lon = $rd835[0];

	  $coord_string=$rd83_lon ;
	  return $coord_string;
}

//Funktion zur Ermittlung des Hochwertes (S4283 Koordinaten)
function get_s4283coordinates_lat($s4283)
{
	  $s42832 = trim($s4283,"POINT(");
	  $s42833 = trim($s42832,")");
	  $s42834 = explode(" ",$s42833);	  
	  $s42836 = explode(".",$s42834[1]);
	  $s4283_lat = $s42836[0];

	  $coord_string=$s4283_lat ;
	  return $coord_string;
}
	  
//Funktion zur Ermittlung des Rechtswertes (S4283 Koordinaten)
function get_s4283coordinates_lon($s4283)
{
	  $s42832 = trim($s4283,"POINT(");
	  $s42833 = trim($s42832,")");
	  $s42834 = explode(" ",$s42833);	  
	  $s42835 = explode(".",$s42834[0]);
	  $s4283_lon = $s42835[0];

	  $coord_string=$s4283_lon ;
	  return $coord_string;
}

//Funktion zur Ermittlung des Umfangs
function get_umfang($umfang)
{
	  $umfang2 = explode(".",$umfang);
	  $umfang3 = $umfang2[0];

	  $umfang_string=$umfang3 ;
	  return $umfang_string;
}

//Funktion zur Ermittlung der Aktualität der Themen
function get_aktualitaet($db_link,$thema_id)
{
  $query="SELECT datum_stand,zyklus FROM metadaten WHERE layer_id='$thema_id' ";
  
  $result=mysql_query($query);
  
  $r=mysql_fetch_array($result);
  $aktualitaet=$r[0];
  $zyklus=$r[1];
  if ($zyklus == 'laufend') $aktualitaet='laufend';
  return $aktualitaet;
 }

function get_i_aktualitaet($db_link,$thema_id)
{
  $query="SELECT datum_stand,zyklus FROM metadaten WHERE layer_id='$thema_id' ";
  
  $result=mysqli_query($db_link,$query);
  
  $r=mysqli_fetch_array($result);
  $aktualitaet=$r[0];
  $zyklus=$r[1];
  if ($zyklus == 'laufend') $aktualitaet='laufend';
  return $aktualitaet;
 }

 
function get_i_mp_link($db_link,$thema_id)
{
  $query="SELECT url_mp FROM metadaten WHERE layer_id='$thema_id' ";
  
  $result=mysqli_query($db_link,$query);
  
  $r=mysqli_fetch_array($result);
  $mp_link=$r['url_mp'];
  
  if (strlen($mp_link) != 0) $mp_link_final = '<a href="'.$mp_link.'" target="_blank"><img src="buttons/kartenportal_button.gif" style="width:100px;height:20px;"  title="Kartenportal" border=0 ></a>';
    else $mp_link_final = '';
	
  return $mp_link_final;
 }

 
 
 
function get_gemeinde_name($gem_schl,$connectp,$dbqueryp,$fetcharrayp)
 {
 $query="SELECT gemeinde FROM gemeinden WHERE gem_schl='$gem_schl'";
 $result = $dbqueryp($connectp,$query);
 $r = $fetcharrayp($result);
 return $r[0];
 }
 
function get_gemarkung_name($gemkg_schl,$connectp,$dbqueryp,$fetcharrayp)
 {
 $query="SELECT gemarkungsname_kurz FROM gemarkung WHERE geographicidentifier='$gemkg_schl'";
 $result = $dbqueryp($connectp,$query);
 $r = $fetcharrayp($result);
 return $r[0];
 }

function get_ortsteil_name($ortsteil_id,$connectp,$dbqueryp,$fetcharrayp)
 {
 $query="SELECT ortsteil,gem_name FROM management.ot_lt_rka WHERE gid='$ortsteil_id'";
 $result = $dbqueryp($connectp,$query);
 $r = $fetcharrayp($result);
 $ortsteilname=$r[ortsteil];
 if (strlen($r[gem_name]) > 0) $ortsteilname=$ortsteilname."(".$r[gem_name].")";
 return $ortsteilname;
 }

function get_bild_name($bildname)
  {
   $bildname1 = explode("&",$bildname);
   $bildname2 = $bildname1[0];
   $bildname3 = explode("/",$bildname2);
   $bild="pictures/".$bildname3[5]."/".$bildname3[6];
   if (empty($bildname)) $bild='';
   return $bild;
  }
   
function write_log($db_link,$log_thema_id)
 {
  $ip=getenv('REMOTE_ADDR');
  $uri=getenv('REQUEST_URI');
  $browser_name=$_SERVER['HTTP_USER_AGENT'];
  
  $query="INSERT INTO u_consume_geoportal (time_id,log_ip,log_thema_id,request_uri,browser_name) VALUES (now(),'$ip','$log_thema_id','$uri','$browser_name')";
    
  mysql_query($query) OR DIE ("Der Eintrag konnte nicht angelegt werden...");
    
    
  return true;
 }


function write_i_log($db_link,$log_thema_id)
   {
     $ip=getenv('REMOTE_ADDR');
     $uri=getenv('REQUEST_URI');
	 $browser_name=$_SERVER['HTTP_USER_AGENT'];
     $query="INSERT INTO u_consume_geoportal (time_id,log_ip,log_thema_id,request_uri,browser_name) VALUES (now(),'$ip','$log_thema_id','$uri','$browser_name')";
     mysqli_query($db_link,$query) OR DIE ("Der Eintrag konnte nicht angelegt werden...");
     return true;
   }

function geo_flaeche($geom,$connectp,$dbqueryp,$fetcharrayp)
 {
 $query="SELECT st_area('$geom') as area,st_astext(st_centroid('$geom')) as center,st_astext(st_centroid(st_transform('$geom'::GEOMETRY, 25833))) as utm,st_astext(st_centroid(st_transform('$geom'::GEOMETRY, 2398))) as gk4283,st_astext(st_centroid(st_transform('$geom'::GEOMETRY, 31468))) as rd83,st_astext(st_centroid(st_transform('$geom'::GEOMETRY, 4326))) as geo,st_perimeter('$geom'::GEOMETRY) as umfang,box('$geom'::GEOMETRY) as box";
 $result = $dbqueryp($connectp,$query);
 $r = $fetcharrayp($result);
 
 $area=$r["area"];
 $rd83 = $r["rd83"];
 $utm = $r["utm"];
 $geo = $r["geo"];
 $umfang = $r["umfang"];
 $s4283 = $r["gk4283"];
 $boxstring = $r["box"];
 $klammern=array("(",")");
 $boxstring = str_replace($klammern,"",$boxstring);
 $koordinaten = explode(",",$boxstring);
 $rechts_range = $koordinaten[0]-$koordinaten[2];
 $rechts = $koordinaten[2]+($rechts_range/2);
 $hoch_range = $koordinaten[1]-$koordinaten[3];
 $hoch = $koordinaten[3]+($hoch_range/2);
 $range = $hoch_range;
 if ($rechts_range > $hoch_range) $range=$rechts_range;
 
 $html=' <table border=0>
			<tr height="35">
				<td bgcolor='.HEADER_FARBE.' align=center valign=center width="350"><b><font size="+1" color=white>Geodätisches...</font></b></td>
									</tr>
									<tr>
										<td bgcolor='.HEADER_FARBE.' align=center valign=center width="350"><font color=white>Zentrum Position</font></td>
									</tr>
									<tr>
										<td>
											<table border="0" rules="none" width="100%">
												<tr>									
													<td colspan=2 align=center bgcolor='.ELEMENT_FARBE.'>Gauß-Krüger<br>S42/83 3&deg; 4-Streifen<br>Krassowski</td>
													<td colspan=2 align=center bgcolor='.ELEMENT_FARBE.'>Gauß-Krüger<br>RD/83 3&deg; 4-Streifen<br>Bessel</td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;'.get_s4283coordinates_lon($s4283).'</b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;'.get_rd83coordinates_lon($rd83).'</b></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;'.get_s4283coordinates_lat($s4283).'</b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;'.get_rd83coordinates_lat($rd83).'</b></td>
												</tr>												
												<tr>
													<td colspan=2 align=center bgcolor='.ELEMENT_FARBE.'>WGS84<br>(geografisch)</td>
													<td colspan=2 align=center bgcolor='.ELEMENT_FARBE.'>UTM<br>ETRS89 6&deg; Zone-33<br>GRS80</td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;östl. L.:</td>
													<td><b>&nbsp;&nbsp;'.get_geocoordinates_long($geo).'</b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;'.get_utmcoordinates_lon($utm).'</b></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;nördl. Br.:</td>
													<td><b>&nbsp;&nbsp;'.get_geocoordinates_lat($geo).'</b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;'.get_utmcoordinates_lat($utm).'</b></td>
												</tr>																							
											</table>
										</td>
									</tr>
									<tr>
										<td bgcolor='.HEADER_FARBE.' align=center valign=center width="350"><font color=white>Flächenangaben</font></td>
									</tr>
									<tr>
										<td>
											<table border="0" rules="none" width="100%">
												<tr bgcolor='.ELEMENT_FARBE.'>
													<td align=center>&nbsp;&nbsp;Fläche:</td>													
													<td align=center>&nbsp;&nbsp;Grenzlänge:</td>
												</tr>
												<tr>
													<td align=center><b>&nbsp;';
														 
														   if ($area > 10000) 
																{$area=$area/10000;
																	//$area = str_replace(".",",",$area);
																	$area2 = explode(".",$area);
																	$area3 = $area2[0];
																	$html=$html.$area3." ha"; 
																} 
															else 
																{
																	$area2 = explode(".",$area);
																	$area3 = $area2[0];
																	$html=$html.$area3." m²";
																}
														$html=$html.'</b>
													</td>
													<td align=center><b>&nbsp;&nbsp;'.get_umfang($umfang).' m<b></td>
												</tr>
												<tr bgcolor='.ELEMENT_FARBE.'>
													<td align=center>&nbsp;&nbsp;Nord-Süd<br>&nbsp;&nbsp;Ausdehnung:</td>
													<td align=center>&nbsp;&nbsp;Ost-West<br>&nbsp;&nbsp;Ausdehnung:</td>
												</tr>
												<tr>
													<td align=center><b>&nbsp;&nbsp;'.round($hoch_range,2).' m</b></td>													
													<td align=center><b>&nbsp;&nbsp;'.round($rechts_range,2).' m</b></td>
												</tr>												
											</table>
										</td>
									</tr>
								</table>';

 return $html;
 }
 
function geo_punkt($geom,$connectp,$dbqueryp,$fetcharrayp)
 {
 $query="SELECT st_astext(st_centroid('$geom')) as center,st_astext(st_centroid(st_transform('$geom'::GEOMETRY, 25833))) as utm,st_astext(st_centroid(st_transform('$geom'::GEOMETRY, 2398))) as gk4283,st_astext(st_centroid(st_transform('$geom'::GEOMETRY, 31468))) as rd83,st_astext(st_centroid(st_transform('$geom'::GEOMETRY, 4326))) as geo";
 $result = $dbqueryp($connectp,$query);
 $r = $fetcharrayp($result);
  
 $rd83 = $r[rd83];
 $utm = $r[utm];
 $geo = $r[geo];
 $s4283 = $r[gk4283];
 
 $html=' <table border=0>
			<tr height="35">
				<td bgcolor='.HEADER_FARBE.' align=center valign=center width="350"><b><font size="+1" color=white>Geodätisches...</font></b></td>
									</tr>
									<tr>
										<td bgcolor='.HEADER_FARBE.' align=center valign=center width="350"><font color=white>Zentrum Position</font></td>
									</tr>
									<tr>
										<td>
											<table border="0" rules="none" width="100%">
												<tr>									
													<td colspan=2 align=center bgcolor='.ELEMENT_FARBE.'>Gauß-Krüger<br>S42/83 3&deg; 4-Streifen<br>Krassowski</td>
													<td colspan=2 align=center bgcolor='.ELEMENT_FARBE.'>Gauß-Krüger<br>RD/83 3&deg; 4-Streifen<br>Bessel</td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;'.get_s4283coordinates_lon($s4283).'</b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;'.get_rd83coordinates_lon($rd83).'</b></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;'.get_s4283coordinates_lat($s4283).'</b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;'.get_rd83coordinates_lat($rd83).'</b></td>
												</tr>												
												<tr>
													<td colspan=2 align=center bgcolor='.ELEMENT_FARBE.'>WGS84<br>(geografisch)</td>
													<td colspan=2 align=center bgcolor='.ELEMENT_FARBE.'>UTM<br>ETRS89 6&deg; Zone-33<br>GRS80</td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;östl. L.:</td>
													<td><b>&nbsp;&nbsp;'.get_geocoordinates_long($geo).'</b></td>
													<td>&nbsp;&nbsp;Rechtswert:</td>
													<td><b>&nbsp;&nbsp;'.get_utmcoordinates_lon($utm).'</b></td>
												</tr>
												<tr>
													<td>&nbsp;&nbsp;nördl. Br.:</td>
													<td><b>&nbsp;&nbsp;'.get_geocoordinates_lat($geo).'</b></td>
													<td>&nbsp;&nbsp;Hochwert:</td>
													<td><b>&nbsp;&nbsp;'.get_utmcoordinates_lat($utm).'</b></td>
												</tr>																							
											</table>
										</td>
									</tr>
									</table>';
									
 return $html;
 }
 
function div_navigation()
  {
    $html='<div id="navigation">
						<table border="0" align="left">
							<tr>
								<td>
									<script type="text/javascript" language="JavaScript1.2" src="menu_msp_i.js"></script>
								</td>
							</tr>
						</table>
					</div>';
	return $html;
  }
  
function div_extra()
  {
    $html=" <div id=\"extra\">
	        <table border='0' width='100%'>
			<tr>
				<td align='right'><b>
					<font size='-1'><a href=\"javascript:ajaxpage('includes/kontakt.php', 'content')\">Kontakt</a>
					&nbsp;|&nbsp;".
					//<a href=\"javascript:ajaxpage('sitemap.php', 'content')\">Sitemap</a>
					//&nbsp;|&nbsp;
					"<a href=\"javascript:ajaxpage('includes/impressum.php', 'content')\">Impressum</a>
					&nbsp;|&nbsp;
					<a href=../geoportal/lizenzen/AfGVK_AGNB_2016_MSE.pdf target='_blank'\">Nutzungsbedingungen</a>
					&nbsp;|&nbsp;
					&copy;Landkreis Mecklenburgische Seenplatte&nbsp;&nbsp;
				</b></td>
			</tr>
		  </table>
		  </div>";
	return $html;
   }
   
function div_footer()
  {
    $html='<div id="footer">
	       </div>';
	return $html;
  }
  
?>

