<!DOCTYPE HTML>
<?php
include ("../../../includes/connect.php");
//include ("../../../includes/portal_functions.php");

$themenid=$layerid;


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
<center>
<html>
<head>
<title>Metadaten: <? echo $name; ?></title>
<link rel="stylesheet" href="css/css_tabs.css" type="text/css" />
</head>
<body>


<br>

	<div class="tabbable-panel">
				<div class="tabbable-line">
					<ul class="nav nav-tabs ">
						<li class="active">
							<a href="#tab_default_1" data-toggle="tab">
							Basisdaten </a>
						</li>
						<li>
							<a href="#tab_default_2" data-toggle="tab">
							Beschreibung </a>
						</li>
						<li>
							<a href="#tab_default_3" data-toggle="tab">
							zugehörige Klassen </a>
						</li>
						<li>
							<a href="#tab_default_4" data-toggle="tab">
							Kontakt </a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_default_1">
							<p>
								<table  class=" table table-hover responsive-table"  >

								<tr>
									<th><b>Name:<br>(Alias)</th>
									<td><? echo $name; ?></td>
								</tr>

								<? 
									if ($geometrietyp == 0)
										echo "<tr>
													<th><b>Geometrietyp:</th>
													<td>Punktgeometrie</td>
												</tr>";
									else if ($geometrietyp == 1)
										echo "<tr>
													<th><b>Geometrietyp:</th>
													<td>Liniengeometrie</td>
												</tr>";
									else if ($geometrietyp == 2)
										echo "<tr>
													<th><b>Geometrietyp:</th>
													<td>Flächengeometrie</td>
												</tr>";
								?>
								<tr >
									<th><b>Gruppe:</th>
									<td><? echo $gruppe; ?></td>
								</tr>
								<tr >
									<th><b>Quelle:</th>
									<td><? echo $quelle; ?></td>
								</tr>
								<tr>
									<th><b>Aktualität:</th>
									<td><? echo $aktualitaet; ?></td>
								</tr>				
								<tr  >
									<th><b>Zyklus:</th>
									<td><? echo $zyklus; ?></td>
								</tr>
							</table>
							</p>
						</div>
						<div class="tab-pane" id="tab_default_2">
							<p>
								<table class="table table-hover responsive-table" width="400">
									<tr >					
										<td><? echo $beschreibung; ?></td>
									</tr>				
								</table>
							</p>
						</div>
						<div class="tab-pane" id="tab_default_3">
							<p>
								<table class="table table-hover responsive-table">
								<? for($v=0;$v<$z;$v++)
									{ 
										echo "<tr ><th><b>Layer</th><td>",$klassen[$v][Class_ID],"</td></tr><tr><th><b>Beschreibung</th><td>",$klassen[$v][Name],"</td></tr>";
									}
								?>
								</table>
							</p>
						</div>
						<div class="tab-pane" id="tab_default_4">
							<p>
								<table  class="table table-hover responsive-table">
									<tr >					
										<td><? echo $kontakt; ?><br></td>
									</tr>
									<tr >
										<td><? echo $einarbeitende_stelle; ?></td>
									</tr>
								</table>
							</p>
						</div>
					</div>
				</div>
			</div>

</body>
</html>
</center>