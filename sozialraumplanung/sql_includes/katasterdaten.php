<?php
//---- Gemarkungen -------	  
	  
	  $query="SELECT COUNT(gemarkung.gid)
				FROM gemarkung,gemeinden
				WHERE CAST(gemarkung.gemeinde AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemarkungen = $r[0];

//---- Gemeinden -------	  
	  
	  $query="SELECT COUNT(gemeinden.gid)
				FROM gemeinden
				WHERE CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gemeinden = $r[0];

//---- Fluren -------	  
	  
	  $query="SELECT COUNT(alknflur.objnr)
				FROM gemarkung,gemeinden,alknflur
				WHERE CAST(alknflur.gemkgschl AS INTEGER) = CAST(gemarkung.geographicidentifier AS INTEGER)
				AND CAST(gemarkung.gemeinde AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $fluren = $r[0];
	  
//---- Flurstücke -------	  
	  
	  $query="SELECT COUNT(alknflst.objnr)
				FROM gemarkung,gemeinden,alknflst
				WHERE CAST(alknflst.gemkgschl AS INTEGER) = CAST(gemarkung.geographicidentifier AS INTEGER)
				AND CAST(gemarkung.gemeinde AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $flurstuecke = $r[0];
	  
//---- Mittelpunkt -------	  
	  
	  $query="SELECT st_astext(st_transform(st_centroid(the_geom), 4326)) AS mittelpunkt
				FROM fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $geo = $r[mittelpunkt];
	  $geo2 = trim($geo,"POINT(");
	  $geo3 = trim($geo2,")");
	  $geo4 = explode(" ",$geo3);
	  $geo_lon = substr($geo4[0],0,7);
	  $geo_grad = substr($geo4[0],0,2);
	  $geo_minute_berechnung = $geo_lon-$geo_grad;
	  $geo_minute_berechnung1 = $geo_minute_berechnung*60;
	  $geo_minute_berechnung2 = explode(".",$geo_minute_berechnung1);
	  $geo_minute = $geo_minute_berechnung2[0];
	  $geo_sekunde_berechnung = $geo_minute_berechnung1-$geo_minute;
	  $geo_sekunde_berechnung1 = $geo_sekunde_berechnung*60;
	  $geo_sekunde_berechnung2 = explode(".",$geo_sekunde_berechnung1);
	  $geo_sekunde = $geo_sekunde_berechnung2[0];
	  $geo_lat = substr($geo4[1],0,7);
	  $geo_grad_lat = substr($geo4[1],0,2);
	  $geo_minute_lat = $geo_lat-$geo_grad_lat;
	  $geo_minute_lat1 = $geo_minute_lat*60;
	  $geo_minute_lat2 = explode(".",$geo_minute_lat1);
	  $geo_minute_lat3 = $geo_minute_lat2[0];
	  $geo_sekunde_lat = $geo_minute_lat1-$geo_minute_lat3;
	  $geo_sekunde_lat1 = $geo_sekunde_lat*60;
	  $geo_sekunde_lat2 = explode(".",$geo_sekunde_lat1);
	  $geo_sekunde_lat3 = $geo_sekunde_lat2[0];
	  $mittelpunkt=$geo_grad."°&nbsp;". $geo_minute."'&nbsp;". $geo_sekunde."'' östl.Länge<br>".$geo_grad_lat."°&nbsp;". $geo_minute_lat3."'&nbsp;". $geo_sekunde_lat3."'' nördl.Breite";
	  
//---- Grenzlänge -------	  
	  
	  $query="SELECT trunc(CAST(st_perimeter(fd_amtsbereiche.the_geom) AS NUMERIC)/(1000),2) AS grenzlaenge
				FROM fd_amtsbereiche
				WHERE CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $grenzlaenge = $r[0];
?>	