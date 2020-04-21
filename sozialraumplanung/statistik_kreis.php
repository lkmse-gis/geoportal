<?php
include ("../includes/connect_geobasis.php");

$amt_id=$_GET["amt"];

if ($amt_id > 0)
   { 
	  include ("bevoelkerungsdaten.php");
	  include ("allgemeine_daten.php");
	  include ("katasterdaten.php");
	  include ("kreis_bildungsdaten.php");
	  include ("baudaten.php");
	  include ("tourismusdaten.php");
	  include ("sicherheitsdaten.php");
	  include ("energiedaten.php");
	  include ("gesundheitsdaten.php");
	  include ("ver_entsorgungsdaten.php");
	  include ("sozialdaten.php");
	  include ("kinderdaten.php");
    
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
						<td valign=top align=left width="25%">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=2 height=50>
										<a href="#" onclick="klappe('eintraege')" title="aufklappen/zuklappen"><b>Allgemeindes</b></a>							
									</td>							
								</tr>
							</table>
							<div id="eintraege" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td>Amtsvorsteher</td>
									<td><? echo $amtsvorsteher; ?></td>
								</tr>
								<tr>
									<td>Fläche</td>
									<td><? echo $flaeche." km²"; ?></td>
								</tr>
								<tr>
									<td>Einwohner</td>
									<td><? echo $gesamt; ?></td>
								</tr>
								<tr>
									<td>Einwohner/km</td>
									<td><? echo round($gesamt/$flaeche,2)." Einwohner pro km²"; ?></td>
								</tr>
							</table>
							</div>
						</td>
						<td valign=top align=left width="25%">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=2 height=50>
										<a href="#" onclick="klappe('eintraege2')" title="aufklappen/zuklappen"><b>Kataster</b></a>							
									</td>							
								</tr>
							</table>
							<div id="eintraege2" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td>Grenzlänge</td>
									<td><? echo $grenzlaenge." km"; ?></td>
								</tr>
								<tr>
									<td>Mittelpunkt</td>
									<td><? echo $mittelpunkt; ?></td>
								</tr>
								<tr>
									<td>Gemeinden</td>
									<td><? echo $gemeinden; ?></td>
								</tr>
								<tr>
									<td>Gemarkungen</td>
									<td><? echo $gemarkungen; ?></td>
								</tr>
								<tr>
									<td>Fluren</td>
									<td><? echo $fluren; ?></td>
								</tr>
								<tr>
									<td>Flurstücke</td>
									<td><? echo $flurstuecke; ?></td>
								</tr>
							</table>
							</div>
						</td>
						<td valign=top align=left width="25%">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=3 height=50>
										<a href="#" onclick="klappe('eintraege3')" title="aufklappen/zuklappen"><b>Bau</b></a>							
									</td>							
								</tr>
							</table>
							<div id="eintraege3" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td colspan=2>Baudenkmale</td>
									<td><? echo $baudenkmale; ?></td>
								</tr>
								<tr>
									<td rowspan=4>Bebauungspläne</td>
									<td>rechtskräftig</td>
									<? if ($bplan_rk == "") echo "<td>k.A.</td>";
										else echo "<td>$bplan_rk</td>";
									?>
								</tr>
								<tr>
									<td>im Verfahren</td>
									<td><? echo $bplan_iv; ?></td>
								</tr>
								<tr>
									<td>Verfahren eingestellt</td>
									<td><? echo $bplan_ve; ?></td>
								</tr>
								<tr>
									<td>Plan aufgehoben</td>
									<td><? echo $bplan_pa; ?></td>
								</tr>
							</table>
							</div>
						</td>
						<td valign=top align=left width="25%">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=2 height=50>
										<a href="#" onclick="klappe('eintraege4')" title="aufklappen/zuklappen"><b>Tourismus</b></a>							
									</td>							
								</tr>
							</table>
							<div id="eintraege4" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td>Badestellen</td>
									<td><? echo $badestellen; ?></td>
								</tr>
								<tr>
									<td>Kirchen</td>
									<td><? echo $kirchen; ?></td>
								</tr>
								<tr>
									<td>Tourist-Informationen</td>
									<td><? echo $touristinfos; ?></td>
								</tr>
							</table>
							</div>
						</td>
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
									<td rowspan=3 align=center width="5%">2011</td>
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
						<td colspan=4>
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=8 height=50>
										<a href="#" onclick="klappe('eintraege10')" title="aufklappen/zuklappen"><b>Kinder</b></a>
									</td>							
								</tr>
							</table>
							<div id="eintraege10" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td colspan=2></td>
									<td>Gesamt</td>
									<td>Kinderkrippen</td>
									<td>Kindergärten</td>
									<td>Horte</td>
									<td>Kindertagesstätten</td>									
									<td>Tagesmütter</td>									
								</tr>
								<tr>
									<td rowspan=3 align=center width="5%">2011</td>
									<td>Anzahl</td>
									<td><? echo $kinderbetreuung; ?></td>
									<td><? echo $krippen; ?></td>
									<td><? echo $kindergarten; ?></td>
									<td><? echo $horte; ?></td>
									<td><? echo $kitas; ?></td>
									<td><? echo $ktagesmutter; ?></td>					
								</tr>
								<tr>									
									<td>Kinderzahlen</td>
									<td><? echo $kinderbetreuung_zahlen; ?></td>
									<? if ($krippen_zahlen == "") echo "<td>k.A.</td>";
										else echo "<td>$krippen_zahlen</td>";
									?>
									<? if ($kindergarten_zahlen == "") echo "<td>k.A.</td>";
										else echo "<td>$kindergarten_zahlen</td>";
									?>
									<? if ($horte_zahlen == "") echo "<td>k.A.</td>";
										else echo "<td>$horte_zahlen</td>";
									?>
									<? if ($kitas_zahlen == "") echo "<td>k.A.</td>";
										else echo "<td>$kitas_zahlen</td>";
									?>	
									<? if ($tagesmutter_zahlen == "") echo "<td>k.A.</td>";
										else echo "<td>$tagesmutter_zahlen</td>";
									?>	
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
										<a href="#" onclick="klappe('eintraege11')" title="aufklappen/zuklappen"><b>Bevölkerung 10 Jahres Scheiben</b></a>							
									</td>							
								</tr>
							</table>
							<div id="eintraege11" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td colspan=2></td>									
									<td>gesamte Bevölkerung</td>
									<td><a href="0_10.php?amt=<?echo $amt_id; ?>" target="_blank" onclick="return popup(this.href)">0-u10</a></td>
									<td><a href="10_20.php?amt=<?echo $amt_id; ?>" target="_blank" onclick="return popup(this.href)">10-u20</a></td>
									<td><a href="20_30.php?amt=<?echo $amt_id; ?>" target="_blank" onclick="return popup(this.href)">20-u30</a></td>
									<td><a href="30_40.php?amt=<?echo $amt_id; ?>" target="_blank" onclick="return popup(this.href)">30-u40</a></td>
									<td><a href="40_50.php?amt=<?echo $amt_id; ?>" target="_blank" onclick="return popup(this.href)">40-u50</a></td>
									<td><a href="50_60.php?amt=<?echo $amt_id; ?>" target="_blank" onclick="return popup(this.href)">50-u60</a></td>
									<td><a href="60_70.php?amt=<?echo $amt_id; ?>" target="_blank" onclick="return popup(this.href)">60-u70</a></td>
									<td><a href="70_80.php?amt=<?echo $amt_id; ?>" target="_blank" onclick="return popup(this.href)">70-u80</a></td>
									<td><a href="80_90.php?amt=<?echo $amt_id; ?>" target="_blank" onclick="return popup(this.href)">80-u90</a></td>
									<td><a href="90_100.php?amt=<?echo $amt_id; ?>" target="_blank" onclick="return popup(this.href)">90-u100</a></td>
								</tr>
								<tr>
									<td rowspan=8 align=center width="5%">2011</td>
									<td bgcolor="#A9E2F3">männlich</td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_0_9_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_10_19_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_20_29_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_30_39_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_40_49_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_50_59_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_60_69_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_70_79_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_80_89_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_90_99_m; ?></td>
								</tr>
								<tr>
									<td>männlich %</td>
									<td><? echo round((($gesamt_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_0_9_m/$gesamt_0_9)*100),2); ?></td>
									<td><? echo round((($gesamt_10_19_m/$gesamt_10_19)*100),2); ?></td>
									<td><? echo round((($gesamt_20_29_m/$gesamt_20_29)*100),2); ?></td>
									<td><? echo round((($gesamt_30_39_m/$gesamt_30_39)*100),2); ?></td>
									<td><? echo round((($gesamt_40_49_m/$gesamt_40_49)*100),2); ?></td>
									<td><? echo round((($gesamt_50_59_m/$gesamt_50_59)*100),2); ?></td>
									<td><? echo round((($gesamt_60_69_m/$gesamt_60_69)*100),2); ?></td>
									<td><? echo round((($gesamt_70_79_m/$gesamt_70_79)*100),2); ?></td>
									<td><? echo round((($gesamt_80_89_m/$gesamt_80_89)*100),2); ?></td>
									<td><? echo round((($gesamt_90_99_m/$gesamt_90_99)*100),2); ?></td>
								</tr>
								<tr>
									<td>männlich % an Gesamtbevölkerung</td>
									<td></td>
									<td><? echo round((($gesamt_0_9_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_10_19_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_20_29_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_30_39_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_40_49_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_50_59_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_60_69_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_70_79_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_80_89_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_90_99_m/$gesamt)*100),2); ?></td>
								</tr>
								<tr bgcolor="#F6CECE">
									<td>weiblich</td>
									<td><? echo $gesamt_w; ?></td>
									<td><? echo $gesamt_0_9_w; ?></td>
									<td><? echo $gesamt_10_19_w; ?></td>
									<td><? echo $gesamt_20_29_w; ?></td>
									<td><? echo $gesamt_30_39_w; ?></td>
									<td><? echo $gesamt_40_49_w; ?></td>
									<td><? echo $gesamt_50_59_w; ?></td>
									<td><? echo $gesamt_60_69_w; ?></td>
									<td><? echo $gesamt_70_79_w; ?></td>
									<td><? echo $gesamt_80_89_w; ?></td>
									<td><? echo $gesamt_90_99_w; ?></td>
								</tr>
								<tr>
									<td>weiblich %</td>
									<td><? echo round((($gesamt_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_0_9_w/$gesamt_0_9)*100),2); ?></td>
									<td><? echo round((($gesamt_10_19_w/$gesamt_10_19)*100),2); ?></td>
									<td><? echo round((($gesamt_20_29_w/$gesamt_20_29)*100),2); ?></td>
									<td><? echo round((($gesamt_30_39_w/$gesamt_30_39)*100),2); ?></td>
									<td><? echo round((($gesamt_40_49_w/$gesamt_40_49)*100),2); ?></td>
									<td><? echo round((($gesamt_50_59_w/$gesamt_50_59)*100),2); ?></td>
									<td><? echo round((($gesamt_60_69_w/$gesamt_60_69)*100),2); ?></td>
									<td><? echo round((($gesamt_70_79_w/$gesamt_70_79)*100),2); ?></td>
									<td><? echo round((($gesamt_80_89_w/$gesamt_80_89)*100),2); ?></td>
									<td><? echo round((($gesamt_90_99_w/$gesamt_90_99)*100),2); ?></td>
								</tr>
								<tr>
									<td>weiblich % an Gesamtbevölkerung</td>
									<td></td>
									<td><? echo round((($gesamt_0_9_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_10_19_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_20_29_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_30_39_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_40_49_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_50_59_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_60_69_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_70_79_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_80_89_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_90_99_w/$gesamt)*100),2); ?></td>
								</tr>
								<tr bgcolor="#F3E2A9">
									<td>gesamt</td>
									<td><? echo $gesamt; ?></td>
									<td><? echo $gesamt_0_9; ?></td>
									<td><? echo $gesamt_10_19; ?></td>
									<td><? echo $gesamt_20_29; ?></td>
									<td><? echo $gesamt_30_39; ?></td>
									<td><? echo $gesamt_40_49; ?></td>
									<td><? echo $gesamt_50_59; ?></td>
									<td><? echo $gesamt_60_69; ?></td>
									<td><? echo $gesamt_70_79; ?></td>
									<td><? echo $gesamt_80_89; ?></td>
									<td><? echo $gesamt_90_99; ?></td>
								</tr>
								<tr>
									<td>gesamt % an Gesamtbevölkerung</td>
									<td></td>
									<td><? echo (round((($gesamt_0_19_m/$gesamt)*100),2))+(round((($gesamt_0_9_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_10_19_m/$gesamt)*100),2))+(round((($gesamt_10_19_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_20_29_m/$gesamt)*100),2))+(round((($gesamt_20_29_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_30_39_m/$gesamt)*100),2))+(round((($gesamt_30_39_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_40_49_m/$gesamt)*100),2))+(round((($gesamt_40_49_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_50_59_m/$gesamt)*100),2))+(round((($gesamt_50_59_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_60_69_m/$gesamt)*100),2))+(round((($gesamt_60_69_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_70_79_m/$gesamt)*100),2))+(round((($gesamt_70_79_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_80_89_m/$gesamt)*100),2))+(round((($gesamt_80_89_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_90_99_m/$gesamt)*100),2))+(round((($gesamt_90_99_w/$gesamt)*100),2)); ?></td>
								</tr>
							</table>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan=4>
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=10 height=50>
										<a href="#" onclick="klappe('eintraege12')" title="aufklappen/zuklappen"><b>Bevölkerung Jugend</b></a>							
									</td>							
								</tr>
							</table>
							<div id="eintraege12" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td colspan=2></td>			
									<td>0-u3</td>
									<td>3-u6</td>
									<td>6-u11</td>
									<td>11-u14</td>
									<td>14-u16</td>
									<td>16-u18</td>
									<td>18-u21</td>
									<td>21-u24</td>
								</tr>
								<tr>
									<td rowspan=8 align=center width="5%">2011</td>
									<td bgcolor="#A9E2F3">männlich</td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_0_2_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_3_5_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_6_10_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_11_13_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_14_15_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_16_17_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_18_20_m; ?></td>
									<td bgcolor="#A9E2F3"><? echo $gesamt_21_23_m; ?></td>
								</tr>
								<tr>
									<td>männlich %</td>
									<td><? echo round((($gesamt_0_2_m/$gesamt_0_2)*100),2); ?></td>
									<td><? echo round((($gesamt_3_5_m/$gesamt_3_5)*100),2); ?></td>
									<td><? echo round((($gesamt_6_10_m/$gesamt_6_10)*100),2); ?></td>
									<td><? echo round((($gesamt_11_13_m/$gesamt_11_13)*100),2); ?></td>
									<td><? echo round((($gesamt_14_15_m/$gesamt_14_15)*100),2); ?></td>
									<td><? echo round((($gesamt_16_17_m/$gesamt_16_17)*100),2); ?></td>
									<td><? echo round((($gesamt_18_20_m/$gesamt_18_20)*100),2); ?></td>
									<td><? echo round((($gesamt_21_23_m/$gesamt_21_23)*100),2); ?></td>
								</tr>
								<tr>
									<td>männlich % an Gesamtbevölkerung</td>
									<td><? echo round((($gesamt_0_2_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_3_5_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_6_10_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_11_13_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_14_15_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_16_17_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_18_20_m/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_21_23_m/$gesamt)*100),2); ?></td>
								</tr>
								<tr bgcolor="#F6CECE">
									<td>weiblich</td>
									<td><? echo $gesamt_0_2_w; ?></td>
									<td><? echo $gesamt_3_5_w; ?></td>
									<td><? echo $gesamt_6_10_w; ?></td>
									<td><? echo $gesamt_11_13_w; ?></td>
									<td><? echo $gesamt_14_15_w; ?></td>
									<td><? echo $gesamt_16_17_w; ?></td>
									<td><? echo $gesamt_18_20_w; ?></td>
									<td><? echo $gesamt_21_23_w; ?></td>
								</tr>
								<tr>
									<td>weiblich %</td>
									<td><? echo round((($gesamt_0_2_w/$gesamt_0_2)*100),2); ?></td>
									<td><? echo round((($gesamt_3_5_w/$gesamt_3_5)*100),2); ?></td>
									<td><? echo round((($gesamt_6_10_w/$gesamt_6_10)*100),2); ?></td>
									<td><? echo round((($gesamt_11_13_w/$gesamt_11_13)*100),2); ?></td>
									<td><? echo round((($gesamt_14_15_w/$gesamt_14_15)*100),2); ?></td>
									<td><? echo round((($gesamt_16_17_w/$gesamt_16_17)*100),2); ?></td>
									<td><? echo round((($gesamt_18_20_w/$gesamt_18_20)*100),2); ?></td>
									<td><? echo round((($gesamt_21_23_w/$gesamt_21_23)*100),2); ?></td>
								</tr>
								<tr>
									<td>weiblich % an Gesamtbevölkerung</td>
									<td><? echo round((($gesamt_0_2_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_3_5_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_6_10_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_11_13_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_14_15_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_16_17_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_18_20_w/$gesamt)*100),2); ?></td>
									<td><? echo round((($gesamt_21_23_w/$gesamt)*100),2); ?></td>
								</tr>
								<tr bgcolor="#F3E2A9">
									<td>gesamt</td>
									<td><? echo $gesamt_0_2; ?></td>
									<td><? echo $gesamt_3_5; ?></td>
									<td><? echo $gesamt_6_10; ?></td>
									<td><? echo $gesamt_11_13; ?></td>
									<td><? echo $gesamt_14_15; ?></td>
									<td><? echo $gesamt_16_17; ?></td>
									<td><? echo $gesamt_18_20; ?></td>
									<td><? echo $gesamt_21_23; ?></td>
								</tr>
								<tr>
									<td>gesamt % an Gesamtbevölkerung</td>
									<td><? echo (round((($gesamt_0_2_m/$gesamt)*100),2))+(round((($gesamt_0_2_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_3_5_m/$gesamt)*100),2))+(round((($gesamt_3_5_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_6_10_m/$gesamt)*100),2))+(round((($gesamt_6_10_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_11_13_m/$gesamt)*100),2))+(round((($gesamt_11_13_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_14_15_m/$gesamt)*100),2))+(round((($gesamt_14_15_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_16_17_m/$gesamt)*100),2))+(round((($gesamt_16_17_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_18_20_m/$gesamt)*100),2))+(round((($gesamt_18_20_w/$gesamt)*100),2)); ?></td>
									<td><? echo (round((($gesamt_21_23_m/$gesamt)*100),2))+(round((($gesamt_21_23_w/$gesamt)*100),2)); ?></td>
								</tr>
							</table>
							</div>
						</td>
					</tr>					
					<tr>
						<td colspan=4>
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr bgcolor="#BDBDBD">
									<td align=center colspan=19 height=50>
										<a href="#" onclick="klappe('eintraege13')" title="aufklappen/zuklappen"><b>Soziales</b></a>							
									</td>							
								</tr>
							</table>
							<div id="eintraege13" style="display: none">
							<table width="100%" border="1" cellpadding="3" cellspacing="0">
								<tr>
									<td colspan=2 rowspan=3></td>									
									<td colspan=9 align=center>Bedarfsgemeinschaft</td>
									<td colspan=7 align=center>Personen in Bedarfsgemeinschaften</td>
								</tr>
								<tr>
									<td rowspan=2>Insgesamt</td>									
									<td colspan=4 align=center>nach BG-Typ</td>
									<td colspan=4 align=center>BG mit Personen unter 18 Jahren</td>
									<td rowspan=2>Insgesamt</td>
									<td colspan=7 align=center>nach Altersgruppen</td>
								</tr>
								<tr>									
									<td align="center">Single-BG</td>
									<td align="center">alleinerziehende BG</td>
									<td align="center">Partner-BG ohne Kinder</td>
									<td align="center">Partner-BG mit Kinder</td>									
									<td align="center">insgesamt</td>
									<td align="center">1 Kind</td>
									<td align="center">2 Kinder</td>	
									<td align="center">3 oder mehr Kinder</td>
									<td align="center">unter 3 Jahre</td>
									<td align="center">3 bis unter 7 Jahre</td>
									<td align="center">7 bis unter 15 Jahre</td>
									<td align="center">15 bis unter 18 Jahre</td>
									<td align="center">18 bis unter 20 Jahre</td>	
									<td align="center">20 bis unter 25 Jahre</td>
								</tr>
								<tr>
									<td rowspan=2 align=center width="5%">2011</td>
									<td>Anzahl</td>
									<td><? echo $bg_insgesamt; ?></td>
									<td><? echo $bg_single; ?></td>
									<td><? echo $bg_alleinerz; ?></td>
									<td><? echo $bg_paar_o; ?></td>
									<td><? echo $bg_paar_m; ?></td>
									<td><? echo $bg_ges_u18; ?></td>
									<td><? echo $bg_1_kinder; ?></td>
									<td><? echo $bg_2_kinder; ?></td>
									<td><? echo $bg_3_kinder; ?></td>
									<td><? echo $p_bg_ges; ?></td>
									<td><? echo $p_bg_2; ?></td>
									<td><? echo $p_bg_3_6; ?></td>
									<td><? echo $p_bg_7_14; ?></td>
									<td><? echo $p_bg_15_17; ?></td>
									<td><? echo $p_bg_18_19; ?></td>
									<td><? echo $p_bg_20_25; ?></td>
								</tr>									
									<td>Anteil</td>
									<td><? echo round(($bg_insgesamt/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($bg_single/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($bg_alleinerz/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($bg_paar_o/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($bg_paar_m/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($bg_ges_u18/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($bg_1_kinder/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($bg_2_kinder/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($bg_3_kinder/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($p_bg_ges/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($p_bg_2/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($p_bg_3_6/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($p_bg_7_14/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($p_bg_15_17/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($p_bg_18_19/$gesamt)*100,2). "%"; ?></td>
									<td><? echo round(($p_bg_20_25/$gesamt)*100,2). "%"; ?></td>
								<tr>
							</table>
							</div>
						</td>
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
