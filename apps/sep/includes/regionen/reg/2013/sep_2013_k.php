<?
		$stichtag='2013-09-10';
		$reg_nr=$_GET["reg_nr"];
		
		//Schülerzahlen holen
		$query="Select anzahl,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'summe_schuelerzahlen'
				and ebene = '$reg_nr'
				AND anzahl IS NOT NULL
				order by gruppierung desc";
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$schuelerzahlen_2013_k=$r;
		
		//Schülerzahlen nach Jahrgangsstufen holen
		$query="Select gruppierung,anzahl,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'jahrgangsstufe'
				and ebene = '$reg_nr'
				AND anzahl IS NOT NULL
				order by gruppierung desc";
		$result = $dbqueryp($connectp,$query);
		$a_2013=0;
		while($r = $fetcharrayp($result))
			{
				$schuelerjgst_2013_k[$a_2013]=$r;
				$a_2013++;
				$count=$a_2013;	
			}
			
		//Schülerzahlen nach generalisierten Schularten holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'schularten_generalisiert'
				and ebene = '$reg_nr'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$b_2013=0;
		while($r = $fetcharrayp($result))
			{
				$schularten_2013_k[$b_2013]=$r;
				$b_2013++;
				$count=$b_2013;	
			}
		
		//Schülerzahlen nach Schularten holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'schulart'
				and ebene = '$reg_nr'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$c_2013=0;
		while($r = $fetcharrayp($result))
			{
				$schulart_2013_k[$c_2013]=$r;
				$c_2013++;
				$count=$c_2013;	
			}
		
		//Schülerzahlen nach Bildungsgang holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'bildungsgang'
				and ebene = '$reg_nr'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$d_2013=0;
		while($r = $fetcharrayp($result))
			{
				$bildungsgang_2013_k[$d_2013]=$r;
				$d_2013++;
				$count=$d_2013;	
			}			
		
?>