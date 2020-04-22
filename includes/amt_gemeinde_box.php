<?
$query="SELECT a.amt,a.amt_id,box(st_transform(a.the_geom,25833)) as box, area(a.the_geom) as area, st_astext(st_centroid(st_transform(a.the_geom,4326))) as geo, st_astext(st_centroid(a.the_geom)) as center, st_astext(st_centroid(a.the_geom)) as utm, st_perimeter(a.the_geom) as umfang, st_astext(st_centroid(st_transform(a.the_geom, 31468))) as rd83, st_astext( st_centroid(a.the_geom)) as koordinaten, a.gemeinde as name, a.einwohner as einw, a.buergermeister as bm, a.einw_km as einw_km, a.wappen as wappen, a.vorwahl as vorwahl, a.plz as plz,a.the_geom as gemeindeumring  from gemeinden as a WHERE gem_schl='$gemeinde_id'";
  
	  $result = $dbqueryp($connectp,$query);
	  $r = $fetcharrayp($result);
	  $amtname=$r[0];
	  $amt=$r[1];
	  $area=$r["area"];
	  $s4283 = $r["koordinaten"];
      $gemeindename = $r["name"];
	  $gemeindeumring=$r["gemeindeumring"];
	  $bm = $r["bm"];
	  $vorwahl = $r["vorwahl"];
	  $einw = $r["einw"];
	  $einw_km = $r["einw_km"];
	  $wappen = $r["wappen"];
	  $area=$r["area"];	  
	  $utm = $r["utm"];
	  $geo = $r["geo"];
	  $rd83 = $r["rd83"];
	  $umfang = $r["umfang"];
	  $boxstring = $r["box"];
	  $klammern=array("(",")");
	  $boxstring = str_replace($klammern,"",$boxstring);
	  $koordinaten = explode(",",$boxstring);
	  $rechts_range = $koordinaten[0]-$koordinaten[2];
	  $hoch_range = $koordinaten[1]-$koordinaten[3];
 ?>
