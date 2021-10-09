<?
$zdjecia = mysql_query("select*from galeria where galeria='$galeria' order by id");
$nazwa_gal = mysql_fetch_array(mysql_query("select nazwa from galeria_kat where id='$galeria'"));

print "<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td height=15 class=kwarta valign=middle width=520 bgcolor=#dfdfdf align=right><b>[ Galeria zdjêæ ]</b>&nbsp;</td></tr></table>";

if(mysql_num_rows($zdjecia)!=0) {
   print "<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td height=15 class=tekst valign=middle width=520 bgcolor=#eeeeee align=center><a name=galeria></a><center><b>$nazwa_gal[nazwa]</b></center></td></tr></table>";
   print "<table border=0 cellspacing=3 cellpadding=3>";
   $count = 1;

   while ($rekord = mysql_fetch_array($zdjecia)) {
      $link = "<a class=galeria href=javascript:duze('$rekord[id]')><img width=80 height=130 src=http://grafika.slask.e-basket.pl/$rekord[adres_male] border=0 alt='$rekord[opis]'></a>";
      if($count == "5"){$count = 1;}

      if($count == 1) {
         print("<tr><td width=130>$link</td>");
      } else if($count == 2) {
         print("<td width=130>$link</td>");
      } else if($count == 3) {
         print("<td width=130>$link</td>");
      } else if($count == 4) {
         print("<td width=130>$link</td></tr>");
      }
         $count++;
   }
      print "</table>";
}
?>
