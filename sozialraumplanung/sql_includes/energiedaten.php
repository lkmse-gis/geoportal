<?php
//---- Solaranlagen -------	  
	  
	  $query="SELECT COUNT(fd_solaranlagen.gid)
				FROM fd_solaranlagen,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_solaranlagen.the_geom,2398));";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $solaranlagen = $r[0];
	  
//---- Bioenergieanlagen -------	  
	  
	  $query="SELECT COUNT(fd_bioenergieanlagen.gid)
				FROM fd_bioenergieanlagen,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_bioenergieanlagen.the_geom,2398));";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bioenergieanlagen = $r[0];

//---- Umspannwerke -------	  
	  
	  $query="SELECT COUNT(fd_umspannwerke.gid)
				FROM fd_umspannwerke,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_umspannwerke.the_geom,2398));";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $umspannwerke = $r[0];

?>	