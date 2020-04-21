<?php
include ("../../../../includes/connect_geobasis.php");
include("sep_2015_k.php");
include("sep_2014_k.php");
include("sep_2013_k.php");
include("sep_2012_k.php");
include("sep_2011_k.php");

//globale Varibalen
$schema="education";
$tabelle="schulentwicklungsplanung";
$stichtage=['2011-09-09','2012-09-12','2013-09-10','2014-09-23','2015-09-30'];
$aktuelles_datum=$stichtage[0];

?>

<!DOCTYPE html>
<html>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
  <link href="../../css/style.css" rel="stylesheet">
  <link href="../../css/font-awesome.min.css" rel="stylesheet">
  <link href="../../css/bootstrap-theme.min.css" rel="stylesheet">
  
  <!-- **************** Export Bibliotheken ****************** -->
				
  <script type="text/javascript" src="../../export_libs/js/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="../../export_libs/js/FileSaver.min.js"></script>
  
  <!-- für Allgemeine Exportfunktionen -->
  <script type="text/javascript" src="../../export_libs/js/tableExport.js"></script>
  
  <!-- für XLSX -->
  <script type="text/javascript" src="../../export_libs/js/xlsx.core.min.js"></script>
  
  <!-- für PDF -->  
  <script type="text/javascript" src="../../export_libs/js/jspdf.min.js"></script>
  <script type="text/javascript" src="../../export_libs/js/jspdf.plugin.autotable.js"></script>
  
  <!-- für PNG --> 
  <script type="text/javascript" src="../../export_libs/js/html2canvas.min.js"></script>
  
  
  
</head>
<body>
  <h2>Bordered Table</h2>
  
  <button class="btn btn-success" onclick="$('#test').tableExport({type:'excel', worksheetName: 'Schulentwicklungsplanung', excelstyles:['border-bottom', 'border-top', 'border-left', 'border-right']});"><img src='../../export_libs/icons/xls.png' alt="XLSX" style="width:24px">  export als Excel 97 - 2003</button>
  <? include("sep_block_2015_k1.php");?>				   
	

				
				<script src="../../js/bootstrap.min.js"></script>
				<script src="../../js/scripts.js"></script>
			

</body>

</html>
