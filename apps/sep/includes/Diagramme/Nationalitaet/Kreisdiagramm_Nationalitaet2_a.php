<?php
# PHPlot Example: Simple line graph
require_once '/var/www/data/phplot_6_2/phplot.php';
include ("../../../../../includes/connect_geobasis.php");
$reg_nr=$_GET["reg_nr"];
$stichtage=$_GET["stichtage"];
//$data=array();

$query="SET client_encoding='LATIN1';SELECT a.stichtag, b.deutsch, c.migranten
from education.schulentwicklungsplanung as a
left join (
            SELECT COUNT(schueler_staatsangehoerigkeit) as deutsch
			FROM education.schulentwicklungsplanung
			WHERE amt_schl = $reg_nr
			AND stichtag = '$stichtage'
			AND schueler_staatsangehoerigkeit = 'Deutschland'
			GROUP BY schueler_staatsangehoerigkeit
		) as b on a.stichtag = stichtag
left join (
            SELECT COUNT(schueler_staatsangehoerigkeit) as migranten
			FROM education.schulentwicklungsplanung
			WHERE amt_schl = $reg_nr
			AND stichtag = '$stichtage'
			AND schueler_staatsangehoerigkeit NOT LIKE 'Deutschland'
		) as c on a.stichtag = stichtag
where a.amt_schl = $reg_nr
AND stichtag = '$stichtage'
group by a.stichtag, b.deutsch, c.migranten";
$result = $dbqueryp($connectp,$query);

	while($r = $fetcharrayp($result))
	{
		$label=$r[stichtag];
		$data[]=array($label,$r[deutsch],$r[migranten]);
	}

$plot = new PHPlot(700, 650);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('pie');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);

# Main plot title:
$plot->SetTitle('Schueleranteil gruppiert nach Deutschen und Migranten '.$stichtage);

# No 3-D shading of the bars:
$plot->SetShading(0);

# Make a legend for the 3 data sets plotted:
foreach ($data as $row)
$plot->SetLegend(array('Deutsch: '.$row[1], 'Migranten: '.$row[2]));
$plot->SetLegendPosition(0, 1.15, 'image', 0, 1, 7, 0);
$plot->SetLegendStyle('left', 'left');

# Make room for the legend to the left of the plot:
$plot->SetMarginsPixels(100,NULL,NULL,NULL);

$plot->DrawGraph();
?>