<?php
  class legende
   {
    private $legende_art;
	
    function tsn($sa)
	  {
	    $this->legende_art=$sa;
		
	    echo "
		 <table border=\"1\" rules=\"none\" width=140 valign=bottom align=right>					
			<tr>
			  <td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
			</tr>";
			if ($this->legende_art == 'all' OR $this->legende_art == 'AIV')
			  echo "
			     <tr>
			     <td width=100 align=right><small>Sperrgebiet (AIV): </td>
			     <td><img src=\"images/sperrgebiet_aiv.png\" width=30></td>
			     </tr>";
			if ($this->legende_art == 'all' OR $this->legende_art == 'AFB')
			  echo "	 
			       <tr>
			       <td width=100 align=right><small>Sperrgebiet (AFB): </td>
			       <td><img src=\"images/sperrgebiet_afb.png\"  width=30></td>
			       <tr>";
			if ($this->legende_art == 'all' OR $this->legende_art == 'AIV')
			  echo "	 
			       <tr>
			       <td width=100 align=right><small>Risikogebiet (AIV): </td>
			       <td><img src=\"images/risikogebiete.png\"  width=30></td>
			       <tr>";
			echo "	   
			       <td width=100 align=right><small>Beobachtungsgebiet: </td>
			       <td><img src=\"images/beobachtungsgebiet.png\"  width=30></td>
			       </tr>
			       </table>";
	  }
  function geotope_flaechen()
      {
       $html='<table border="1" rules="none" width="100%" valign=bottom align=right>					
			  <tr>
				<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
			  </tr>
			  <tr>
				<td align=right><small>Geotop (glaziale Bildung): </td>
				<td width=30 bgcolor=#ffec0b></td>
				<td align=right><small>Geotop (fluviale Bildung): </td>
				<td width=30 bgcolor=#ff0000></td>
			  </tr>
              <tr>
				<td align=right><small>Geotop (äolische Bildung): </td>
				<td width=30 bgcolor=#00ff00></td>
				<td align=right><small>Geotop (marine Bildung): </td>
				<td width=30 bgcolor=#0000ff></td>
			  </tr>			  
			 </table>';
        return $html;
      }

 function brw_bauland()
      {
       $html='<tr>
	          <td>
			  <table border="1" rules="none" width="100%" valign=bottom align=right>					
			  <tr>
				<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
			  </tr>
			  <tr>
				<td align=right><small>Bodenrichtwertzone: </td>
				<td width=50><img src="images/bauland.png" width=50></td>
				<td align=right><small>Sanierungsgebiet: </td>
				<td width=50><img src="images/sanierungsgebiet.png" width=50></td>
			  </tr>
              </table>
			  </td></tr>';
        return $html;
      }	  
function lsg()
      {
       $html=
	         '<tr>
			  <td valign=bottom align=right>
			  <table border="1" rules="none" width="100%" valign=bottom align=right>					
			  <tr>
				<td colspan=4 align=center height=25><i>Kartenlegende:</i></td>
			  </tr>
			  <tr>
				<td align=right><small>Landschaftsschutzgebiet: </td>
				<td width=30 bgcolor=#FF39B4></td>
				<td align=right><small>Entwicklungszone BR ELB: </td>
				<td width=30 bgcolor=#0078FF></td>
			  </tr>
              </table>
			  </td></tr>';
        return $html;
      }


	  
 }
?>