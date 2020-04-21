<?php
//--- zuzüge ------------------------------------------------------------------------
	  $query="SELECT sum(fd_bev_wanderung.zuzuege)
				FROM fd_bev_wanderung,gemeinden
				WHERE CAST(fd_bev_wanderung.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id
				AND fd_bev_wanderung.stichtag='31.12.2011'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_zuzuege = $r[0];
	  
//--- fortzüge ------------------------------------------------------------------------
	  $query="SELECT sum(fd_bev_wanderung.fortzuege)
				FROM fd_bev_wanderung,gemeinden
				WHERE CAST(fd_bev_wanderung.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id
				AND fd_bev_wanderung.stichtag='31.12.2011'";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_fortzuege = $r[0];
?>	