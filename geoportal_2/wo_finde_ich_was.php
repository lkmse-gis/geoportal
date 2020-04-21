
<?php
	

	$speicher = unserialize(rawurldecode($_GET['speicher']));
	$aktuelleseite = $_SERVER['PHP_SELF'];
	$speicher[] = array( 'Wo finde ich was?' => $aktuelleseite);

	foreach ($speicher as $key => $value) {


	 foreach ($value as $key1 => $value1) {

		$titel[$key] = $key1;
		$url[$key] = $value1;
		
		
	 }
   }

   	$serialized = rawurlencode(serialize($speicher));


?>
<!DOCTYPE html>
<html lang="de">
  <head>
	<? include('head.php'); ?>
	
  </head>
  <body>
	<header >

		<?php include('navbar.php'); ?>
		
	</header>
	

	<div class="suche"></div>  
	<header class="header_standard" style="background: url(bilder/feld.jpg) no-repeat center center;background-color:grey;">
	<div class="carousel-item" >
	</div>
  			<div class="carousel-caption" >
				<h2 class="display-4" style="background-color:#006085;width:330px;margin-left:-50px;">Themen</h2>
				<p style="background-color:#75b726;width:360px;margin-left:30px;font-size:22w;">Aktuell</p>
			</div>  
</header>
<div>
<ul id="breadcrumbs-one">
<li><a href="#" class="current"><? echo $titel[0] ?> </a></li>
</ul>
</div>
	<section>

	
		


<?php

//////////////////// Ermitteln der Anzahl an Dateien zum Thema, hier Bsp Gesundheit  ///////////////////////

$files = scandir('../geoportal_2/themen/gesundheit/');

$files_count = count($files)-3; // Minus 3 wegen "." und ".." und gesundheit.php

$count_bauen = 0;

?>

	<!--	
	 <div class="container" >
        <div class="row" >
			<div class="" style="height:100%">
            <div class="col-sm-6 col-md-4 col-lg-3 text-muted"><a href="#" <?php if ($count_bauen == 0) {echo 'style="color:#777;" disabled="disabled"';}; ?>><p><em class="glyphicon glyphicon-wrench "></em><br>Bauen</a></p><div class="comment-box" <?php if ($count_bauen == 0) {echo 'style="background-color:lightgrey;"';}; ?> >0</div></div>
            <div class="col-sm-6 col-md-4 col-lg-3 text-muted"><p><em class="glyphicon glyphicon-user"></em><br>Bevölkerung</p><div class="comment-box" <?php if ($count_bauen == 0) {echo 'style="background-color:lightgrey;"';}; ?> >0</div></div>
            <div class="clearfix visible-sm-block"></div>
            <div class="col-sm-6 col-md-4 col-lg-3 text-muted"><p><em class="glyphicon glyphicon-object-align-bottom"></em><br>Bodenrichtwerte</p><div class="comment-box" <?php if ($count_bauen == 0) {echo 'style="background-color:lightgrey;"';}; ?> >0</div></div>
            <div class="clearfix visible-md-block"></div>
            <div class="col-sm-6 col-md-4 col-lg-3 text-muted"><p><em class="glyphicon glyphicon-education"></em><br>Bildung</p><div class="comment-box" <?php if ($count_bauen == 0) {echo 'style="background-color:lightgrey;"';}; ?> >0</div></div>
            <div class="clearfix visible-sm-block"></div>
            <div class="clearfix visible-lg-block"></div>
            <div class="col-sm-6 col-md-4 col-lg-3  <?php if ($files_count == 0){ echo "text-muted";} ?>"><p><a href="../geoportal_2/themen/gesundheit/gesundheit.php?speicher=<?php echo $serialized; ?>&ebene=0&auswahl=Gesundheit"><em class="fa fa-medkit"></em><br>Gesundheit</a></p><div class="comment-box" <?php if ($files_count == 0) {echo 'style="background-color:lightgrey;"';}; ?> ><?php echo $files_count; ?></div></div>
            <div class="col-sm-6 col-md-4 col-lg-3 text-muted"><p><em class="fa fa-sitemap"></em><br>Kreisstruktur</p><div class="comment-box" <?php if ($count_bauen == 0) {echo 'style="background-color:lightgrey;"';}; ?> >0</div></div>
            <div class="clearfix visible-sm-block"></div>
            <div class="clearfix visible-md-block"></div>
            <div class="col-sm-6 col-md-4 col-lg-3 text-muted"><p><em class="glyphicon glyphicon-tree-deciduous"></em><br>Umwelt/Natur</p><div class="comment-box" <?php if ($count_bauen == 0) {echo 'style="background-color:lightgrey;"';}; ?> >0</div></div>
            <div class="col-sm-6 col-md-4 col-lg-3 text-muted"><p><em class="fa fa-bomb"></em><br>Sicherheit</p><div class="comment-box" <?php if ($count_bauen == 0) {echo 'style="background-color:lightgrey;"';}; ?> >0</div></div>
            <div class="clearfix visible-sm-block"></div>
            <div class="clearfix visible-lg-block"></div>
            <div class="col-sm-6 col-md-4 col-lg-3 text-muted"><p><em class="glyphicon glyphicon-tent"></em><br>Tourismus</p><div class="comment-box" <?php if ($count_bauen == 0) {echo 'style="background-color:lightgrey;"';}; ?> >0</div></div>
            <div class="clearfix visible-md-block"></div>
            <div class="col-sm-6 col-md-4 col-lg-3 text-muted"><p><em class="glyphicon glyphicon-road"></em><br>Verkehr</</p><div class="comment-box" <?php if ($count_bauen == 0) {echo 'style="background-color:lightgrey;"';}; ?> >0</div></div>
            <div class="clearfix visible-sm-block"></div>
            <div class="col-sm-6 col-md-4 col-lg-3 text-muted"><p><em class="fa fa-recycle"></em><br>Ver-/Entsorgung</p><div class="comment-box" <?php if ($count_bauen == 0) {echo 'style="background-color:lightgrey;"';}; ?> >0</div></div>
            <div class="col-sm-6 col-md-4 col-lg-3 text-muted"><p><em class="fa fa-industry"></em><br>Wirtschaft</p><div class="comment-box" <?php if ($count_bauen == 0) {echo 'style="background-color:lightgrey;"';}; ?> >0</div></div>
			</div>
        </div>
    </div>-->
	
	<div class="col-md-12">	
<br>
<div class="container">
  <div id="accordion">
	<a class="card-link" data-toggle="collapse" href="#t1">
		<div class="card">
			<div class="card-header">
			Bauen
			</div>
			<div id="t1" class="collapse " data-parent="#accordion">
			<div class="card-body">
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t2">
		<div class="card">
			<div class="card-header">
			Bevölkerung
			</div>
			<div id="t2" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t3">
		<div class="card">
			<div class="card-header">
			Bodenrichtwerte
			</div>
			<div id="t3" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t4">
		<div class="card">
			<div class="card-header">
			Bildung
			</div>
			<div id="t4" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t5">
		<div class="card">
			<div class="card-header">
			Gesundheit<em style="margin-left:5px;" class="fa fa-medkit"></em>
			</div>
			<div id="t5" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t6">
		<div class="card">
			<div class="card-header">
			Kreisstruktur
			</div>
			<div id="t6" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t7">
		<div class="card">
			<div class="card-header">
			Umwelt / Natur
			</div>
			<div id="t7" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t8">
		<div class="card">
			<div class="card-header">
			Sicherheit
			</div>
			<div id="t8" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t9">
		<div class="card">
			<div class="card-header">
			Tourismus
			</div>
			<div id="t9" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
		<a class="card-link" data-toggle="collapse" href="#t10">
		<div class="card">
			<div class="card-header">
			Verkehr
			</div>
			<div id="t10" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t11">
		<div class="card">
			<div class="card-header">
			Ver- / Entsorgung
			</div>
			<div id="t11" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>
	<a class="card-link" data-toggle="collapse" href="#t12">
		<div class="card">
			<div class="card-header">
			Wirtschaft
			</div>
			<div id="t12" class="collapse " data-parent="#accordion">
			<div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
			</div>
		</div>
	</a>

  </div>
</div>

		</section>
		
		<section id="version">		
			<div>
				<? include('footer.php'); ?>
			<div>
		</section>
  </body>
</html>