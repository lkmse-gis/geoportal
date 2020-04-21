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
    <span class="step finish">2<div style="margin-left:-8px;margin-top:-10px"><br>Tabelle</div></span>
    <span class="step active">3<div style="margin-left:-10px;margin-top:-10px"><br>Attribute</div></span>
    <span class="step">4<div style="margin-left:-4px;margin-top:-10px"><br>Prüfen</div></span>
	<span class="step">5<div style="margin-left:-4px;margin-top:-10px"><br>Import</div></span>
  </div>
  <br>
 <div class="kopf"></div>
<form id="regForm" action="pruefer.php" method="POST">
  <h1>Adressschlüssel-Tool <small>v1.0</small></h1>

  <br>


  <div class="tab" style="text-align:center;"><b>aus <? echo $schema.'.'.$tabelle ?></b><br>wählen:
  <p>
<?php
///////////////////////////////////////////////////// Spalten

$query2="SELECT column_name FROM information_schema.columns WHERE table_name = '$tabelle'";

$result2 = $dbqueryp($connectp,$query2);
$counter2=0;


while($h = $fetcharrayp($result2))
{
	$spalte[$counter2] = $h[column_name];
	$counter2++;
};

echo'<hr><p><label>Ort</label>';
echo"<select name='ort' style='width:300px'>";
echo'<option value="null"></option>';
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	};
echo'</select></p><hr>
<p><label>PLZ</label>';
echo"<select name='plz' style='width:300px'>";
echo'<option value="null"></option>';
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	};
echo'</select></p><hr>
<p><label>Straße</label>';
echo"<select name='strasse' style='width:300px'>";
echo'<option value="null"></option>';
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	};
echo'</select></p><hr>';
echo'<p><label>Hausnummer</label>';
echo"<select name='hausnummer' style='width:300px'>";
echo'<option value="null"></option>';
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	};
echo'</select></p><hr>';
echo'<p><label>Hausnummerzusatz</label>';
echo"<select name='zusatz' style='width:300px'>";
echo'<option value="null"></option>';
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	};
echo'</select></p><hr>';
echo'<p><label>Adresse</label>';
echo"<select name='adresse' style='width:300px'>";
echo'<option value="null"></option>';
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	}; 
echo'</select></p><hr>';
echo '<p><label>Beschreibung</label>';
echo"<select name='beschreibung' style='width:300px'>";
echo'<option value="null">optional</option>';
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	};
echo'</select></p><hr>';
echo '<input type="hidden" name="schema" value='.$schema.'><input type="hidden" name="tabelle" value='.$tabelle.'>';

?></p>
  </div>
  <div style="overflow:auto;">
    <div style="text-align:center;">
	<button type="reset" id="reset" value="Reset" onclick="window.location.replace('index.php')" >Abbrechen</button>
    <button type="submit" id="prevBtn_disabled" onclick="window.location.replace('schritt2.php')" disabled>Zurück</button>
    <button type="submit" name="fertig" id="nextBtn" ">Ermitteln</button>
    </div>
  </div>

</form>


</body>
</html>
