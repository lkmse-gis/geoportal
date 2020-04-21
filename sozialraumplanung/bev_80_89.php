<?php

//----- Bevölkerung 80-89 einzeln -----------------------------------------------------------------------------------------	  

	  $query="SELECT sum(fd_bev.wert_80),sum(fd_bev.wert_81),sum(fd_bev.wert_82),sum(fd_bev.wert_83),sum(fd_bev.wert_84),sum(fd_bev.wert_85),sum(fd_bev.wert_86),sum(fd_bev.wert_87),sum(fd_bev.wert_88),sum(fd_bev.wert_89)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $w = $fetcharrayp($result);
	  
	  $query="SELECT sum(fd_bev.wert_80),sum(fd_bev.wert_81),sum(fd_bev.wert_82),sum(fd_bev.wert_83),sum(fd_bev.wert_84),sum(fd_bev.wert_85),sum(fd_bev.wert_86),sum(fd_bev.wert_87),sum(fd_bev.wert_88),sum(fd_bev.wert_89)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $m = $fetcharrayp($result);
?>	