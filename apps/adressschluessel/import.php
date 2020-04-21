<!DOCTYPE html>
<?php
include("../../includes/connect_geobasis.php");

$schema = htmlspecialchars($_POST['schema']);
$tabelle = htmlspecialchars($_POST['tabelle']);
$speicher = unserialize(rawurldecode($_POST['speicher']));

$query="select nspname from pg_catalog.pg_namespace WHERE nspname NOT LIKE 'pg_%' AND nspname != 'information_schema' ORDER BY nspname ";

$result = $dbqueryp($connectp,$query);
$counter=0;


?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="style.css" rel="stylesheet">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="style.css" rel="stylesheet">
</head>
<body>
 <div style="text-align:center;margin-top:0px;padding:10px;background-color:#006085;box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.15);">
    <span class="step finish">1<div style="margin-left:-10px;margin-top:-10px"><br>Schema</div></span>
    <span class="step finish">2<div style="margin-left:-8px;margin-top:-10px"><br>Tabelle</div></span>
    <span class="step finish">3<div style="margin-left:-10px;margin-top:-10px"><br>Attribute</div></span>
    <span class="step finish">4<div style="margin-left:-4px;margin-top:-10px"><br>Prüfen</div></span>
	<span class="step active">5<div style="margin-left:-4px;margin-top:-10px"><br>Import</div></span>
  </div>
  <br>
 <div class="kopf"></div>
<?php
//echo '<pre>'; 
//print_r($speicher); 
//echo '</pre>'; 
$i = 0;
foreach ($speicher as $key => $value) {
				
	foreach ($value as $key1 => $value1) {
					
		$gid[$key] = $key1;
		$schluessel[$key] = $value1;
		$i++;
		}
	}
$count=0;			
while ($count < $i){			
$gid[$count];
$schluessel[$count];

$query = "UPDATE $schema.$tabelle SET adressschluessel = '$schluessel[$count]' WHERE gid  = $gid[$count]"; 
		$result = $dbqueryp($connectp,$query);   
		if (!$result){  
			echo "<div class='alert alert-danger' role='alert'>Update fehlgeschlagen<br>$query</div>";  
			}  
		else  
			{
			echo "<div class='alert alert-success' role='alert'>Update erfolgreich gespeichert<br>$query</div>";  
			

			}; 
			
		$count++;
		};


			
?>

<div style="overflow:auto;">
	<div style="text-align:center;">
		<button type="reset" id="reset" value="Reset" onclick="window.location.replace('index.php')" >Beenden</button>
	</div>
</div>
<br>
</body>
</html>
