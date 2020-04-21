<?php include ("../include/connect_geobasis_geoportal2.php"); ?>
<!DOCTYPE html>
<html>

<head>
<title> Geoportal 2.0 Admin</title>
<? include('../head.php'); ?>
<link href="style_admin.css" rel="stylesheet">

<script>
$(document).ready(function () {
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

</script>
<script>


$(document).ready(function() {
    var max_fields      = 12; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text"  class="form-control"  placeholder="Attribut" name="query[]"/><input type="text"  class="form-control"  placeholder="Bezeichnung" name="beschriftung[]"/><a href="#"  class="remove_field"><span><i class="glyphicon glyphicon-remove" style="color:red;"></i></span></a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
		e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});

</script>


</head>

<body>
<?php
		if (isset($_POST['fertig'])){  
		
		
		$thema_neu = $_POST['thema'];
		$themen_name = $_POST['themenname'];
		$layerid = $_POST['layerid'];
		$dateiname = $_POST['dateiname'];
		$dateipfad = $_POST['dateipfad'];
		$online = $_POST['online'];
		$bearbeiter = $_POST['bearbeiter'];
		$stichtag = $_POST['stichtag'];
		$wms = $_POST['wmspfad'];
		$wms_layer = $_POST['layer'];
		$db_schema = $_POST['schema'];
		$db_sicht = $_POST['sicht'];
		$db_query = $_POST['query'];
		$beschriftung1 = $_POST['beschriftung1'];
		$beschriftung2 = $_POST['beschriftung2'];
		
		
		$query = "INSERT INTO 
					geoportal.geoportal_2 (	layer_id,
											themen_name,
											kategorie,
											dateiname,
											dateipfad,
											online,
											bearbeiter,
											stichtag,
											wms,
											wms_layer,
											db_schema,
											db_sicht,
											db_query,
											beschriftung)
								VALUES 	(	'$layerid',
											'$themen_name',
											'$thema_neu',
											'$dateiname',
											'$dateipfad',
											'',
											'$bearbeiter',
											'2017-10-05',
											'$wms',
											'$wms_layer',
											'$db_schema',
											'$db_sicht',
											'$db_query',
											'{[$beschriftung1,$beschriftung2]}')"; 
		echo $query;
		$result = $dbqueryp($connectp,$query);   
		if (!$result){  
			echo "<div class='alert alert-danger' role='alert'>Update fehlgeschlagen</div>";  
			}  
		else  
			{
			echo "<div class='alert alert-success' role='alert'>Update erfolgreich gespeichert</div>";  
			print_r ($beschriftung);

			}; 
		};
		
?>

<div class="admin-panel" >

<?php include ("navigation.php"); ?>	



    <div class="main">
         <div id="tab1">
			<header>
				<h1>Thema erstellen</h1>
			</header>
		</div> 

		 <div class="container">
	<div class="row">
		<section>
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Schritt 1">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Schritt 2">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-globe"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Schritt 3">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-th-list"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Fertigstellung">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-edit"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>


			
				<?php
				if ( htmlspecialchars($_POST['themenname']) <> "" )
				{
					// und nun die Daten in eine Datei schreiben
					// Datei wird zum Schreiben geöffnet
					$handle = fopen("../../../../../tmp/".htmlspecialchars($_POST['dateiname']), "w");
				
				
					fwrite ( $handle, "<?php\n\n\n");
					
					// setzen von $themendatei
					fwrite ( $handle, "$");
				    fwrite ( $handle, "themendatei='");
					fwrite ( $handle, htmlspecialchars($_POST['dateiname']) );
					fwrite ( $handle, "';				//Name der Themendatei\n" );
					
					// setzen von $thema 
					fwrite ( $handle, "$");
				    fwrite ( $handle, "thema='");
					fwrite ( $handle, htmlspecialchars($_POST['themenname']) );
					fwrite ( $handle, "';				//Themenname für Anzeige im Geoportal\n" );
									
					// setzen von $themaWMS
					fwrite ( $handle, "$");
				    fwrite ( $handle, "themaWMS='");
					fwrite ( $handle, htmlspecialchars($_POST['wmspfad']) );
					fwrite ( $handle, "';				//Link des WMS Dienstes\n" );	

					// setzen von $layer
					fwrite ( $handle, "$");
				    fwrite ( $handle, "layer='");
					fwrite ( $handle, htmlspecialchars($_POST['layer']) );
					fwrite ( $handle, "';				// Layer in der WMS Datei\n" );			

					// setzen von $layerid
					fwrite ( $handle, "$");
				    fwrite ( $handle, "layerid='");
					fwrite ( $handle, htmlspecialchars($_POST['layerid'] ));
					fwrite ( $handle, "';				// LayerID wird für Metadatenanzeige benötigt\n" );
					
					// setzen von $schema
					fwrite ( $handle, "$");
				    fwrite ( $handle, "schema='");
					fwrite ( $handle, htmlspecialchars($_POST['schema'] ));
					fwrite ( $handle, "';				//Schema in der Datenbank\n" );
					
					// setzen von $tabelle
					fwrite ( $handle, "$");
				    fwrite ( $handle, "sicht='");
					fwrite ( $handle, htmlspecialchars($_POST['sicht'] ));
					fwrite ( $handle, "';				//Tabellenname in der Datenbank	\n" );
					
					// setzen von $queryselect
					fwrite ( $handle, "$");
				    fwrite ( $handle, "queryselect='");
					fwrite ( $handle, htmlspecialchars($_POST['query'] ));
					fwrite ( $handle, "';				// Attribute welche ausgegeben werden sollen\n" );
					
					// setzen von $beschriftung
					fwrite ( $handle, "$");
				    fwrite ( $handle, "beschriftung[0]='");
					fwrite ( $handle, htmlspecialchars($_POST['beschriftung1'] ));
					fwrite ( $handle, "';				// Beschriftung der Attribite im Geoportal\n" );	
					
					// setzen von $beschriftung
					fwrite ( $handle, "$");
				    fwrite ( $handle, "beschriftung[1]='");
					fwrite ( $handle, htmlspecialchars($_POST['beschriftung2'] ));
					fwrite ( $handle, "';				// Beschriftung der Attribite im Geoportal\n" );					
					
					// setzen von $beschriftung
					fwrite ( $handle, "$");
				    fwrite ( $handle, "beschriftung[2]='");
					fwrite ( $handle, htmlspecialchars($_POST['beschriftung3'] ));
					fwrite ( $handle, "';				// Beschriftung der Attribite im Geoportal\n" );					
					
					// setzen von $beschriftung
					fwrite ( $handle, "$");
				    fwrite ( $handle, "beschriftung[3]='");
					fwrite ( $handle, htmlspecialchars($_POST['beschriftung4'] ));
					fwrite ( $handle, "';				// Beschriftung der Attribite im Geoportal\n" );

					// setzen von $beschriftung
					fwrite ( $handle, "$");
				    fwrite ( $handle, "beschriftung[4]='");
					fwrite ( $handle, htmlspecialchars($_POST['beschriftung5'] ));
					fwrite ( $handle, "';				// Beschriftung der Attribite im Geoportal\n" );

					// setzen von $beschriftung
					fwrite ( $handle, "$");
				    fwrite ( $handle, "beschriftung[5]='");
					fwrite ( $handle, htmlspecialchars($_POST['beschriftung6'] ));
					fwrite ( $handle, "';				// Beschriftung der Attribite im Geoportal\n" );

					// setzen von $beschriftung
					fwrite ( $handle, "$");
				    fwrite ( $handle, "beschriftung[6]='");
					fwrite ( $handle, htmlspecialchars($_POST['beschriftung7'] ));
					fwrite ( $handle, "';				// Beschriftung der Attribite im Geoportal\n" );

					// setzen von $beschriftung
					fwrite ( $handle, "$");
				    fwrite ( $handle, "beschriftung[7]='");
					fwrite ( $handle, htmlspecialchars($_POST['beschriftung8'] ));
					fwrite ( $handle, "';				// Beschriftung der Attribite im Geoportal\n" );

					// setzen von $beschriftung
					fwrite ( $handle, "$");
				    fwrite ( $handle, "beschriftung[8]='");
					fwrite ( $handle, htmlspecialchars($_POST['beschriftung9'] ));
					fwrite ( $handle, "';				// Beschriftung der Attribite im Geoportal\n" );

					// setzen von $beschriftung
					fwrite ( $handle, "$");
				    fwrite ( $handle, "beschriftung[9]='");
					fwrite ( $handle, htmlspecialchars($_POST['beschriftung10'] ));
					fwrite ( $handle, "';				// Beschriftung der Attribite im Geoportal\n" );

					// setzen von $beschriftung
					fwrite ( $handle, "$");
				    fwrite ( $handle, "beschriftung[10]='");
					fwrite ( $handle, htmlspecialchars($_POST['beschriftung11'] ));
					fwrite ( $handle, "';				// Beschriftung der Attribite im Geoportal\n" );	

					// setzen von $beschriftung
					fwrite ( $handle, "$");
				    fwrite ( $handle, "beschriftung[11]='");
					fwrite ( $handle, htmlspecialchars($_POST['beschriftung12'] ));
					fwrite ( $handle, "';				// Beschriftung der Attribite im Geoportal\n" );

					
					// Schnittstelle Abfrage
					fwrite ( $handle, "include('");
				    fwrite ( $handle, "abfrage.php");
					fwrite ( $handle, "');				// Attribute welche ausgegeben werden sollen\n" );
					
					// PHP Ende
					fwrite ( $handle, "?>");
				
					// Datei schließen
					fclose ( $handle );
					
					// Downloadlink

					echo "
						<div align='center' class='tab-pane' role='tabpanel' id='complete'>
								<h3>Datei wurde generiert und im /tmp Verzeichnis abgelegt!</h3>
							<p>
															<span>
									<i class='glyphicon glyphicon-ok finish'></i>
								</span><br>
								<div class='form-group'>
							<textarea id='textarea' rows='20' cols='120' style='padding-left:50px';>";
								$filename = "../../../../../tmp/".htmlspecialchars($_POST['dateiname']);
								$file = fopen($filename, "r");
								echo fread($file, filesize($filename));
								fclose($file);
								echo"</textarea>
								</div>

						</div>
				";
				
					// Datei wird nicht weiter ausgeführt
					exit;
				}
				?>			

            <form role="form" method="POST" action="thema_erstellen.php">
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <h3>Grundeinstellungen</h3>
                        <p>
						<br>
						
						<div class="form-group">
							<label class="control-label">Themenname</label>
							<input name="themenname" maxlength="100" type="text" class="form-control" placeholder="z.B. Apotheken"  />
						</div>
						<div class="form-group">
							<label class="control-label">Dateiname</label>
							<input name="dateiname" maxlength="100" type="text" r class="form-control" placeholder="z.B. apotheken.php"  />
						</div>		
						<div class="form-group">
							<label class="control-label">Layer ID</label>
							<input name="layerid" maxlength="100" type="text"  class="form-control" placeholder="z.B. 110020"  />
						</div>							
						</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" id="btn" class="btn btn-primary next-step">Weiter</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <h3>WMS Einstellungen</h3>
                        <p>
						<div class="form-group">
							<label class="control-label">WMS Pfad</label>
							<input  name="wmspfad" maxlength="100" type="text"  class="form-control" placeholder="z.B. https://geoport-lk-mse.de/webservices/mse_all"  />
						</div>
						<div class="form-group">
							<label class="control-label">Layer</label>
							<input name="layer" maxlength="100" type="text"  class="form-control" placeholder="z.B. Apotheken"  />
						</div>								
						</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" id="btn" class="btn btn-default prev-step">Zurück</button></li>
                            <li><button type="button" id="btn" class="btn btn-primary next-step">Weiter</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <h3>Datenbank Einstellungen</h3>
						
                        <p>
						<div class="form-group">
							<label class="control-label">Schema</label>						
						<input name="schema" maxlength="100" type="text"  value="geoportal" class="form-control" selected  placeholder=""  />
						</div>
						
						<div class="form-group" id="sicht">
							<label class="control-label">Sicht</label> <!--SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'-->
							<?php
							
							$query="SELECT table_name FROM information_schema.tables WHERE table_schema = 'geoportal'";
							
							$result = $dbqueryp($connectp,$query);
							$counter=0;

							while($r = $fetcharrayp($result))
							{
								$table_name[$counter] = $r[table_name];
								$counter++;
							};
							
							echo"<select multiple class='form-control' name='sicht' >";
							for ($i = 0; $i < $counter; $i++)
							{
								echo"<option>$table_name[$i]</option>";
							};
							echo"</select>";
							
						?>
						</div>
						<?php
						
							// $query="select column_name from information_schema.columns where table_schema='health' and table_name='zert_gesundheitskurse'";
							
							// $result = $dbqueryp($connectp,$query);
							// $counter=0;

							// while($r = $fetcharrayp($result))
							// {
								// $attribut_name[$counter] = $r[column_name];
								// $counter++;
							// };
							
							
							// echo"<div><h4>Attributauswahl: (Test)</h4></div><form>";
							// for ($i = 0; $i < $counter; $i++)
							// {
								// echo"<div class='checkbox-inline'><label><input type='checkbox'>$attribut_name[$i]</label></div>";
							// };
							// echo"</form>";
							
								
						?>
						<div class="form-group">
							<label class="control-label">Attribute ( Reihenfolge beachten ! )</label>
							<input name="query" maxlength="100" type="text"  class="form-control" placeholder="z.B. gid, bezeichnung, ..."  />
						</div>					
						</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" id="btn" class="btn btn-default prev-step">Zurück</button></li>
                            <!--<li><button type="button" class="btn btn-default next-step">Überspringen</button></li>-->
                            <li><button type="button" id="btn" class="btn btn-primary btn-info-full next-step">Weiter</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
							<h3>Themeneinstellungen</h3>
							<p>
													
						<div class="form-group">
							<label class="control-label">Beschriftung 1</label>
							<input name="beschriftung1" maxlength="100" type="text"  class="form-control" placeholder="..."  />
							<label class="control-label">Beschriftung 2</label>
							<input name="beschriftung2" maxlength="100" type="text"  class="form-control" placeholder="..."  />
							<label class="control-label">Beschriftung 3</label>
							<input name="beschriftung3" maxlength="100" type="text"  class="form-control" placeholder="..."  />
							<label class="control-label">Beschriftung 4</label>
							<input name="beschriftung4" maxlength="100" type="text"  class="form-control" placeholder="..."  />
							<label class="control-label">Beschriftung 5</label>
							<input name="beschriftung5" maxlength="100" type="text"  class="form-control" placeholder="..."  />
							<label class="control-label">Beschriftung 6</label>
							<input name="beschriftung6" maxlength="100" type="text"  class="form-control" placeholder="..."  />
							<label class="control-label">Beschriftung 7</label>
							<input name="beschriftung7" maxlength="100" type="text"  class="form-control" placeholder="..."  />
							<label class="control-label">Beschriftung 8</label>
							<input name="beschriftung8" maxlength="100" type="text"  class="form-control" placeholder="..."  />
							<label class="control-label">Beschriftung 9</label>
							<input name="beschriftung9" maxlength="100" type="text"  class="form-control" placeholder="..."  />
							<label class="control-label">Beschriftung 10</label>
							<input name="beschriftung10" maxlength="100" type="text"  class="form-control" placeholder="..."  />
							<label class="control-label">Beschriftung 11</label>
							<input name="beschriftung11" maxlength="100" type="text"  class="form-control" placeholder="..."  />
							<label class="control-label">Beschriftung12</label>
							<input name="beschriftung12" maxlength="100" type="text"  class="form-control" placeholder="..."  />
						</div>	
						
							<div class="input_fields_wrap form-inline form-group">
							<div>Attribute hinzufügen <button class="btn btn-default add_field_button" disabled><span><i class="glyphicon glyphicon-plus"></i></span></button></div><br>
							<div><input disabled type="text" name="query[]" class="form-control"  placeholder="Attribut"><input disabled class="form-control" type="text" name="beschriftung[]" placeholder="Beschriftung"></div>
							</div>	  
                        </p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" id="btn" class="btn btn-default prev-step">Zurück</button></li>
                            <li><button type="reset" id="btn" onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>'" class="btn btn-default next-step">Abbrechen</button></li>
                            <li><button type="submit" id="btn-final"  name='fertig' class="btn btn-primary btn-info-full btn-success">Fertig</button></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
   </div>
</div>
    </div>
  
 
</div>

</body>

</html>