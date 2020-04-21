<?php
//---- Gesamt Schulen -------	  
	  
	  $query="SELECT COUNT(fd_schulen.gid)
				FROM fd_schulen,fd_kreis
				WHERE st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $schulen = $r[0];
	  
//---- Schülerzahlen-------	  
	  
	  $query="SELECT sum(CAST(fd_schulen.schülerzah AS INTEGER))
				FROM fd_schulen,fd_kreis
				WHERE st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $schulen_sz = $r[0];

//---- Grundschulen -------	  
	  
	  $query="SELECT COUNT(fd_schulen.gid)
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=2 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $grundschulen = $r[0];
	  
//---- Grundschulen Schülerzahlen-------	  
	  
	  $query="SELECT sum(CAST(fd_schulen.schülerzah AS INTEGER))
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=2 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $grundschulen_sz = $r[0];

//---- Regionalschulen -------	  
	  
	  $query="SELECT COUNT(fd_schulen.gid)
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=6 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $regionalschulen = $r[0];
	  
//---- Regionalschulen Schülerzahlen-------	  
	  
	  $query="SELECT sum(CAST(fd_schulen.schülerzah AS INTEGER))
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=6 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $regionalschulen_sz = $r[0];
	  
//---- Gymnasien -------	  
	  
	  $query="SELECT COUNT(fd_schulen.gid)
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=4 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gymnasien = $r[0];
	  
//---- Gymnasien Schülerzahlen-------	  
	  
	  $query="SELECT sum(CAST(fd_schulen.schülerzah AS INTEGER))
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=4 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gymnasien_sz = $r[0];
	  
//---- Berufsschulen -------	  
	  
	  $query="SELECT COUNT(fd_schulen.gid)
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=7 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $berufsschulen = $r[0];
	  
//---- Berufsschulen Schülerzahlen-------	  
	  
	  $query="SELECT sum(CAST(fd_schulen.schülerzah AS INTEGER))
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=7 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $berufsschulen_sz = $r[0];
	  
//---- IGS -------	  
	  
	  $query="SELECT COUNT(fd_schulen.gid)
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=8 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $igs = $r[0];
	  
//---- IGS Schülerzahlen-------	  
	  
	  $query="SELECT sum(CAST(fd_schulen.schülerzah AS INTEGER))
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=8
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $igs_sz = $r[0];
	  
//---- KVHS -------	  
	  
	  $query="SELECT COUNT(fd_schulen.gid)
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=10 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kvhs = $r[0];
	  
//---- KVHS Schülerzahlen-------	  
	  
	  $query="SELECT sum(CAST(fd_schulen.schülerzah AS INTEGER))
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=10
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kvhs_sz = $r[0];

//---- Musikschulen -------	  
	  
	  $query="SELECT COUNT(fd_schulen.gid)
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=11 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $ms = $r[0];
	  
//---- Musikschulen Schülerzahlen-------	  
	  
	  $query="SELECT sum(CAST(fd_schulen.schülerzah AS INTEGER))
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=11
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $ms_sz = $r[0];
	  
//---- Förderschulen -------	  
	  
	  $query="SELECT COUNT(fd_schulen.gid)
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=1 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $foerderschulen = $r[0];
	  
//---- Förderschulen Schülerzahlen-------	  
	  
	  $query="SELECT sum(CAST(fd_schulen.schülerzah AS INTEGER))
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=1 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $foerderschulen_sz = $r[0];

//---- private Schulen -------	  
	  
	  $query="SELECT COUNT(fd_schulen.gid)
				FROM fd_schulen,fd_kreis
				WHERE (CAST(fd_schulen.schultyp AS INTEGER)=3 OR CAST(fd_schulen.schultyp AS INTEGER)=5) 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $private_schulen = $r[0];
	  
//---- private Schulen Schülerzahlen-------	  
	  
	  $query="SELECT sum(CAST(fd_schulen.schülerzah AS INTEGER))
				FROM fd_schulen,fd_kreis
				WHERE (CAST(fd_schulen.schultyp AS INTEGER)=3 OR CAST(fd_schulen.schultyp AS INTEGER)=5) 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $private_schulen_sz = $r[0];
	  
//---- KGS -------	  
	  
	  $query="SELECT COUNT(fd_schulen.gid)
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=9 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kgs = $r[0];
	  
//---- KGS Schülerzahlen-------	  
	  
	  $query="SELECT sum(CAST(fd_schulen.schülerzah AS INTEGER))
				FROM fd_schulen,fd_kreis
				WHERE CAST(fd_schulen.schultyp AS INTEGER)=9 
				AND st_intersects(fd_kreis.the_geom,fd_schulen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kgs_sz = $r[0];
?>	