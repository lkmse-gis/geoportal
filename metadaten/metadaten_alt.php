<?php
include ("../includes/connect.php");
$themenid=$_GET["Layer_ID"];

$query="SELECT m.layer_id as layerid, m.alias as synonym, m.quelle as quelle, m.datum_stand as aktualitaet,m.zyklus, m.comment as beschreibung, m.k_fa_b, m.fachamt, m.k_fa, m.k_fa_tel, m.k_fa_mail, m.k_es_b, m.es, m.k_es, m.k_es_tel, m.k_es_mail, l.Datentyp as geometrietyp, l.name as name, l.epsg_code as epsg from metadaten as m, layer as l WHERE m.layer_id=l.Layer_ID AND l.Layer_ID='$themenid'";

$result=mysql_query($query);
$r=mysql_fetch_array($result);
$name = $r[synonym];
$layerid = $r[layerid];
$quelle = $r[quelle];
$aktualitaet = $r[aktualitaet];
$epsg =$r[epsg];
$beschreibung = $r[beschreibung];
$kontakt = '<b>Fachamt:</b><br>'.$r[k_fa_b].'<br>'.$r[fachamt].'<br>'.$r[k_fa].'<br>'.$r[k_fa_tel].'<br><a href=mailto:\"'.$r[k_fa_mail].'\">'.$r[k_fa_mail].'</a>';
$einarbeitende_stelle = '<b>pflegende Stelle:</b><br>'.$r[k_es_b].'<br>'.$r[es].'<br>'.$r[k_es].'<br>'.$r[k_es_tel].'<br><a href=mailto:\"'.$r[k_es_mail].'\">'.$r[k_es_mail].'</a>';
$geometrietyp = $r[geometrietyp];
$zyklus=$r[zyklus];

$query="SELECT u.Gruppenname as gruppe from u_groups as u, layer as l WHERE u.id=l.Gruppe AND l.Layer_ID=$themenid";
$result=mysql_query($query);
$r=mysql_fetch_array($result);
$gruppe = $r[gruppe];



$query="SELECT classes.Class_ID, classes.Name FROM classes WHERE classes.Layer_ID=$themenid ORDER BY classes.Class_ID";
$result = mysql_query($query);
	$z=0;
	while($r = mysql_fetch_array($result))
		{
	       $klassen[$z]=$r;
		   $z++;
		   $count=$z;	
		}
?>
<html>
<title>Metadaten <? echo $name; ?></title>
<head>
	<style type="text/css">
	table.hovertable {
		font-family: verdana,arial,sans-serif;
		font-size:12px;
		color:#000000;
		border-width: 1px;
		border-color: #999999;
		border-collapse: collapse;
	}
	table.hovertable th {
		background-color:#dbedd1;
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #ffffff;
	}
	table.hovertable td {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #dcdcdc;
	}
	</style>
</head>
<body link=#000000 alink=#000000 vlink=#000000>
<table border='0' cellpadding='0' cellspacing='0' width=90% align="center"><tr><td align=center><img src="../images/geoportal_logo.png" width="88%" align=center></td></tr></table>
<table width=80% align="center" cellspacing='13px'>
	<tr>
		<td height='35' align=center style="font-size: 18px;font-family: arial;"><b>Metadaten: <? echo $name; ?></b></td>
	</tr>
</table>
<table width="80%" align="center" border=0 cellspacing=10>
	<tr>
		<td width=1%></td>
		<td width="25%" valign=top>
			<table width="100%" class="hovertable">
				<tr height='30'>
					<th colspan=2 align=center style="background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #ffffff;
						font-size: 14px;
						font-family: verdana;
						text-shadow: 1px 1px 1px #393939;">Basisdaten</th>		
				</tr>
				<tr onmouseover="this.style.backgroundColor='#dbedd1';" onmouseout="this.style.backgroundColor='#ffffff';">
					<td>Name:<br>(Alias)</td>
					<td><? echo $name; ?></td>
				</tr>
				<tr onmouseover="this.style.backgroundColor='#dbedd1';" onmouseout="this.style.backgroundColor='#ffffff';">
					<td>Layer ID:</td>
					<td><? echo $layerid; ?></td>
				</tr>
				<? 
					if ($geometrietyp == 0)
						echo "<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Geometrietyp:</td>
									<td>Punktgeometrie</td>
								</tr>";
					else if ($geometrietyp == 1)
						echo "<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Geometrietyp:</td>
									<td>Liniengeometrie</td>
								</tr>";
					else if ($geometrietyp == 2)
						echo "<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Geometrietyp:</td>
									<td>Flächengeometrie</td>
								</tr>";
				?>
				<tr onmouseover="this.style.backgroundColor='#dbedd1';" onmouseout="this.style.backgroundColor='#ffffff';">
					<td>Gruppe:</td>
					<td><? echo $gruppe; ?></td>
				</tr>
				<tr onmouseover="this.style.backgroundColor='#dbedd1';" onmouseout="this.style.backgroundColor='#ffffff';">
					<td>Quelle:</td>
					<td><? echo $quelle; ?></td>
				</tr>
				<tr onmouseover="this.style.backgroundColor='#dbedd1';" onmouseout="this.style.backgroundColor='#ffffff';">
					<td>Aktualität:</td>
					<td><? echo $aktualitaet; ?></td>
				</tr>				
				<tr onmouseover="this.style.backgroundColor='#dbedd1';" onmouseout="this.style.backgroundColor='#ffffff';">
					<td>Zyklus:</td>
					<td><? echo $zyklus; ?></td>
				</tr>
			</table>
		</td>
		<td width="25%" valign=top>			
				<?
					if ($epsg == 2398)
						echo"<table width='100%' class='hovertable'>
								<tr height='30'>
									<th colspan=2 align=center style=\"background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #ffffff;
						font-size: 14px;
						font-family: verdana;
						text-shadow: 1px 1px 1px #393939;\">Koordinatensystem (Erfassung)</th>		
								</tr>	
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>EPSG:</td>
									<td>2398</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Lagebezugssystem:</td>
									<td>S42/83 - 3°</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Referenzellipsoid</td>
									<td>Krassowski</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Datum:</td>
									<td>Pulkovo</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Projektion:</td>
									<td>Gauß-Krüger</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Streifen:</td>
									<td>4 Streifen</td>
								</tr>
							</table>";
					else if ($epsg == 35833 OR $epsg == 5650)
						echo"<table width='100%' class='hovertable'>
								<tr height='30'>
									<th colspan=2 align=center style=\"background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #ffffff;
						font-size: 14px;
						font-family: verdana;
						text-shadow: 1px 1px 1px #393939;\">Koordinatensystem (Erfassung)</th>		
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>EPSG:</td>
									<td>5650/35833</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Lagebezugssystem:</td>
									<td>ETRS89 mit führender UTM Zone</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Referenzellipsoid</td>
									<td>GRS80</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Datum:</td>
									<td>ETRS89</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Projektion:</td>
									<td>UTM</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Zone:</td>
									<td>33</td>
								</tr>
							</table>";
					else if ($epsg == 25833)
						echo"<table width='100%' class='hovertable'>
								<tr height='30'>
									<th colspan=2 align=center style=\"background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #ffffff;
						font-size: 14px;
						font-family: verdana;
						text-shadow: 1px 1px 1px #393939;\">Koordinatensystem (Erfassung)</th>		
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>EPSG:</td>
									<td>25833</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Lagebezugssystem:</td>
									<td>ETRS89</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Referenzellipsoid</td>
									<td>GRS80</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Datum:</td>
									<td>ETRS89</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Projektion:</td>
									<td>UTM</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Zone:</td>
									<td>33</td>
								</tr>
							</table>";
					else if ($epsg == 31468)
						echo"<table width='100%' class='hovertable'>
								<tr height='30'>
									<th colspan=2 align=center style=\"background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #ffffff;
						font-size: 14px;
						font-family: verdana;
						text-shadow: 1px 1px 1px #393939;\">Koordinatensystem (Erfassung)</th>		
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>EPSG:</td>
									<td>31468</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Lagebezugssystem:</td>
									<td>1841 Bessel</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Referenzellipsoid</td>
									<td>Bessel</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Datum:</td>
									<td>Rauenberg</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Projektion:</td>
									<td>Gauß-Krüger</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Streifen:</td>
									<td>4 Streifen</td>
								</tr>
							</table>";
				?>
		</td>
		<td width="25%" valign=top>
			<table width="100%" class="hovertable">
				<tr height='30'>
					<th colspan=2 align=center style="background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #ffffff;
						font-size: 14px;
						font-family: verdana;
						text-shadow: 1px 1px 1px #393939;">zugehörige Klassen</th>		
				</tr>
				<? for($v=0;$v<$z;$v++)
					{ 
						echo "<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\"><td>",$klassen[$v][Class_ID],"</td><td>",$klassen[$v][Name],"</td></tr>";
					}
				?>
			</table>
		</td>
		<td width="25%" valign=top>
			<table width="100%" class="hovertable">
				<tr height='30'>
					<th align=center style="background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #ffffff;
						font-size: 14px;
						font-family: verdana;
						text-shadow: 1px 1px 1px #393939;">Kontakt</th>		
				</tr>
				<tr onmouseover="this.style.backgroundColor='#dbedd1';" onmouseout="this.style.backgroundColor='#ffffff';">					
					<td><? echo $kontakt; ?></td>
				</tr>
				<tr onmouseover="this.style.backgroundColor='#dbedd1';" onmouseout="this.style.backgroundColor='#ffffff';">
					<td><? echo $einarbeitende_stelle; ?></td>
				</tr>
			</table>
		</td>
		<td width=2%></td>
	</tr>
	<tr>
		<td width=1%></td>
		<td  colspan=2 width="50%" valign=top>			
				<?
					if ($epsg == 2398)
						echo"<table width='100%' class='hovertable'>
								<tr height='30'>
									<th colspan=4 align=center style=\"background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #ffffff;
						font-size: 14px;
						font-family: verdana;
						text-shadow: 1px 1px 1px #393939;\">lieferbare Koordinatensysteme</th>		
								</tr>	
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>EPSG:</td>
									<td>25833</td>
									<td>35833</td>
									<td>31468</td>									
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Lagebezugssystem:</td>
									<td>ETRS89</td>
									<td>ETRS89 mit führender<br>UTM Zone</td>
									<td>1841 Bessel</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Referenzellipsoid</td>
									<td>GRS80</td>
									<td>GRS80</td>
									<td>Bessel</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Datum:</td>
									<td>ETRS89</td>
									<td>ETRS89</td>
									<td>Rauenberg</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Projektion:</td>
									<td>UTM</td>
									<td>UTM</td>
									<td>Gauß-Krüger</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Streifen/Zone:</td>
									<td>Zone 33</td>
									<td>Zone 33</td>
									<td>4 Streifen</td>
								</tr>
							</table>";
					else if ($epsg == 35833)
						echo"<table width='100%' class='hovertable'>
								<tr height='30'>
									<th colspan=4 align=center style=\"background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #ffffff;
						font-size: 14px;
						font-family: verdana;
						text-shadow: 1px 1px 1px #393939;\">lieferbare Koordinatensysteme</th>		
								</tr>	
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>EPSG:</td>
									<td>25833</td>
									<td>2398</td>
									<td>31468</td>									
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Lagebezugssystem:</td>
									<td>ETRS89</td>
									<td>S42/83 - 3°</td>
									<td>1841 Bessel</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Referenzellipsoid</td>
									<td>GRS80</td>
									<td>Krassowski</td>
									<td>Bessel</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Datum:</td>
									<td>ETRS89</td>
									<td>Pulkovo</td>
									<td>Rauenberg</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Projektion:</td>
									<td>UTM</td>
									<td>Gauß-Krüger</td>
									<td>Gauß-Krüger</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Streifen/Zone:</td>
									<td>Zone 33</td>
									<td>4 Streifen</td>
									<td>4 Streifen</td>
								</tr>
							</table>";
					else if ($epsg == 25833)
						echo"<table width='100%' class='hovertable'>
								<tr height='30'>
									<th colspan=4 align=center style=\"background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #ffffff;
						font-size: 14px;
						font-family: verdana;
						text-shadow: 1px 1px 1px #393939;\">lieferbare Koordinatensysteme</th>		
								</tr>	
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>EPSG:</td>
									<td>25833</td>
									<td>35833</td>
									<td>31468</td>									
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Lagebezugssystem:</td>
									<td>ETRS89</td>
									<td>ETRS89 mit führender<br>UTM Zone</td>
									<td>1841 Bessel</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Referenzellipsoid</td>
									<td>GRS80</td>
									<td>GRS80</td>
									<td>Bessel</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Datum:</td>
									<td>ETRS89</td>
									<td>ETRS89</td>
									<td>Rauenberg</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Projektion:</td>
									<td>UTM</td>
									<td>UTM</td>
									<td>Gauß-Krüger</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Streifen/Zone:</td>
									<td>Zone 33</td>
									<td>Zone 33</td>
									<td>4 Streifen</td>
								</tr>
							</table>";
					else if ($epsg == 31468)
						echo"<table width='100%' class='hovertable'>
								<tr height='30'>
									<th colspan=4 align=center style=\"background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #ffffff;
						font-size: 14px;
						font-family: verdana;
						text-shadow: 1px 1px 1px #393939;\">lieferbare Koordinatensysteme</th>		
								</tr>	
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>EPSG:</td>
									<td>25833</td>
									<td>35833</td>
									<td>31468</td>									
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Lagebezugssystem:</td>
									<td>ETRS89</td>
									<td>ETRS89 mit führender<br>UTM Zone</td>
									<td>1841 Bessel</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Referenzellipsoid</td>
									<td>GRS80</td>
									<td>GRS80</td>
									<td>Bessel</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Datum:</td>
									<td>ETRS89</td>
									<td>ETRS89</td>
									<td>Rauenberg</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Projektion:</td>
									<td>UTM</td>
									<td>UTM</td>
									<td>Gauß-Krüger</td>
								</tr>
								<tr onmouseover=\"this.style.backgroundColor='#dbedd1';\" onmouseout=\"this.style.backgroundColor='#ffffff';\">
									<td>Streifen/Zone:</td>
									<td>Zone 33</td>
									<td>Zone 33</td>
									<td>4 Streifen</td>
								</tr>
							</table>";
				?>
		</td>
		<td width="50%" valign=top colspan=4>
			<table class="hovertable">
				<tr height='30'>
					<th colspan=2 align=center style="background: -webkit-gradient(#52AA22 0%, white 80%);
						background: -moz-linear-gradient(#52AA22 0%, white 80%);
						-webkit-border-top-left-radius: 6px;
						-webkit-border-top-right-radius: 6px;
						-moz-border-radius-topleft: 6px;
						-moz-border-radius-topright: 6px;
						border-top-left-radius: 6px;
						border-top-right-radius: 6px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 0px;
						-moz-border-radius-bottomright: 0px;
						border-bottom-left-radius: 0px;
						border-bottom-right-radius: 0px;
						-webkit-box-shadow: 3px -3px -3px #393939;
						-moz-box-shadow: 3px -3px -3px #393939;
						box-shadow: 3px -3px -3px #393939;
						color: #ffffff;
						font-size: 14px;
						font-family: verdana;
						text-shadow: 1px 1px 1px #393939;">Beschreibung</th>		
				</tr>
				<tr onmouseover="this.style.backgroundColor='#dbedd1';" onmouseout="this.style.backgroundColor='#ffffff';">					
					<td><? echo $beschreibung; ?></td>
				</tr>				
			</table>
		</td>
		<td width=2%></td>
	</tr>
	<tr>
				<td width=1%></td>
				<td height=30 colspan=4 align=right style="background: -webkit-gradient(white 20%, #3667B3 100%);
						background: -moz-linear-gradient(white 20%, #3667B3 100%);
						-webkit-border-top-left-radius: 0px;
						-webkit-border-top-right-radius: 0px;
						-moz-border-radius-topleft: 0px;
						-moz-border-radius-topright: 0px;
						border-top-left-radius: 0px;
						border-top-right-radius: 0px;
						-webkit-border-bottom-left-radius: 6px;
						-webkit-border-bottom-right-radius: 6px;
						-moz-border-radius-bottomleft: 6px;
						-moz-border-radius-bottomright: 6px;
						border-bottom-left-radius: 6px;
						border-bottom-right-radius: 6px;
						-webkit-box-shadow: 1px -1px -1px #393939;
						-moz-box-shadow: 1px -1px -1px #393939;
						box-shadow: 1px -1px -1px #393939;">							
				</td>
				<td width=2%></td>
			</tr>
</table>
</body>
</html>