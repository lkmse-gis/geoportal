<?php

//Kopf der Dateien
function head_portal()
{
	$datum = getdate(time());
    $year=$datum[year];
    $month=$datum[mon];
    $day=$datum[mday];
    $wday=$datum[wday];
    if ($wday=='0') $wochentag="Sonntag";
    if ($wday=='1') $wochentag="Montag";
    if ($wday=='2') $wochentag="Dienstag";
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
<table border='0' cellpadding='0' cellspacing='0' width=100%><tr><td><img src=\"images/geologo_5.jpg\" width=1200></td></tr></table>
</div>
<div style='width: 100%; background-color: #50aa19; height: 3px'><img src='images/trennlinie.gif' height='0' width='0'></div>
<table bgcolor='#3264af' border='0' width=100%>
<tr style=\"color: #ffffff; font-family:Arial; font-size: 11pt; font-weight: bold\">
<td width=200>";

echo "<form name='form1' method='get' action='suche.php'><input onfocus=\"if(this.value=='Suchbegriff eingeben')this.value='';\" type='text' name='suche' value='Suchbegriff eingeben' size='30'>";
echo "</td>
<td width=150><input type='image' src='buttons/lupe.gif' value='Suche' width='19'></form></td>
<td width=250><a href=\"https://geoport-lk-mse.de/kvwmapmsp\" target=\"_blank\" onclick=\"window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,');return false;\"><img src='buttons/kvwmap_button.gif' border=0></a></td>
<td width=120 align='left'><a href=\"https://geoport-lk-mse.de/kvwmapmsp/index.php?gast=50\" target=\"_blank\" onclick=\"window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,');return false;\"><img src='buttons/buergerportal_button.gif' border=0></a></td>
<td width=300 align='left'>".
//<b>Neue Themen: <font color='darkblue'>Taxiunternehmen</font></b> (Tourismus), 
//<font color='darkblue'>Landschaftsschutzgebiete</font></b> (Natur/Umwelt), 
//<font color='darkblue'>Fauna Flora Habitat Gebiete</font></b> (Natur/Umwelt), 
//<font color='darkblue'>Naturschutzgebiete</font></b> (Natur/Umwelt),
//<font color='darkblue'>Fussballpl&auml;tze</font></b> (Sport/Freizeit)</marquee>
"</td>
<td>&nbsp;&nbsp;".$wochentag."&nbsp;&nbsp;".$print_datum."&nbsp;&nbsp;<span id='zeit'></span></td>
</tr>
</table>
<div style='width: 100%; background-color: #50aa19; height: 3px'><img src='images/trennlinie.gif' height='0' width='0'></div>";

}

//Kopf für die Trefferliste
function head_trefferliste($i,$spalten,$header_farbe)
{
 echo "<a name='liste'></a><tr><td colspan=$spalten align=\"center\" height=50 bgcolor=$header_farbe><b><font color='white'>	Ihre Suchanfrage lieferte  $i Treffer<br><small>Wählen Sie einen Eintrag aus der Liste um weitere Informationen zu erhalten.</font></td></tr>";
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
	  
	  $coord_string=$geo_grad."°&nbsp;". $geo_minute."'&nbsp;". $geo_sekunde."''<br>&nbsp;&nbsp;". $geo_lon."° ";
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

	  $coord_string=$geo_grad_lat."°&nbsp;". $geo_minute_lat3."'&nbsp;". $geo_sekunde_lat3."''<br>&nbsp;&nbsp;". $geo_lat."°" ;
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

	  $coord_string="33".$utm_lon ;
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

//Funktion zur Ermittlung der Aktualität der Themen
function get_aktualitaet($db_link,$thema_id)
{
  $query="SELECT aktualitaet FROM metadaten WHERE layer_id='$thema_id' ";
  
  $result=mysql_query($query);
  
  $r=mysql_fetch_array($result);
  $aktualitaet=$r[0];
  return $aktualitaet;
 }

//############ Globale Variablen #################################################### 
 
//allgemeine Mapdatei 
$map_url="\"../../cgi-bin/mapserv?map=/data/wms/mapdata.map&\"";
$map_msp_url="\"/cgi-bin/mapserv?map=/data/wms/msp.map&\"";
$borismap_url="\"../../cgi-bin/mapserv?map=/data/wms/boris_bau_msp.map&\"";			//BORIS Bauland
$boris_agr_map_url="\"../../cgi-bin/mapserv?map=/data/wms/boris_agr_msp.map&\"";			//BORIS Acker-/Grünland
$kunst_msp_url="\"../../cgi-bin/mapserv?map=/data/wms/kunst_msp.map&\"";
$offenes_denkmal_msp_url="\"../../cgi-bin/mapserv?map=/data/wms/offenes_denkmal_msp.map&\"";

//Datei für Feature Info
$featureinfo_url="../../cgi-bin/mapserv?map=/data/wms/mapdata.map";
$featureinfo_msp_url="../../cgi-bin/mapserv?map=/data/wms/msp.map";
$featureinfo_boris_bau_msp_url="../../cgi-bin/mapserv?map=/data/wms/boris_bau_msp.map";
$featureinfo_boris_agr_msp_url="../../cgi-bin/mapserv?map=/data/wms/boris_agr_msp.map";
$featureinfo_kunst_msp_url="../../cgi-bin/mapserv?map=/data/wms/kunst_msp.map";
$featureinfo_offenes_denkmal_msp_url="../../cgi-bin/mapserv?map=/data/wms/offenes_denkmal_msp.map";
$featureinfo_bevoelkerung_msp_url="../../cgi-bin/mapserv?map=/data/wms/bevoelkerung_msp.map";

//Kataster
$gemeindemap_url="\"../../cgi-bin/mapserv?map=/data/wms/gemeinden_msp.map&\""; 		//Gemeinden
$plzmap_url="\"../../cgi-bin/mapserv?map=/data/wms/plz_msp.map&\"";					//Postleitzahlbereiche
$regionmap_url="\"../../cgi-bin/mapserv?map=/data/wms/regionen_msp.map&\"";			//Regionen
$gemarkungmap_url="\"../../cgi-bin/mapserv?map=/data/wms/gemarkungen_msp.map&\"";	//Gemarkungen
$amtmap_url="\"../../cgi-bin/mapserv?map=/data/wms/aemter_msp.map&\"";				//Ämter
$dop_url="\"http://www.geodaten-mv.de/dienste/adv_dop\"";								//Luftbilder (Dienst)
$topo_url="\"http://www.geodaten-mv.de/dienste/gdimv_topomv\"";							//Topogafische Karte (Dienst)
#$osm_citymap_url="\"http://geo.sv.rostock.de/osm/mapproxy/ows\"";
$osm_citymap_url="\"http://geo.sv.rostock.de/geodienste/stadtplan/wms\"";
$dtk_url="\"http://www.geodaten-mv.de/dienste/gdimv_dtk\"";								//Topogafische Karte (Dienst)
$bevoelkerung_url="\"/cgi-bin/mapserv?map=/data/wms/bevoelkerung_msp.map&\"";					//Bevölkerungsgewichtung

//Umwelt
$spaflmap_url="\"../../cgi-bin/mapserv?map=/data/wms/spa_fl_msp.map&\"";				//Vogelschutzgebiete
$npamap_url="\"../../cgi-bin/mapserv?map=/data/wms/npa_msp.map&\"";					//Naturparke
$nlpmap_url="\"../../cgi-bin/mapserv?map=/data/wms/nlp_msp.map&\"";					//Nationalparke
$nsgmap_url="\"../../cgi-bin/mapserv?map=/data/wms/nsg_msp.map&\"";					//Naturschutzgebiete
$lsgmap_url="\"../../cgi-bin/mapserv?map=/data/wms/lsg_msp.map&\"";					//Landschaftsschutzgebiete
$geotopflmap_url="\"../../cgi-bin/mapserv?map=/data/wms/geotop_fl_msp.map&\"";		//Geotope
$nwgemap_url="\"../../cgi-bin/mapserv?map=/data/wms/nw_ge_msp.map&\"";				//natürliche Wälder Gebiete
$nwflmap_url="\"../../cgi-bin/mapserv?map=/data/wms/nw_fl_msp.map&\"";				//natürliche Wälder Einzelflächen
$ffhmap_url="\"../../cgi-bin/mapserv?map=/data/wms/ffh_fl_msp.map&\"";				//Fauna Flora Habitat

//Verkehr
$sbabmap_url="\"../../cgi-bin/mapserv?map=/data/wms/sbab_msp.map&\"";				//Straßenbauamtsbereiche
$sbmbmap_url="\"../../cgi-bin/mapserv?map=/data/wms/sbmb_msp.map&\"";				//Straßenmeistereibereiche

//Gesundheit
$arzt_url="\"../../cgi-bin/mapserv?map=/data/wms/arzt.map&\"";

//Open Layers Datei / Open Layers Style
$openlayers_url="\"../../OpenLayers/OpenLayers.js\"";
$olstyle_url="\"../../OpenLayers/theme/default/style.css\"";

//Copyright unter der Karte (Map)
$copyright="&copy; Landkreis Mecklenburgische Seenplatte&nbsp;| &nbsp;Kartendaten: &copy; GeoBasis-DE/M-V 2011&nbsp;";
$cr="&copy; Landkreis Mecklenburgische Seenplatte&nbsp;| &nbsp;Kartendaten: &copy; GeoBasis-DE/M-V 2011&nbsp;";

//Farben für Gestaltung
$header_farbe="#3264af";
$element_farbe="#d2e8ff";
$font_farbe="<font color=white><b>";
$font_farbe_end="</b></font>";
$link_farbe="<font color=white><i>";
$link_farbe_end="</i></font>";

//Bildpfad
$bildpfad="images/kvwmap/";


$ip=getenv('REMOTE_ADDR');

if ($ip != "192.168.101.18") $wms_url="http://gisweb/";
     else $wms_url="http://www.landkreis-mueritz.de/gis/";


function get_gemeinde_name($gem_schl,$connectp,$dbqueryp,$fetcharrayp)
 {
 $query="SELECT gemeinde FROM gemeinden WHERE gem_schl='$gem_schl'";
 $result = $dbqueryp($connectp,$query);
 $r = $fetcharrayp($result);
 return $r[gemeinde];
 }
 
 function get_gemarkung_name($gemkg_schl,$connectp,$dbqueryp,$fetcharrayp)
 {
 $query="SELECT gemkgname FROM alb_v_gemarkungen WHERE gemkgschl='$gemkg_schl'";
 $result = $dbqueryp($connectp,$query);
 $r = $fetcharrayp($result);
 return $r[0];
 }

?>