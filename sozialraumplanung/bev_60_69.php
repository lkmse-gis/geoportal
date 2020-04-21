<?php

//----- Bevölkerung 60-69 einzeln -----------------------------------------------------------------------------------------	  

	  $query="SELECT sum(fd_bev.wert_60),sum(fd_bev.wert_61),sum(fd_bev.wert_62),sum(fd_bev.wert_63),sum(fd_bev.wert_64),sum(fd_bev.wert_65),sum(fd_bev.wert_66),sum(fd_bev.wert_67),sum(fd_bev.wert_68),sum(fd_bev.wert_69)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $w = $fetcharrayp($result);
	  
	  $query="SELECT sum(fd_bev.wert_60),sum(fd_bev.wert_61),sum(fd_bev.wert_62),sum(fd_bev.wert_63),sum(fd_bev.wert_64),sum(fd_bev.wert_65),sum(fd_bev.wert_66),sum(fd_bev.wert_67),sum(fd_bev.wert_68),sum(fd_bev.wert_69)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $m = $fetcharrayp($result);
?>	