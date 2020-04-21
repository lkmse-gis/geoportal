<?php
# PHPlot Example: Simple line graph
require_once '/var/www/data/phplot_6_2/phplot.php';
include ("../../../../includes/connect_geobasis.php");

$query="SET client_encoding='LATIN1';SELECT 
a.name,
a.dsa as dsa_2011,
b.dsa as dsa_2012,
c.dsa as dsa_2013,
d.dsa as dsa_2014,
e.dsa as dsa_2011_m,
f.dsa as dsa_2012_m,
g.dsa as dsa_2013_m,
h.dsa as dsa_2014_m,
i.dsa as dsa_2011_w,
j.dsa as dsa_2012_w,
k.dsa as dsa_2013_w,
l.dsa as dsa_2014_w
from
population.a_2011_bevoelkerung_g as a
left join (
        SELECT name, dsa from population.a_2012_bevoelkerung_g
        ) as b on a.name = b.name
left join (
        SELECT name, dsa from population.a_2013_bevoelkerung_g
        ) as c on a.name = c.name
left join (
        SELECT name, dsa from population.a_2014_bevoelkerung_g
        ) as d on a.name = d.name
left join (
        SELECT name, dsa from population.a_2011_bevoelkerung_m
        ) as e on a.name = e.name
left join (
        SELECT name, dsa from population.a_2012_bevoelkerung_m
        ) as f on a.name = f.name
left join (
        SELECT name, dsa from population.a_2013_bevoelkerung_m
        ) as g on a.name = g.name
left join (
        SELECT name, dsa from population.a_2014_bevoelkerung_m
        ) as h on a.name = h.name
left join (
        SELECT name, dsa from population.a_2011_bevoelkerung_w
        ) as i on a.name = i.name
left join (
        SELECT name, dsa from population.a_2012_bevoelkerung_w
        ) as j on a.name = j.name
left join (
        SELECT name, dsa from population.a_2013_bevoelkerung_w
        ) as k on a.name = k.name
left join (
        SELECT name, dsa from population.a_2014_bevoelkerung_w
        ) as l on a.name = l.name
ORDER by a.name;";
$result = $dbqueryp($connectp,$query);
#$data=array();
while($r = $fetcharrayp($result))
	 {
	   $label=$r[name]; 
	   $data[]=array($label,$r[1],$r[2],$r[3],$r[4]);
	 }
	 
	 #var_dump($data);



$plot = new PHPlot(1600, 800);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);

# Main plot title:
#$plot->SetTitle('Entwicklung der Schülerzahlen');

# No 3-D shading of the bars:
$plot->SetShading(0);

# Make a legend for the 3 data sets plotted:
$plot->SetLegend(array('2011', '2012', '2013', '2014'));
$plot->SetLegendPosition(0, 1, 'plot', 0, 1, 7, 0);
$plot->SetLegendStyle('left', 'left');

# Set Y data limits, tick increment, and titles:
# $plot->SetPlotAreaWorld(NULL, 0, NULL, 100);
# $plot->SetYTickIncrement(10);
$plot->SetYTitle('Durchschnittsalter');
$plot->SetXTitle('Amtsverwaltungen');

# Turn on Y data labels:
$plot->SetYDataLabelPos('plotin');

# Turn off X tick labels and ticks because they don't apply here:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

$plot->DrawGraph();
?>