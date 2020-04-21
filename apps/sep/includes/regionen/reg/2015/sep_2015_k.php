<?
		$stichtag='2015-09-30';
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
		$schuelerzahlen_2015_k=$r;
		
		//Schülerzahlen nach Jahrgangsstufen holen
		$query="Select gruppierung,anzahl,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'jahrgangsstufe'
				and ebene = '$reg_nr'
				AND anzahl IS NOT NULL
				order by gruppierung desc";
		$result = $dbqueryp($connectp,$query);
		$a_2015=0;
		while($r = $fetcharrayp($result))
			{
				$schuelerjgst_2015_k[$a_2015]=$r;
				$a_2015++;
				$count=$a_2015;	
			}
			
		//Schülerzahlen nach generalisierten Schularten holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'schularten_generalisiert'
				and ebene = '$reg_nr'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$b_2015=0;
		while($r = $fetcharrayp($result))
			{
				$schularten_2015_k[$b_2015]=$r;
				$b_2015++;
				$count=$b_2015;	
			}
		
		//Schülerzahlen nach Schularten holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'schulart'
				and ebene = '$reg_nr'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$c_2015=0;
		while($r = $fetcharrayp($result))
			{
				$schulart_2015_k[$c_2015]=$r;
				$c_2015++;
				$count=$c_2015;	
			}
		
		//Schülerzahlen nach Bildungsgang holen
		$query="Select gruppierung,gesamt,fristgemaess,vorzeitig,verspaetet,aussiedler,asylbewerber,fluechtlinge,maedchen,fristgemaess_w,vorzeitig_w,verspaetet_w,aussiedler_w,asylbewerber_w,fluechtlinge_w,jungen,fristgemaess_m,vorzeitig_m,verspaetet_m,aussiedler_m,asylbewerber_m,fluechtlinge_m
				from education.schulen_gruppierungstabelle
				where stichtag = '$stichtag'
				and art = 'bildungsgang'
				and ebene = '$reg_nr'
				order by gruppierung";
		$result = $dbqueryp($connectp,$query);
		$d_2015=0;
		while($r = $fetcharrayp($result))
			{
				$bildungsgang_2015_k[$d_2015]=$r;
				$d_2015++;
				$count=$d_2015;	
			}

		
?>