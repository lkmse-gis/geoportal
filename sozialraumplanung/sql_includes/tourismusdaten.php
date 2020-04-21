<?php
//---- Badestellen -------	  
	  
	  $query="SELECT COUNT(fd_badestellen.gid)
				FROM fd_badestellen,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_badestellen.the_geom,2398));";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $badestellen = $r[0];
	  
//---- Kirchen -------	  
	  
	  $query="SELECT COUNT(fd_kirchen.gid)
				FROM fd_kirchen,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kirchen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kirchen = $r[0];

//---- Tourist-Informationen -------	  
	  
	  $query="SELECT COUNT(fd_tourismusinfostellen.gid)
				FROM fd_tourismusinfostellen,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_tourismusinfostellen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $touristinfos = $r[0];

?>	