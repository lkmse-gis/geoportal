<?php

		$schul_id=$_GET["schul_id"];

		$query="SELECT st_box(st_buffer(b.wkb_geometry,200)) as bounding_box
				FROM education.schulen as a, address_registry.adresstabelle as b
				WHERE a.schul_id='$schul_id'
				AND a.stichtag = '2016-09-30'
				AND a.adressschluessel=b.adressschluessel";
		$result = $dbqueryp($connectp,$query);
			$r = $fetcharrayp($result);
				
				$box = $r[bounding_box];				
				$klammer = array("(",")");
				$box2 = str_replace($klammer,"",$box);
				$array = explode(",",$box2);
				$a0 = $array[0];
				$a1 = $array[1];
				$a2 = $array[2];
				$a3 = $array[3];

				$x=$a0 - $a2;
				$y=$a1 - $a3;

				if ($x>$y) 
					{
						$diff=$x-$y;
						$hoch_neu=$a1+$diff;
						$bbox_2016=$a2.",".$a3.",".$a0.",".$hoch_neu;
					}
				else 
					{
						$diff=$y-$x;
						$rechts_neu=$a0+$diff;
						$bbox_2016=$a2.",".$a3.",".$rechts_neu.",".$a1;
					};
?>
<table>
	<tr>
		<td>Karte DOP20</td>
		<td>Karte ORKA</td>
	</tr>
	<td>
		<?php echo "<img  class=\"img-thumbnail\" align='center' width='500' height='500' src=\"http://www.geoport-lk-mse.de/webservices/wms/schulen_sep_wms?REQUEST=GetMap&VERSION=1.1.1&SERVICE=WMS&LAYERS=DOP20,Schulen 2016&BBOX=$bbox_2016&SRS=EPSG:25833&FORMAT=image/png&WIDTH=500&HEIGHT=500\">"; ?>
	</td>
	<td>
		<?php echo "<img  class=\"img-thumbnail\" align='center' width='500' height='500' src=\"http://www.geoport-lk-mse.de/webservices/wms/schulen_sep_wms?REQUEST=GetMap&VERSION=1.1.1&SERVICE=WMS&LAYERS=ORKA,Schulen 2016&BBOX=$bbox_2016&SRS=EPSG:25833&FORMAT=image/png&WIDTH=500&HEIGHT=500\">"; ?>
	</td>
</table>