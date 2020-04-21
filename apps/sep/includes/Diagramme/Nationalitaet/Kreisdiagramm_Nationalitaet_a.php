<?php
# PHPlot Example: Simple line graph
require_once '/var/www/data/phplot_6_2/phplot.php';
include ("../../../../../includes/connect_geobasis.php");
$reg_nr=$_GET["reg_nr"];
$stichtage=$_GET["stichtage"];

$query="SET client_encoding='LATIN1';SELECT DISTINCT substring(schueler_staatsangehoerigkeit from 0 for 30) as nationalitaet, COUNT(schueler_staatsangehoerigkeit) as anzahl
			FROM education.schulentwicklungsplanung
			WHERE amt_schl = $reg_nr
			AND stichtag = '$stichtage'
			AND schueler_staatsangehoerigkeit NOT LIKE 'Deutschland'
			GROUP BY nationalitaet
			ORDER BY nationalitaet";
$result = $dbqueryp($connectp,$query);

	while($r = $fetcharrayp($result))
	{
		$data[] = array($r[nationalitaet],$r[anzahl]);
	}

$plot = new PHPlot(900, 650);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('pie');
$plot->SetDataType('text-data-single');
$plot->SetDataValues($data);

# Main plot title:
$plot->SetTitle('Schueleranteil der Migranten gruppiert nach Nationalitaet '.$stichtage);

# No 3-D shading of the bars:
$plot->SetShading(0);

# Make a legend for the 3 data sets plotted:
foreach ($data as $row)
$plot->SetLegend(implode(': ', $row));
#$plot->SetLegendPosition((-0.08), 1.3, 'image', 0, 1, 0, 0);
$plot->SetLegendPixels(5, 37);
$plot->SetLegendStyle('left', 'left');

# Make room for the legend to the left of the plot:
$plot->SetMarginsPixels(250,NULL,NULL,NULL);

$plot->DrawGraph();
?>