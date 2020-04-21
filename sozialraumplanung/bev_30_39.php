<?php

//----- Bevölkerung 30-39 einzeln -----------------------------------------------------------------------------------------	  

	  $query="SELECT sum(fd_bev.wert_30),sum(fd_bev.wert_31),sum(fd_bev.wert_32),sum(fd_bev.wert_33),sum(fd_bev.wert_34),sum(fd_bev.wert_35),sum(fd_bev.wert_36),sum(fd_bev.wert_37),sum(fd_bev.wert_38),sum(fd_bev.wert_39)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $w = $fetcharrayp($result);
	  
	  $query="SELECT sum(fd_bev.wert_30),sum(fd_bev.wert_31),sum(fd_bev.wert_32),sum(fd_bev.wert_33),sum(fd_bev.wert_34),sum(fd_bev.wert_35),sum(fd_bev.wert_36),sum(fd_bev.wert_37),sum(fd_bev.wert_38),sum(fd_bev.wert_39)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $m = $fetcharrayp($result);
?>	