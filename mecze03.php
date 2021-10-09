<SCRIPT LANGUAGE="JavaScript">
<!--
function sezon(s) {
var adres = s.options[s.selectedIndex].value;
window.location.href = adres;
}
-->
</SCRIPT>
<?
include("polacz.htm");

function wyswietl($mecz) {
   $spotkanie = mysql_query("select*from mecze where id='$mecz'");
   while ($rekord = mysql_fetch_array($spotkanie)) {
      $wez_roz = mysql_fetch_array(mysql_query("select rozgrywki from rozgrywki where id='$rekord[rozgrywki]'"));
      if($rekord[rozgrywki] == "1") {
         $kluby = "10";
      } else {
         $kluby = "16";
      }
      print "<table border=0>";
      print "<tr><td width=400><font class=wynik>$wez_roz[rozgrywki], $rekord[kolejka] kolejka</font></td><td align=right class=male width=150><b><i>$rekord[data]</td></tr>";
      print "</table>";
      print "<center><table border=0 valign=bottom>";
      $logo1 = mysql_fetch_array(mysql_query("select adres,nazwa from zdjecia where id='$rekord[d1_logo]'"));
      $logo2 = mysql_fetch_array(mysql_query("select adres,nazwa from zdjecia where id='$rekord[d2_logo]'"));
      print "<tr><td height=85 align=center><img src=http://grafika.slask.e-basket.pl/$logo1[adres] alt=\"$logo1[nazwa]\" border=1></td><td width=150><center><font class=wynik>$rekord[d1_wynik]:$rekord[d2_wynik]</font><br><font class=kwarta>$rekord[kwarty]</font></td><td align=center><img src=http://grafika.slask.e-basket.pl/$logo2[adres] alt=\"$logo2[nazwa]\" border=1></td></tr>";
      print "<tr><td class=tekst align=center width=200><a href=\"?poddzial=$kluby&klub=$rekord[druzyna1]\" class=klub><center>$rekord[druzyna1]</center></td><td></td><td class=tekst align=center width=200><a href=\"?poddzial=$kluby&klub=$rekord[druzyna2]\" class=klub><center>$rekord[druzyna2]</center></td></tr>";
      print "</table>";
      if(($rekord[d1_kosze] != "") || ($rekord[d2_kosze] != "")) {
      print "<hr noshade>";
      print "<table border=0>";
      print "<tr><td bgcolor=#eeeeee class=kwarta><b>$rekord[druzyna1]:</b> $rekord[d1_kosze]</td></tr>";
      print "<tr><td bgcolor=#eeeeee class=kwarta><b>$rekord[druzyna2]:</b> $rekord[d2_kosze]</td></tr>";
      print "</table>";
      }
      print "</center>";
      if($rekord[zobacz_tez] != "") {
         print "<font class=tekst>$rekord[zobacz_tez]</font>";
      }
      print "<hr noshade>";
      print "<table border=0 cellspacing=0 cellpadding=0><tr><td class=tekst>";
      if($rekord[gracz_meczu] != "") {
         $graczmeczu = mysql_fetch_array(mysql_query("select imie,nazwisko,zdjecie from zawodnicy where id='$rekord[gracz_meczu]'"));
         $zdjecie = mysql_fetch_array(mysql_query("select adres,nazwa from zdjecia where id='$graczmeczu[zdjecie]'"));
         print "<table border=1 cellspacing=0 cellpadding=0 align=right>";
         print "<tr><td class=male bgcolor=#eeeeee width=70 align=center><b>Zawodnik meczu ze ¦l±ska:</td></tr>";
         print "<tr><td width=70 align=center bgcolor=#eeeeee><a href=\"?poddzial=1&zawodnik=$rekord[gracz_meczu]\"><img border=0 src=http://grafika.slask.e-basket.pl/$zdjecie[adres] width=70></a>";
         print "<br><font class=male><b>$graczmeczu[imie] $graczmeczu[nazwisko]</b><br>$rekord[gracz_meczu_czemu]</td></tr>";
         print "</table>";
      }
      print "$rekord[opis]";
      print "</td></tr></table>";

      $zdjecia = mysql_query("select*from galeria where mecz='$mecz' order by id");

      if(mysql_num_rows($zdjecia)!=0) {
         print "<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td height=15 class=tekst valign=middle width=520 bgcolor=#eeeeee align=center><a name=galeria></a><center><b>Galeria zdjêæ</b></center></td></tr></table>";
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
   }
}
if($mecz) {
   wyswietl($mecz, "mecze");
} else {
   glowna();
}
?>
</BODY>
</HTML>
