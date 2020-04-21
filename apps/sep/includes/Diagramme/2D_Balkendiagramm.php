<?php
# PHPlot Example: Bar chart, 3 data sets, shaded
require_once '/var/www/data/phplot_6_2/phplot.php';
include ("../../../../includes/connect_geobasis.php");
$schul_id=$_GET["schul_id"];

$query="SET client_encoding='LATIN1';SELECT a.stichtag, b.gesamt, c.weiblich, d.maennlich
from education.schulentwicklungsplanung as a
left join (
                Select count(*) as gesamt, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
                group by stichtag
                order by stichtag desc
          ) as b on a.stichtag = b.stichtag
left join (
                Select count(*) as weiblich, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
                AND schueler_geschlecht = 'weiblich'
                group by stichtag
                order by stichtag desc
          ) as c on a.stichtag = c.stichtag
left join (
                Select count(*) as maennlich, stichtag
                from education.schulentwicklungsplanung
                where schul_id = '$schul_id'
                AND schueler_geschlecht = 'männlich'
                group by stichtag
                order by stichtag desc
          ) as d on a.stichtag = d.stichtag
where a.schul_id = '$schul_id'
group by a.stichtag, b.gesamt, c.weiblich, d.maennlich
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
$plot->SetTitle('Entwicklung der Schuelerzahlen');

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