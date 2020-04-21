<?php

//----- Bevölkerung 10-19 einzeln -----------------------------------------------------------------------------------------	  

	  $query="SELECT sum(fd_bev.wert_20),sum(fd_bev.wert_21),sum(fd_bev.wert_22),sum(fd_bev.wert_23),sum(fd_bev.wert_24),sum(fd_bev.wert_25),sum(fd_bev.wert_26),sum(fd_bev.wert_27),sum(fd_bev.wert_28),sum(fd_bev.wert_29)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $w = $fetcharrayp($result);
	  
	  $query="SELECT sum(fd_bev.wert_20),sum(fd_bev.wert_21),sum(fd_bev.wert_22),sum(fd_bev.wert_23),sum(fd_bev.wert_24),sum(fd_bev.wert_25),sum(fd_bev.wert_26),sum(fd_bev.wert_27),sum(fd_bev.wert_28),sum(fd_bev.wert_29)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $m = $fetcharrayp($result);
?>	