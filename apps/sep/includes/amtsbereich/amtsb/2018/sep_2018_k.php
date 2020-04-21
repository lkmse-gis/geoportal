<?
		$stichtag='2018-09-14';
		$reg_nr=$_GET["reg_nr"];
		
		//Schülerzahlen holen
		$query="Select gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'summe_schuelerzahlen'
				and ebene = '$reg_nr'
				order by gruppierung desc";
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$schuelerzahlen_2018_k=$r;
		
		//Schülerzahlen nach Jahrgangsstufen holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'jahrgangsstufe'
				and ebene = '$reg_nr'
				order by gruppierung desc";
		$result = $dbqueryp($connectp,$query);
		$a_2018=0;
		while($r = $fetcharrayp($result))
			{
				$schuelerjgst_2018_k[$a_2018]=$r;
				$a_2018++;
				$count=$a_2018;	
			}
			
		//Schülerzahlen nach generalisierten Schularten holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'schularten_generalisiert'
				and ebene = '$reg_nr'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$b_2018=0;
		while($r = $fetcharrayp($result))
			{
				$schularten_2018_k[$b_2018]=$r;
				$b_2018++;
				$count=$b_2018;	
			}
		
		//Schülerzahlen nach Schularten holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'schulart'
				and ebene = '$reg_nr'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$c_2018=0;
		while($r = $fetcharrayp($result))
			{
				$schulart_2018_k[$c_2018]=$r;
				$c_2018++;
				$count=$c_2018;	
			}
		
		//Schülerzahlen nach Bildungsgang holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'bildungsgang'
				and ebene = '$reg_nr'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$d_2018=0;
		while($r = $fetcharrayp($result))
			{
				$bildungsgang_2018_k[$d_2018]=$r;
				$d_2018++;
				$count=$d_2018;	
			}			
		
?>