<?php
include ("/var/www/data/phplot_6_2/phplot.php");
$data = array(array('', 10), array('', 1));
$plot = new PHPlot();
$plot->SetDataValues($data);
$plot->SetTitle('First Test Plot');
$plot->DrawGraph();
