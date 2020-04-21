<?php
	

	$speicher = unserialize(rawurldecode($_GET['speicher']));
	$aktuelleseite = $_SERVER['PHP_SELF'];
	$speicher[] = array( 'Auskunft' => $aktuelleseite);

	foreach ($speicher as $key => $value) {


	 foreach ($value as $key1 => $value1) {

		$titel[$key] = $key1;
		$url[$key] = $value1;
		
		
	 }
   }

   	$serialized = rawurlencode(serialize($speicher));


?>

<!DOCTYPE html>
<html lang="en">
  <head>	
	
	<? include('head.php'); ?>
  
  </head>
  <body>		
  	<header >

		<?php include('navbar.php'); ?>
		
	</header>
	
	
	<div class="kopf"></div>
	<div>
	<ul id="breadcrumbs-one">
	<li><a href="#" class="current"><? echo $titel[0] ?> </a></li>
	</ul>
	</div>
	

	
	
	
	<section>
	
		<div class="">
			<div class="col-md-3">				
				<div class="list-group">
					<a class="list-group-item active"><p><em class="fa fa-graduation-cap"></em> 10 Zentrale Dienste und Schulverwaltungsamt</p></a>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> ...</a>
					</div>
				</div>
				<div class="list-group">
					<a class="list-group-item active"><p><em class="fa fa-group"></em> 11 Personalamt</p></a>
					<div class="list-group-item">
						<a href="javascript:ajaxpage('geoportal_2/kontakt.php', 'content')"><em class="glyphicon glyphicon-arrow-right"></em> ...</a>
					</div>
				</div>
				<div class="list-group">
					<a class="list-group-item active"><p><em class="fa fa-balance-scale"></em> 14 Rechnungsprüfungsamt</p></a>
					<div class="list-group-item">
						<a href="javascript:ajaxpage('geoportal_2/kontakt.php', 'content')"><em class="glyphicon glyphicon-arrow-right"></em> ...</a>
					</div>
				</div>
				<div class="list-group">
					<a class="list-group-item active"><p><em class="fa fa-money"></em> 20 Amt für Finanzen</p></a>
					<div class="list-group-item">
						<a href="javascript:ajaxpage('geoportal_2/kontakt.php', 'content')"><em class="glyphicon glyphicon-arrow-right"></em> ...</a>
					</div>
				</div>
			</div>
			<div class="col-md-3">				
				<div class="list-group">
					<a class="list-group-item active"><p><em class="fa fa-building-o"></em> 60 Bauamt</p></a>
					<div class="list-group-item">
						<a href="adressen.php"><em class="glyphicon glyphicon-arrow-right"></em> Bauaufsicht</a>
					</div>
					<div class="list-group-item">
						<a href="adressen.php"><em class="glyphicon glyphicon-arrow-right"></em> Baudenkmalpflege</a>
					</div>
				</div>
				<div class="list-group">
					<a class="list-group-item active"><p><em class="glyphicon glyphicon-screenshot"></em> 61 Katasteramt</p></a>
					<div class="list-group-item">
						<a href="javascript:ajaxpage('geoportal_2/kontakt.php', 'content')"><em class="glyphicon glyphicon-arrow-right"></em> Vermessungsstellen</a>
					</div>
				</div>
				<div class="list-group">
					<a class="list-group-item active"><p><em class="glyphicon glyphicon-tree-deciduous"></em> 66 Umweltamt</p></a>
					<div class="list-group-item">
						<a href="javascript:ajaxpage('geoportal_2/kontakt.php', 'content')"><em class="glyphicon glyphicon-arrow-right"></em> Abflusslose Sammelgruben</a>
					</div>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Alleen</a>
					</div>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Altlasten</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Artenschutz</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Bauvorhaben</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Biotope</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Brunnen/Erdwärme</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Cross Compliance</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Gehölzschutz</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Gewässeraufsicht</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Immissionsschutz</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Klärschlamm</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Kleinkläranlagen</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Kommunale Kläranlagen</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Landschaftsschutzgebiete</a>
					</div>	
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Natura 2000 Gebiete</a>
					</div>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Naturdenkmale</a>
					</div>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Naturschutzgebiete</a>
					</div>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Ökokonto</a>
					</div>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Trinkwasserschutzzonen</a>
					</div>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Untere Abfallbehörde</a>
					</div>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Untere Bodenschutzbehörde</a>
					</div>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Übertragung Abwasserbeseitigung</a>
					</div>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> wassergefährdende Stoffe</a>
					</div>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Widerspruch Leitungsrecht</a>
					</div>
				</div>
			</div>
			<div class="col-md-3">			
				<div class="list-group">
					<a class="list-group-item active"><p><em class="fa fa-handshake-o"></em> 50 Sozialamt</p></a>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> Pflegestützpunkte</a>
					</div>
				</div>
				<div class="list-group">
					<a class="list-group-item active"><p><em class="fa fa-universal-access"></em> 51 Jugendamtamt</p></a>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> ...</a>
					</div>
				</div>
				<div class="list-group">
					<a class="list-group-item active"><p><em class="fa fa-medkit"></em> 55 Gesundheitsamt</p></a>
					<div class="list-group-item">
						<a href="apotheken.php?<? $speicher[] = array( 'Gesundheit' => 'gesundheit.php'); $serialized = rawurlencode(serialize($speicher)); ?>speicher=<? echo $serialized; ?>&ebene=1"> <em class="glyphicon glyphicon-arrow-right"> </em> Apotheken</a>
					</div>
				</div>
			</div>			
			<div class="col-md-3">				
				<div class="list-group">
					<a class="list-group-item active"><p><em class="fa fa-cubes"></em> 32 Ordnungsamt</p></a>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> ...</a>
					</div>
				</div>
				<div class="list-group">
					<a class="list-group-item active"><p><em class="fa fa-paw"></em> 39 Veterinäramt und Lebensmittelüberwachung</p></a>
					<div class="list-group-item">
						<a href="#"><em class="glyphicon glyphicon-arrow-right"></em> ...</a>
					</div>
				</div>							
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