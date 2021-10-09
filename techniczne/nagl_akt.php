<?
print "<br><table border=0 cellspacing=0 cellpadding=1>";
if($rekord[rodzaj]!="") {
   print "<tr><td background=http://grafika.slask.e-basket.pl/grafika/kropkinews.jpg class=tytul_newsa width=515 colspan=2 height=20>&nbsp;<i>$rekord[rodzaj]:</i> $rekord[tytul]</td></tr>";
} else {
   print "<tr><td background=http://grafika.slask.e-basket.pl/grafika/kropkinews.jpg class=tytul_newsa width=515 colspan=2 height=20>&nbsp;$rekord[tytul]</td></tr>";
}
print "<tr><td class=data_newsa>$rekord[dzien] $rekord[miesiac] $rekord[rok] ($rekord[godzina]) - <b>$rekord[dzial]</b> - <a href=mailto:$rekord[email] class=autor_newsa>$rekord[kto]</a></font>";
if($rekord[edycja]!="") {
   print "<br><font class=edycja_newsa>(edycja: $rekord[edycja])</font>";
}
print "</td>";
print "<td align=right class=male valign=top><a href=?news=$rekord[id]#komentarze><font class=male>Komentarze($ile_kom)</font></a> | <a href=javascript:komentarze($rekord[id])><font class=male>Dodaj</font></a></td></tr>";
print "<tr><td width=500 class=tekst_gl colspan=2>";
if($rekord[zdjecie] != "") {
   $zdj = mysql_fetch_array(mysql_query("select adres,nazwa,szer,wys from zdjecia where id='$rekord[zdjecie]'"));
   if($zdj[wys] == 0) {
      $wys = "";
   } else {
      $wys = "height=$zdj[wys]";
   }
   print "<img src='http://grafika.slask.e-basket.pl/$zdj[adres]' alt='$zdj[nazwa]' width=$zdj[szer] $wys border=1 hspace=7 align=left>";
}
print "$wypisz";
if(($rekord[zrodlo] == "") || ($rekord[zrodlo] == " ")) {
   print "";
} else {
   print "<br><font class=male><font color=#999999>(¬ród³o:</font> $rekord[zrodlo]<font color=#999999>)</font></font>";
}
print "</td></tr>";
print "</table>";
?>
