<?php
//---- Containerstellplätze -------	  
	  
	  $query="SELECT COUNT(fd_container.id)
				FROM fd_container,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_container.the_geom,2398));";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $container = $r[0];
	  
//---- Supermärkte -------	  
	  
	  $query="SELECT COUNT(fd_supermarkt.gid)
				FROM fd_supermarkt,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_supermarkt.the_geom,2398));";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $supermarkt = $r[0];

//---- Wertstoffhöfe -------	  
	  
	  $query="SELECT COUNT(fd_wertstoffhof.id)
				FROM fd_wertstoffhof,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_wertstoffhof.the_geom,2398));";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $wertstoffhof = $r[0];
	  
//---- Tankstellen -------	  
	  
	  $query="SELECT COUNT(fd_tankstellen.gid)
				FROM fd_tankstellen,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_tankstellen.the_geom,2398));";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $tankstellen = $r[0];

?>	