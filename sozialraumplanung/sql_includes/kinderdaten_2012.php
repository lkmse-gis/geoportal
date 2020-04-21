<?php
//---- Gesamt Kinderbetreuung 2012 -------	  
	  
	  $query="SELECT COUNT(fd_kitas.gid)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012'
				ANd CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbetreuung_2012 = $r[0];
	  
//---- Kinderzahlen 2012 -------	  
	  
	  $query="SELECT sum(fd_kitas.kk+fd_kitas.kg+fd_kitas.hort)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbetreuung_zahlen_2012 = $r[0];

//---- Kinderzahlen kapazitaet 2012-------	  
	  
	  $query="SELECT sum(fd_kitas.kapazitaet)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbetreuung_zahlen_kapazitaet_2012 = $r[0];

//---- Krippen 2012 -------	  
	  
	  $query="SELECT COUNT(fd_kitas.gid)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_kitas.kk_ja='ja'
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $krippen_2012 = $r[0];
	  
//---- Krippen Zahlen 2012 -------	  
	  
	  $query="SELECT sum(fd_kitas.kk)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $krippen_zahlen_2012 = $r[0];

//---- Krippen Zahlen Kapazität 2012 -------	  
	  
	  $query="SELECT sum(fd_kitas.k_kk)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $krippen_zahlen_kapazitaet_2012 = $r[0];
	  
//---- Kindergärten 2012 -------	  
	  
	  $query="SELECT COUNT(fd_kitas.gid)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_kitas.kg_ja='ja'
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kindergarten_2012 = $r[0];
	  
//---- Kindergärten Zahlen 2012 -------	  
	  
	  $query="SELECT sum(fd_kitas.kg)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kindergarten_zahlen_2012 = $r[0];
	  
//---- Kindergärten Zahlen Kapazität 2012 -------	  
	  
	  $query="SELECT sum(fd_kitas.k_kg)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kindergarten_zahlen_kapazitaet_2012 = $r[0];
	  
//---- Horte 2012 -------	  
	  
	  $query="SELECT COUNT(fd_kitas.gid)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_kitas.hort_ja='ja'
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $horte_2012 = $r[0];
	  
//---- Horte Zahlen 2012 -------	  
	  
	  $query="SELECT sum(fd_kitas.hort)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $horte_zahlen_2012 = $r[0];
	  
//---- Horte Zahlen Kapazität 2012 -------	  
	  
	  $query="SELECT sum(fd_kitas.k_hort)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $horte_zahlen_kapazitaet_2012 = $r[0];
	  
//---- Gesamt Beiträge Krippe 2012 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_h_kk AS NUMERIC)+CAST (fd_kitas.p_t_kk AS NUMERIC)+CAST (fd_kitas.p_g_kk AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kk_2012 = $r[0];
	  
//---- Gesamt Beiträge Kindergarten 2012 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_h_kg AS NUMERIC)+CAST (fd_kitas.p_t_kg AS NUMERIC)+CAST (fd_kitas.p_g_kg AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kg_2012 = $r[0];
	  
//---- Gesamt Beiträge Hort 2012 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_h_hort AS NUMERIC)+CAST (fd_kitas.p_t_hort AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_hort_2012 = $r[0];
	  
//---- Beiträge Krippe halbtags 2012 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_h_kk AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kk_h_2012 = $r[0];

//---- Beiträge Krippe teilzeit 2012 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_t_kk AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kk_t_2012 = $r[0];

//---- Beiträge Krippe ganztags 2012 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_g_kk AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kk_g_2012 = $r[0];

//---- Beiträge Kindergarten halbtags 2012 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_h_kg AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kg_h_2012 = $r[0];

//---- Beiträge Kindergarten teilzeit 2012 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_t_kg AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kg_t_2012 = $r[0];

//---- Beiträge Kindergarten ganztags 2012 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_g_kg AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kg_g_2012 = $r[0];

//---- Beiträge Hort halbtags 2012 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_h_hort AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_hort_h_2012 = $r[0];

//---- Beiträge Hort teilzeit 2012 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_t_hort AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_hort_t_2012 = $r[0];

//---- integrative Standorte 2012 -------	  
	  
	  $query="SELECT COUNT(fd_kitas.gid)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_kitas.plaetze > '0'
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $integrativ_anzahl_2012 = $r[0];
	  
//---- integrative Plätze 2012 -------	  
	  
	  $query="SELECT sum(fd_kitas.plaetze)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2012' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $integrativ_plaetze_2012 = $r[0];	  
?>	