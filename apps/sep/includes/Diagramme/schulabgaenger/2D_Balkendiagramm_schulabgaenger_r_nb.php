<?php
# PHPlot Example: Bar chart, 3 data sets, shaded
require_once '/var/www/data/phplot_6_2/phplot.php';
include ("../../../../../includes/connect_geobasis.php");
$schul_id=$_GET["schul_id"];

$query="SET client_encoding='LATIN1';SELECT a.stichtag, 
	coalesce(b.gesamt_b,0)+coalesce(c.gesamt_c,0)+coalesce(d.gesamt_d,0)+coalesce(e.gesamt_e,0)+coalesce(f.gesamt_f,0)-coalesce(g.gesamt_g,0)-coalesce(h.gesamt_h,0)+coalesce(i.gesamt_i,0)+coalesce(j.gesamt_j,0) as gesamt,
	coalesce(bw.weiblich_b,0)+coalesce(cw.weiblich_c,0)+coalesce(dw.weiblich_d,0)+coalesce(ew.weiblich_e,0)+coalesce(fw.weiblich_f,0)-coalesce(gw.weiblich_g,0)-coalesce(hw.weiblich_h,0)+coalesce(iw.weiblich_i,0)+coalesce(jw.weiblich_j,0) as weiblich,
	coalesce(bm.maennlich_b,0)+coalesce(cm.maennlich_c,0)+coalesce(dm.maennlich_d,0)+coalesce(em.maennlich_e,0)+coalesce(fm.maennlich_f,0)-coalesce(gm.maennlich_g,0)-coalesce(hm.maennlich_h,0)+coalesce(im.maennlich_i,0)+coalesce(jm.maennlich_j,0) as maennlich	
from education.schulentwicklungsplanung as a

left join (
                Select count(*) as gesamt_b, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '13'
		AND reg_nr = 4
                group by stichtag
                order by stichtag desc
          ) as b on a.stichtag = b.stichtag
left join (
                Select count(*) as gesamt_c, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '12'
		AND reg_nr = 4
                group by stichtag
                order by stichtag desc
          ) as c on a.stichtag = c.stichtag
left join (
                Select count(*) as gesamt_d, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '10'
		AND reg_nr = 4
		AND schueler_schulart = 'IGS'
		AND schueler_bildungsgang = 'regBg'
                group by stichtag
                order by stichtag desc
          ) as d on a.stichtag = d.stichtag 
left join (
                Select count(*) as gesamt_e, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '10'
		AND reg_nr = 4
		AND schueler_schulart = 'RegS'
                group by stichtag
                order by stichtag desc
          ) as e on a.stichtag = e.stichtag
left join (
                Select count(*) as gesamt_f, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst BETWEEN '09' AND '13'
		AND reg_nr = 4
		AND schueler_schulart = 'FöL'
                group by stichtag
                order by stichtag desc
          ) as f on a.stichtag = f.stichtag
left join (
                Select count(*) as gesamt_g, stichtag
                from education.schulentwicklungsplanung
                where schueler_klasse LIKE '12K%'
		AND schul_id = '75530232'
                group by stichtag
                order by stichtag desc
          ) as g on a.stichtag = g.stichtag
left join (
                Select count(*) as gesamt_h, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '12'
		AND schul_id = '75530240'
                group by stichtag
                order by stichtag desc
          ) as h on a.stichtag = h.stichtag
left join (
                Select count(*) as gesamt_i, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst BETWEEN '09' AND '10'
		AND schueler_schulart = 'FöK'
		AND reg_nr = 4
                group by stichtag
                order by stichtag desc
          ) as i on a.stichtag = i.stichtag 
left join (
                Select count(*) as gesamt_j, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst BETWEEN '09' AND '10'
		AND schueler_schulart = 'FöKr'
		AND reg_nr = 4
                group by stichtag
                order by stichtag desc
          ) as j on a.stichtag = j.stichtag  

left join (
                Select count(*) as weiblich_b, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '13'
		AND reg_nr = 4
		AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as bw on a.stichtag = bw.stichtag
left join (
                Select count(*) as weiblich_c, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '12'
		AND reg_nr = 4
		AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as cw on a.stichtag = cw.stichtag
left join (
                Select count(*) as weiblich_d, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '10'
		AND reg_nr = 4
		AND schueler_schulart = 'IGS'
		AND schueler_bildungsgang = 'regBg'
		AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as dw on a.stichtag = dw.stichtag 
left join (
                Select count(*) as weiblich_e, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '10'
		AND reg_nr = 4
		AND schueler_schulart = 'RegS'
		AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as ew on a.stichtag = ew.stichtag
left join (
                Select count(*) as weiblich_f, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst BETWEEN '09' AND '13'
		AND reg_nr = 4
		AND schueler_schulart = 'FöL'
		AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as fw on a.stichtag = fw.stichtag
left join (
                Select count(*) as weiblich_g, stichtag
                from education.schulentwicklungsplanung
                where schueler_klasse LIKE '12K%'
		AND schul_id = '75530232'
		AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as gw on a.stichtag = gw.stichtag
left join (
                Select count(*) as weiblich_h, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '12'
		AND schul_id = '75530240'
		AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as hw on a.stichtag = hw.stichtag 
left join (
                Select count(*) as weiblich_i, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst BETWEEN '09' AND '10'
		AND schueler_schulart = 'FöK'
		AND reg_nr = 4
		AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as iw on a.stichtag = iw.stichtag 
left join (
                Select count(*) as weiblich_j, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst BETWEEN '09' AND '10'
		AND schueler_schulart = 'FöKr'
		AND reg_nr = 4
		AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as jw on a.stichtag = jw.stichtag

left join (
                Select count(*) as maennlich_b, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '13'
		AND reg_nr = 4
		AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as bm on a.stichtag = bm.stichtag
left join (
                Select count(*) as maennlich_c, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '12'
		AND reg_nr = 4
		AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as cm on a.stichtag = cm.stichtag
left join (
                Select count(*) as maennlich_d, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '10'
		AND reg_nr = 4
		AND schueler_schulart = 'IGS'
		AND schueler_bildungsgang = 'regBg'
		AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as dm on a.stichtag = dm.stichtag 
left join (
                Select count(*) as maennlich_e, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '10'
		AND reg_nr = 4
		AND schueler_schulart = 'RegS'
		AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as em on a.stichtag = em.stichtag
left join (
                Select count(*) as maennlich_f, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst BETWEEN '09' AND '13'
		AND reg_nr = 4
		AND schueler_schulart = 'FöL'
		AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as fm on a.stichtag = fm.stichtag
left join (
                Select count(*) as maennlich_g, stichtag
                from education.schulentwicklungsplanung
                where schueler_klasse LIKE '12K%'
		AND schul_id = '75530232'
		AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as gm on a.stichtag = gm.stichtag
left join (
                Select count(*) as maennlich_h, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst = '12'
		AND schul_id = '75530240'
		AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as hm on a.stichtag = hm.stichtag
left join (
                Select count(*) as maennlich_i, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst BETWEEN '09' AND '10'
		AND schueler_schulart = 'FöK'
		AND reg_nr = 4
		AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as im on a.stichtag = im.stichtag 
left join (
                Select count(*) as maennlich_j, stichtag
                from education.schulentwicklungsplanung
                where schueler_jgst BETWEEN '09' AND '10'
		AND schueler_schulart = 'FöKr'
		AND reg_nr = 4
		AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as jm on a.stichtag = jm.stichtag
WHERE reg_nr = 4
group by a.stichtag, gesamt, weiblich, maennlich
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