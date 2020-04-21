<?php
# PHPlot Example: Bar chart, 3 data sets, shaded
require_once '/var/www/data/phplot_6_2/phplot.php';
include ("../../../../includes/connect_geobasis.php");
$reg_nr=$_GET["reg_nr"];

$query="SET client_encoding='LATIN1';SELECT a.stichtag, m.gesamt, p.asylbewerber_w, s.asylbewerber_m
from education.schulentwicklungsplanung as a
left join (
                select stichtag, count(gid) as gesamt FRom education.schulentwicklungsplanung
				WHERE reg_nr = '$reg_nr'
				AND schueler_migrantenstatus = 'Asylbewerber'
				group by stichtag
				ORDER BY stichtag desc) as m on a.stichtag = m.stichtag
left join (
                select stichtag, count(gid) as asylbewerber_w FRom education.schulentwicklungsplanung
					WHERE reg_nr = '$reg_nr'
					AND schueler_migrantenstatus = 'Asylbewerber'
					and schueler_geschlecht = 'weiblich'
					group by stichtag
					ORDER BY stichtag desc) as p on a.stichtag = p.stichtag
LEFT JOIN (
				select stichtag, count(gid) as asylbewerber_m FRom education.schulentwicklungsplanung
					WHERE reg_nr = '$reg_nr'
					AND schueler_migrantenstatus = 'Asylbewerber'
					and schueler_geschlecht = 'männlich'
					group by stichtag
					ORDER BY stichtag desc) as s on a.stichtag = s.stichtag				
where a.reg_nr = '$reg_nr'
group by a.stichtag, m.gesamt, p.asylbewerber_w, s.asylbewerber_m
order by a.stichtag";
$result = $dbqueryp($connectp,$query);
#$data=array();
	while($r = $fetcharrayp($result))
	 {
	   $label=$r[stichtag]; 
	   $data[]=array($label,$r[gesamt],$r[asylbewerber_w],$r[asylbewerber_m]);
	 }
	 
	 #var_dump($data);



$plot = new PHPlot(800, 400);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);

# Main plot title:
$plot->SetTitle('Entwicklung der Asylbewerber');

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