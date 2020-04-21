<?php
	  $query="SELECT sum(fd_bev.gesamt)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt = $r[0];
	  
	  $query="SELECT sum(fd_bev.gesamt)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_m = $r[0];
	  
	  $query="SELECT sum(fd_bev.gesamt)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_w = $r[0];

//----- Bevölkerung 0_2 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_00+fd_bev.wert_01+fd_bev.wert_02)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_0_2 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_00+fd_bev.wert_01+fd_bev.wert_02)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_0_2_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_00+fd_bev.wert_01+fd_bev.wert_02)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_0_2_m = $r[0];
	  
//----- Bevölkerung 3_5 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_03+fd_bev.wert_04+fd_bev.wert_05)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_3_5 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_03+fd_bev.wert_04+fd_bev.wert_05)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_3_5_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_03+fd_bev.wert_04+fd_bev.wert_05)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_3_5_m = $r[0];
	  
//----- Bevölkerung 3_6 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_03+fd_bev.wert_04+fd_bev.wert_05+fd_bev.wert_06)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_3_6 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_03+fd_bev.wert_04+fd_bev.wert_05+fd_bev.wert_06)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_3_6_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_03+fd_bev.wert_04+fd_bev.wert_05+fd_bev.wert_06)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_3_6_m = $r[0];

//----- Bevölkerung 7_10 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09+fd_bev.wert_10)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_7_10 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09+fd_bev.wert_10)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_7_10_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09+fd_bev.wert_10)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_7_10_m = $r[0];
	  
//----- Bevölkerung 7_14 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09+fd_bev.wert_10+fd_bev.wert_11+fd_bev.wert_12+fd_bev.wert_13+fd_bev.wert_14)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_7_14 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09+fd_bev.wert_10+fd_bev.wert_11+fd_bev.wert_12+fd_bev.wert_13+fd_bev.wert_14)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_7_14_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09+fd_bev.wert_10+fd_bev.wert_11+fd_bev.wert_12+fd_bev.wert_13+fd_bev.wert_14)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_7_14_m = $r[0];
	  
//----- Bevölkerung 15_17 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_15+fd_bev.wert_16+fd_bev.wert_17)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_15_17 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_15+fd_bev.wert_16+fd_bev.wert_17)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_15_17_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_15+fd_bev.wert_16+fd_bev.wert_17)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_15_17_m = $r[0];
	  
//----- Bevölkerung 18_19 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_18+fd_bev.wert_19)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_18_19 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_18+fd_bev.wert_19)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_18_19_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_18+fd_bev.wert_19)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_18_19_m = $r[0];
	  
//----- Bevölkerung 20_24 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_20+fd_bev.wert_21+fd_bev.wert_22+fd_bev.wert_23+fd_bev.wert_24)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_20_24 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_20+fd_bev.wert_21+fd_bev.wert_22+fd_bev.wert_23+fd_bev.wert_24)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_20_24_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_20+fd_bev.wert_21+fd_bev.wert_22+fd_bev.wert_23+fd_bev.wert_24)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_20_24_m = $r[0];
	  
//----- Bevölkerung 6_10 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_06+fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09+fd_bev.wert_10)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_6_10 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_06+fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09+fd_bev.wert_10)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_6_10_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_06+fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09+fd_bev.wert_10)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_6_10_m = $r[0];

//----- Bevölkerung 11_13 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_11+fd_bev.wert_12+fd_bev.wert_13)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_11_13 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_11+fd_bev.wert_12+fd_bev.wert_13)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_11_13_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_11+fd_bev.wert_12+fd_bev.wert_13)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_11_13_m = $r[0];	

//----- Bevölkerung 14_15 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_14+fd_bev.wert_15)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_14_15 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_14+fd_bev.wert_15)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_14_15_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_14+fd_bev.wert_15)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_14_15_m = $r[0];

//----- Bevölkerung 16_17 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_16+fd_bev.wert_17)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_16_17 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_16+fd_bev.wert_17)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_16_17_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_16+fd_bev.wert_17)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_16_17_m = $r[0];

//----- Bevölkerung 18_20 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_18+fd_bev.wert_19+fd_bev.wert_20)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_18_20 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_18+fd_bev.wert_19+fd_bev.wert_20)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_18_20_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_18+fd_bev.wert_19+fd_bev.wert_20)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_18_20_m = $r[0];	

//----- Bevölkerung 21_23 -----------------------------------------------------------------------------------------	  
	  
	  $query="SELECT sum(fd_bev.wert_21+fd_bev.wert_22+fd_bev.wert_23)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_21_23 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_21+fd_bev.wert_22+fd_bev.wert_23)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_21_23_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_21+fd_bev.wert_22+fd_bev.wert_23)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_21_23_m = $r[0];

//----- Bevölkerung 0_9 -----------------------------------------------------------------------------------------	  

	$query="SELECT sum(fd_bev.wert_00+fd_bev.wert_01+fd_bev.wert_02+fd_bev.wert_03+fd_bev.wert_04+fd_bev.wert_05+fd_bev.wert_06+fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_0_9 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_00+fd_bev.wert_01+fd_bev.wert_02+fd_bev.wert_03+fd_bev.wert_04+fd_bev.wert_05+fd_bev.wert_06+fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_0_9_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_00+fd_bev.wert_01+fd_bev.wert_02+fd_bev.wert_03+fd_bev.wert_04+fd_bev.wert_05+fd_bev.wert_06+fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_0_9_m = $r[0];
	  
//----- Bevölkerung 10_19 -----------------------------------------------------------------------------------------	  

	$query="SELECT sum(fd_bev.wert_10+fd_bev.wert_11+fd_bev.wert_12+fd_bev.wert_13+fd_bev.wert_14+fd_bev.wert_15+fd_bev.wert_16+fd_bev.wert_17+fd_bev.wert_18+fd_bev.wert_19)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_10_19 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_10+fd_bev.wert_11+fd_bev.wert_12+fd_bev.wert_13+fd_bev.wert_14+fd_bev.wert_15+fd_bev.wert_16+fd_bev.wert_17+fd_bev.wert_18+fd_bev.wert_19)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_10_19_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_10+fd_bev.wert_11+fd_bev.wert_12+fd_bev.wert_13+fd_bev.wert_14+fd_bev.wert_15+fd_bev.wert_16+fd_bev.wert_17+fd_bev.wert_18+fd_bev.wert_19)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_10_19_m = $r[0];
	  
//----- Bevölkerung 20_29 -----------------------------------------------------------------------------------------	  

	$query="SELECT sum(fd_bev.wert_20+fd_bev.wert_21+fd_bev.wert_22+fd_bev.wert_23+fd_bev.wert_24+fd_bev.wert_25+fd_bev.wert_26+fd_bev.wert_27+fd_bev.wert_28+fd_bev.wert_29)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_20_29 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_20+fd_bev.wert_21+fd_bev.wert_22+fd_bev.wert_23+fd_bev.wert_24+fd_bev.wert_25+fd_bev.wert_26+fd_bev.wert_27+fd_bev.wert_28+fd_bev.wert_29)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_20_29_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_20+fd_bev.wert_21+fd_bev.wert_22+fd_bev.wert_23+fd_bev.wert_24+fd_bev.wert_25+fd_bev.wert_26+fd_bev.wert_27+fd_bev.wert_28+fd_bev.wert_29)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_20_29_m = $r[0];
	  
//----- Bevölkerung 30_39 -----------------------------------------------------------------------------------------	  

	$query="SELECT sum(fd_bev.wert_30+fd_bev.wert_31+fd_bev.wert_32+fd_bev.wert_33+fd_bev.wert_34+fd_bev.wert_35+fd_bev.wert_36+fd_bev.wert_37+fd_bev.wert_38+fd_bev.wert_39)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_30_39 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_30+fd_bev.wert_31+fd_bev.wert_32+fd_bev.wert_33+fd_bev.wert_34+fd_bev.wert_35+fd_bev.wert_36+fd_bev.wert_37+fd_bev.wert_38+fd_bev.wert_39)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_30_39_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_30+fd_bev.wert_31+fd_bev.wert_32+fd_bev.wert_33+fd_bev.wert_34+fd_bev.wert_35+fd_bev.wert_36+fd_bev.wert_37+fd_bev.wert_38+fd_bev.wert_39)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_30_39_m = $r[0];

//----- Bevölkerung 40_49 -----------------------------------------------------------------------------------------	  

	$query="SELECT sum(fd_bev.wert_40+fd_bev.wert_41+fd_bev.wert_42+fd_bev.wert_43+fd_bev.wert_44+fd_bev.wert_45+fd_bev.wert_46+fd_bev.wert_47+fd_bev.wert_48+fd_bev.wert_49)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_40_49 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_40+fd_bev.wert_41+fd_bev.wert_42+fd_bev.wert_43+fd_bev.wert_44+fd_bev.wert_45+fd_bev.wert_46+fd_bev.wert_47+fd_bev.wert_48+fd_bev.wert_49)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_40_49_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_40+fd_bev.wert_41+fd_bev.wert_42+fd_bev.wert_43+fd_bev.wert_44+fd_bev.wert_45+fd_bev.wert_46+fd_bev.wert_47+fd_bev.wert_48+fd_bev.wert_49)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_40_49_m = $r[0];
	  
//----- Bevölkerung 50_59 -----------------------------------------------------------------------------------------	  

	$query="SELECT sum(fd_bev.wert_50+fd_bev.wert_51+fd_bev.wert_52+fd_bev.wert_53+fd_bev.wert_54+fd_bev.wert_55+fd_bev.wert_56+fd_bev.wert_57+fd_bev.wert_58+fd_bev.wert_59)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_50_59 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_50+fd_bev.wert_51+fd_bev.wert_52+fd_bev.wert_53+fd_bev.wert_54+fd_bev.wert_55+fd_bev.wert_56+fd_bev.wert_57+fd_bev.wert_58+fd_bev.wert_59)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_50_59_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_50+fd_bev.wert_51+fd_bev.wert_52+fd_bev.wert_53+fd_bev.wert_54+fd_bev.wert_55+fd_bev.wert_56+fd_bev.wert_57+fd_bev.wert_58+fd_bev.wert_59)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_50_59_m = $r[0];
	  
//----- Bevölkerung 60_69 -----------------------------------------------------------------------------------------	  

	$query="SELECT sum(fd_bev.wert_60+fd_bev.wert_61+fd_bev.wert_62+fd_bev.wert_63+fd_bev.wert_64+fd_bev.wert_65+fd_bev.wert_66+fd_bev.wert_67+fd_bev.wert_68+fd_bev.wert_69)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_60_69 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_60+fd_bev.wert_61+fd_bev.wert_62+fd_bev.wert_63+fd_bev.wert_64+fd_bev.wert_65+fd_bev.wert_66+fd_bev.wert_67+fd_bev.wert_68+fd_bev.wert_69)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_60_69_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_60+fd_bev.wert_61+fd_bev.wert_62+fd_bev.wert_63+fd_bev.wert_64+fd_bev.wert_65+fd_bev.wert_66+fd_bev.wert_67+fd_bev.wert_68+fd_bev.wert_69)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_60_69_m = $r[0];

//----- Bevölkerung 70_79 -----------------------------------------------------------------------------------------	  

	$query="SELECT sum(fd_bev.wert_70+fd_bev.wert_71+fd_bev.wert_72+fd_bev.wert_73+fd_bev.wert_74+fd_bev.wert_75+fd_bev.wert_76+fd_bev.wert_77+fd_bev.wert_78+fd_bev.wert_79)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_70_79 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_70+fd_bev.wert_71+fd_bev.wert_72+fd_bev.wert_73+fd_bev.wert_74+fd_bev.wert_75+fd_bev.wert_76+fd_bev.wert_77+fd_bev.wert_78+fd_bev.wert_79)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_70_79_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_70+fd_bev.wert_71+fd_bev.wert_72+fd_bev.wert_73+fd_bev.wert_74+fd_bev.wert_75+fd_bev.wert_76+fd_bev.wert_77+fd_bev.wert_78+fd_bev.wert_79)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_70_79_m = $r[0];
	  
//----- Bevölkerung 80_89 -----------------------------------------------------------------------------------------	  

	$query="SELECT sum(fd_bev.wert_80+fd_bev.wert_81+fd_bev.wert_82+fd_bev.wert_83+fd_bev.wert_84+fd_bev.wert_85+fd_bev.wert_86+fd_bev.wert_87+fd_bev.wert_88+fd_bev.wert_89)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_80_89 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_80+fd_bev.wert_81+fd_bev.wert_82+fd_bev.wert_83+fd_bev.wert_84+fd_bev.wert_85+fd_bev.wert_86+fd_bev.wert_87+fd_bev.wert_88+fd_bev.wert_89)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_80_89_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_80+fd_bev.wert_81+fd_bev.wert_82+fd_bev.wert_83+fd_bev.wert_84+fd_bev.wert_85+fd_bev.wert_86+fd_bev.wert_87+fd_bev.wert_88+fd_bev.wert_89)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_80_89_m = $r[0];
	  
//----- Bevölkerung 90_99 -----------------------------------------------------------------------------------------	  

	$query="SELECT sum(fd_bev.wert_90+fd_bev.wert_91+fd_bev.wert_92+fd_bev.wert_93+fd_bev.wert_94+fd_bev.wert_95+fd_bev.wert_96+fd_bev.wert_97+fd_bev.wert_98+fd_bev.wert_99)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_90_99 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_90+fd_bev.wert_91+fd_bev.wert_92+fd_bev.wert_93+fd_bev.wert_94+fd_bev.wert_95+fd_bev.wert_96+fd_bev.wert_97+fd_bev.wert_98+fd_bev.wert_99)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_90_99_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_90+fd_bev.wert_91+fd_bev.wert_92+fd_bev.wert_93+fd_bev.wert_94+fd_bev.wert_95+fd_bev.wert_96+fd_bev.wert_97+fd_bev.wert_98+fd_bev.wert_99)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_90_99_m = $r[0];
	  
//----- Bevölkerung 65_99 -----------------------------------------------------------------------------------------

	$query="SELECT sum(fd_bev.wert_65+fd_bev.wert_66+fd_bev.wert_67+fd_bev.wert_68+fd_bev.wert_69+fd_bev.wert_70+fd_bev.wert_71+fd_bev.wert_72+fd_bev.wert_73+fd_bev.wert_74+fd_bev.wert_75+fd_bev.wert_76+fd_bev.wert_77+fd_bev.wert_78+fd_bev.wert_79+fd_bev.wert_80+fd_bev.wert_81+fd_bev.wert_82+fd_bev.wert_83+fd_bev.wert_84+fd_bev.wert_85+fd_bev.wert_86+fd_bev.wert_87+fd_bev.wert_88+fd_bev.wert_89+fd_bev.wert_90+fd_bev.wert_91+fd_bev.wert_92+fd_bev.wert_93+fd_bev.wert_94+fd_bev.wert_95+fd_bev.wert_96+fd_bev.wert_97+fd_bev.wert_98+fd_bev.wert_99)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_65_99 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_65+fd_bev.wert_66+fd_bev.wert_67+fd_bev.wert_68+fd_bev.wert_69+fd_bev.wert_70+fd_bev.wert_71+fd_bev.wert_72+fd_bev.wert_73+fd_bev.wert_74+fd_bev.wert_75+fd_bev.wert_76+fd_bev.wert_77+fd_bev.wert_78+fd_bev.wert_79+fd_bev.wert_80+fd_bev.wert_81+fd_bev.wert_82+fd_bev.wert_83+fd_bev.wert_84+fd_bev.wert_85+fd_bev.wert_86+fd_bev.wert_87+fd_bev.wert_88+fd_bev.wert_89+fd_bev.wert_90+fd_bev.wert_91+fd_bev.wert_92+fd_bev.wert_93+fd_bev.wert_94+fd_bev.wert_95+fd_bev.wert_96+fd_bev.wert_97+fd_bev.wert_98+fd_bev.wert_99)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_65_99_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_65+fd_bev.wert_66+fd_bev.wert_67+fd_bev.wert_68+fd_bev.wert_69+fd_bev.wert_70+fd_bev.wert_71+fd_bev.wert_72+fd_bev.wert_73+fd_bev.wert_74+fd_bev.wert_75+fd_bev.wert_76+fd_bev.wert_77+fd_bev.wert_78+fd_bev.wert_79+fd_bev.wert_80+fd_bev.wert_81+fd_bev.wert_82+fd_bev.wert_83+fd_bev.wert_84+fd_bev.wert_85+fd_bev.wert_86+fd_bev.wert_87+fd_bev.wert_88+fd_bev.wert_89+fd_bev.wert_90+fd_bev.wert_91+fd_bev.wert_92+fd_bev.wert_93+fd_bev.wert_94+fd_bev.wert_95+fd_bev.wert_96+fd_bev.wert_97+fd_bev.wert_98+fd_bev.wert_99)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_65_99_m = $r[0];
	  
//----- Bevölkerung 0_17 -----------------------------------------------------------------------------------------

	$query="SELECT sum(fd_bev.wert_00+fd_bev.wert_01+fd_bev.wert_02+fd_bev.wert_03+fd_bev.wert_04+fd_bev.wert_05+fd_bev.wert_06+fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09+fd_bev.wert_10+fd_bev.wert_11+fd_bev.wert_12+fd_bev.wert_13+fd_bev.wert_14+fd_bev.wert_15+fd_bev.wert_16+fd_bev.wert_17)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_0_17 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_00+fd_bev.wert_01+fd_bev.wert_02+fd_bev.wert_03+fd_bev.wert_04+fd_bev.wert_05+fd_bev.wert_06+fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09+fd_bev.wert_10+fd_bev.wert_11+fd_bev.wert_12+fd_bev.wert_13+fd_bev.wert_14+fd_bev.wert_15+fd_bev.wert_16+fd_bev.wert_17)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_0_17_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_00+fd_bev.wert_01+fd_bev.wert_02+fd_bev.wert_03+fd_bev.wert_04+fd_bev.wert_05+fd_bev.wert_06+fd_bev.wert_07+fd_bev.wert_08+fd_bev.wert_09+fd_bev.wert_10+fd_bev.wert_11+fd_bev.wert_12+fd_bev.wert_13+fd_bev.wert_14+fd_bev.wert_15+fd_bev.wert_16+fd_bev.wert_17)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_0_17_m = $r[0];
	  
//----- Bevölkerung 18_64 -----------------------------------------------------------------------------------------

	   $query="SELECT sum(fd_bev.wert_18+fd_bev.wert_19+fd_bev.wert_20+fd_bev.wert_21+fd_bev.wert_22+fd_bev.wert_23+fd_bev.wert_24+fd_bev.wert_25+fd_bev.wert_26+fd_bev.wert_27+fd_bev.wert_28+fd_bev.wert_29+fd_bev.wert_30+fd_bev.wert_31+fd_bev.wert_32+fd_bev.wert_33+fd_bev.wert_34+fd_bev.wert_35+fd_bev.wert_36+fd_bev.wert_37+fd_bev.wert_38+fd_bev.wert_39+fd_bev.wert_40+fd_bev.wert_41+fd_bev.wert_42+fd_bev.wert_43+fd_bev.wert_44+fd_bev.wert_45+fd_bev.wert_46+fd_bev.wert_47+fd_bev.wert_48+fd_bev.wert_49+fd_bev.wert_50+fd_bev.wert_51+fd_bev.wert_52+fd_bev.wert_53+fd_bev.wert_54+fd_bev.wert_55+fd_bev.wert_56+fd_bev.wert_57+fd_bev.wert_58+fd_bev.wert_59+fd_bev.wert_60+fd_bev.wert_61+fd_bev.wert_62+fd_bev.wert_63+fd_bev.wert_64)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_18_64 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_18+fd_bev.wert_19+fd_bev.wert_20+fd_bev.wert_21+fd_bev.wert_22+fd_bev.wert_23+fd_bev.wert_24+fd_bev.wert_25+fd_bev.wert_26+fd_bev.wert_27+fd_bev.wert_28+fd_bev.wert_29+fd_bev.wert_30+fd_bev.wert_31+fd_bev.wert_32+fd_bev.wert_33+fd_bev.wert_34+fd_bev.wert_35+fd_bev.wert_36+fd_bev.wert_37+fd_bev.wert_38+fd_bev.wert_39+fd_bev.wert_40+fd_bev.wert_41+fd_bev.wert_42+fd_bev.wert_43+fd_bev.wert_44+fd_bev.wert_45+fd_bev.wert_46+fd_bev.wert_47+fd_bev.wert_48+fd_bev.wert_49+fd_bev.wert_50+fd_bev.wert_51+fd_bev.wert_52+fd_bev.wert_53+fd_bev.wert_54+fd_bev.wert_55+fd_bev.wert_56+fd_bev.wert_57+fd_bev.wert_58+fd_bev.wert_59+fd_bev.wert_60+fd_bev.wert_61+fd_bev.wert_62+fd_bev.wert_63+fd_bev.wert_64)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_18_64_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_18+fd_bev.wert_19+fd_bev.wert_20+fd_bev.wert_21+fd_bev.wert_22+fd_bev.wert_23+fd_bev.wert_24+fd_bev.wert_25+fd_bev.wert_26+fd_bev.wert_27+fd_bev.wert_28+fd_bev.wert_29+fd_bev.wert_30+fd_bev.wert_31+fd_bev.wert_32+fd_bev.wert_33+fd_bev.wert_34+fd_bev.wert_35+fd_bev.wert_36+fd_bev.wert_37+fd_bev.wert_38+fd_bev.wert_39+fd_bev.wert_40+fd_bev.wert_41+fd_bev.wert_42+fd_bev.wert_43+fd_bev.wert_44+fd_bev.wert_45+fd_bev.wert_46+fd_bev.wert_47+fd_bev.wert_48+fd_bev.wert_49+fd_bev.wert_50+fd_bev.wert_51+fd_bev.wert_52+fd_bev.wert_53+fd_bev.wert_54+fd_bev.wert_55+fd_bev.wert_56+fd_bev.wert_57+fd_bev.wert_58+fd_bev.wert_59+fd_bev.wert_60+fd_bev.wert_61+fd_bev.wert_62+fd_bev.wert_63+fd_bev.wert_64)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_18_64_m = $r[0];
	  
//----- Bevölkerung 65_79 -----------------------------------------------------------------------------------------

	$query="SELECT sum(fd_bev.wert_65+fd_bev.wert_66+fd_bev.wert_67+fd_bev.wert_68+fd_bev.wert_69+fd_bev.wert_70+fd_bev.wert_71+fd_bev.wert_72+fd_bev.wert_73+fd_bev.wert_74+fd_bev.wert_75+fd_bev.wert_76+fd_bev.wert_77+fd_bev.wert_78+fd_bev.wert_79)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_65_79 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_65+fd_bev.wert_66+fd_bev.wert_67+fd_bev.wert_68+fd_bev.wert_69+fd_bev.wert_70+fd_bev.wert_71+fd_bev.wert_72+fd_bev.wert_73+fd_bev.wert_74+fd_bev.wert_75+fd_bev.wert_76+fd_bev.wert_77+fd_bev.wert_78+fd_bev.wert_79)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_65_79_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_65+fd_bev.wert_66+fd_bev.wert_67+fd_bev.wert_68+fd_bev.wert_69+fd_bev.wert_70+fd_bev.wert_71+fd_bev.wert_72+fd_bev.wert_73+fd_bev.wert_74+fd_bev.wert_75+fd_bev.wert_76+fd_bev.wert_77+fd_bev.wert_78+fd_bev.wert_79)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_65_79_m = $r[0];

//----- Bevölkerung 80_99 -----------------------------------------------------------------------------------------

	$query="SELECT sum(fd_bev.wert_80+fd_bev.wert_81+fd_bev.wert_82+fd_bev.wert_83+fd_bev.wert_84+fd_bev.wert_85+fd_bev.wert_86+fd_bev.wert_87+fd_bev.wert_88+fd_bev.wert_89+fd_bev.wert_90+fd_bev.wert_91+fd_bev.wert_92+fd_bev.wert_93+fd_bev.wert_94+fd_bev.wert_95+fd_bev.wert_96+fd_bev.wert_97+fd_bev.wert_98+fd_bev.wert_99)
				FROM fd_bev,gemeinden
				WHERE CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_80_99 = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_80+fd_bev.wert_81+fd_bev.wert_82+fd_bev.wert_83+fd_bev.wert_84+fd_bev.wert_85+fd_bev.wert_86+fd_bev.wert_87+fd_bev.wert_88+fd_bev.wert_89+fd_bev.wert_90+fd_bev.wert_91+fd_bev.wert_92+fd_bev.wert_93+fd_bev.wert_94+fd_bev.wert_95+fd_bev.wert_96+fd_bev.wert_97+fd_bev.wert_98+fd_bev.wert_99)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'w'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_80_99_w = $r[0];
	  
	  $query="SELECT sum(fd_bev.wert_80+fd_bev.wert_81+fd_bev.wert_82+fd_bev.wert_83+fd_bev.wert_84+fd_bev.wert_85+fd_bev.wert_86+fd_bev.wert_87+fd_bev.wert_88+fd_bev.wert_89+fd_bev.wert_90+fd_bev.wert_91+fd_bev.wert_92+fd_bev.wert_93+fd_bev.wert_94+fd_bev.wert_95+fd_bev.wert_96+fd_bev.wert_97+fd_bev.wert_98+fd_bev.wert_99)
				FROM fd_bev,gemeinden
				WHERE geschlecht = 'm'
				AND CAST(fd_bev.gem_schl AS INTEGER) = CAST(gemeinden.gem_schl AS INTEGER)
				AND CAST(gemeinden.amt_id AS INTEGER)=$amt_id";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $gesamt_80_99_m = $r[0];
?>	