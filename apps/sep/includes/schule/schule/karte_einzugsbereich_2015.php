<table>
	<tr>
		<?php

			$schul_id=$_GET["schul_id"];
			
				$query="SELECT gid, bereich, schultyp, st_box(st_buffer(the_geom,500)), stichtag
						FROM education.schuleinzugsbereiche
						WHERE '$schul_id' = ANY(schul_id)
						AND stichtag = '2015-09-30'";
				$result = $dbqueryp($connectp,$query);
					$i=0;
				while($r = $fetcharrayp($result))
					{
						$seb[$i]=$r;
						$i++;
						$count=$i;	
					};	
					
					
				 for($a=0;$a<$i;$a++)
					{			
						echo "<td>Schuleizugsbereich ".$seb[$a][1]." mit dem Schultyp ".$seb[$a][2].", Stichtag ".$seb[$a][4]."</td>";					
					}	
		?>
	</tr>
	<tr>
		<?
			for($a=0;$a<$i;$a++){ 
						$layer = $seb[$a][0];
						$box = $seb[$a][3];				
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
								$abox=$a2.",".$a3.",".$a0.",".$hoch_neu;
							}
						else 
							{
								$diff=$y-$x;
								$rechts_neu=$a0+$diff;
								$abox=$a2.",".$a3.",".$rechts_neu.",".$a1;
							};
			
					echo "<td><img  class=\"img-thumbnail\" align='center' width='500' height='500' src=\"http://www.geoport-lk-mse.de/cgi-bin/mapserv?map=/var/www/wms/protected/seb.map&REQUEST=GetMap&VERSION=1.1.1&SERVICE=WMS&LAYERS=ORKA,$layer&BBOX=$abox&SRS=EPSG:25833&FORMAT=image/png&WIDTH=500&HEIGHT=500\"></td>";
			
		} ?>
	</tr>
</table>