<?php
# PHPlot Example: Bar chart, 3 data sets, shaded
require_once '/var/www/data/phplot_6_2/phplot.php';
include ("../../../../../includes/connect_geobasis.php");
$stichtage=$_GET["stichtage"];
$reg_nr=$_GET["reg_nr"];

$query="SET client_encoding='LATIN1';SELECT a.schueler_alter, b.gesamt, c.weiblich, d.maennlich
FROM education.schulentwicklungsplanung as a
LEFT JOIN(
		SELECT schueler_alter, COUNT(*) as gesamt
		FROM education.schulentwicklungsplanung
		WHERE stichtag = '$stichtage'
		AND schueler_alter BETWEEN 06 AND 19
		AND reg_nr = '$reg_nr'
		GROUP BY schueler_alter
		ORDER By schueler_alter ASC) as b on a.schueler_alter = b.schueler_alter
LEFT JOIN(
		SELECT schueler_alter, COUNT(*) as weiblich
		FROM education.schulentwicklungsplanung
		WHERE stichtag = '$stichtage'
		AND schueler_alter BETWEEN 06 AND 19
		AND reg_nr = '$reg_nr'
		AND schueler_geschlecht = 'weiblich'
		GROUP BY schueler_alter
		ORDER By schueler_alter ASC) as c on a.schueler_alter = c.schueler_alter
LEFT JOIN(
		SELECT schueler_alter, COUNT(*) as maennlich
		FROM education.schulentwicklungsplanung
		WHERE stichtag = '$stichtage'
		AND schueler_alter BETWEEN 06 AND 19
		AND reg_nr = '$reg_nr'
		AND schueler_geschlecht = 'männlich'
		GROUP BY schueler_alter
		ORDER By schueler_alter ASC) as d on a.schueler_alter = d.schueler_alter		
WHERE stichtag = '$stichtage'
AND a.schueler_alter BETWEEN 06 AND 19
AND reg_nr = '$reg_nr'
GROUP BY a.schueler_alter, b.gesamt, c.weiblich, d.maennlich
ORDER By a.schueler_alter ASC";
$result = $dbqueryp($connectp,$query);
#$data=array();
	while($r = $fetcharrayp($result))
	 {
	   $label=$r[schueler_alter]; 
	   $data[]=array($label,$r[gesamt],$r[weiblich],$r[maennlich]);
	 }
	 
	 #var_dump($data);



$plot = new PHPlot(1500, 800);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);

# Main plot title:
$plot->SetTitle('Schueleranteil gruppiert nach Alter und Geschlecht '.$stichtage);

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
$plot->SetXTitle('Alter');

# Turn on Y data labels:
$plot->SetYDataLabelPos('plotin');

# Turn off X tick labels and ticks because they don't apply here:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

$plot->DrawGraph();
?>