<?php
//---- Gesamt Kinderbetreuung 2011 -------	  
	  
	  $query="SELECT COUNT(fd_kitas.gid)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011'
				ANd CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbetreuung = $r[0];
	  
//---- Kinderzahlen 2011 -------	  
	  
	  $query="SELECT sum(fd_kitas.kk+fd_kitas.kg+fd_kitas.hort)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbetreuung_zahlen = $r[0];

//---- Kinderzahlen kapazitaet 2011-------	  
	  
	  $query="SELECT sum(fd_kitas.kapazitaet)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbetreuung_zahlen_kapazitaet = $r[0];

//---- Krippen 2011 -------	  
	  
	  $query="SELECT COUNT(fd_kitas.gid)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_kitas.kk_ja='ja'
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $krippen = $r[0];
	  
//---- Krippen Zahlen 2011 -------	  
	  
	  $query="SELECT sum(fd_kitas.kk)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $krippen_zahlen = $r[0];

//---- Krippen Zahlen Kapazität 2011 -------	  
	  
	  $query="SELECT sum(fd_kitas.k_kk)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $krippen_zahlen_kapazitaet = $r[0];
	  
//---- Kindergärten 2011 -------	  
	  
	  $query="SELECT COUNT(fd_kitas.gid)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_kitas.kg_ja='ja'
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kindergarten = $r[0];
	  
//---- Kindergärten Zahlen 2011 -------	  
	  
	  $query="SELECT sum(fd_kitas.kg)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kindergarten_zahlen = $r[0];
	  
//---- Kindergärten Zahlen Kapazität 2011 -------	  
	  
	  $query="SELECT sum(fd_kitas.k_kg)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kindergarten_zahlen_kapazitaet = $r[0];
	  
//---- Horte 2011 -------	  
	  
	  $query="SELECT COUNT(fd_kitas.gid)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_kitas.hort_ja='ja'
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $horte = $r[0];
	  
//---- Horte Zahlen 2011 -------	  
	  
	  $query="SELECT sum(fd_kitas.hort)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $horte_zahlen = $r[0];
	  
//---- Horte Zahlen Kapazität 2011 -------	  
	  
	  $query="SELECT sum(fd_kitas.k_hort)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $horte_zahlen_kapazitaet = $r[0];
	  
//---- Gesamt Beiträge Krippe 2011 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_h_kk AS NUMERIC)+CAST (fd_kitas.p_t_kk AS NUMERIC)+CAST (fd_kitas.p_g_kk AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kk = $r[0];
	  
//---- Gesamt Beiträge Kindergarten 2011 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_h_kg AS NUMERIC)+CAST (fd_kitas.p_t_kg AS NUMERIC)+CAST (fd_kitas.p_g_kg AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kg = $r[0];
	  
//---- Gesamt Beiträge Hort 2011 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_h_hort AS NUMERIC)+CAST (fd_kitas.p_t_hort AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_hort = $r[0];
	  
//---- Beiträge Krippe halbtags 2011 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_h_kk AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kk_h = $r[0];

//---- Beiträge Krippe teilzeit 2011 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_t_kk AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kk_t = $r[0];

//---- Beiträge Krippe ganztags 2011 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_g_kk AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kk_g = $r[0];

//---- Beiträge Kindergarten halbtags 2011 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_h_kg AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kg_h = $r[0];

//---- Beiträge Kindergarten teilzeit 2011 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_t_kg AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kg_t = $r[0];

//---- Beiträge Kindergarten ganztags 2011 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_g_kg AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_kg_g = $r[0];

//---- Beiträge Hort halbtags 2011 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_h_hort AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_hort_h = $r[0];

//---- Beiträge Hort teilzeit 2011 -------	  
	  
	  $query="SELECT sum(CAST (fd_kitas.p_t_hort AS NUMERIC))
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $kinderbeitraege_hort_t = $r[0];

//---- integrative Standorte 2011 -------	  
	  
	  $query="SELECT COUNT(fd_kitas.gid)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND fd_kitas.plaetze > '0'
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $integrativ_anzahl = $r[0];
	  
//---- integrative Plätze 2011 -------	  
	  
	  $query="SELECT sum(fd_kitas.plaetze)
				FROM fd_kitas,fd_amtsbereiche
				WHERE fd_kitas.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_kitas.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $integrativ_plaetze = $r[0];

//---- Tagesmutter 2011 -------	  
	  
	  $query="SELECT COUNT(fd_tagespflegen.gid)
				FROM fd_tagespflegen,fd_amtsbereiche
				WHERE fd_tagespflegen.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_tagespflegen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $tagesmutter = $r[0];
	  
//---- Tagesmutter Zahlen Kapazität 2011 -------	  
	  
	  $query="SELECT sum(fd_tagespflegen.k_kk)
				FROM fd_tagespflegen,fd_amtsbereiche
				WHERE fd_tagespflegen.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_tagespflegen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $tagesmutter_zahlen_kapazitaet = $r[0];
	  
//---- Tagesmutter Zahlen Belegung 2011 -------	  
	  
	  $query="SELECT sum(fd_tagespflegen.kk)
				FROM fd_tagespflegen,fd_amtsbereiche
				WHERE fd_tagespflegen.jahr = '31.12.2011' 
				AND CAST(fd_amtsbereiche.amts_sf AS INTEGER)=$amt_id
				AND st_intersects(fd_amtsbereiche.the_geom,fd_tagespflegen.the_geom)";
	  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $tagesmutter_zahlen = $r[0];
	  	  
?>	