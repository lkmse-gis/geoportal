<?php
include("../../includes/connect_geobasis.php");

$schema = htmlspecialchars($_POST['schema']);
$tabelle = htmlspecialchars($_POST['tabelle']);

$query="select nspname from pg_catalog.pg_namespace WHERE nspname NOT LIKE 'pg_%' AND nspname != 'information_schema' ORDER BY nspname ";

$result = $dbqueryp($connectp,$query);
$counter=0;

echo'<center><h3>Automatisierte Adressschlüsselsuche</h3>';
echo'<table><tr>';

////////////////////////////////////////////////////// Schema

echo'<form action="index.php" method="POST" >
<label>Schema</label>
  <select name="schema" size="20" style="width:300px">';
  
	while($r = $fetcharrayp($result))
	{
		echo'<option '; if ( $schema==$r[nspname]){ echo'selected';};echo' value='.$r[nspname].'>'.$r[nspname].'</option>';
		$counter++;
	};
  echo'</select>
 
  <button type="submit" value="1">-></button>
</form>';
echo'</tr><tr>';

///////////////////////////////////////////////////// Tabelle

$query1="SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema ='$schema'";

$result1 = $dbqueryp($connectp,$query1);
$counter1=0;
while($g = $fetcharrayp($result1))
{
	$table_name[$counter1] = $g[table_name];
	$counter1++;
};

echo'<form action="index.php" method="POST">

<label>Tabelle</label>';
echo"<select size='20' name='tabelle'  style='width:300px'>";
	for ($i = 0; $i < $counter1; $i++)
	{
		echo'<option '; if ( $tabelle==$table_name[$i]){ echo'selected';};echo' value='.$table_name[$i].'>'.$table_name[$i].'</option>';
	};
echo'</select><input type="hidden" name="schema" value='.$schema.'><button type="submit" value="1">-></button></form>';
	
echo'</tr></table><br><br>';
echo'<table><tr>';

///////////////////////////////////////////////////// Spalten

$query2="SELECT column_name FROM information_schema.columns WHERE table_name = '$tabelle'";

$result2 = $dbqueryp($connectp,$query2);
$counter2=0;


while($h = $fetcharrayp($result2))
{
	$spalte[$counter2] = $h[column_name];
	$counter2++;
};

echo'<form action="pruefer.php" method="POST">

<label>Ort = </label>';
echo"<select name='ort' style='width:300px'>";
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	};
echo'</select><br>
<label>Straße = </label>';
echo"<select name='strasse' style='width:300px'>";
echo'<option value="null"></option>';
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	};
echo'</select><br>';
echo'<label>Hausnummer = </label>';
echo"<select name='hausnummer' style='width:300px'>";
echo'<option value="null"></option>';
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	};
echo'</select><br>';
echo'<label>Hausnummerzusatz = </label>';
echo"<select name='zusatz' style='width:300px'>";
echo'<option value="null">optional</option>';
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	};
echo'</select><br>';
echo'<b> oder </b> Adresse ';
echo"<select name='adresse' style='width:300px'>";
echo'<option value="null"></option>';
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	};
echo'</select><br>';
echo 'Beschreibung ';
echo"<select name='beschreibung' style='width:300px'>";
echo'<option value="null">optional</option>';
	for ($i = 0; $i < $counter2; $i++)
	{
		echo'<option value='.$spalte[$i].'>'.$spalte[$i].'</option>';
	};
echo'</select>';
echo '<input type="hidden" name="schema" value='.$schema.'><input type="hidden" name="tabelle" value='.$tabelle.'>';
echo'<button type="submit" name="action" value="1" >Starten</button></form>';
echo '</tr></table></center>';
echo '<pre>';
print_r ($spalte);
echo '</pre>';
?>