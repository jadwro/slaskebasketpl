<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
</HEAD>
<BODY>
<?
include("polacz.php");
?>
<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td height=15 class=kwarta valign=middle width=520 bgcolor=#dfdfdf align=right><b>[ SLASK.e-basket.pl ] - Pytanie do...</b>&nbsp;</td></tr></table>
<?
if(!$pytanie) {
   $pobierz = mysql_fetch_array(mysql_query("select*from zawodnicy where id='$zawodnik'"));
   $zdjecie = mysql_fetch_array(mysql_query("select adres from zdjecia where id='$pobierz[zdjecie]'"));
   print "<br><font class=duze><center>$pobierz[imie] $pobierz[nazwisko]</center></font>";
   print "<form action=index.php?poddzial=44 method=post>";
   print "<table border=0 cellspacing=0 cellpadding=0>";
      print "<tr><td width=370><table border=0>";
      print "<input type=hidden name=zawodnik value='$zawodnik'>";
      print "<tr><td class=tekst>Nick</td><td><input type=text name=nick class=szukaj2></td></tr>";
      print "<tr><td class=tekst>E-mail</td><td><input type=text name=email class=szukaj2></td></tr>";
      print "<tr><td class=tekst>Twoje pytanie</td><td><textarea rows=9 cols=40 name=pytanie class=szukaj2></textarea></td></tr>";
      print "<tr><td><input class=szukaj2 type=submit value='Zadaj pytanie'>";
      print "</table></td>";
   print "<td><img border=1 src=$zdjecie[adres] alt='$pobierz[imie] $pobierz[nazwisko]'></td></tr>";
   print "</table>";
   print "</form>";
   print "<img src=http://grafika.slask.e-basket.pl/grafika/strzalka.gif> <font class=male>Na pytania czekamy do 20 lutego 2005 roku. Na autorów najciekawszych pytań czekają zdjęcia z autografem zawodnika. Zapraszamy!";
   print "<br><hr size=1 color=#dfdfdf width=500 align=center>";
   print "<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td height=15 class=tekst valign=middle width=520 bgcolor=#eeeeee align=center><a name=galeria></a><center><b><a class=czarny href=?poddzial=1&zawodnik=$zawodnik&akcja=zdjecia>Galeria zdjęć...</a></b></center></td></tr></table>";
   print "<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td height=15 class=tekst valign=middle width=520 bgcolor=#eeeeee align=center><a name=galeria></a><center><b><a class=czarny href=?poddzial=1&zawodnik=$zawodnik&akcja=statystyki>Statystyki...</a></b></center></td></tr></table>";
   print "<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td height=15 class=tekst valign=middle width=520 bgcolor=#eeeeee align=center><a name=galeria></a><center><b><a class=czarny href=?poddzial=1&zawodnik=$zawodnik&akcja=newsy>Pisaliśmy o zawodniku...</b></center></td></tr></table>";
   print "<br><font class=tekst>$pobierz[charakterystyka]</font>";

   print "<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td height=15 class=tekst valign=middle width=520 bgcolor=#eeeeee align=center><a name=galeria></a><center><b><a class=czarny href=?poddzial=1&zawodnik=$zawodnik&akcja=zdjecia>Galeria zdjęć...</a></b></center></td></tr></table>";
   print "<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td height=15 class=tekst valign=middle width=520 bgcolor=#eeeeee align=center><a name=galeria></a><center><b><a class=czarny href=?poddzial=1&zawodnik=$zawodnik&akcja=statystyki>Statystyki...</a></b></center></td></tr></table>";
   print "<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td height=15 class=tekst valign=middle width=520 bgcolor=#eeeeee align=center><a name=galeria></a><center><b><a class=czarny href=?poddzial=1&zawodnik=$zawodnik&akcja=newsy>Pisaliśmy o zawodniku...</b></center></td></tr></table>";
} else {
   $pobierz = mysql_fetch_array(mysql_query("select*from zawodnicy where id='$zawodnik'"));
   $temat = "[SLASK.e-b.pl] Pytanie do: $pobierz[imie] $pobierz[nazwisko]";
   $ja = "slask@e-basket.pl";
   $mazur = "mazur@slask.e-basket.pl";
   $wiadomosc = "Nick pytajacego: $nick \n\n Podany e-mail: $email \n\n Pytanie: $pytanie \n\n\n SLASK.e-basket.pl";
   $wyslij1 = mail($ja, $temat, $wiadomosc, "From: $email");
   $wyslij2 = mail($mazur, $temat, $wiadomosc, "From: $email");
   if(($wyslij1) || ($wyslij2)) {
      print "<br><br><font class=tekst><center>Pytanie zostało wysłane.<br><a href=?poddzial=44&zawodnik=$zawodnik>Zadaj kolejne pytanie</a>";
   } else {
      print "Niestety nie udało się wysłać pytanie. Proszę się szybko skontaktować z administratorem - <a href=mailto:slask@e-basket.pl>slask@e-basket.pl</a>!";
   }
}
?>
</form>
</BODY>
</HTML>
