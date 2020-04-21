<?php

//----- Bevölkerung 70-79 einzeln -----------------------------------------------------------------------------------------	  

	  $query="SELECT sum(fd_bev.wert_70),sum(fd_bev.wert_71),sum(fd_bev.wert_72),sum(fd_bev.wert_73),sum(fd_bev.wert_74),sum(fd_bev.wert_75),sum(fd_bev.wert_76),sum(fd_bev.wert_77),sum(fd_bev.wert_78),sum(fd_bev.wert_79)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $w = $fetcharrayp($result);
	  
	  $query="SELECT sum(fd_bev.wert_70),sum(fd_bev.wert_71),sum(fd_bev.wert_72),sum(fd_bev.wert_73),sum(fd_bev.wert_74),sum(fd_bev.wert_75),sum(fd_bev.wert_76),sum(fd_bev.wert_77),sum(fd_bev.wert_78),sum(fd_bev.wert_79)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $m = $fetcharrayp($result);
?>	