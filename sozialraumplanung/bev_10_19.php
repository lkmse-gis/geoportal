<?php

//----- Bevölkerung 10-19 einzeln -----------------------------------------------------------------------------------------	  

	  $query="SELECT sum(fd_bev.wert_10),sum(fd_bev.wert_11),sum(fd_bev.wert_12),sum(fd_bev.wert_13),sum(fd_bev.wert_14),sum(fd_bev.wert_15),sum(fd_bev.wert_16),sum(fd_bev.wert_17),sum(fd_bev.wert_18),sum(fd_bev.wert_19)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $w = $fetcharrayp($result);
	  
	  $query="SELECT sum(fd_bev.wert_10),sum(fd_bev.wert_11),sum(fd_bev.wert_12),sum(fd_bev.wert_13),sum(fd_bev.wert_14),sum(fd_bev.wert_15),sum(fd_bev.wert_16),sum(fd_bev.wert_17),sum(fd_bev.wert_18),sum(fd_bev.wert_19)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $m = $fetcharrayp($result);
?>	