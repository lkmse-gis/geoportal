<!DOCTYPE html>
<?php
include("../../includes/connect_geobasis.php");

$schema = htmlspecialchars($_POST['schema']);
$tabelle = htmlspecialchars($_POST['tabelle']);

$query="select nspname from pg_catalog.pg_namespace WHERE nspname NOT LIKE 'pg_%' AND nspname != 'information_schema' ORDER BY nspname ";

$result = $dbqueryp($connectp,$query);
$counter=0;


?>
<html>
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
<body>
 <div style="text-align:center;margin-top:0px;padding:10px;background-color:#006085;box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.15);">
    <span class="step finish">1<div style="margin-left:-10px;margin-top:-10px"><br>Schema</div></span>
    <span class="step active">2<div style="margin-left:-8px;margin-top:-10px"><br>Tabelle</div></span>
    <span class="step">3<div style="margin-left:-10px;margin-top:-10px"><br>Attribute</div></span>
    <span class="step">4<div style="margin-left:-4px;margin-top:-10px"><br>Prüfen</div></span>
	<span class="step">5<div style="margin-left:-4px;margin-top:-10px"><br>Import</div></span>
  </div>
  <br>
 <div class="kopf"></div>
<form id="regForm" action="schritt3.php" method="POST">
  <h1>Adressschlüssel-Tool <small>v1.0</small></h1>
  <br>
  <div class="tab" style="text-align:center;"><b>aus <? echo $schema ?></b><br>wählen:
 <?php ///////////////////////////////////////////////////// Tabelle

$query1="SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema ='$schema' ORDER by table_name";

$result1 = $dbqueryp($connectp,$query1);
$counter1=0;
while($g = $fetcharrayp($result1))
{
	$table_name[$counter1] = $g[table_name];
	$counter1++;
	
}; 

echo"<p><select size='20' name='tabelle'  style='width:300px'>";
	for ($i = 0; $i < $counter1; $i++)
	{
		echo'<option '; if ( $tabelle==$table_name[$i]){ echo'selected';};echo' value='.$table_name[$i].'>'.$table_name[$i].'</option>';
	};
echo'</select><input type="hidden" name="schema" value='.$schema.'></p>';
?>

  </div>
  <div style="overflow:auto;">
    <div style="text-align:center;">
	<button type="reset" id="reset" value="Reset" onclick="window.location.replace('index.php')" >Abbrechen</button>
    <button type="button" id="prevBtn_disabled" onclick="window.location.replace('index.php')" disabled >Zurück</button>
    <button type="submit" id="nextBtn" ">Nächster Schritt</button>
    </div>
  </div>


</form>

</body>
</html>
