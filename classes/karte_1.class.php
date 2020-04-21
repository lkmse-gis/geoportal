<?php
  class karte_1
   {
    private $lon = 0;
    private $lat = 0;
	private $zoom = 0;
	private $beschriftung = '';
	private $layer = '';
	private $plz='';
	private $orts_teile='';
	private $orka_url = '"http://www.orka-mv.de/geodienste/orkamv/wms"';
	private $dtk_url = '"http://www.geodaten-mv.de/dienste/gdimv_dtk"';
	private $webatlas_url = '"http://www.geodaten-mv.de/dienste/webatlasde_wms/service"';
	private $dop_url = '"http://www.geodaten-mv.de/dienste/adv_dop20"';
	private $map_mse_url = '"/cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map&"';
	private $featureinfo_mse_url = '../cgi-bin/mapserv?map=/var/www/dienste/wms/int_geoportal_mse_wms.map';
	private $openlayers_url='"../openlayers/OpenLayers.js"';
    private $olstyle_url='"../openlayers/theme/default/style.css"';

	
   function zeigeKarteLonLat($lon,$lat,$zoom,$width,$height,$beschriftung,$layer)
    {
     $html="
	        <style type=\"text/css\">
			   #map {
					width: ".$width."px;
					height: ".$height."px;
					border: 1px solid black;
				}
			</style>
			<script src=$this->openlayers_url type=\"text/javascript\" language=\"Javascript\"></script>
			<link rel=\"stylesheet\" href=$this->olstyles_url type=\"text/css\" />
		    <script type=\"text/javascript\" language=\"Javascript\">
			var lon = $lon
			var lat = $lat
			var zoom = $zoom;

			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: 'map',
					projection: 'EPSG:25833',
					scales: [750000,700000,650000,600000,550000,500000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,500],
					maxExtent:  new OpenLayers.Bounds(296166,5891077,431881,5986576),
					units: 'm'
				});				
				
				var orka = new OpenLayers.Layer.WMS.Untiled(\"ORKA M-V\",
					 $this->orka_url,
					{'layers': 'orkamv-gesamt', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var orka_grau = new OpenLayers.Layer.WMS.Untiled(\"ORKA M-V (Graustufen)\",
					 $this->orka_url,
					{'layers': 'orkamv-graustufen', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var dtkmv = new OpenLayers.Layer.WMS.Untiled(\"topografische Karte\",
					$this->dtk_url,
					{'layers': 'mv_dtk', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var webatlasde = new OpenLayers.Layer.WMS.Untiled(\"WebatlasDE\",
					$this->webatlas_url,
					{'layers': 'WebAtlasDE_MV_farbe', transparent: true, format: 'image/gif'},
					{isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled(\"Luftbild\",
									 $this->dop_url,
									{'layers': 'mv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var kreisgrenze = new OpenLayers.Layer.WMS.Untiled(\"Kreisgrenze\",
								  $this->map_mse_url,
								 {layers: 'Kreisgrenze_msp', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var gemeinden = new OpenLayers.Layer.WMS.Untiled(\"Gemeinden\",
								  $this->map_mse_url,
								 {layers: 'msp_outline_gem', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);";
				
				if ($basiskarte == 'orka') $html=$html."map.addLayers([orka,orka_grau,webatlasde,dtkmv,dop,kreisgrenze,thema]);";
				if ($basiskarte == 'webatlas') $html=$html."map.addLayers([webatlasde,orka,orka_grau,dtkmv,dop,kreisgrenze,thema]);";
				if ($basiskarte == 'dtk') $html=$html."map.addLayers([dtkmv,webatlasde,orka,orka_grau,dop,kreisgrenze,thema]);";
				if ($basiskarte == 'dop') $html=$html."map.addLayers([dop,webatlasde,orka,orka_grau,dtkmv,kreisgrenze,thema]);";
				
				$html=$html."
				    info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [thema],
					url: '$this->featureinfo_mse_url',
					title: 'Identify features by clicking',
					queryVisible: true,
					eventListeners: {
						getfeatureinfo: function(event) {
							map.addPopup(new OpenLayers.Popup.FramedCloud(
								'chicken',
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

				map.addControl(new OpenLayers.Control.LayerSwitcher({'ascending':false}));
				
				map.addControl(new OpenLayers.Control.Permalink());
				map.addControl(new OpenLayers.Control.OverviewMap({'ascending':false}));
				//var om = map.getControlsByClass('OpenLayers.Control.OverviewMap')[0];
				//om.maximizeControl();
				map.addControl(new OpenLayers.Control.MousePosition());
				var lonLat = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection('EPSG:25833'), map.getProjectionObject());
				map.setCenter(lonLat,zoom);
				map.zoomToMaxExtent();
			}";	
			return $html;
    }
		
    function zeigeKarteBox($box,$width,$height,$basiskarte,$landkreis,$aemter,$gemeinden,$gemarkungen,$adressen,$plz,$orts_teile,$pflegestuetzp,$beschriftung,$layer)
    {
	 $klammern=array("(",")");
	 $box = str_replace($klammern,"",$box);
	 
	 $boxkoordinaten=explode(',',$box);
	 $left=$boxkoordinaten[2];
	 $bottom=$boxkoordinaten[3];
	 $right=$boxkoordinaten[0];
	 $top=$boxkoordinaten[1];
	 $boxextent=$left.",".$bottom.",".$right.",".$top;
	 
     $html="
	        <style type=\"text/css\">
			   #map {
					width: ".$width."px;
					height: ".$height."px;
					border: 1px solid black;
				}
			</style>
			<script src=$this->openlayers_url type=\"text/javascript\" language=\"Javascript\"></script>
			<link rel=\"stylesheet\" href=$this->olstyles_url type=\"text/css\" />
		    <script type=\"text/javascript\" language=\"Javascript\">
			var map, info;

			function load() {
				map = new OpenLayers.Map({
					div: 'map',
					projection: 'EPSG:25833',
					scales: [750000,700000,650000,600000,550000,500000,450000,400000,350000,250000,200000,150000,100000,75000,70000,65000,60000,55000,50000,45000,40000,35000,30000,25000,20000,15000,10000,5000,2500,1000,500],
					maxExtent:  new OpenLayers.Bounds(297581,5891784,435114,5987090),
					units: 'm'
				});
				
				var orka = new OpenLayers.Layer.WMS.Untiled(\"ORKA M-V\",
					 $this->orka_url,
					{'layers': 'orkamv', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var orka_grau = new OpenLayers.Layer.WMS.Untiled(\"ORKA M-V (Graustufen)\",
					 $this->orka_url,
					{'layers': 'orkamv-graustufen', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var dtkmv = new OpenLayers.Layer.WMS.Untiled(\"topografische Karte\",
					$this->dtk_url,
					{'layers': 'mv_dtk', transparent: true, format: 'image/png'},
					{isBaseLayer: true}
				);
				
				var webatlasde = new OpenLayers.Layer.WMS.Untiled(\"WebatlasDE\",
					$this->webatlas_url,
					{'layers': 'WebAtlasDE_MV_farbe', transparent: true, format: 'image/gif'},
					{isBaseLayer: true}
				);

				 var dop = new OpenLayers.Layer.WMS.Untiled(\"Luftbild\",
									 $this->dop_url,
									{'layers': 'mv_dop', transparent: true, format: 'image/png'},
									{isBaseLayer: true}
				);
				
				var kreisgrenze = new OpenLayers.Layer.WMS.Untiled(\"Kreisgrenze\",
								  $this->map_mse_url,
								 {layers: 'Kreisgrenze_msp', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var amtsbereiche = new OpenLayers.Layer.WMS.Untiled(\"Amtsbereiche\",
								  $this->map_mse_url,
								 {layers: 'aemter_msp_outline', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var gemeinden = new OpenLayers.Layer.WMS.Untiled(\"Gemeinden\",
								  $this->map_mse_url,
								 {layers: 'msp_outline_gem', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var gemarkungen = new OpenLayers.Layer.WMS.Untiled(\"Gemarkungen\",
								  $this->map_mse_url,
								 {layers: 'msp_outline_gemkg', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var adressen = new OpenLayers.Layer.WMS.Untiled(\"Adressen\",
								  $this->map_mse_url,
								 {layers: 'Adress_Geometrie', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				var orts_teile = new OpenLayers.Layer.WMS.Untiled(\"Ortsteile\",
								  $this->map_mse_url,
								 {layers: 'Ortsteile_lt_rka', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				var plz = new OpenLayers.Layer.WMS.Untiled(\"Postleitzahlbereiche\",
								  $this->map_mse_url,
								 {layers: 'Postleitzahlbereiche', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				var pflegestuetzpunkte = new OpenLayers.Layer.WMS.Untiled(\"Pflegestützpunkte\",
								  $this->map_mse_url,
								 {layers: 'pflegestuetzpunkte', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				
				var thema = new OpenLayers.Layer.WMS.Untiled(\"$beschriftung\",
								  $this->map_mse_url,
								 {layers: '$layer', transparent: true, format: 'image/png'},
								 {isBaseLayer: false}
				);
				";

				if ($basiskarte == 'orka') $html=$html."map.addLayers([orka,orka_grau,webatlasde,dtkmv,dop";
				if ($basiskarte == 'orka_grau') $html=$html."map.addLayers([orka_grau,orka,webatlasde,dtkmv,dop";
				if ($basiskarte == 'webatlas') $html=$html."map.addLayers([webatlasde,orka,orka_grau,dtkmv,dop";
				if ($basiskarte == 'dtk') $html=$html."map.addLayers([dtkmv,webatlasde,orkaorka_grau,dop";
				if ($basiskarte == 'dop') $html=$html."map.addLayers([dop,webatlasde,orka,orka_grau,dtkmv";
				
				
				if ($adressen == '1') $html=$html.",adressen";
				if ($gemarkungen == '1') $html=$html.",gemarkungen";
				if ($gemeinden == '1') $html=$html.",gemeinden";
				if ($aemter == '1') $html=$html.",amtsbereiche";
				if ($landkreis == '1') $html=$html.",kreisgrenze";
				if ($plz == '1') $html=$html.",plz";
				if ($orts_teile == '1') $html=$html.",orts_teile";
				if ($pflegestuetzp == '1') $html=$html.",pflegestuetzpunkte";
				
				$html=$html.",thema]);";
				
				$html=$html."
				info = new OpenLayers.Control.WMSGetFeatureInfo({
					layers: [thema";
					if ($gemeinden == '1') $html=$html.",gemeinden";
					$html=$html."],
					url: '$this->featureinfo_mse_url',
					title: 'Identify features by clicking',
					queryVisible: true,
					eventListeners: {
						getfeatureinfo: function(event) {
							map.addPopup(new OpenLayers.Popup.FramedCloud(
								'chicken',
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

				map.addControl(new OpenLayers.Control.LayerSwitcher({'ascending':false}));
				map.addControl(new OpenLayers.Control.Permalink());
				map.addControl(new OpenLayers.Control.OverviewMap({'ascending':false}));
				map.addControl(new OpenLayers.Control.MousePosition());
				var extent = new OpenLayers.Bounds($boxextent);
				map.zoomToExtent(extent,true);
				
			}
			</script>";	
			return $html;
    }
	
   }
?>