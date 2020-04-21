<?php

//----- gesamte Bevölkerung -----------------------------------------------------------------------------------------	  

	  $query="SELECT sum(fd_sgbii.gesamt)
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bg_insgesamt = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.single AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bg_single = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.alleinerziehend AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bg_alleinerz = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.paar_o AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bg_paar_o = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.paar_m AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bg_paar_m = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.g_u18 AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bg_ges_u18 = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.kind_1 AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bg_1_kinder = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.kind_2 AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bg_2_kinder = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.kind_3 AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $bg_3_kinder = $r[0];

//-------
	  
	  $query="SELECT sum(CAST(fd_sgbii.g_bg AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $p_bg_ges = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.u_3 AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $p_bg_2 = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.v_3_bis_u_7 AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $p_bg_3_6 = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.v_7_bis_u_15 AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $p_bg_7_14 = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.v_15_bis_u_18 AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $p_bg_15_17 = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.v_18_bis_u_20 AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $p_bg_18_19 = $r[0];
	  
	  $query="SELECT sum(CAST(fd_sgbii.v_20_bis_25 AS INTEGER))
				FROM fd_sgbii,gemeinden
				WHERE CAST(fd_sgbii.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $p_bg_20_25 = $r[0];
?>	