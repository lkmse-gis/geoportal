<?php
# PHPlot Example: Simple line graph
require_once '/var/www/data/phplot_6_2/phplot.php';
include ("../../../../includes/connect_geobasis.php");
$reg_nr=$_GET["reg_nr"];

$query="SET client_encoding='LATIN1';SELECT a.stichtag, coalesce(b.gesamt,0)+coalesce(f.gesamt,0)+coalesce(i.gesamt,0) as gesamt, coalesce(c.asylbewerber_w,0)+coalesce(g.aussiedler_w,0)+coalesce(j.fluechtlinge_w,0) as weiblich, coalesce(e.asylbewerber_m,0)+coalesce(h.aussiedler_m,0)+coalesce(k.fluechtlinge_m,0) as maennlich
from education.schulentwicklungsplanung as a
left join (
                select stichtag, count(gid) as gesamt FRom education.schulentwicklungsplanung
				WHERE schueler_migrantenstatus = 'Asylbewerber'
				group by stichtag
				ORDER BY stichtag desc) as b on a.stichtag = b.stichtag
left join (
                select stichtag, count(gid) as asylbewerber_w FRom education.schulentwicklungsplanung
				WHERE schueler_migrantenstatus = 'Asylbewerber'
				and schueler_geschlecht = 'weiblich'
				group by stichtag
				ORDER BY stichtag desc) as c on a.stichtag = c.stichtag
LEFT JOIN (
				select stichtag, count(gid) as asylbewerber_m FRom education.schulentwicklungsplanung
				WHERE schueler_migrantenstatus = 'Asylbewerber'
				and schueler_geschlecht = 'männlich'
				group by stichtag
				ORDER BY stichtag desc) as e on a.stichtag = e.stichtag
left join (
                select stichtag, count(gid) as gesamt 
				FRom education.schulentwicklungsplanung
				WHERE schueler_migrantenstatus = 'Aussiedler'
				group by stichtag
				ORDER BY stichtag desc) as f on a.stichtag = f.stichtag
left join (
                select stichtag, count(gid) as aussiedler_w FRom education.schulentwicklungsplanung
				WHERE schueler_migrantenstatus = 'Aussiedler'
				and schueler_geschlecht = 'weiblich'
				group by stichtag
				ORDER BY stichtag desc) as g on a.stichtag = g.stichtag
LEFT JOIN (
				select stichtag, count(gid) as aussiedler_m FRom education.schulentwicklungsplanung
				WHERE schueler_migrantenstatus = 'Aussiedler'
				and schueler_geschlecht = 'männlich'
				group by stichtag
				ORDER BY stichtag desc) as h on a.stichtag = h.stichtag
left join (
                select stichtag, count(gid) as gesamt FRom education.schulentwicklungsplanung
				WHERE schueler_migrantenstatus = 'Flüchtlinge'
				group by stichtag
				ORDER BY stichtag desc) as i on a.stichtag = i.stichtag
left join (
                select stichtag, count(gid) as fluechtlinge_w FRom education.schulentwicklungsplanung
				WHERE schueler_migrantenstatus = 'Flüchtlinge'
				and schueler_geschlecht = 'weiblich'
				group by stichtag
				ORDER BY stichtag desc) as j on a.stichtag = j.stichtag
LEFT JOIN (
				select stichtag, count(gid) as fluechtlinge_m FRom education.schulentwicklungsplanung
				WHERE schueler_migrantenstatus = 'Flüchtlinge'
				and schueler_geschlecht = 'männlich'
				group by stichtag
				ORDER BY stichtag desc) as k on a.stichtag = k.stichtag				
group by a.stichtag, coalesce(b.gesamt,0)+coalesce(f.gesamt,0)+coalesce(i.gesamt,0), coalesce(c.asylbewerber_w,0)+coalesce(g.aussiedler_w,0)+coalesce(j.fluechtlinge_w,0), coalesce(e.asylbewerber_m,0)+coalesce(h.aussiedler_m,0)+coalesce(k.fluechtlinge_m,0)
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

$plot->SetPlotType('lines');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);

# Main plot title:
$plot->SetTitle('Entwicklung der Migranten');

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