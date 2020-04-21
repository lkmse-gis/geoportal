
<!DOCTYPE html>
<html lang="de">
  <head>
	<? include('head.php'); ?>
  </head>
  <body>
	<header >

		<?php include('navbar.php'); ?>
		
		
<style class="cp-pen-styles">
body {
  color: #3a404d;
  background: #f8f9fb;
}

.site-content {
  overflow: hidden;
  
}

.py-4 {
  padding-top: 4rem;
  padding-bottom: 4rem;
}

.mb-6 {
  margin-bottom: 6rem;
}

.form-control {
  box-shadow: none;
  padding: 13px 10px;
  height: 50px;
  background: #FFF;
  color: #3a404d;
  border-radius: 5px;
  border-color: #DFE2E8;
}
.form-control:focus, .form-control.input-focus {
  box-shadow: none !important;
  border-color: #006085;
}

.card {
  background: #FFF;
  box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.15);
  border-radius: 5px;
  overflow: hidden;
}
.card__content {
  padding: 15px;
  font-size: 14px;
  line-height: 22px;
}
.card__content p:last-child {
  margin-bottom: 0;
}
.card__title {
  font-weight: 500;
  font-size: 16px;
  line-height: 24px;
}
.card__title a {
  color: #3a404d;
  text-decoration: none;
}
.card__title a:hover, .card__title a:focus {
  color: #006085;
  text-decoration: none;
}

.glossary__nav__item.active a {
  color: #FFF;
  background-color: #006085;
}
.glossary__nav__item a {
  width: 50px;
  font-size: 16px;
  color: #3a404d;
  text-decoration: none;
  text-align: center;
  display: block;
}
.glossary__nav__item a:hover, .glossary__nav__item a:focus {
  color: #FFF;
  background-color: darkgrey;
}
.glossary__nav__item a.card__content {
  padding: 13px 10px;
  margin-bottom: 5px;
  border-radius: 3px;
}
.glossary__search__form {
  max-width: 500px;
  position: relative;
}
.glossary__search__form:before {
  content: "\f002";
  color: #aaa;
  font-family: "FontAwesome";
  position: absolute;
  left: 15px;
  top: 12px;
  font-size: 18px;
}
.glossary__search__form .form-control {
  padding-left: 40px;
}
.glossary__results__row {
  overflow: hidden;
  margin-bottom: 40px;
  transition: all 0.4s ease-in-out;
}
.glossary__results__row:last-child {
  margin-bottom: 0;
}
.glossary__results__row.inactive {
  opacity: 0;
  height: 0;
  margin: 0;
  width: 100%;
}
.glossary__results__term {
  color: #006085
}
.glossary__results__item {
  margin-bottom: 20px;
}
.glossary__results__item a {
  display: block;
  text-decoration: none;
  color: #3a404d;
}
.glossary__results__item a.card {
  border: 2px solid transparent;
}
.glossary__results__item a:hover {
  border-color: #006085;
}
.glossary__results__item a:hover .card__title {
  color: #006085;
}

.title-style--three {
  margin-bottom: 15px;
  position: relative;
  padding-top: 20px;
  padding-bottom: 10px;
}
.title-style--three:after {
  content: "";
  background: #75b726;
  width: 60px;
  height: 3px;
  position: absolute;
  left: 0;
  bottom: 0;
  border-radius: 30px;
}
</style>		
		
	</header>
	

	<div class="kopf"></div>  

<section>
<main class="site-content" id="main">
    <div class="container py-4">
        <nav class="glossary__nav mb-4">
            <ul class="list-inline">
                <li class="glossary__nav__item active">
                    <a class="card card__content" data-nav="#" data-toggle="glossary" href="#">#</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="A" data-toggle="glossary" href="#">A</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="B" data-toggle="glossary" href="#">B</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="C" data-toggle="glossary" href="#">C</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="D" data-toggle="glossary" href="#">D</a>
                </li>
				<li class="glossary__nav__item">
                    <a class="card card__content" data-nav="E" data-toggle="glossary" href="#">D</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="F" data-toggle="glossary" href="#">F</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="G" data-toggle="glossary" href="#">G</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="H" data-toggle="glossary" href="#">H</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="I" data-toggle="glossary" href="#">I</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="J" data-toggle="glossary" href="#">J</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="K" data-toggle="glossary" href="#">K</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="L" data-toggle="glossary" href="#">L</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="M" data-toggle="glossary" href="#">M</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="N" data-toggle="glossary" href="#">N</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="O" data-toggle="glossary" href="#">O</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="P" data-toggle="glossary" href="#">P</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="Q" data-toggle="glossary" href="#">Q</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="R" data-toggle="glossary" href="#">R</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="S" data-toggle="glossary" href="#">S</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="T" data-toggle="glossary" href="#">T</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="U" data-toggle="glossary" href="#">U</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="V" data-toggle="glossary" href="#">V</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="W" data-toggle="glossary" href="#">W</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="X" data-toggle="glossary" href="#">X</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="Y" data-toggle="glossary" href="#">Y</a>
                </li>
                <li class="glossary__nav__item">
                    <a class="card card__content" data-nav="Z" data-toggle="glossary" href="#">Z</a>
                </li>
            </ul>
        </nav>
        <!--END Glossary Nav-->

        <div class="glossary__search mb-4">
            <form action="#" class="glossary__search__form">
                <input class="form-control" id="glossarySearchInput" placeholder="Search Keywords" type="search">
            </form>
        </div>
        <!--END Glossary Search-->

        <div class="glossary__results mb-6">
            <div class="glossary__results__row" data-term="#">
                <h3 class="glossary__results__term title-style--three mb-3">#</h3>
                <div class="row">
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="3G">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">3G</h4>
                        <p class="mb-0"><img src="bilder/qrcode.jpg" style="float:left;width:100px">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="4G">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">4G</h4>
                        <p class="mb-0"><img src="bilder/qrcode.jpg" style="float:left;width:100px">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                </div>
            </div>
            <!--END Glossary Results Row-->

            <div class="glossary__results__row" data-term="A">
                <h3 class="glossary__results__term title-style--three mb-3">A</h3>
                <div class="row">
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Application Cycle Management">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Application Cycle Management</h4>
                        <p class="mb-0"><img src="bilder/qrcode.jpg" style="float:left;width:100px">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="API">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">API</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="AVR">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">AVR</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="ARP">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">ARP</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                </div>
            </div>
            <!--END Glossary Results Row-->

            <div class="glossary__results__row" data-term="B">
                <h3 class="glossary__results__term title-style--three mb-3">B</h3>
                <div class="row">
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Bandwidth">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Bandwidth</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Back Office">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Back Office</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Bluetooth">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Bluetooth</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Backbone Network">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Backbone Network</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                </div>
            </div>
            <!--END Glossary Results Row-->

            <div class="glossary__results__row" data-term="C">
                <h3 class="glossary__results__term title-style--three mb-3">C</h3>
                <div class="row">
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Cable">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Cable</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Citizen">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Citizen</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Coat">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Coat</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Cynagenmod">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Cynagenmod</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                </div>
            </div>
            <!--END Glossary Results Row-->

            <div class="glossary__results__row" data-term="D">
                <h3 class="glossary__results__term title-style--three mb-3">D</h3>
                <div class="row">
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Data">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Data</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Delta">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Delta</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Dragon">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Dragon</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                    <div class="glossary__results__item col-md-3 col-sm-6" data-item="Dynasty">
                        <a class="card card__content" href="#">
                        <h4 class="card__title">Dynasty</h4>
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste vel, magnam incidunt obcaecati.</p></a>
                    </div>
                    <!--END Glossary Result item-->
                </div>
            </div>
            <!--END Glossary Results Row-->
        </div>
        <!--END Glossary Results-->
    </div>
</main>
<!-- END Main content -->

<script>$(function(){
	initGlossaryFilter();
});

// Filter Glossary items
function initGlossaryFilter(){
		// Filter using search box
    $("#glossarySearchInput").bind("keyup", function(){
        var inputValue = $(this).val();

        // Hide all the results & Cards
        $(".glossary__results__row").addClass("inactive");
        $(".glossary__results__item").hide();

        $(".glossary__results__row").each(function(){
            $(".glossary__results__item").each(function(){
                var item = $(this).attr("data-item");

                if(item.toUpperCase().indexOf(inputValue.toUpperCase()) != -1){
                    $(this).parents(".glossary__results__row").removeClass("inactive");
                    $(this).show();
                }
            });
        });
    });
	
		// Filter using navigation
    $(".glossary__nav a").click(function(){
        var nav = $(this).attr("data-nav");

        // Remove & Add active class
        $(".glossary__nav__item").removeClass("active");
        $(this).parent().toggleClass("active");

        // Hide all the results
        $(".glossary__results__row").addClass("inactive");

        // Loop through the row
        $(".glossary__results__row").each(function(){
            var term = $(this).attr("data-term");

            if(nav == term){
                $(this).removeClass("inactive");
            }
        });

        // Only return false if data-toggle is glossary
        if($(this).attr("data-toggle") == "glossary"){
            return false;
        }
    });
}
//# sourceURL=pen.js
</script>

		

		</section>
			<section id="version">		
				<div>
					<? include('footer.php'); ?>
				<div>
			</section>
  </body>
</html>