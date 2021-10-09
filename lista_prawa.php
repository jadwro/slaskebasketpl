<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
<TR><TD ALIGN="CENTER">
<IMG SRC="http://grafika.slask.e-basket.pl/grafika/lista.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>
<TABLE WIDTH="200" HEIGHT="150" CELLSPACING="0" CELLPADDING="0" BORDER="1" BORDERCOLOR="#dddddd" RULES="NONE" STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
<TR><TD VALIGN="TOP" WIDTH="200">
<?
if(!$ciastko_kom_ilosc) {
   $ciastko_kom_ilosc = 30;
}
if(!$ciastko_kom_kolornicka) {
   $ciastko_kom_kolornicka = "#000000";
}
if((!$ciastko_kom_wyswietl) || ($ciastko_kom_wyswietl=="")) {
   $wysw = "wszystko";
} elseif($ciastko_kom_wyswietl=="kom") {
   $wysw = "tylko komentarze";
} elseif($ciastko_kom_wyswietl=="lista") {
   $wysw = "tylko wpisy z listy";
}
$kolor = mysql_fetch_array(mysql_query("select nazwa from kom_kolory where kod='$ciastko_kom_kolornicka'"));
print "<font class=tekst_gl>";
print "Ilo¶æ wy¶wietlanych wpisów: <b>$ciastko_kom_ilosc</b>";
print "<br>Kolor nicka: <font color=$ciastko_kom_kolornicka><b>$kolor[nazwa]</b></font>";
print "<br>Wy¶wietlanie: <b>$wysw</b>";
print "<br><a class=kwarta href=?poddzial=35&akcja=ustawienia><font color=#999999>[ Zmieñ ustawienia ]</font></a>";
print "<br><br>";
$wpisy = mysql_query("select id from komentarze");
print "Na li¶cie jest<b> ".mysql_num_rows($wpisy)."</b> wpisów.";
$uzytk = mysql_query("select id from kom_rejestracja");
print "<br>Dotychczas zarejestrowa³o siê<b> ".mysql_num_rows($uzytk)." </b>u¿ytkowników.";
print "<form action=\"index.php?poddzial=35&akcja=find\" method=post>";
print "<b>Wyszukaj wpisy:</b>";
print "<br>Autor: <input type=text name=autor class=lista>";
print "<br>S³owa kluczowe: <input type=text name=tresc class=lista>";
print "<br>Od numeru <input class=lista type=text name=nr1 size=2> do <input type=text name=nr2 size=2 class=lista>";
print "<br><input class=lista type=submit value=Szukaj>";
print "</form>";
print "</font>";
?>
</TR></TD>
</TABLE>
</TD></TR>
<TR><TD>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
<TR><TD ALIGN="CENTER">
<IMG SRC="http://grafika.slask.e-basket.pl/grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>
