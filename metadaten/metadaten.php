<!DOCTYPE HTML>
<?php
include ("../includes/connect_i_procedure_mse.php");
$themenid=$_GET["Layer_ID"];

$query="SELECT m.layer_id as layerid, m.alias as synonym, m.quelle as quelle, m.datum_stand as aktualitaet,m.zyklus, m.comment as beschreibung, m.k_fa_b, m.fachamt, m.k_fa, m.k_fa_tel, m.k_fa_mail, m.k_es_b, m.es, m.k_es, m.k_es_tel, m.k_es_mail, l.Datentyp as geometrietyp, l.name as name, l.epsg_code as epsg from metadaten as m, layer as l WHERE m.layer_id=l.Layer_ID AND l.Layer_ID='$themenid'";

$result=mysqli_query($db_link,$query);
$r = mysqli_fetch_array($result);
$name = $r["synonym"];
$layerid = $r["layerid"];
$quelle = $r["quelle"];
$aktualitaet = $r["aktualitaet"];
$epsg =$r["epsg"];
$beschreibung = $r["beschreibung"];
$kontakt = '<b>Fachamt:</b><br>'.$r["k_fa_b"].'<br>'.$r["fachamt"].'<br>'.$r["k_fa"].'<br>'.$r["k_fa_tel"].'<br><a href=mailto:\"'.$r["k_fa_mail"].'\">'.$r["k_fa_mail"].'</a>';
$einarbeitende_stelle = '<b>pflegende Stelle:</b><br>'.$r["k_es_b"].'<br>'.$r["es"].'<br>'.$r["k_es"].'<br>'.$r["k_es_tel"].'<br><a href=mailto:\"'.$r["k_es_mail"].'\">'.$r["k_es_mail"].'</a>';
$geometrietyp = $r["geometrietyp"];
$zyklus=$r["zyklus"];

$query="SELECT u.Gruppenname as gruppe from u_groups as u, layer as l WHERE u.id=l.Gruppe AND l.Layer_ID=$themenid";
$result=mysqli_query($db_link,$query);
$r = mysqli_fetch_array($result);
$gruppe = $r["gruppe"];



$query="SELECT classes.Class_ID, classes.Name FROM classes WHERE classes.Layer_ID=$themenid ORDER BY classes.Class_ID";
$result=mysqli_query($db_link,$query);
	$z=0;
	while($r = mysqli_fetch_array($result))
		{
	       $klassen[$z]=$r;
		   $z++;
		   $count=$z;	
		}
?>
<center>
<html>
<head>
<title>Metadaten: <? echo $name; ?></title>
<link rel="stylesheet" href="css_tabs.css" type="text/css" />
</head>
<body style=" 	background: url(pics/hintergrund12.jpg) no-repeat center center fixed;
					-webkit-background-size: cover;
					-moz-background-size: cover;
					-o-background-size: cover;
					background-size: cover;" onLoad="window.resizeTo(700,600)">

<div style=" margin-top:0; padding:0; align:top;">
<img src="pics/geoportal_logo.png" width="600" >
</div>

<div style="background-color: white; width:600px;" >
<center><font style="font-family: Arial, Sans-serif;
    font-size: 1em;
    font-weight: 400;
    color: #404040;" ><b>Metadaten: <? echo $name; ?></b></font></center>
</div>
<br>

<table width="600"  >
<tr>
<td>
<div class="tabreiter">
    <ul>
        <li>
            <input type="radio" name="tabreiter-0" checked="checked" id="tabreiter-0-0" /><label for="tabreiter-0-0">Basisdaten</label>
            <div>
				<table width="400" class="tabelle"  >

				<tr class="zelle" >
					<td><b>Name:<br>(Alias)</td>
					<td><? echo $name; ?></td>
				</tr>

				<? 
					if ($geometrietyp == 0)
						echo "<tr class='zelle' >
									<td><b>Geometrietyp:</td>
									<td>Punktgeometrie</td>
								</tr>";
					else if ($geometrietyp == 1)
						echo "<tr class='zelle'>
									<td><b>Geometrietyp:</td>
									<td>Liniengeometrie</td>
								</tr>";
					else if ($geometrietyp == 2)
						echo "<tr class='zelle'>
									<td><b>Geometrietyp:</td>
									<td>Flächengeometrie</td>
								</tr>";
				?>
				<tr class="zelle" >
					<td><b>Gruppe:</td>
					<td><? echo $gruppe; ?></td>
				</tr>
				<tr class="zelle"  >
					<td><b>Quelle:</td>
					<td><? echo $quelle; ?></td>
				</tr>
				<tr class="zelle" >
					<td><b>Aktualität:</td>
					<td><? echo $aktualitaet; ?></td>
				</tr>				
				<tr class="zelle"  >
					<td><b>Zyklus:</td>
					<td><? echo $zyklus; ?></td>
				</tr>
			</table>
            </div>
		       </li><li>
            <input type="radio" name="tabreiter-0" id="tabreiter-0-1" /><label for="tabreiter-0-1">Beschreibung</label>
            <div>
				<table class="tabelle" width="400">
				<tr class="zelle" >					
					<td><? echo $beschreibung; ?></td>
				</tr>				
			</table>
            </div>
        </li><li>
            <input type="radio" name="tabreiter-0" id="tabreiter-0-2" /><label for="tabreiter-0-2">zugehörige Klassen</label>
            <div>
			<table width="400" class="tabelle">
			<tr class="zelle" ><td><b>Layer</td><td><b>Beschreibung</td></tr>
				<? for($v=0;$v<$z;$v++)
					{ 
						echo "<tr class='zelle'><td>",$klassen[$v]["Class_ID"],"</td><td>",$klassen[$v]["Name"],"</td></tr>";
					}
				?>
			</table>
            </div>
        </li><li>
            <input type="radio" name="tabreiter-0" id="tabreiter-0-3" /><label for="tabreiter-0-3">Kontakt</label>
            <div>
				<table width="400" class="tabelle">
	
				<tr class="zelle" >					
					<td><? echo $kontakt; ?><br></td>
				</tr>
				<tr class="zelle" >
					<td><? echo $einarbeitende_stelle; ?></td>
				</tr>
			</table>
            </div>
      <!--  </li><li>
            <input type="radio" name="tabreiter-0" id="tabreiter-0-4" disabled="disabled" /><label for="tabreiter-0-3">Test</label>
            <div>
                <h3>Test</h3>
            </div>
        </li> -->
    </ul>
</div>
</td>
</tr>
</table>
</body>
</html>
</center>