<?php
//---- Schutzpolizei -------	  
	  
	  $query="SELECT COUNT(fd_polizei.gid)
				FROM fd_polizei,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_polizei.art='Schutzpolizei'
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_polizei.the_geom,2398))";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $schutzpolizei = $r[0];
	  
//---- Wasserschutzpolizei -------	  
	  
	  $query="SELECT COUNT(fd_polizei.gid)
				FROM fd_polizei,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_polizei.art='Wasserschutzpolizei'
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_polizei.the_geom,2398))";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $wasserschutzpolizei = $r[0];

//---- Kriminalpolizei -------	  
	  
	  $query="SELECT COUNT(fd_polizei.gid)
				FROM fd_polizei,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_polizei.art='Kriminalpolizei'
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_polizei.the_geom,2398))";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kriminalpolizei = $r[0];
	  
//---- Schwerpunktfeuerwehr -------	  
	  
	  $query="SELECT COUNT(fd_feuerwehr.gid)
				FROM fd_feuerwehr,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_feuerwehr.typ='Schwerpunkt-FW'
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_feuerwehr.the_geom,2398))";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $schwerpunktfw = $r[0];
	  
//---- Stützpunktfeuerwehr -------	  
	  
	  $query="SELECT COUNT(fd_feuerwehr.gid)
				FROM fd_feuerwehr,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_feuerwehr.typ='Stützpunkt-FW'
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_feuerwehr.the_geom,2398))";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $stuetzpunktfw = $r[0];

//---- Feuerwehr mit Grundausstattung -------	  
	  
	  $query="SELECT COUNT(fd_feuerwehr.gid)
				FROM fd_feuerwehr,fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_feuerwehr.typ='FW m. Grundausstattung'
				AND st_intersects(fd_amtsbereiche.the_geom,st_transform(fd_feuerwehr.the_geom,2398))";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $fwmgrund = $r[0];
?>	