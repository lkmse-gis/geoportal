<?
		//Schuldaten holen
		$query="SELECT distinct a.bezeichnung, a.schul_id, a.plz, a.ortsteil, a.strasse_haus_nr, a.tel, a.fax, a.mail as email, a.schulleiter, a.schultraeger FROM $schema.$tabelle as a where a.stichtag = '2013-09-10' AND a.schul_id = '$schul_id'";
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$schul_id_2013 = $r[schul_id];
		$bezeichnung_2013 = $r[bezeichnung];
		$schulname_2013 = $r[bezeichnung]."&nbsp;".$r[ortsteil];
		$anschrift_2013 = $r[strasse_haus_nr]."<br>".$r[plz]."&nbsp;".$r[ortsteil];
		$schulleiter_2013 = $r[schulleiter];
		$tel_2013 = $r[tel];
		$fax_2013 = $r[fax];
		$mail_2013 = $r[email];
		
		//Schülerzahlen holen
		$query="Select count(*) as gesamt, d.fristgemaess, f.vorzeitig, e.verspaetet, m.aussiedler, n.asylbewerber, o.fluechtlinge, b.maedchen, g.fristgemaess_w, i.vorzeitig_w, h.verspaetet_w, p.aussiedler_w, q.asylbewerber_w, r.fluechtlinge_w, c.jungen, j.fristgemaess_m, l.vorzeitig_m, k.verspaetet_m, s.aussiedler_m, t.asylbewerber_m, u.fluechtlinge_m
			from education.schulentwicklungsplanung as a
			LEFT JOIN (
					select stichtag, count(gid) as fristgemaess FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'fristgemäß eingeschult'
					group by stichtag
					ORDER BY stichtag desc) as d on a.stichtag = d.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as verspaetet FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'verspätet eingeschult'
					group by stichtag
					ORDER BY stichtag desc) as e on a.stichtag = e.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as vorzeitig FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'vorzeitig eingeschult'
					group by stichtag
					ORDER BY stichtag desc) as f on a.stichtag = f.stichtag
                        LEFT JOIN (
					select stichtag, count(gid) as aussiedler FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Aussiedler'
					group by stichtag
					ORDER BY stichtag desc) as m on a.stichtag = m.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as asylbewerber FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Asylbewerber'
					group by stichtag
					ORDER BY stichtag desc) as n on a.stichtag = n.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as fluechtlinge FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Flüchtlinge'
					group by stichtag
					ORDER BY stichtag desc) as o on a.stichtag = o.stichtag
			LEFT JOIN (
					Select stichtag, count(*) as maedchen  
					from education.schulentwicklungsplanung
					WHERE stichtag = '2013-09-10'	
					and schul_id = '$schul_id'
					and schueler_geschlecht = 'weiblich'	
					GROUP BY stichtag 
					order by stichtag desc) as b on a.stichtag = b.stichtag
            LEFT JOIN (
					select stichtag, count(gid) as fristgemaess_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'fristgemäß eingeschult'
					and schueler_geschlecht = 'weiblich'
					group by stichtag
					ORDER BY stichtag desc) as g on a.stichtag = g.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as verspaetet_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'verspätet eingeschult'
					and schueler_geschlecht = 'weiblich'
					group by stichtag
					ORDER BY stichtag desc) as h on a.stichtag = h.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as vorzeitig_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'vorzeitig eingeschult'
					and schueler_geschlecht = 'weiblich'
					group by stichtag
					ORDER BY stichtag desc) as i on a.stichtag = i.stichtag
            LEFT JOIN (
					select stichtag, count(gid) as aussiedler_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Aussiedler'
					and schueler_geschlecht = 'weiblich'
					group by stichtag
					ORDER BY stichtag desc) as p on a.stichtag = p.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as asylbewerber_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Asylbewerber'
					and schueler_geschlecht = 'weiblich'
					group by stichtag
					ORDER BY stichtag desc) as q on a.stichtag = q.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as fluechtlinge_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Flüchtlinge'
					and schueler_geschlecht = 'weiblich'
					group by stichtag
					ORDER BY stichtag desc) as r on a.stichtag = r.stichtag
			LEFT JOIN (
					Select stichtag, count(*) as jungen  
					from education.schulentwicklungsplanung
					WHERE stichtag = '2013-09-10'	
					and schul_id = '$schul_id'
					and schueler_geschlecht = 'männlich'	
					GROUP BY stichtag 
					order by stichtag desc) as c on a.stichtag = c.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as fristgemaess_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'fristgemäß eingeschult'
					and schueler_geschlecht = 'männlich'
					group by stichtag
					ORDER BY stichtag desc) as j on a.stichtag = j.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as verspaetet_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'verspätet eingeschult'
					and schueler_geschlecht = 'männlich'
					group by stichtag
					ORDER BY stichtag desc) as k on a.stichtag = k.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as vorzeitig_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'vorzeitig eingeschult'
					and schueler_geschlecht = 'männlich'
					group by stichtag
					ORDER BY stichtag desc) as l on a.stichtag = l.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as aussiedler_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Aussiedler'
					and schueler_geschlecht = 'männlich'
					group by stichtag
					ORDER BY stichtag desc) as s on a.stichtag = s.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as asylbewerber_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Asylbewerber'
					and schueler_geschlecht = 'männlich'
					group by stichtag
					ORDER BY stichtag desc) as t on a.stichtag = t.stichtag
			LEFT JOIN (
					select stichtag, count(gid) as fluechtlinge_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Flüchtlinge'
					and schueler_geschlecht = 'männlich'
					group by stichtag
					ORDER BY stichtag desc) as u on a.stichtag = u.stichtag		
			WHERE a.stichtag = '2013-09-10'	
			and a.schul_id = '$schul_id'
			GROUP BY a.stichtag, a.schul_id, b.maedchen, c.jungen, d.fristgemaess, f.vorzeitig, e.verspaetet, g.fristgemaess_w, i.vorzeitig_w, h.verspaetet_w, j.fristgemaess_m, l.vorzeitig_m, k.verspaetet_m, m.aussiedler, n.asylbewerber, o.fluechtlinge, p.aussiedler_w, q.asylbewerber_w, r.fluechtlinge_w, s.aussiedler_m, t.asylbewerber_m, u.fluechtlinge_m
			order by a.stichtag desc";
		$result = $dbqueryp($connectp,$query);
		$r = $fetcharrayp($result);
		$schuelerzahlen_2013=$r;
		
		//Schülerzahlen nach Klassenstufen holen
		$query="Select a.schueler_klasse, count(*) as gesamt, d.fristgemaess, f.vorzeitig, e.verspaetet, m.aussiedler, n.asylbewerber, o.fluechtlinge, b.maedchen, g.fristgemaess_w, i.vorzeitig_w, h.verspaetet_w, p.aussiedler_w, q.asylbewerber_w, r.fluechtlinge_w, c.jungen, j.fristgemaess_m, l.vorzeitig_m, k.verspaetet_m, s.aussiedler_m, t.asylbewerber_m, u.fluechtlinge_m
			from education.schulentwicklungsplanung as a
			LEFT JOIN (
					select schueler_klasse, count(gid) as fristgemaess FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'fristgemäß eingeschult'
					group by schueler_art_einschulung, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_art_einschulung) as d on a.schueler_klasse = d.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as verspaetet FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'verspätet eingeschult'
					group by schueler_art_einschulung, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_art_einschulung) as e on a.schueler_klasse = e.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as vorzeitig FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'vorzeitig eingeschult'
					group by schueler_art_einschulung, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_art_einschulung) as f on a.schueler_klasse = f.schueler_klasse
            LEFT JOIN (
					select schueler_klasse, count(gid) as aussiedler FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Aussiedler'
					group by schueler_migrantenstatus, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_migrantenstatus) as m on a.schueler_klasse = m.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as asylbewerber FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Asylbewerber'
					group by schueler_migrantenstatus, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_migrantenstatus) as n on a.schueler_klasse = n.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as fluechtlinge FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Flüchtlinge'
					group by schueler_migrantenstatus, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_migrantenstatus) as o on a.schueler_klasse = o.schueler_klasse
			LEFT JOIN (
					Select schueler_klasse, count(*) as maedchen  
					from education.schulentwicklungsplanung
					WHERE stichtag = '2013-09-10'	
					and schul_id = '$schul_id'
					and schueler_geschlecht = 'weiblich'	
					GROUP BY schueler_klasse, schul_id, stichtag 
					order by schueler_klasse desc) as b on a.schueler_klasse = b.schueler_klasse
            LEFT JOIN (
					select schueler_klasse, count(gid) as fristgemaess_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'fristgemäß eingeschult'
					and schueler_geschlecht = 'weiblich'
					group by schueler_art_einschulung, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_art_einschulung) as g on a.schueler_klasse = g.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as verspaetet_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'verspätet eingeschult'
					and schueler_geschlecht = 'weiblich'
					group by schueler_art_einschulung, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_art_einschulung) as h on a.schueler_klasse = h.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as vorzeitig_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'vorzeitig eingeschult'
					and schueler_geschlecht = 'weiblich'
					group by schueler_art_einschulung, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_art_einschulung) as i on a.schueler_klasse = i.schueler_klasse
            LEFT JOIN (
					select schueler_klasse, count(gid) as aussiedler_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Aussiedler'
					and schueler_geschlecht = 'weiblich'
					group by schueler_migrantenstatus, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_migrantenstatus) as p on a.schueler_klasse = p.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as asylbewerber_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Asylbewerber'
					and schueler_geschlecht = 'weiblich'
					group by schueler_migrantenstatus, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_migrantenstatus) as q on a.schueler_klasse = q.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as fluechtlinge_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Flüchtlinge'
					and schueler_geschlecht = 'weiblich'
					group by schueler_migrantenstatus, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_migrantenstatus) as r on a.schueler_klasse = r.schueler_klasse
			LEFT JOIN (
					Select schueler_klasse, count(*) as jungen  
					from education.schulentwicklungsplanung
					WHERE stichtag = '2013-09-10'	
					and schul_id = '$schul_id'
					and schueler_geschlecht = 'männlich'	
					GROUP BY schueler_klasse, schul_id, stichtag 
					order by schueler_klasse desc) as c on a.schueler_klasse = c.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as fristgemaess_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'fristgemäß eingeschult'
					and schueler_geschlecht = 'männlich'
					group by schueler_art_einschulung, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_art_einschulung) as j on a.schueler_klasse = j.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as verspaetet_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'verspätet eingeschult'
					and schueler_geschlecht = 'männlich'
					group by schueler_art_einschulung, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_art_einschulung) as k on a.schueler_klasse = k.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as vorzeitig_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'vorzeitig eingeschult'
					and schueler_geschlecht = 'männlich'
					group by schueler_art_einschulung, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_art_einschulung) as l on a.schueler_klasse = l.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as aussiedler_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Aussiedler'
					and schueler_geschlecht = 'männlich'
					group by schueler_migrantenstatus, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_migrantenstatus) as s on a.schueler_klasse = s.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as asylbewerber_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Asylbewerber'
					and schueler_geschlecht = 'männlich'
					group by schueler_migrantenstatus, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_migrantenstatus) as t on a.schueler_klasse = t.schueler_klasse
			LEFT JOIN (
					select schueler_klasse, count(gid) as fluechtlinge_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Flüchtlinge'
					and schueler_geschlecht = 'männlich'
					group by schueler_migrantenstatus, schueler_klasse
					ORDER BY schueler_klasse desc, schueler_migrantenstatus) as u on a.schueler_klasse = u.schueler_klasse		
			WHERE stichtag = '2013-09-10'	
			and schul_id = '$schul_id'
			GROUP BY a.schueler_klasse, a.schul_id, b.maedchen, c.jungen, a.stichtag, d.fristgemaess, f.vorzeitig, e.verspaetet, g.fristgemaess_w, i.vorzeitig_w, h.verspaetet_w, j.fristgemaess_m, l.vorzeitig_m, k.verspaetet_m, m.aussiedler, n.asylbewerber, o.fluechtlinge, p.aussiedler_w, q.asylbewerber_w, r.fluechtlinge_w, s.aussiedler_m, t.asylbewerber_m, u.fluechtlinge_m
			order by a.schueler_klasse desc";
		$result = $dbqueryp($connectp,$query);
		$x_2013=0;
		while($r = $fetcharrayp($result))
			{
				$schuelerklassen_2013[$x_2013]=$r;
				$x_2013++;
				$count=$x_2013;	
			}
			
		//Schülerzahlen nach Jahrgangsstufen holen
		$query="Select a.schueler_jgst, count(*) as gesamt, d.fristgemaess, f.vorzeitig, e.verspaetet, m.aussiedler, n.asylbewerber, o.fluechtlinge, b.maedchen, g.fristgemaess_w, i.vorzeitig_w, h.verspaetet_w, p.aussiedler_w, q.asylbewerber_w, r.fluechtlinge_w, c.jungen, j.fristgemaess_m, l.vorzeitig_m, k.verspaetet_m, s.aussiedler_m, t.asylbewerber_m, u.fluechtlinge_m
			from education.schulentwicklungsplanung as a
			LEFT JOIN (
					select schueler_jgst, count(gid) as fristgemaess FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'fristgemäß eingeschult'
					group by schueler_art_einschulung, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_art_einschulung) as d on a.schueler_jgst = d.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as verspaetet FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'verspätet eingeschult'
					group by schueler_art_einschulung, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_art_einschulung) as e on a.schueler_jgst = e.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as vorzeitig FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'vorzeitig eingeschult'
					group by schueler_art_einschulung, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_art_einschulung) as f on a.schueler_jgst = f.schueler_jgst
            LEFT JOIN (
					select schueler_jgst, count(gid) as aussiedler FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Aussiedler'
					group by schueler_migrantenstatus, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_migrantenstatus) as m on a.schueler_jgst = m.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as asylbewerber FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Asylbewerber'
					group by schueler_migrantenstatus, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_migrantenstatus) as n on a.schueler_jgst = n.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as fluechtlinge FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Flüchtlinge'
					group by schueler_migrantenstatus, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_migrantenstatus) as o on a.schueler_jgst = o.schueler_jgst
			LEFT JOIN (
					Select schueler_jgst, count(*) as maedchen  
					from education.schulentwicklungsplanung
					WHERE stichtag = '2013-09-10'	
					and schul_id = '$schul_id'
					and schueler_geschlecht = 'weiblich'	
					GROUP BY schueler_jgst, schul_id, stichtag 
					order by schueler_jgst desc) as b on a.schueler_jgst = b.schueler_jgst
            LEFT JOIN (
					select schueler_jgst, count(gid) as fristgemaess_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'fristgemäß eingeschult'
					and schueler_geschlecht = 'weiblich'
					group by schueler_art_einschulung, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_art_einschulung) as g on a.schueler_jgst = g.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as verspaetet_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'verspätet eingeschult'
					and schueler_geschlecht = 'weiblich'
					group by schueler_art_einschulung, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_art_einschulung) as h on a.schueler_jgst = h.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as vorzeitig_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'vorzeitig eingeschult'
					and schueler_geschlecht = 'weiblich'
					group by schueler_art_einschulung, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_art_einschulung) as i on a.schueler_jgst = i.schueler_jgst
            LEFT JOIN (
					select schueler_jgst, count(gid) as aussiedler_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Aussiedler'
					and schueler_geschlecht = 'weiblich'
					group by schueler_migrantenstatus, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_migrantenstatus) as p on a.schueler_jgst = p.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as asylbewerber_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Asylbewerber'
					and schueler_geschlecht = 'weiblich'
					group by schueler_migrantenstatus, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_migrantenstatus) as q on a.schueler_jgst = q.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as fluechtlinge_w FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Flüchtlinge'
					and schueler_geschlecht = 'weiblich'
					group by schueler_migrantenstatus, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_migrantenstatus) as r on a.schueler_jgst = r.schueler_jgst
			LEFT JOIN (
					Select schueler_jgst, count(*) as jungen  
					from education.schulentwicklungsplanung
					WHERE stichtag = '2013-09-10'	
					and schul_id = '$schul_id'
					and schueler_geschlecht = 'männlich'	
					GROUP BY schueler_jgst, schul_id, stichtag 
					order by schueler_jgst desc) as c on a.schueler_jgst = c.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as fristgemaess_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'fristgemäß eingeschult'
					and schueler_geschlecht = 'männlich'
					group by schueler_art_einschulung, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_art_einschulung) as j on a.schueler_jgst = j.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as verspaetet_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'verspätet eingeschult'
					and schueler_geschlecht = 'männlich'
					group by schueler_art_einschulung, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_art_einschulung) as k on a.schueler_jgst = k.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as vorzeitig_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_art_einschulung = 'vorzeitig eingeschult'
					and schueler_geschlecht = 'männlich'
					group by schueler_art_einschulung, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_art_einschulung) as l on a.schueler_jgst = l.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as aussiedler_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Aussiedler'
					and schueler_geschlecht = 'männlich'
					group by schueler_migrantenstatus, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_migrantenstatus) as s on a.schueler_jgst = s.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as asylbewerber_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Asylbewerber'
					and schueler_geschlecht = 'männlich'
					group by schueler_migrantenstatus, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_migrantenstatus) as t on a.schueler_jgst = t.schueler_jgst
			LEFT JOIN (
					select schueler_jgst, count(gid) as fluechtlinge_m FRom education.schulentwicklungsplanung
					WHERE stichtag='2013-09-10'
					AND schul_id = '$schul_id'
					AND schueler_migrantenstatus = 'Flüchtlinge'
					and schueler_geschlecht = 'männlich'
					group by schueler_migrantenstatus, schueler_jgst
					ORDER BY schueler_jgst desc, schueler_migrantenstatus) as u on a.schueler_jgst = u.schueler_jgst		
			WHERE stichtag = '2013-09-10'	
			and schul_id = '$schul_id'
			GROUP BY a.schueler_jgst, a.schul_id, b.maedchen, c.jungen, a.stichtag, d.fristgemaess, f.vorzeitig, e.verspaetet, g.fristgemaess_w, i.vorzeitig_w, h.verspaetet_w, j.fristgemaess_m, l.vorzeitig_m, k.verspaetet_m, m.aussiedler, n.asylbewerber, o.fluechtlinge, p.aussiedler_w, q.asylbewerber_w, r.fluechtlinge_w, s.aussiedler_m, t.asylbewerber_m, u.fluechtlinge_m
			order by a.schueler_jgst desc";
		$result = $dbqueryp($connectp,$query);
		$d_2013=0;
		while($r = $fetcharrayp($result))
			{
				$schuelerjgst_2013[$d_2013]=$r;
				$d_2013++;
				$count=$d_2013;	
			}
?>