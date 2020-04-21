
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="style.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

 <div style="text-align:center;margin-top:0px;padding:10px;background-color:#006085;box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.15);">
    <span class="step finish">1<div style="margin-left:-10px;margin-top:-10px"><br>Schema</div></span>
    <span class="step finish">2<div style="margin-left:-8px;margin-top:-10px"><br>Tabelle</div></span>
    <span class="step finish">3<div style="margin-left:-10px;margin-top:-10px"><br>Attribute</div></span>
    <span class="step active">4<div style="margin-left:-4px;margin-top:-10px"><br>Prüfen</div></span>
	<span class="step">5<div style="margin-left:-4px;margin-top:-10px"><br>Import</div></span>
  </div>
    <br>
 <div class="kopf"></div>

<?php
include("../../includes/connect_geobasis.php");
$schema = htmlspecialchars($_POST['schema']);
$tabelle = htmlspecialchars($_POST['tabelle']);
$ort = htmlspecialchars($_POST['ort']);
$plz = htmlspecialchars($_POST['plz']);
$strasse = htmlspecialchars($_POST['strasse']);
$hausnummer = htmlspecialchars($_POST['hausnummer']);
$zusatz = htmlspecialchars($_POST['zusatz']);
$adresse = htmlspecialchars($_POST['adresse']);
$beschreibung = htmlspecialchars($_POST['beschreibung']);

function cleanWhitespace($string) { // Funktion unötige Leerzeichen entfernen 
    return trim( preg_replace('/\s+/', ' ', $string) ); 
} 

// Daten auslesen und Tabelle generieren
if($adresse !== 'null'){$query11="SELECT gid, $ort,$plz, $adresse, $beschreibung FROM $schema.$tabelle ORDER BY gid";}
else{
	if ($zusatz === 'null'){$query11="SELECT gid, $ort,$plz, $strasse, $hausnummer, $beschreibung FROM $schema.$tabelle ORDER BY gid";}
	else{$query11="SELECT gid, $ort,$plz, $strasse, $hausnummer,$zusatz, $beschreibung FROM $schema.$tabelle ORDER BY gid";}
	}


$results = $dbqueryp($connectp,$query11);

$counter =0;
$count=0;

echo "<table class='table table-striped'><tr>";

while($r = $fetcharrayp($results)){


if($adresse !== 'null'){

$r[$adresse] = str_replace("Str.", "Str. ", $r[$adresse]); // Punktfehler korrigieren
$r[$adresse] = str_replace("str.", "str. ", $r[$adresse]); // Punktfehler korrigieren

if(ereg("1", $r[$adresse])){$str_pos = strpos($r[$adresse], "1");} 
if(ereg("2", $r[$adresse])){$str_pos = strpos($r[$adresse], "2");} 
if(ereg("3", $r[$adresse])){$str_pos = strpos($r[$adresse], "3");} 
if(ereg("4", $r[$adresse])){$str_pos = strpos($r[$adresse], "4");} 
if(ereg("5", $r[$adresse])){$str_pos = strpos($r[$adresse], "5");} 
if(ereg("6", $r[$adresse])){$str_pos = strpos($r[$adresse], "6");} 
if(ereg("7", $r[$adresse])){$str_pos = strpos($r[$adresse], "7");} 
if(ereg("8", $r[$adresse])){$str_pos = strpos($r[$adresse], "8");} 
if(ereg("9", $r[$adresse])){$str_pos = strpos($r[$adresse], "9");} 



$str_pos=$str_pos-1;


$form_str  = substr($r[$adresse], 0, $str_pos); 
$form_strnr  = substr($r[$adresse], $str_pos);


$a_strasse[$counter]=$form_str;
$b_strasse[$counter]=$form_str;


$a_hausnummer[$counter] =$form_strnr;
$b_hausnummer[$counter] =$form_strnr;
}

$a_gid[$counter]=$r[gid];
$a_ort[$counter] = $r[$ort];
$b_ort[$counter] = $r[$ort];
$a_plz[$counter] = $r[$plz];
if($adresse === 'null'){$a_strasse[$counter] = $r[$strasse];
$b_strasse[$counter] = $r[$strasse];}
if($adresse === 'null'){$a_hausnummer[$counter] = $r[$hausnummer];
$b_hausnummer[$counter] = $r[$hausnummer];}
$a_zusatz[$counter] = $r[$zusatz];
$a_adresse[$counter] = $r[$adresse];
$a_beschreibung[$counter] = $r[$beschreibung];

///////////////// unötige Leerzeichen entfernen 
 
$a_ort[$counter] = cleanWhitespace($a_ort[$counter]); 
$a_strasse[$counter] = cleanWhitespace($a_strasse[$counter]); 

$a_hausnummer[$counter]= str_replace(' ','',$a_hausnummer[$counter]); // alle Leerzeichen entfernen
$a_hausnummer[$counter] = strtolower($a_hausnummer[$counter]); // nur Kleinbuchstaben zulassen

$a_zusatz[$counter]= str_replace(' ','',$a_zusatz[$counter]); // alle Leerzeichen entfernen
$a_zusatz[$counter] = strtolower($a_zusatz[$counter]); // nur Kleinbuchstaben zulassen

//$a_strasse[$counter] = preg_replace("/ /","_",$a_strasse[$counter]);  // Leerzeichen anzeigen
$a_strasse[$counter] = str_replace("str.", "straße", $a_strasse[$counter]); // str. durch straße ersetzten
$a_strasse[$counter] = str_replace("Str.", "Straße", $a_strasse[$counter]); // Str. durch Straße ersetzten
$a_ort[$counter] = str_replace("Ortsteil", "OT", $a_ort[$counter]); // Ortsteil durch OT ersetzten
$a_strasse[$counter] = str_replace("strasse", "straße", $a_strasse[$counter]); // strasse durch straße ersetzten
$a_strasse[$counter] = str_replace("Strasse", "Straße", $a_strasse[$counter]); // Strasse durch Straße ersetzten
$a_strasse[$counter] = str_replace("st.", "straße", $a_strasse[$counter]); // st. durch straße ersetzten
$a_strasse[$counter] = str_replace("OT", "", $a_strasse[$counter]); 
$a_strasse[$counter] = str_replace("Grosse", "Große", $a_strasse[$counter]); 
//$a_zusatz[$counter] = str_replace("n.a.", "", $a_zusatz[$counter]); 
$a_ort[$counter] = str_replace("Hansestadt", "", $a_ort[$counter]); 
$a_ort[$counter] = str_replace("Reuterstadt ", "", $a_ort[$counter]); 
$a_ort[$counter] = str_replace("/", "", $a_ort[$counter]); 
$a_ort[$counter] = str_replace("RöbelMüritz", "Röbel/Müritz", $a_ort[$counter]); 

if ($plz !== 'null'){$plzif="AND postleitzahl='$a_plz[$counter]'";}else{$plzif='';}

if ($zusatz === 'null'){
		
		// Gemeinde
		$query ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name = '$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query=mb_convert_encoding($query, 'UTF-8', mb_detect_encoding($query, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] !== $r[strasse_name]){
		// Ortsteil	
		$query1 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil = '$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query1=mb_convert_encoding($query1, 'UTF-8', mb_detect_encoding($query1, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query1);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] !== $r[strasse_name]){
		// Gemeinde Ortsteil	
		$query2 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							where gemeinde_name||' OT '||ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query2=mb_convert_encoding($query2, 'UTF-8', mb_detect_encoding($query2, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query2);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}

		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Ortsteil + -Straße
		$a_strasse[$counter] = str_replace("-Str.","-Straße",$a_strasse[$counter]);

		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		
		// Gemeinde + -Straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}			
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Ortsteil + -Straße
		$a_strasse[$counter] = str_replace("-Str.", "-Straße", $a_strasse[$counter]);

		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		
		// Gemeinde + -Straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}				
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Ortsteil + -Straße
		$a_strasse[$counter] = str_replace("-str.", "-Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + -Straße		
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}	
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("Str.", "Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){	
		// Gemeinde + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("str.", "straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){	
		// Gemeinde + straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("straße", " Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){	
		// Gemeinde + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("-Straße", " Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + _Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + _Straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		if($a_strasse[$counter]  !== $r[strasse_name]){ $fehler_str[$counter] =" (Straßennamen prüfen)";}
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace(" Straße", "straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		if($a_strasse[$counter]  !== $r[strasse_name]){ $fehler_str[$counter] =" (Straßennamen prüfen)";}
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("-Straße", "straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		if($a_strasse[$counter]  !== $r[strasse_name]){ $fehler_str[$counter] =" (Straßennamen prüfen)";}
		}

		if ($schluessel[$counter]  === null ){
		$a_strasse[$counter] = str_replace("straße", "str.", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + str.
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null ){
		// Gemeinde + str.	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		if($a_strasse[$counter]  !== $r[strasse_name] or $schluessel[$counter]  === null ){ $fehler_str[$counter] =" <b>(Adressdaten prüfen)</b>";}
		}

}
else{
		// Gemeinde
		$query ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name = '$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query=mb_convert_encoding($query, 'UTF-8', mb_detect_encoding($query, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] !== $r[strasse_name]){
		// Ortsteil	
		$query1 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil = '$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query1=mb_convert_encoding($query1, 'UTF-8', mb_detect_encoding($query1, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query1);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] !== $r[strasse_name]){
		// Gemeinde Ortsteil	
		$query2 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							where gemeinde_name||' OT '||ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query2=mb_convert_encoding($query2, 'UTF-8', mb_detect_encoding($query2, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query2);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}

		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Ortsteil + -Straße
		$a_strasse[$counter] = str_replace("-Str.","-Straße",$a_strasse[$counter]);

		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		
		// Gemeinde + -Straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}			
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Ortsteil + -Straße
		$a_strasse[$counter] = str_replace("-Str.", "-Straße", $a_strasse[$counter]);

		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		
		// Gemeinde + -Straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}				
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Ortsteil + -Straße
		$a_strasse[$counter] = str_replace("-str.", "-Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + -Straße		
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}	
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("Str.", "Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){	
		// Gemeinde + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("str.", "straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){	
		// Gemeinde + straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("straße", " Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){	
		// Gemeinde + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("-Straße", " Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + _Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + _Straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		if($a_strasse[$counter]  !== $r[strasse_name]){ $fehler_str[$counter] =" (Straßennamen prüfen)";}
		}
		
				if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace(" Straße", "straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		if($a_strasse[$counter]  !== $r[strasse_name]){ $fehler_str[$counter] =" (Straßennamen prüfen)";}
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("-Straße", "straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		if($a_strasse[$counter]  !== $r[strasse_name]){ $fehler_str[$counter] =" (Straßennamen prüfen)";}
		}	
		
		if ($schluessel[$counter]  === null ){
		$a_strasse[$counter] = str_replace("straße", "str.", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + str.
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null ){
		// Gemeinde + str.	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' $plzif AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		$query3=mb_convert_encoding($query3, 'UTF-8', mb_detect_encoding($query3, "UTF-8, ISO-8859-1, ISO-8859-15", true));
		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		if($a_strasse[$counter]  !== $r[strasse_name] or $schluessel[$counter]  === null ){ $fehler_str[$counter] =" <b>(Adressdaten prüfen)</b>";}
		}
	}	
	$counter++;
}
	echo "<th>GID</th>";
	echo "<th></th>";
	echo "<th>Addressschluessel</th>";
    echo "<th>Ort</th>";
	echo "<th>PLZ</th>";
	echo "<th>Adresse</th>";
    echo "<th>Straße</th>";
    echo "<th>Hausnummer</th>";
	echo "<th>Zusatz</th>";	
	echo "<th>Bezeichnung</th>";
	echo '</tr>';

	
	for ($i = 0; $i < $counter; $i++)
	{
	$speicher[]=array($a_gid[$i] => $schluessel[$i]);	
	if ($schluessel[$i] !== null){ $count++;}	
	echo'<tr>';
	echo "<td style='border-bottom: solid thin black;'>".$a_gid[$i]."</td>";
	if($schluessel[$i] != null){echo "<td style='border-bottom: solid thin black;color:#75b726;'><p><span class='glyphicon glyphicon-ok'></span></p></td>";}else{echo "<td style='border-bottom: solid thin black;color:#d22d2d;'><p><span class='glyphicon glyphicon-remove'></span></p></td>";}
	if ($schluessel[$i] == null){echo "<td style='background-color:#ff4d4d ;border-bottom: solid thin black;'>nicht gefunden</td>";}else{echo "<td style='background-color:#70db70;border-bottom: solid thin black;'>".$schluessel[$i]."</td>";};
	if ($a_ort[$i] == null){echo "<td style='background-color:#ff4d4d ;border-bottom: solid thin black;'>".$a_ort[$i]."</td>";}else{echo "<td style='border-bottom: solid thin black;'>".$a_ort[$i]."</td>";};
	echo "<td style='border-bottom: solid thin black;'>".$a_plz[$i]."</td>";
	if ($a_adresse[$i] == null){echo "<td style='background-color:#ff4d4d ;border-bottom: solid thin black;'>".$a_adresse[$i]."</td>";}else{echo "<td style='border-bottom: solid thin black;'>".$a_adresse[$i]."</td>";};
	if ($a_strasse[$i] == null){echo "<td style='background-color:#ff4d4d ;border-bottom: solid thin black;'>".$a_strasse[$i]."</td>";}elseif ($a_strasse[$i] != $b_strasse[$i]){echo "<td style='background-color:#ffe680 ;border-bottom: solid thin black;'>".$b_strasse[$i]=str_replace(' ','_',$b_strasse[$i]).' &rarr; '.$a_strasse[$i].$fehler_str[$i]."</td>";}else{echo "<td style='border-bottom: solid thin black;'>".$a_strasse[$i]."</td>";};
	if ($a_hausnummer[$i] == null or stristr($a_hausnummer[$i], 'AM') or stristr($a_hausnummer[$i], 'PM')){echo "<td style='background-color:#ff4d4d ;border-bottom: solid thin black;'>".$a_hausnummer[$i]."</td>";}elseif ($a_hausnummer[$i] != $b_hausnummer[$i]){echo "<td style='background-color:#ffe680 ;border-bottom: solid thin black;'>".$b_hausnummer[$i]=str_replace(' ','_',$b_hausnummer[$i]).' &rarr; '.$a_hausnummer[$i]."</td>";}else{echo "<td style='border-bottom: solid thin black;'>".$a_hausnummer[$i]."</td>";};
	echo "<td style='border-bottom: solid thin black;'>".$a_zusatz[$i]."</td>";
	echo "<td style='border-bottom: solid thin black;'>".$a_beschreibung[$i]."</td>";
	echo '</tr>';
	};
echo '</table>';
echo'<form id="regForm" action="import.php" method="POST">';
echo "<br><div style=text-align:center;'><h3><small>Gesamt:</small> ".$counter." <small>davon ermittelt:</small> ".$count." <small>Quote:</small> ".$quote=round((100/$counter)*$count)." %</h3></div><br>";
echo '<input type="hidden" name="schema" value='.$schema.'><input type="hidden" name="tabelle" value='.$tabelle.'></p>';
?>
  <div style="overflow:auto;">
    <div style="text-align:center;">

	<input type="hidden" name="speicher" value="<?php echo $speicher=rawurlencode(serialize($speicher));?>">
	<button type="reset" id="reset" value="Reset" onclick="window.location.replace('index.php')" >Abbrechen</button>
    <button type="button" id="prevBtn_disabled" onclick="window.location.replace('schritt3.php')" disabled>Zurück</button>
    <button type="submit" id="nextBtn_pruef" <?php if($count === 0){ echo'disabled style="opacity:0.6"';}?>>Importieren</button>
	</form>
    </div>
  </div>
	<br>
</body>
</html>