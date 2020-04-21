<?php 

	require_once 'include/config.inc';

?>	

		<nav class="navbar navbar-default navbar-static" role="navigation" >

  			<div class="container" >

            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse" >
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $pfad; ?>index.php"><img src="<?php echo $pfad; ?>bilder/Logo.png" width="245px" style="margin-top:-20px;"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse" >
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a class="page-scroll" href="#startseite"></a>
                    </li>
					<li>
					<a href="<?php echo $pfad; ?>index.php" data-toggle="tooltip" data-placement="bottom" title=""><em class="glyphicon glyphicon-home"></em></a>
					</li>
					<!--<li>
                        <a href="geoportal/information.php" data-toggle="tooltip" data-placement="bottom" title="informieren Sie sich"><em class="fa fa-comments-o"></em> Information</a>
                    </li>-->
					<li>
                       <a href="<?php echo $pfad; ?>wo_finde_ich_was.php" data-toggle="tooltip" data-placement="bottom" title=""><!--<em class="fa fa-map-signs"></em>-->| Wo finde ich was?</a>
                    </li>
					<li>
                        <a href="<?php echo $pfad; ?>dienste.php" data-toggle="tooltip" data-placement="bottom" title=""><!--<em class="fa fa-user-circle"></em>-->| Dienste</a>
                    </li>
					<li>
                        <a href="<?php echo $pfad; ?>themenuebersicht.php" data-toggle="tooltip" data-placement="bottom" title=""><!--<em class="glyphicon glyphicon-menu-hamburger"></em>-->| Themenübersicht</a>
                    </li>
                    <li>
                        <a href="<?php echo $pfad; ?>geoportale.php" data-toggle="tooltip" data-placement="bottom" title="" ><!--<em class="glyphicon glyphicon-globe"></em>-->| Geoportale</a>
                    </li>
					<li>
                        <a href="#version" data-toggle="tooltip" data-placement="bottom" title=""><!--<em class="glyphicon glyphicon-info-sign"></em>-->| Über</a>
                    </li>
                </ul>
				 <ul class="nav navbar-nav navbar-right">
					<li><a href="javascript:increaseFontSize14();" style="font-size:12px">A</a></li>
					<li><a href="javascript:increaseFontSize16();" style="font-size:18px">A</a></li>
                    <!--<li><a href="#search"><span style="font-size: 15px;" class="glyphicon glyphicon-search"></span></a></li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->       
				
		
		</nav>
		