<?php

//----- Bevölkerung 40-49 einzeln -----------------------------------------------------------------------------------------	  

	  $query="SELECT sum(fd_bev.wert_40),sum(fd_bev.wert_41),sum(fd_bev.wert_42),sum(fd_bev.wert_43),sum(fd_bev.wert_44),sum(fd_bev.wert_45),sum(fd_bev.wert_46),sum(fd_bev.wert_47),sum(fd_bev.wert_48),sum(fd_bev.wert_49)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $w = $fetcharrayp($result);
	  
	  $query="SELECT sum(fd_bev.wert_40),sum(fd_bev.wert_41),sum(fd_bev.wert_42),sum(fd_bev.wert_43),sum(fd_bev.wert_44),sum(fd_bev.wert_45),sum(fd_bev.wert_46),sum(fd_bev.wert_47),sum(fd_bev.wert_48),sum(fd_bev.wert_49)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $m = $fetcharrayp($result);
?>	