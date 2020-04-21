<?php
# PHPlot Example: Bar chart, 3 data sets, shaded
require_once '/var/www/data/phplot_6_2/phplot.php';
include ("../../../../../includes/connect_geobasis.php");
$schul_id=$_GET["schul_id"];

$query="SET client_encoding='LATIN1';SELECT a.stichtag, 	
case 	when schul_id='75530232' then coalesce(b.gesamta,0)+coalesce(e.gesamtb,0)-coalesce(h.gesamtc,0) 
	when schul_id='75530240' then coalesce(e.gesamtb,0)
	when (schul_id<>'75530232' and schul_id<>'75530240' and schueler_schulart='FöL') or (schul_id<>'75530232' or schul_id<>'75530240' or schueler_schulart='FöL') then coalesce(j.gesamte,0)
	when (schul_id<>'75530232' and schul_id<>'75530240' and schueler_schulart='Gy') or (schul_id<>'75530232' or schul_id<>'75530240' or schueler_schulart='Gy') then coalesce(b.gesamta,0) 
	when (schul_id<>'75530232' and schul_id<>'75530240' and schueler_schulart='IGS' or schueler_schulart='RegS' ) or (schul_id<>'75530232' or schul_id<>'75530240' or schueler_schulart='IGS' or schueler_schulart='RegS' ) then coalesce(i.gesamtd,0) 
end as gesamt,

case 	when schul_id='75530232' then coalesce(bw.weiblicha,0)+coalesce(ew.weiblichb,0)-coalesce(hw.weiblichc,0) 
	when schul_id='75530240' then coalesce(ew.weiblichb,0)
	when (schul_id<>'75530232' and schul_id<>'75530240' and schueler_schulart='FöL') or (schul_id<>'75530232' or schul_id<>'75530240' or schueler_schulart='FöL') then coalesce(jw.weibliche,0)
	when (schul_id<>'75530232' and schul_id<>'75530240' and schueler_schulart='Gy') or (schul_id<>'75530232' or schul_id<>'75530240' or schueler_schulart='Gy') then coalesce(bw.weiblicha,0) 
	when (schul_id<>'75530232' and schul_id<>'75530240' and schueler_schulart='IGS' or schueler_schulart='RegS' ) or (schul_id<>'75530232' or schul_id<>'75530240' or schueler_schulart='IGS' or schueler_schulart='RegS' ) then coalesce(iw.weiblichd,0) 
end as weiblich, 

case 	when schul_id='75530232' then coalesce(bm.maennlicha,0)+coalesce(em.maennlichb,0)-coalesce(hm.maennlichc,0) 
	when schul_id='75530240' then coalesce(em.maennlichb,0)
	when (schul_id<>'75530232' and schul_id<>'75530240' and schueler_schulart='FöL') or (schul_id<>'75530232' or schul_id<>'75530240' or schueler_schulart='FöL') then coalesce(jm.maennliche,0)
	when (schul_id<>'75530232' and schul_id<>'75530240' and schueler_schulart='Gy') or (schul_id<>'75530232' or schul_id<>'75530240' or schueler_schulart='Gy') then coalesce(bm.maennlicha,0) 
	when (schul_id<>'75530232' and schul_id<>'75530240' and schueler_schulart='IGS' or schueler_schulart='RegS' ) or (schul_id<>'75530232' or schul_id<>'75530240' or schueler_schulart='IGS' or schueler_schulart='RegS' ) then coalesce(im.maennlichd,0) 
end as maennlich
			
from education.schulentwicklungsplanung as a

left join (
                Select count(*) as gesamtb, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '13'
                group by stichtag
                order by stichtag desc
          ) as e on a.stichtag = e.stichtag
left join (
                Select count(*) as gesamta, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '12'
                group by stichtag
                order by stichtag desc
          ) as b on a.stichtag = b.stichtag
left join (
                Select count(*) as gesamtc, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_klasse LIKE '12K%'
                group by stichtag
                order by stichtag desc
          ) as h on a.stichtag = h.stichtag
left join (
                Select count(*) as gesamtd, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '10'
                group by stichtag
                order by stichtag desc
          ) as i on a.stichtag = i.stichtag 
left join (
                Select count(*) as gesamte, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '09'
                group by stichtag
                order by stichtag desc
          ) as j on a.stichtag = j.stichtag         
left join (
                Select count(*) as weiblichb, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '13'
				AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as ew on a.stichtag = ew.stichtag
left join (
                Select count(*) as weiblicha, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '12'
				AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as bw on a.stichtag = bw.stichtag
left join (
                Select count(*) as weiblichc, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_klasse LIKE '12K%'
				AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as hw on a.stichtag = hw.stichtag
left join (
                Select count(*) as weiblichd, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '10'
				AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as iw on a.stichtag = iw.stichtag 
left join (
                Select count(*) as weibliche, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '09'
				AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as jw on a.stichtag = jw.stichtag         
left join (
                Select count(*) as maennlicha, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '12'
                AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as d on a.stichtag = d.stichtag
left join (
                Select count(*) as maennlichb, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '13'
                AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as g on a.stichtag = g.stichtag
left join (
                Select count(*) as maennlichb, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '13'
				AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as em on a.stichtag = em.stichtag
left join (
                Select count(*) as maennlicha, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '12'
				AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as bm on a.stichtag = bm.stichtag
left join (
                Select count(*) as maennlichc, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_klasse LIKE '12K%'
				AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as hm on a.stichtag = hm.stichtag
left join (
                Select count(*) as maennlichd, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '10'
				AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as im on a.stichtag = im.stichtag 
left join (
                Select count(*) as maennliche, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
				AND schueler_jgst = '09'
				AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as jm on a.stichtag = jm.stichtag
where a.schul_id = '$schul_id'
group by a.stichtag, gesamt,weiblich, maennlich
order by a.stichtag";
$result = $dbqueryp($connectp,$query);
#$data=array();
	while($r = $fetcharrayp($result))
	 {
	   $label=$r[stichtag]; 
	   $data[]=array($label,$r[gesamt],$r[weiblich],$r[maennlich]);
	 }
	 
	 #var_dump($data);



$plot = new PHPlot(800, 400);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);

# Main plot title:
$plot->SetTitle('Entwicklung der Schulabgaenger');

# No 3-D shading of the bars:
$plot->SetShading(0);

# Make a legend for the 3 data sets plotted:
$plot->SetLegend(array('gesamt', 'weiblich', 'maennlich'));
$plot->SetLegendPosition(0, 1, 'plot', 0, 1, 7, 0);
$plot->SetLegendStyle('left', 'left');

# Set Y data limits, tick increment, and titles:
# $plot->SetPlotAreaWorld(NULL, 0, NULL, 100);
# $plot->SetYTickIncrement(10);
$plot->SetYTitle('Anzahl');
$plot->SetXTitle('Stichtag');

# Turn on Y data labels:
$plot->SetYDataLabelPos('plotin');

# Turn off X tick labels and ticks because they don't apply here:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

$plot->DrawGraph();
?>