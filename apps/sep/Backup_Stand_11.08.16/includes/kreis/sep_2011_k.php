<?
		$stichtag='2011-09-09';
		
		//Schülerzahlen holen
		$query="Select gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'summe_schuelerzahlen'
				order by gruppierung desc";
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$schuelerzahlen_2011_k=$r;
		
		//Schülerzahlen nach Jahrgangsstufen holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'jahrgangsstufe'
				order by gruppierung desc";
		$result = $dbqueryp($connectp,$query);
		$a_2011=0;
		while($r = $fetcharrayp($result))
			{
				$schuelerjgst_2011_k[$a_2011]=$r;
				$a_2011++;
				$count=$a_2011;	
			}
			
		//Schülerzahlen nach generalisierten Schularten holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'schularten_generalisiert'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$b_2011=0;
		while($r = $fetcharrayp($result))
			{
				$schularten_2011_k[$b_2011]=$r;
				$b_2011++;
				$count=$b_2011;	
			}
		
		//Schülerzahlen nach Schularten holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'schulart'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$c_2011=0;
		while($r = $fetcharrayp($result))
			{
				$schulart_2011_k[$c_2011]=$r;
				$c_2011++;
				$count=$c_2011;	
			}
		
		//Schülerzahlen nach Bildungsgang holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'bildungsgang'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$d_2011=0;
		while($r = $fetcharrayp($result))
			{
				$bildungsgang_2011_k[$d_2011]=$r;
				$d_2011++;
				$count=$d_2011;	
			}			
		
?>