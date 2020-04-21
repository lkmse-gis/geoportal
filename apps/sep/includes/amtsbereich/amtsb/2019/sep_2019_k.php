<?
		$stichtag='2019-09-06';
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
		$schuelerzahlen_2019_k=$r;
		
		//Schülerzahlen nach Jahrgangsstufen holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'jahrgangsstufe'
				and ebene = '$reg_nr'
				order by gruppierung desc";
		$result = $dbqueryp($connectp,$query);
		$a_2019=0;
		while($r = $fetcharrayp($result))
			{
				$schuelerjgst_2019_k[$a_2019]=$r;
				$a_2019++;
				$count=$a_2019;	
			}
			
		//Schülerzahlen nach generalisierten Schularten holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'schularten_generalisiert'
				and ebene = '$reg_nr'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$b_2019=0;
		while($r = $fetcharrayp($result))
			{
				$schularten_2019_k[$b_2019]=$r;
				$b_2019++;
				$count=$b_2019;	
			}
		
		//Schülerzahlen nach Schularten holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'schulart'
				and ebene = '$reg_nr'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$c_2019=0;
		while($r = $fetcharrayp($result))
			{
				$schulart_2019_k[$c_2019]=$r;
				$c_2019++;
				$count=$c_2019;	
			}
		
		//Schülerzahlen nach Bildungsgang holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'bildungsgang'
				and ebene = '$reg_nr'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$d_2019=0;
		while($r = $fetcharrayp($result))
			{
				$bildungsgang_2019_k[$d_2019]=$r;
				$d_2019++;
				$count=$d_2019;	
			}			
		
?>