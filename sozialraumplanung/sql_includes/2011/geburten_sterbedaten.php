<?php
//--- lebendgeborene ------------------------------------------------------------------------
	  $query="SELECT sum(fd_bev_geburt_tot.lg_g)
				FROM fd_bev_geburt_tot,gemeinden
				WHERE CAST(fd_bev_geburt_tot.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id
				AND fd_bev_geburt_tot.stichtag='2011'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_lebend = $r[0];
	  
	  $query="SELECT sum(fd_bev_geburt_tot.lg_m)
				FROM fd_bev_geburt_tot,gemeinden
				WHERE CAST(fd_bev_geburt_tot.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id
				AND fd_bev_geburt_tot.stichtag='2011'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_lebend_m = $r[0];
	  
	  $query="SELECT sum(fd_bev_geburt_tot.lg_w)
				FROM fd_bev_geburt_tot,gemeinden
				WHERE CAST(fd_bev_geburt_tot.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id
				AND fd_bev_geburt_tot.stichtag='2011'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_lebend_w = $r[0];
	  
//--- gestorbene ------------------------------------------------------------------------
	  $query="SELECT sum(fd_bev_geburt_tot.g_g)
				FROM fd_bev_geburt_tot,gemeinden
				WHERE CAST(fd_bev_geburt_tot.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id
				AND fd_bev_geburt_tot.stichtag='2011'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_tot = $r[0];
	  
	  $query="SELECT sum(fd_bev_geburt_tot.g_m)
				FROM fd_bev_geburt_tot,gemeinden
				WHERE CAST(fd_bev_geburt_tot.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id
				AND fd_bev_geburt_tot.stichtag='2011'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_tot_m = $r[0];
	  
	  $query="SELECT sum(fd_bev_geburt_tot.g_w)
				FROM fd_bev_geburt_tot,gemeinden
				WHERE CAST(fd_bev_geburt_tot.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id
				AND fd_bev_geburt_tot.stichtag='2011'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_tot_w = $r[0];
?>	