<?php
# PHPlot Example: Simple line graph
require_once '/var/www/data/phplot_6_2/phplot.php';
include ("../../../../../includes/connect_geobasis.php");
$stichtage=$_GET["stichtage"];

$query="SET client_encoding='LATIN1';Select gruppierung,gesamt
from education.schulen_gruppierungstabelle
where stichtag = '$stichtage'
and art = 'schulart'
and ebene = 13071
order by gruppierung ASC";
$result = $dbqueryp($connectp,$query);

	while($r = $fetcharrayp($result))
	{
		$data[] = array($r[gruppierung],$r[gesamt]);
	}

$plot = new PHPlot(700, 500);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('pie');
$plot->SetDataType('text-data-single');
$plot->SetDataValues($data);

# Main plot title:
$plot->SetTitle('Schueleranteil nach Schulart '.$stichtage);

# No 3-D shading of the bars:
$plot->SetShading(0);

# Make a legend for the 3 data sets plotted:
foreach ($data as $row)
$plot->SetLegend(implode(': ', $row));
#$plot->SetLegendPosition(0, 1.01, 'image', 0, 1, 7, 0);
$plot->SetLegendPixels(5, 37);
$plot->SetLegendStyle('left', 'left');

# Make room for the legend to the left of the plot:
$plot->SetMarginsPixels(100,NULL,NULL,NULL);

$plot->DrawGraph();
?>