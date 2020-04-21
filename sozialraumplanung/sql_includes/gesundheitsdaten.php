<?php
//---- Apotheken -------	  
	  
	  $query="SELECT COUNT(fd_apotheken.gid)
				FROM fd_apotheken,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_apotheken.the_geom,2398));";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $apotheken = $r[0];
	  
//---- Krankenhäuser -------	  
	  
	  $query="SELECT COUNT(fd_klinik.gid)
				FROM fd_klinik,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_klinik.the_geom,2398));";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $klinik = $r[0];

?>	