								<table width="100%" border="0" valign="top">
									<tr height="35">
										<td colspan="<? echo $sp_anz ; ?> " align="center" height=30 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;echo 'in der Gemeinde ',$gemeindename,' für das Thema ',$titel2,' zuständig:'; echo $font_farbe_end ;?>
										</td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=20><small>Name:</td>
										<td><b><? echo $sachbearbeiter[0]["mitarbeiter_titel"],' ',$sachbearbeiter[0]["mitarbeiter_vorname"],' ',$sachbearbeiter[0]["mitarbeiter_name"]; ?></td>
										<? if ($i_sachbearbeiter > 1) {?>
										<td height=20><small>Name:</td>
										<td><b><? echo $sachbearbeiter[1]["mitarbeiter_titel"],' ',$sachbearbeiter[1]["mitarbeiter_vorname"],' ',$sachbearbeiter[1]["mitarbeiter_name"]; ?></td>
										<?}?>
									</tr>
									<tr>
										<td height=20><small>Telefon:</td>
										<td><? echo $sachbearbeiter[0]["mitarbeiter_telefon"] ?></td>
										<? if ($i_sachbearbeiter > 1) {?>
										<td height=20><small>Telefon:</td>
										<td><? echo $sachbearbeiter[0]["mitarbeiter_telefon"] ?></td>
										<?}?>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=20><small>Fax:</td>
										<td><? echo $sachbearbeiter[0]["mitarbeiter_fax"] ?></td>
										<? if ($i_sachbearbeiter > 1)	{?>
										<td height=20><small>Fax:</td>
										<td><? echo $sachbearbeiter[1]["mitarbeiter_fax"] ?></td>
										<?}?>
									</tr>
									<tr>
										<td height=20><small>E-Mail:</td>
										<td><a href="mailto:<? echo $sachbearbeiter[0]["mitarbeiter_mail"];?>"><? echo $sachbearbeiter[0]["mitarbeiter_mail"];?></a></td>
										<? if ($i_sachbearbeiter > 1) { ?>
										<td height=20><small>E-Mail:</td>
										<td><a href="mailto:<? echo $sachbearbeiter[1]["mitarbeiter_mail"];?>"><? echo $sachbearbeiter[1]["mitarbeiter_mail"];?></a></td>
										<?}?>
									</tr>
									<tr height="35">
										<td colspan="<? echo $sp_anz ;?>" align="left" height=35 bgcolor=<? echo $header_farbe ;?>><? echo $font_farbe ;?>Sachgebiet: <? echo $sachbearbeiter[0]["sg_name"] ?><? echo $font_farbe_end ;?></td>
									</tr>
									<tr>
										<td height=20><small>Sachgebietsleiter</td>
										<td><? echo $sachbearbeiter[0]["sg_leiter_vorname"],' ',$sachbearbeiter[0]["sg_leiter_name"]; ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=20><small>Telefon:</td>
										<td><? echo $sachbearbeiter[0]["sg_leiter_telefon"] ?></td>
									</tr>
									<tr>
										<td height=20><small>E-Mail:</td>
										<td><a href="mailto:<? echo $sachbearbeiter[0]["sg_leiter_mail"];?>"><? echo $sachbearbeiter[0]["sg_leiter_mail"];?></a></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=20><small>Fachamt</td>
										<td><? echo $sachbearbeiter[0]["fachamt_name"] ?></td>
									</tr>
									<tr>
										<td height=20><small>Amtsleiter</td>
										<td><? echo $sachbearbeiter[0]["fachamt_leiter"]; ?></td>
									</tr>
									<tr bgcolor=<? echo $element_farbe ;?>>
										<td height=20><small>Telefon:</td>
										<td><? echo $sachbearbeiter[0]["fachamt_leiter_telefon"] ?></td>
									</tr>
									<tr>
										<td height=20><small>E-Mail:</td>
										<td><a href="mailto:<? echo $sachbearbeiter[0]["fachamt_leiter_mail"];?>"><? echo $sachbearbeiter[0]["fachamt_leiter_mail"];?></a></td>
									</tr>
								</table>
 
