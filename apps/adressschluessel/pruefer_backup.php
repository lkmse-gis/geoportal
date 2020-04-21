<?php
include("../../includes/connect_geobasis.php");
$schema = htmlspecialchars($_POST['schema']);
$tabelle = htmlspecialchars($_POST['tabelle']);
$ort = htmlspecialchars($_POST['ort']);
$strasse = htmlspecialchars($_POST['strasse']);
$hausnummer = htmlspecialchars($_POST['hausnummer']);
$zusatz = htmlspecialchars($_POST['zusatz']);
$adresse = htmlspecialchars($_POST['adresse']);
$beschreibung = htmlspecialchars($_POST['beschreibung']);

function cleanWhitespace($string) { // Funktion unötige Leerzeichen entfernen 
    return trim( preg_replace('/\s+/', ' ', $string) ); 
} 

// Daten auslesen und Tabelle generieren
if($adresse !== 'null'){$query11="SELECT $ort, $adresse, $beschreibung FROM $schema.$tabelle ORDER BY gid";}
else{
	if ($zusatz === 'null'){$query11="SELECT $ort, $strasse, $hausnummer, $beschreibung FROM $schema.$tabelle ORDER BY gid";}
	else{$query11="SELECT $ort, $strasse, $hausnummer,$zusatz, $beschreibung FROM $schema.$tabelle ORDER BY gid";}
	}


$results = $dbqueryp($connectp,$query11);
$counter =0;
$count=0;


echo "<table><tr>";

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
//if(ereg("10", $r[$adresse])){$str_pos = strpos($r[$adresse], "10");} 

$str_pos=$str_pos-1;


$form_str  = substr($r[$adresse], 0, $str_pos); 
$form_strnr  = substr($r[$adresse], $str_pos);


$a_strasse[$counter]=$form_str;
$b_strasse[$counter]=$form_str;


$a_hausnummer[$counter] =$form_strnr;
$b_hausnummer[$counter] =$form_strnr;
}

$a_ort[$counter] = $r[$ort];
$b_ort[$counter] = $r[$ort];
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
//$a_strasse[$counter] = str_replace("str.", "straße", $a_strasse[$counter]); // str. durch straße ersetzten
//$a_strasse[$counter] = str_replace("Str.", "Straße", $a_strasse[$counter]); // Str. durch Straße ersetzten
$a_ort[$counter] = str_replace("Ortsteil", "OT", $a_ort[$counter]); // Ortsteil durch OT ersetzten
$a_strasse[$counter] = str_replace("strasse", "straße", $a_strasse[$counter]); // strasse durch straße ersetzten
$a_strasse[$counter] = str_replace("Strasse", "Straße", $a_strasse[$counter]); // Strasse durch Straße ersetzten
$a_strasse[$counter] = str_replace("st.", "straße", $a_strasse[$counter]); // st. durch straße ersetzten
$a_strasse[$counter] = str_replace("OT", "", $a_strasse[$counter]); 
//$a_zusatz[$counter] = str_replace("n.a.", "", $a_zusatz[$counter]); 
$a_ort[$counter] = str_replace("Hansestadt", "", $a_ort[$counter]); 
$a_ort[$counter] = str_replace("/", "", $a_ort[$counter]); 


if ($zusatz === 'null'){

		// Gemeinde
		$query ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name = '$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] !== $r[strasse_name]){
		// Ortsteil	
		$query1 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil = '$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";
		
		$result = $dbqueryp($connectp,$query1);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] !== $r[strasse_name]){
		// Gemeinde Ortsteil	
		$query2 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							where gemeinde_name||' OT '||ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query2);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}

		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Ortsteil + -Straße
		$a_strasse[$counter] = str_replace("-Str.","-Straße",$a_strasse[$counter]);

		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		
		// Gemeinde + -Straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}			
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Ortsteil + -Straße
		$a_strasse[$counter] = str_replace("-Str.", "-Straße", $a_strasse[$counter]);

		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		
		// Gemeinde + -Straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}				
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Ortsteil + -Straße
		$a_strasse[$counter] = str_replace("-str.", "-Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + -Straße		
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}	
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("Str.", "Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){	
		// Gemeinde + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("str.", "straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){	
		// Gemeinde + straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("straße", " Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){	
		// Gemeinde + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("-Straße", " Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + _Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + _Straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

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
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

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
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

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
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null ){
		// Gemeinde + str.	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]' AND alkis_konform = 'Ja';";

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
							WHERE gemeinde_name = '$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] !== $r[strasse_name]){
		// Ortsteil	
		$query1 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil = '$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";
		
		$result = $dbqueryp($connectp,$query1);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] !== $r[strasse_name]){
		// Gemeinde Ortsteil	
		$query2 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							where gemeinde_name||' OT '||ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query2);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}

		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Ortsteil + -Straße
		$a_strasse[$counter] = str_replace("-Str.","-Straße",$a_strasse[$counter]);

		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		
		// Gemeinde + -Straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}			
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Ortsteil + -Straße
		$a_strasse[$counter] = str_replace("-Str.", "-Straße", $a_strasse[$counter]);

		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		
		// Gemeinde + -Straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}				
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Ortsteil + -Straße
		$a_strasse[$counter] = str_replace("-str.", "-Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + -Straße		
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}	
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("Str.", "Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){	
		// Gemeinde + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("str.", "straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){	
		// Gemeinde + straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("straße", " Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){	
		// Gemeinde + Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		$a_strasse[$counter] = str_replace("-Straße", " Straße", $a_strasse[$counter]); // strasse durch straße ersetzten	
		// Ortsteil + _Straße
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + _Straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

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
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

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
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null && $a_strasse[$counter] != 'Dorfstraße'){
		// Gemeinde + straße	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

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
							WHERE ortsteil ='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		}
		
		if ($schluessel[$counter]  === null ){
		// Gemeinde + str.	
		$query3 ="SELECT gemeinde_name, strasse_name, hausnummer,adressschluessel, alkis_konform, ortsteil
							FROM address_registry.adresstabelle
							WHERE gemeinde_name='$a_ort[$counter]' AND strasse_name = '$a_strasse[$counter]' AND hausnummer = '$a_hausnummer[$counter]'||'$a_zusatz[$counter]' AND alkis_konform = 'Ja';";

		$result = $dbqueryp($connectp,$query3);
		$r = $fetcharrayp($result);
		$schluessel[$counter] = $r[adressschluessel];
		
		if($a_strasse[$counter]  !== $r[strasse_name] or $schluessel[$counter]  === null ){ $fehler_str[$counter] =" <b>(Adressdaten prüfen)</b>";}
		}
	}	
	$counter++;
}

	echo "<th></th>";
	echo "<th>Addressschluessel</th>";
    echo "<th>Ort</th>";
	echo "<th>Adresse</th>";
    echo "<th>Straße</th>";
    echo "<th>Hausnummer</th>";
	echo "<th>Zusatz</th>";	
	echo "<th>Bezeichnung</th>";
	echo '</tr>';

	
	for ($i = 0; $i < $counter; $i++)
	{
	if ($schluessel[$i] !== null){ $count++;}	
	echo'<tr>';
	if($schluessel[$i] != null){echo "<td style='border-bottom: solid thin black;color:green;'>&#10003;</td>";}else{echo "<td style='border-bottom: solid thin black;color:red;'>x</td>";}
	if ($schluessel[$i] == null){echo "<td style='background-color:LightSalmon ;border-bottom: solid thin black;'><small>nicht gefunden</small></td>";}else{echo "<td style='background-color:lightgreen;border-bottom: solid thin black;'>".$schluessel[$i]."</td>";};
	if ($a_ort[$i] == null){echo "<td style='background-color:LightSalmon ;border-bottom: solid thin black;'>".$a_ort[$i]."</td>";}else{echo "<td style='border-bottom: solid thin black;'>".$a_ort[$i]."</td>";};
	if ($a_adresse[$i] == null){echo "<td style='background-color:LightSalmon ;border-bottom: solid thin black;'>".$a_adresse[$i]."</td>";}else{echo "<td style='border-bottom: solid thin black;'>".$a_adresse[$i]."</td>";};
	if ($a_strasse[$i] == null){echo "<td style='background-color:LightSalmon ;border-bottom: solid thin black;'>".$a_strasse[$i]."</td>";}elseif ($a_strasse[$i] != $b_strasse[$i]){echo "<td style='background-color:#ffffb3 ;border-bottom: solid thin black;'>".$b_strasse[$i]=str_replace(' ','_',$b_strasse[$i]).' &rarr; '.$a_strasse[$i].$fehler_str[$i]."</td>";}else{echo "<td style='border-bottom: solid thin black;'>".$a_strasse[$i]."</td>";};
	if ($a_hausnummer[$i] == null or stristr($a_hausnummer[$i], 'AM') or stristr($a_hausnummer[$i], 'PM')){echo "<td style='background-color:LightSalmon ;border-bottom: solid thin black;'>".$a_hausnummer[$i]."</td>";}elseif ($a_hausnummer[$i] != $b_hausnummer[$i]){echo "<td style='background-color:#ffffb3 ;border-bottom: solid thin black;'>".$b_hausnummer[$i]=str_replace(' ','_',$b_hausnummer[$i]).' &rarr; '.$a_hausnummer[$i]."</td>";}else{echo "<td style='border-bottom: solid thin black;'>".$a_hausnummer[$i]."</td>";};
	echo "<td style='border-bottom: solid thin black;'>".$a_zusatz[$i]."</td>";
	echo "<td style='border-bottom: solid thin black;'>".$a_beschreibung[$i]."</td>";
	echo '</tr>';
	};
echo '</table>';

echo "<br>Gesamt: ".$counter." Gefunden: ".$count;

?>