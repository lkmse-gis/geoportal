<?php
      	  
	  $user = $_GET['user'];  
	
		switch ($user)
			{
			 case 'andreas':
				header ('Location: mailto:andreas.thurm@lk-seenplatte.de');
				exit();
				break;
			 case 'norman':
				header ('Location: mailto:norman.schley@lk-seenplatte.de');
				exit();
				break;
			 case 'geoportal':
				header ('Location: mailto:geoportal@lk-seenplatte.de');				
				exit();
				break;
			}
	  	
		 /* Inhalt der Datei „email_handler.php“ 
            header ('Location: mailto:andreas.thurm@lk-seenplatte.de?
						subject=GeoportalAnfrage&cc=norman.schley@lk-seenplatte.de&bcc=geoportal@lk-seenplatte.de');
            exit();*/
?>
