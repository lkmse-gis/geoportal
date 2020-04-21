<!DOCTYPE html>
<html>

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	<meta name="author" content="Olaf Bräunlich">
	
	<link rel="stylesheet" href="style.css" type="text/css" />
	
	<title>Flurstücksauskunft ALKIS</title>
	
	<script language="javascript">
				function klappe (Id){
				  if (document.getElementById) {
					var mydiv = document.getElementById(Id);
					mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
				  }
				}
				
				function preload(){
					document.getElementById('preload').style.display = 'none';
				}	
					
					
	</script>

</head>


<body text="#000000" bgcolor="#ffffff" link="#000000" alink="#000000" vlink="#000000" onLoad="preload()" >



	<span style="width:100%; height:100%; top:0px; left:0px; background-color:#fff;opacity: 0.9; position:absolute; z-index:1; display:block;" id="preload">
		<table style="position:absolute; top:35%;left:50%; margin-left:-25%;" >
			<tr>
				<td>
					<font style="font-size:26px;"><b>Geoportal Landkreis Mecklenburgische Seenplatte</b></font><br><br>
					<font style="font-size:26px;">Flurstücksauskunft ALKIS</font><br>
					<br>
					<br>
					<img src="lade3.gif">
				</td>
			</tr>
		</table>
	</span>

	
	<?php

	include("../../includes/connect_geobasis.php");
	$flstkennz=$_GET["flst"];
	$basis=$_GET["basis"];
	$zeichen=$GET["zeich"];

	if (isset($_COOKIE["flur"]))
		{
			$flstkennz = $_COOKIE["flur"];
			$basis = $_COOKIE["basis"];
			setcookie("flur",$flstkennz,time()-3600);
			setcookie("basis",$basis,time()-3600);
		}
	setcookie("flur",$flstkennz,time()+3600);
	setcookie("basis",$basis,time()+3600);
	?>
<center>	
<div id="framecontent" >
	<div class="innertube">


	<table width="100%" height="100%" border="0" align="center">
		<tr>
			<td width="45%" height="100%" valign="top">
				<p>
				<center>
				<img src="geoportal_logo.png" width="725" height="85" >
				
					<!--<div class="alert-box warning">
						<span>Hinweis: </span>
						<br>Derzeitig finden Wartungsarbeiten am Script statt.<br>Vielen Dank für Ihr Verständnis.
					</div>-->
					
					<table  border="0">
						<tr>
							<td id="tdkopf1" width="440" valign="top"><b>Flurst&uuml;cksauskunft<br>
							
								<?php
									$datum = getdate(time());
									$year=$datum[year];
									$month=$datum[mon];
									$day=$datum[mday];
									$hour=$datum[hours];
									$minute=$datum[minutes];
									$second=$datum[seconds];
										if (strlen($month) == 1) $month='0'.$month;
										if (strlen($day) == 1) $day='0'.$day;
										if (strlen($hour) == 1) $hour='0'.$hour;
										if (strlen($minute) == 1) $minute='0'.$minute;
										if (strlen($second) == 1) $second='0'.$second;
									$heute=$year.'-'.$month.'-'.$day;
									$print_datum=$day.".".$month.".".$year;
									$lfdmon=$year.'-'.$month;

									echo"<small>Stand: $print_datum<br>"
								?>
							</td>
						<td>
					<table>
						<tr>
							<td width="260" valign="top,right" align="right">
	<!--------Lesemodus----------------------------------------------------------------------------------------------------->
								<form  method="POST">
									<input style="background-color:white;" valign="right" type="button"  value="Druckmodus" onclick="location.href = '<? 
									include("../../includes/connect_geobasis.php");
									$flstkennz=$_GET["flst"];
									$basis=$_GET["basis"];
									echo"http://geoport-lk-mse.de/geoportal/apps/flstauskunft/flstauskunft_alkis_druck.php?flst=",$flstkennz,"&basis=",$basis; ?>';" />
								</form>					
								<br>
								</td>
								</tr>
								</table>
	<!-------------------------------------------------------------------------------------------------------------------------->
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table id="tdkopf2" >
									<tr>
										<td width="190"><br>
											Regionalstandort Neubrandenburg<br>
											Platanenstra&szlig;e 43<br>
											17033 Neubrandenburg 
										</td>
										<td width="180"><br>
											Regionalstandort Waren (M&uuml;ritz)<br>
											Zum Amtsbrink 2<br>
											17192 Waren (M&uuml;ritz)
										</td>
										<td width="150"><br>
											Regionalstandort Demmin<br>
											Reitweg 1<br>
											17109 Demmin </td>
										</td>
											<td width="150"><br>
											Regionalstandort Neustrelitz<br>
											Woldegker Chaussee 35<br>
											17235 Neustrelitz 
										</td>
									</tr>
								</table>
							</td>
						</tr>
					<tr>
						<td colspan="2">
							 <table id="tableauskunft2" valign="left" >
								<?php
								include("../../includes/connect_geobasis.php");
								$flstkennz=$_GET["flst"];
								$basis=$_GET["basis"];

								$query="SELECT b.gemarkungsname_kurz as bezeichnung,a.flurnummer,a.zaehler,a.nenner,a.amtlicheflaeche,c.gemeinde,d.name as amt,a.gemarkungsnummer,a.land ,c.gem_schl ,st_box(st_buffer(a.wkb_geometry,100)) as bounding_box, round(st_area(a.wkb_geometry)::numeric,2) as gerechnet  FROM alkis.ax_flurstueck as a, public.gemarkung as b, public.gemeinden as c, public.fd_amtsbereiche as d WHERE a.flurstueckskennzeichen='$flstkennz' AND a.gemarkungsnummer=b.gemarkung AND c.gem_schl::integer=b.gemeinde::integer AND c.amt_id::integer=d.amts_sf AND a.endet IS NULL";
								$result = $dbqueryp($connectp,$query);
								$r = $fetcharrayp($result);
								$box = $r[bounding_box];
								//$isEmpty = $box;
								$klammer = array("(",")");
								$box2 = str_replace($klammer,"",$box);
								$array = explode(",",$box2);

								/*if ($isEmpty===null)
								{ 
								$fehler = "<font color='ff0000'>Keine Anwendung der Kreisgebietsreform f&uuml;r das Flurst&uuml;ck erfolgt !</font>";
								}*/

								//$bbox = $array[2].",".$array[3].",".$array[0].",".$array[1];

								$a0 = $array[0];
								$a1 = $array[1];
								$a2 = $array[2];
								$a3 = $array[3];

								$x=$a0 - $a2;
								$y=$a1 - $a3;

								if ($x>$y) 
									{
										$diff=$x-$y;
										$hoch_neu=$a1+$diff;
										$bbox=$a2.",".$a3.",".$a0.",".$hoch_neu;
									}
								else 
									{
										$diff=$y-$x;
										$rechts_neu=$a0+$diff;
										$bbox=$a2.",".$a3.",".$rechts_neu.",".$a1;
									};

								echo 
									"
									<tr width='45%' height='10'><td colspan=2><hr width='100%' NOSHADE size='1' color='#000000'></td></tr>
									<tr><td id=padding><b>Amt:</td><td>$r[amt]$fehler</td>
									<tr><td id=padding><b>Gemeinde:</td><td>$r[gemeinde] ($r[gem_schl])</td>
									<tr><td id=padding><b>Gemarkung:</td><td>$r[bezeichnung] ($r[land]$r[gemarkungsnummer])</td></tr>
									<tr><td id=padding><b>Flurnummer:</td><td>$r[flurnummer]</td>
									<tr><td id=padding><b>Flurst&uuml;ck:</td><td>";
										if ($r[nenner] != NULL) {
											echo $r[zaehler]."/".$r[nenner];
											}
										else echo $r[zaehler];
								echo "</td>
									<tr><td id=padding><b>Amtliche Fl&auml;che:</td><td>$r[amtlicheflaeche] m&sup2; ( gerechnet: $r[gerechnet] m&sup2; )</td></tr>
									<tr><td colspan=2><hr width='100%' NOSHADE size='1' color='#000000'></td></tr>
									";
								?> 
							</table>
							<table>
								<center>
									<form name="form" >
									 <select name="link" SIZE="1" onChange="window.location.href = document.form.link.options[document.form.link.selectedIndex].value;">
									 <option  value="<? echo"http://geoport-lk-mse.de/geoportal/apps/flstauskunft/flstauskunft_alkis.php?flst=",$flstkennz,"&basis=ORKA"; ?>" 
																<?php if($_GET['basis'] == "ORKA") echo "selected=\"selected\"";?>>Offene Regionalkarte (ORKa)</option>
									 <option  value="<? echo"http://geoport-lk-mse.de/geoportal/apps/flstauskunft/flstauskunft_alkis.php?flst=",$flstkennz,"&basis=DOP20"; ?>" 
																<?php if($_GET['basis'] == "DOP20") echo "selected=\"selected\""; ?>>Luftbilder 2013 (DOP20)</option>
									 </select>
									 </form>
								 </center>
							</table> 
							<p>
							<?php
							echo "<img  border='1' align='center' width='450' height='450' alt='Flurstücksfehler' src=\"http://www.geoport-lk-mse.de/webservices/alkis07?REQUEST=GetMap&VERSION=1.1.1&SERVICE=WMS&LAYERS=",$basis,",ag_t_flurstueck,ag_l_flurstueck,sk2004_zuordnungspfeil_spitze,ag_p_flurstueck,ax_flurstueck,ax_besondereflurstuecksgrenze,ax_punktortta,ax_gebaeude_fl,ax_bauteil,ax_besonderegebaeudelinie,ag_t_gebaeude,ag_t_nebengeb,ag_l_gebaeude,ax_gebaeude_txt&BBOX=$bbox&SRS=EPSG:25833&FORMAT=image/png&WIDTH=450&HEIGHT=450&STYLES=\">";
							?> 
							</p>
					</table>
				</td>
			</td>
		</tr>
	</table>
</center>
</div>
</div>
<div id="maincontent" >
	<div class="innertube" >
	<br>
		<iframe src="flstauskunft_alkis_themen.php" name="ausgabeframe" width="100%" height="99%" frameborder="0" scrolling="auto" ></iframe>
	</div>
</div>

</body>

</html>