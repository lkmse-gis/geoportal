<?php
# PHPlot Example: Bar chart, 3 data sets, shaded
require_once '/var/www/data/phplot_6_2/phplot.php';
include ("../includes/connect_geobasis.php");

$query="SET client_encoding='LATIN1';SELECT name,gesamt,mann,frau FROM population.a_1990_bevoelkerung";
$result = $dbqueryp($connectp,$query);
#$data=array();
	while($r = $fetcharrayp($result))
	 {
	   $label=$r[name]; 
	   $data[]=array($label,$r[gesamt],$r[mann],$r[frau]);
	 }
	 
	 #var_dump($data);



$plot = new PHPlot(1600, 600);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);

# Main plot title:
$plot->SetTitle('Einwohnerzahlen der Amtsbereiche 1990');

# Make a legend for the 3 data sets plotted:
$plot->SetLegend(array('gesamt', 'männlich', 'weiblich'));

# Turn off X tick labels and ticks because they don't apply here:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

$plot->DrawGraph();
