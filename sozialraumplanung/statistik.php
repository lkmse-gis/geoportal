<?php
include ("../includes/connect_geobasis.php");

$amt_id=$_GET["amt"];

if ($amt_id > 0)
   { 
	  include ("sql_includes/bevoelkerungsdaten.php");
	  include ("sql_includes/allgemeine_daten.php");
	  include ("sql_includes/katasterdaten.php");
	  include ("sql_includes/bildungsdaten.php");
	  include ("sql_includes/baudaten.php");
	  include ("sql_includes/tourismusdaten.php");
	  include ("sql_includes/sicherheitsdaten.php");
	  include ("sql_includes/energiedaten.php");
	  include ("sql_includes/gesundheitsdaten.php");
	  include ("sql_includes/ver_entsorgungsdaten.php");
	  include ("sql_includes/sgb2daten.php");
	  include ("sql_includes/kinderdaten.php");
	  include ("sql_includes/kinderdaten_2012.php");
	  include ("sql_includes/2011/geburten_sterbedaten.php");
	  include ("sql_includes/2011/wanderungsdaten.php");
	  include ("sql_includes/2011/sozialpflichtigdaten.php");
	  include ("bev_0_9.php");
    
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		<script type='text/javascript'>
			function popup (url) {
				fenster = window.open(url, 'Popupfenster', 'width=1200,height=420,resizable=no,scrollbars=yes,toolbar=no,status=no,menubar=yes,location=no,directories=no');
				fenster.focus();
				return false;
			}
		</script>
		<script language="javascript">
			function klappe (Id){
			  if (document.getElementById) {
				var mydiv = document.getElementById(Id);
				mydiv.style.display = (mydiv.style.display=='block'?'none':'block');
			  }
			}
		</script>
		</head>
		<body onload="init();load();">
		<div id="container">
			<div id="wrapper">
				<div id="content">
				<table width="100%" border="0" cellpadding="5" align="center" cellspacing="2" style="font-family:'Arial'">
					<tr>
						<td colspan=2 height=50 align=center><b><u> Amt <? echo $amtsname ;?> </u></b></td>
						<td colspan=2 align="center" valign="center">
							<form action="statistik.php" method="get" name="amt">
								Amt:&nbsp;
									<select name="amt" onchange="document.amt.submit();">
										<?php
											$query="SELECT * FROM fd_amtsbereiche ORDER BY name";
											$result = $dbqueryp($connectp,$query);
												while($r = $fetcharrayp($result))
													{
													 echo "<option";if ($amt_id == $r[amts_sf]) echo " selected"; echo " value=\"$r[amts_sf]\">$r[name]</option>\n";
													}
										?>
									</select>
							</form>
						</td>
					</tr>
					<tr>
						<? include ("includes/block_allgemeines.php"); ?>						
						<? include ("includes/block_kataster.php"); ?>
						<? include ("includes/block_bau.php"); ?>
						<? include ("includes/block_tourismus.php"); ?>						
					</tr>
					<tr>
						<td valign=top align=left width="25%">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=3 height=50>
										<a href="#" onclick="klappe('eintraege5')" title="aufklappen/zuklappen"><b>Sicherheit</b></a>							
									</td>							
								</tr>
							</table>
							<div id="eintraege5" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td rowspan=3>Polizei</td>
									<td>Schutzpolizei</td>
									<td><? echo $schutzpolizei; ?></td>
								</tr>
								<tr>									
									<td>Wasserschutzpolizei</td>
									<td><? echo $wasserschutzpolizei; ?></td>
								</tr>
								<tr>									
									<td>Kriminalpolizei</td>
									<td><? echo $kriminalpolizei; ?></td>
								</tr>
								<tr>
									<td rowspan=3>Feuerwehr</td>
									<td>Schwerpunkt Fw</td>
									<td><? echo $schwerpunktfw; ?></td>
								</tr>
								<tr>									
									<td>Stützpunkt Fw</td>
									<td><? echo $stuetzpunktfw; ?></td>
								</tr>
								<tr>									
									<td>Fw mit Grundausstattung</td>
									<td><? echo $fwmgrund; ?></td>
								</tr>
							</table>
							</div>
						</td>					
						<td valign=top align=left width="25%">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=2 height=50>
										<a href="#" onclick="klappe('eintraege6')" title="aufklappen/zuklappen"><b>Ver- Entsorgung</b></a>							
									</td>							
								</tr>
							</table>
							<div id="eintraege6" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td>Tankstellen</td>
									<td><? echo $tankstellen; ?></td>
									
								</tr>
								<tr>									
									<td>Containerstellplätze</td>
									<td><? echo $container; ?></td>
								</tr>
								<tr>									
									<td>Wertstoffhöfe</td>
									<td><? echo $wertstoffhof; ?></td>
								</tr>
								<tr>
									<td>Supermärkte</td>
									<td><? echo $supermarkt; ?></td>									
								</tr>								
							</table>
							</div>
						</td>
						<td valign=top align=left width="25%">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=2 height=50>
										<a href="#" onclick="klappe('eintraege7')" title="aufklappen/zuklappen"><b>Energie</b></a>							
									</td>							
								</tr>
							</table>
							<div id="eintraege7" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td>Windkraftanlagen</td>
									<td><? echo $windkraftanlagen; ?></td>
									
								</tr>
								<tr>									
									<td>Solaranlagen</td>
									<td><? echo $solaranlagen; ?></td>
								</tr>
								<tr>									
									<td>Bioenergieanlagen</td>
									<td><? echo $bioenergieanlagen; ?></td>
								</tr>
								<tr>
									<td>Umspannwerke</td>
									<td><? echo $umspannwerke; ?></td>									
								</tr>								
							</table>
							</div>
						</td>
						<td valign=top align=left width="25%">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=2 height=50>
										<a href="#" onclick="klappe('eintraege8')" title="aufklappen/zuklappen"><b>Gesundheit</b></a>							
									</td>							
								</tr>
							</table>
							<div id="eintraege8" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td>Krankenhäuser</td>
									<td><? echo $klinik; ?></td>
									
								</tr>
								<tr>									
									<td>Ärzte</td>
									<td></td>
								</tr>
								<tr>									
									<td>Apotheken</td>
									<td><? echo $apotheken;?></td>
								</tr>
								<tr>
									<td>Psychotherapeuten</td>
									<td></td>									
								</tr>
								<tr>
									<td>Rettungsstellen</td>
									<td></td>									
								</tr>
							</table>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan=4>
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=13 height=50>
										<a href="#" onclick="klappe('eintraege9')" title="aufklappen/zuklappen"><b>Bildung</b></a>
									</td>							
								</tr>
							</table>
							<div id="eintraege9" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td colspan=2></td>
									<td>Gesamt</td>
									<td>Grundschulen</td>
									<td>Regionalschulen</td>
									<td>Gymnasien</td>
									<td>Berufsschulen</td>
									<td>Förderschulen</td>
									<td>private Schulen</td>
									<td>IGS</td>
									<td>KGS</td>
									<td>KVHS</td>
									<td>Musikschulen</td>
								</tr>
								<tr>
									<td rowspan=3 align=center width="5%">2012</td>
									<td>Anzahl</td>
									<td><? echo $schulen; ?></td>
									<td><? echo $grundschulen; ?></td>
									<td><? echo $regionalschulen; ?></td>
									<td><? echo $gymnasien; ?></td>
									<td><? echo $berufsschulen; ?></td>
									<td><? echo $foerderschulen; ?></td>
									<td><? echo $private_schulen; ?></td>
									<td><? echo $igs; ?></td>
									<td><? echo $kgs; ?></td>									
									<td><? echo $kvhs; ?></td>									
									<td><? echo $ms; ?></td>									
								</tr>
								<tr>									
									<td>Schülerzahlen</td>
									<td><? echo $schulen_sz; ?></td>
									<? if ($grundschulen_sz == "") echo "<td>k.A.</td>";
										else echo "<td>$grundschulen_sz</td>";
									?>
									<? if ($regionalschulen_sz == "") echo "<td>k.A.</td>";
										else echo "<td>$regionalschulen_sz</td>";
									?>
									<? if ($gymnasien_sz == "") echo "<td>k.A.</td>";
										else echo "<td>$gymnasien_sz</td>";
									?>
									<? if ($berufsschulen_sz == "") echo "<td>k.A.</td>";
										else echo "<td>$berufsschulen_sz</td>";
									?>
									<? if ($foerderschulen_sz == "") echo "<td>k.A.</td>";
										else echo "<td>$foerderschulen_sz</td>";
									?>
									<? if ($private_schulen_sz == "") echo "<td>k.A.</td>";
										else echo "<td>$private_schulen_sz</td>";
									?>
									<? if ($igs_sz == "") echo "<td>k.A.</td>";
										else echo "<td>$igs_sz</td>";
									?>
									<? if ($kgs_sz == "") echo "<td>k.A.</td>";
										else echo "<td>$kgs_sz</td>";
									?>
									<? if ($kvhs_sz == "") echo "<td>k.A.</td>";
										else echo "<td>$kvhs_sz</td>";
									?>
									<? if ($ms_sz == "") echo "<td>k.A.</td>";
										else echo "<td>$ms_sz</td>";
									?>
								</tr>
							</table>
							</div>
						</td>
					</tr>
					<tr>
						<? include ("includes/block_kinder.php"); ?>
					</tr>
					<tr>
						<? include ("includes/block_bevoelkerung_scheiben.php"); ?>
					</tr>
					<tr>
						<? include ("includes/block_bevoelkerung_jugend.php"); ?>
					</tr>
					<tr>
						<? include ("includes/block_bevoelkerung.php"); ?>
					</tr>
					<tr>
						<? include ("includes/block_geburten_tot.php"); ?>
					</tr>
					<tr>
						<? include ("includes/block_sgb2.php"); ?>
					</tr>
					<tr>
						<? include ("includes/block_wanderung.php"); ?>
					</tr>
					<tr>
						<? include ("includes/block_sozialpflichtige.php"); ?>
					</tr>
				</table>
				</div>
			</div>
		</div>
		</body>
		</html>
<?  }





else
    { 	
	?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<title>Geoportal Landkreis Mecklenburgische Seenplatte</title>
		</head>
		<body onload="init();load();">
		<div id="container">
		  <div id="header">
		  </div>
		  <div id="wrapper">
			<div id="content">
				<table width="100%" border="0" cellpadding="0" align="center" cellspacing="0">
					<tr>
						<td align="center" height=30 colspan=2>
							Amt ausw&auml;hlen:
						</td>
					</tr>
					<tr>
						<td align="center" height=60 colspan=2> 	  
							<form action="statistik.php" method="get" name="amt">
								<select name="amt" onchange="document.amt.submit();">
									 <?php
									 $query="SELECT * FROM fd_amtsbereiche ORDER BY name";
									 $result = $dbqueryp($connectp,$query);

									 while($r = $fetcharrayp($result))
									   {
									   echo "<option value=\"$r[amts_sf]\">$r[name]</option>\n";
									   }
									?>
								</select>
							</form>
						</td>									
					</tr>
			</div>
		</div>
		</body>
		</html>
<?	} ?>
