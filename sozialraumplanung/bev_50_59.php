<?php

//----- Bevölkerung 10-19 einzeln -----------------------------------------------------------------------------------------	  

	  $query="SELECT sum(fd_bev.wert_50),sum(fd_bev.wert_51),sum(fd_bev.wert_52),sum(fd_bev.wert_53),sum(fd_bev.wert_54),sum(fd_bev.wert_55),sum(fd_bev.wert_56),sum(fd_bev.wert_57),sum(fd_bev.wert_58),sum(fd_bev.wert_59)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $w = $fetcharrayp($result);
	  
	  $query="SELECT sum(fd_bev.wert_50),sum(fd_bev.wert_51),sum(fd_bev.wert_52),sum(fd_bev.wert_53),sum(fd_bev.wert_54),sum(fd_bev.wert_55),sum(fd_bev.wert_56),sum(fd_bev.wert_57),sum(fd_bev.wert_58),sum(fd_bev.wert_59)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $m = $fetcharrayp($result);
?>	