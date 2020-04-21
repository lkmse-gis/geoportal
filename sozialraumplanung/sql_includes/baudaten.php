<?php
//---- Baudenkmale -------	  
	  
	  $query="SELECT COUNT(fd_baudenkmal.gid)
				FROM fd_baudenkmal,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_baudenkmal.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $baudenkmale = $r[0];

//---- B-Pläne rechtskrätig -------	  
	  
	  $query="SELECT COUNT(fd_vblp5.gid)
				FROM fd_vblp5,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_vblp5.stand_verfahren LIKE 'rechtskräftig'
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_vblp5.the_geom,2398))";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bplan_rk = $r[0];

//---- B-Pläne im Verfahren -------	  
	  
	  $query="SELECT COUNT(fd_vblp5.gid)
				FROM fd_vblp5,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_vblp5.stand_verfahren LIKE 'im Verfahren'
				AND st_intersects(fd_amtsbereiche.the_geom,fd_vblp5.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bplan_iv = $r[0];
	  
//---- B-Pläne Verfahren eingestellt -------	  
	  
	  $query="SELECT COUNT(fd_vblp5.gid)
				FROM fd_vblp5,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_vblp5.stand_verfahren LIKE 'Verfahren eingestellt'
				AND st_intersects(fd_amtsbereiche.the_geom,fd_vblp5.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bplan_ve = $r[0];

//---- B-Pläne Plan aufgehoben -------	  
	  
	  $query="SELECT COUNT(fd_vblp5.gid)
				FROM fd_vblp5,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_vblp5.stand_verfahren LIKE 'Plan aufgehoben'
				AND st_intersects(fd_amtsbereiche.the_geom,fd_vblp5.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bplan_pa = $r[0];	  
?>	