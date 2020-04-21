<?php
# PHPlot Example: Bar chart, 3 data sets, shaded
require_once '/var/www/data/phplot_6_2/phplot.php';
include ("../includes/connect_geobasis.php");

$query="SET client_encoding='LATIN1';SELECT name,gesamt FROM population.a_1990_bevoelkerung;";
$result = $dbqueryp($connectp,$query);
#$data=array();

	while($r = $fetcharrayp($result))
	 {
	   $label=$r[name]; 
	   $data[]=array($label,$r[gesamt]);
	   
	 }
	 
	 #var_dump($data);



$plot = new PHPlot(1600, 600);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('pie');
$plot->SetDataType('text-data-single');
$plot->SetDataValues($data);

# Main plot title:
$plot->SetTitle('Einwohnerzahlen der Amtsbereiche 1990');

# Make a legend for the 3 data sets plotted:
foreach ($data as $row)
  $plot->SetLegend(implode(': ', $row));


#$plot->SetLegend($label_array);

# Turn off X tick labels and ticks because they don't apply here:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

$plot->DrawGraph();
