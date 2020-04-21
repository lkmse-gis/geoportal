<?php

//----- Bevölkerung 0-9 einzeln -----------------------------------------------------------------------------------------	  

	  $query="SELECT sum(fd_bev.wert_00),sum(fd_bev.wert_01),sum(fd_bev.wert_02),sum(fd_bev.wert_03),sum(fd_bev.wert_04),sum(fd_bev.wert_05),sum(fd_bev.wert_06),sum(fd_bev.wert_07),sum(fd_bev.wert_08),sum(fd_bev.wert_09)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $w = $fetcharrayp($result);
	  
	  $query="SELECT sum(fd_bev.wert_00),sum(fd_bev.wert_01),sum(fd_bev.wert_02),sum(fd_bev.wert_03),sum(fd_bev.wert_04),sum(fd_bev.wert_05),sum(fd_bev.wert_06),sum(fd_bev.wert_07),sum(fd_bev.wert_08),sum(fd_bev.wert_09)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $m = $fetcharrayp($result);
?>	