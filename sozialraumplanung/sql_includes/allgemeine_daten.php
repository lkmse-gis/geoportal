<?php
	  $query="SELECT name,amtsvorsteher,round(CAST((area(the_geom)/1000000) AS NUMERIC),2) as flaeche
				FROM fd_amtsbereiche
				WHERE CAST(amts_sf AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtsvorsteher = $r[amtsvorsteher];
	  $flaeche = $r[flaeche];
	  $amtsname = $r[name];
?>	