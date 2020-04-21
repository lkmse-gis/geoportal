<?php

//----- Bevölkerung 90-99 einzeln -----------------------------------------------------------------------------------------	  

	  $query="SELECT sum(fd_bev.wert_90),sum(fd_bev.wert_91),sum(fd_bev.wert_92),sum(fd_bev.wert_93),sum(fd_bev.wert_94),sum(fd_bev.wert_95),sum(fd_bev.wert_96),sum(fd_bev.wert_97),sum(fd_bev.wert_98),sum(fd_bev.wert_99)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $w = $fetcharrayp($result);
	  
	  $query="SELECT sum(fd_bev.wert_90),sum(fd_bev.wert_91),sum(fd_bev.wert_92),sum(fd_bev.wert_93),sum(fd_bev.wert_94),sum(fd_bev.wert_95),sum(fd_bev.wert_96),sum(fd_bev.wert_97),sum(fd_bev.wert_98),sum(fd_bev.wert_99)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $m = $fetcharrayp($result);
?>	