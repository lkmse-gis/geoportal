<?php
//--- Gesamt Sozialpflichtige ------------------------------------------------------------------------
	  $query="SELECT sum(fd_bev_sozialpflichtige.sozi_ges)
				FROM fd_bev_sozialpflichtige,gemeinden
				WHERE CAST(fd_bev_sozialpflichtige.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id
				AND fd_bev_sozialpflichtige.stichtag='31.12.2011'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_sozialpflichtige = $r[0];
	  
//--- Sozialpflichtige Männlich ------------------------------------------------------------------------
	  $query="SELECT sum(fd_bev_sozialpflichtige.sozi_m)
				FROM fd_bev_sozialpflichtige,gemeinden
				WHERE CAST(fd_bev_sozialpflichtige.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id
				AND fd_bev_sozialpflichtige.stichtag='31.12.2011'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_sozialpflichtige_m = $r[0];
	  
//--- Gesamt Azubis ------------------------------------------------------------------------
	  $query="SELECT sum(fd_bev_sozialpflichtige.azubi_ges)
				FROM fd_bev_sozialpflichtige,gemeinden
				WHERE CAST(fd_bev_sozialpflichtige.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id
				AND fd_bev_sozialpflichtige.stichtag='31.12.2011'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_azubis = $r[0];
	  
//--- Azubis Männlich ------------------------------------------------------------------------
	  $query="SELECT sum(fd_bev_sozialpflichtige.azubi_m)
				FROM fd_bev_sozialpflichtige,gemeinden
				WHERE CAST(fd_bev_sozialpflichtige.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id
				AND fd_bev_sozialpflichtige.stichtag='31.12.2011'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_azubis_m = $r[0];
?>	