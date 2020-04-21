<html>

<head>
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
            return true;
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
</head>

<body>


<div class="admin-panel">



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
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-globe"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-th-list"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

			
			
<?php
if ( $_GET['test'] <> "" )
{
    // und nun die Daten in eine Datei schreiben
    // Datei wird zum Schreiben geöffnet
    $handle = fopen ( "test.txt", "a+" );
 
    // schreiben des Inhaltes von email
    fwrite ( $handle, $_GET['test'] );
 
    // Trennzeichen einfügen, damit Auswertung möglich wird
    fwrite ( $handle, "|" );
 
    // schreiben des Inhalts von name
    fwrite ( $handle, $_GET['name'] );
 
    // Datei schließen
    fclose ( $handle );
 
    echo "Danke - Ihre Daten wurden speichert";
 
    // Datei wird nicht weiter ausgeführt
    exit;
}
?>			

            <form role="form">
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <h3>Grundeinstellungen</h3>
                        <p>
						<br>
						
						<div class="form-group">
							<label class="control-label">Themenname</label>
							<input name="test" maxlength="100" type="text" required="required" class="form-control" placeholder="z.B. Apotheken"  />
						</div>
						<div class="form-group">
							<label class="control-label">Dateiname</label>
							<input  maxlength="100" type="text" required="required" class="form-control" placeholder="apotheken.php"  />
						</div>				
						</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-primary next-step">Weiter</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <h3>WMS Einstellungen</h3>
                        <p>
						<div class="form-group">
							<label class="control-label">WMS Pfad</label>
							<input  maxlength="100" type="text" required="required" class="form-control" placeholder="z.B. https://geoport-lk-mse.de/webservices/mse_all"  />
						</div>
						<div class="form-group">
							<label class="control-label">Layer</label>
							<input  maxlength="100" type="text" required="required" class="form-control" placeholder="z.B. Apotheken"  />
						</div>	
						<div class="form-group">
							<label class="control-label">Layer ID</label>
							<input  maxlength="100" type="text" required="required" class="form-control" placeholder="z.B. 110020"  />
						</div>	
						<div class="form-group">
							<label class="control-label">GET Themenname</label>
							<input  maxlength="100" type="text" required="required" class="form-control" placeholder="z.B. apotheke"  />
						</div>								
						</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Zurück</button></li>
                            <li><button type="button" class="btn btn-primary next-step">Weiter</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <h3>Datenbank Einstellungen</h3>
                        <p></p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Zurück</button></li>
                            <li><button type="button" class="btn btn-default next-step">Überspringen</button></li>
                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Weiter</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <h3>Speichern?</h3>
                        <p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Zurück</button></li>
                            <li><button type="button" class="btn btn-default next-step">Abbrechen</button></li>
                            <li><button type="submit" class="btn btn-primary btn-info-full btn-success">Speichern</button></li>
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