<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<LINK href="../techniczne/style.css" type=text/css rel=stylesheet>
<style type=text/css>
<!--
.klub {font-family:arial,verdana; font-size:11px};
//-->
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
function sezon(s) {
var adres = s.options[s.selectedIndex].value;
window.location.href = adres;
}
-->
</SCRIPT>
</HEAD>
<body bgcolor=#eeeeee>
<?
require("polacz.htm");

function usun($klub, $tabela = "kluby") {
   $query = "delete from $tabela where id=\"$klub\"";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=kluby.php>Powrót...</a>";
   }
}

function edytuj($klub, $tabela = "kluby", $nazwa, $logo, $rozgrywki, $rozgrywki2, $info, $hala, $www, $www_sklad, $zal, $webl, $sukcesy) {
   if(!$klub) {
      print "<center><font class=tyt_admin>Kluby</font></center><br>";
      $pobierz = mysql_query("select*from kluby order by nazwa");
      print "<table border=0>";
      print "<tr><td></td><td class=tekst width=150><b>Nazwa</td><td class=tekst width=150><b>Rozgrywki</td><td class=tekst><b>Akcja</td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         $logo = mysql_fetch_array(mysql_query("select*from zdjecia where id='$rekord[logo]'"));
         print "<tr><td><img src=../$logo[adres] width=30></td><td class=tekst><a href=\"?poddzial=10&klub=$rekord[nazwa]\">$rekord[nazwa]</td><td class=tekst>$rekord[rozgrywki] $rekord[rozgrywki2]</td><td class=tekst><a href=\"kluby.php?klub=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"kluby.php?klub=$rekord[id]&akcja=delete\">Usuń</a></td></tr>";
      }
      print "</table>";
   } else {
   $rekord = mysql_fetch_array(mysql_query("select*from $tabela where id='$klub'"));
   print "<center><font class=tyt_admin>$rekord[nazwa]</font></center><br>";
   print "<form action=\"kluby.php?akcja=edit_now\" method=post>";
   print "<table border=0>";
   print "<input type=hidden name=klub value=\"$rekord[nazwa]\">";
   print "<tr><td class=tekst>Nazwa</td><td class=tekst><input type=text name=nazwa value=\"$rekord[nazwa]\"></td></tr>\n";
   print "<tr><td class=tekst>Hala</td><td class=tekst><input type=text name=hala value=\"$rekord[hala]\"></td></tr>\n";
   print "<tr><td class=tekst>WWW (z http://)</td><td class=tekst><input type=text name=www value=\"$rekord[www]\"></td></tr>\n";
   print "<tr><td class=tekst>Link do składu (z http://)</td><td class=tekst><input type=text name=www_sklad value=\"$rekord[www_sklad]\"></td></tr>\n";
   print "<tr><td class=tekst>Rok założenia</td><td class=tekst><input type=text name=zal value=\"$rekord[zal]\"></td></tr>\n";
   print "<tr><td class=tekst>W EBL od...</td><td class=tekst><input type=text name=webl value=\"$rekord[webl]\"></td></tr>\n";
   print "<tr><td class=tekst>Osiągnięcia</td><td class=tekst><textarea cols=30 rows=10 name=sukcesy>$rekord[sukcesy]</textarea></td></tr>";

   $pobierz_logo = mysql_query("select*from zdjecia where rodzaj='logo' order by nazwa");
   echo "<tr><td class=tekst>Logo</td><td>";
   echo "<select name=logo>";
   while ($rekord2 = mysql_fetch_array($pobierz_logo)) {
      if($rekord2[id] == $rekord[logo]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option name=logo value=\"$rekord2[id]\"$to>$rekord2[nazwa]</option>";
   }
   echo "</select>";
   echo "</td></tr>";

   $pobierz_rozg = mysql_query("select*from rozgrywki order by sezon desc,rozgrywki");
   echo "<tr><td class=tekst>Rozgrywki</td><td>";
   echo "<select name=rozgrywki>";
   while ($rekord2 = mysql_fetch_array($pobierz_rozg)) {
      if($rekord2[id] == $rekord[rozgrywki]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option name=rozgrywki value=\"$rekord2[id]\"$to>$rekord2[rozgrywki] - $rekord2[sezon]</option>";
   }
   echo "</select>";
   echo "</td></tr>";

   $pobierz_rozg2 = mysql_query("select*from rozgrywki order by sezon desc,rozgrywki");
   echo "<tr><td class=tekst>Rozgrywki 2</td><td>";
   echo "<select name=rozgrywki2>";
   echo "<option name=rozgrywki2 value=\"\">Brak</option>";
   while ($rekord3 = mysql_fetch_array($pobierz_rozg2)) {
      if($rekord3[id] == $rekord[rozgrywki2]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option name=rozgrywki2 value=\"$rekord3[id]\"$to>$rekord3[rozgrywki] - $rekord3[sezon]</option>";
   }
   echo "</select>";
   echo "</td></tr>";
   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($klub, $tabela = "kluby", $nazwa, $logo, $rozgrywki, $rozgrywki2, $info, $hala, $www, $www_sklad, $zal, $webl, $sukcesy) {
   $query = "update $tabela set nazwa=\"$nazwa\", logo='$logo', rozgrywki='$rozgrywki', rozgrywki2='$rozgrywki2', info='$info', hala='$hala', www='$www', www_sklad='$www_sklad', zal='$zal', webl='$webl', sukcesy='$sukcesy' where nazwa='$klub'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=kluby.php>Powrót...</a>";
   }
}

function wyswietl() {
   print "<font class=kto>Kluby</font>";
   $pobierz = mysql_query("select*from kluby");
   print "<table border=0>";
   print "<tr><td></td><td class=tekst width=150><b>Nazwa</td><td class=tekst width=150><b>Rozgrywki</td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
   $logo = mysql_fetch_array(mysql_query("select*from zdjecia where id='$rekord[logo]'"));
      print "<tr><td><img src=../$logo[adres] width=30></td><td class=tekst><a href=\"../index.php?poddzial=10&klub=$rekord[nazwa]\">$rekord[nazwa]</td><td class=tekst>$rekord[rozgrywki], $rekord[rozgrywki2]</td></tr>";
   }
   print "</table>";
}

function dopisz($czy, $akcja, $nazwa, $logo, $rozgrywki, $rozgrywki2, $info, $hala, $www, $www_sklad, $zal, $webl, $sukcesy) {
   if($czy!="tak") {
      echo "<form action=kluby.php method=post>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      print "<center><font class=tyt_admin>Dodaj klub</font></center><br>";
      print "<table border=0>";
      print "<input type=hidden name=klub value=\"$rekord[nazwa]\">";
      print "<tr><td class=tekst>Nazwa</td><td class=tekst><input type=text name=nazwa></td></tr>\n";
      print "<tr><td class=tekst>Hala</td><td class=tekst><input type=text name=hala></td></tr>\n";
      print "<tr><td class=tekst>WWW (z http://)</td><td class=tekst><input type=text name=www></td></tr>\n";
      print "<tr><td class=tekst>Link do składu (z http://)</td><td class=tekst><input type=text name=www_sklad></td></tr>\n";
      print "<tr><td class=tekst>Rok założenia</td><td class=tekst><input type=text name=zal></td></tr>\n";
      print "<tr><td class=tekst>W EBL od...</td><td class=tekst><input type=text name=webl></td></tr>\n";
      print "<tr><td class=tekst>Osiągnięcia</td><td class=tekst><textarea cols=30 rows=10 name=sukcesy></textarea></td></tr>";

      $pobierz_logo = mysql_query("select*from zdjecia where rodzaj='logo' order by nazwa");
      echo "<tr><td class=tekst>Logo</td><td>";
      echo "<select name=logo>";
      while ($rekord2 = mysql_fetch_array($pobierz_logo)) {
         echo "<option name=logo value=$rekord2[id]>$rekord2[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_rozg = mysql_query("select*from rozgrywki order by sezon desc,rozgrywki");
      echo "<tr><td class=tekst>Rozgrywki</td><td>";
      echo "<select name=rozgrywki>";
      while ($rekord2 = mysql_fetch_array($pobierz_rozg)) {
         echo "<option name=rozgrywki value=$rekord2[id]>$rekord2[rozgrywki] - $rekord2[sezon]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_rozg2 = mysql_query("select*from rozgrywki order by sezon desc,rozgrywki");
      echo "<tr><td class=tekst>Rozgrywki 2</td><td>";
      echo "<select name=rozgrywki2>";
      echo "<option name=rozgrywki2 value=\"\">Brak</option>";
      while ($rekord3 = mysql_fetch_array($pobierz_rozg2)) {
         echo "<option name=rozgrywki2>$rekord3[rozgrywki] - $rekord3[sezon]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      print "<tr><td class=tekst><input type=submit value=Dodaj>\n";
      print "</table>\n";
      echo "</form>";
   } else {
      $info = stripslashes($info);
      $historia = stripslashes($historia);
      $nowy = "insert into kluby (nazwa, logo, rozgrywki, rozgrywki2, info, hala, www, www_sklad, zal, webl, sukcesy) values ('$nazwa', '$logo', '$rozgrywki', '$rozgrywki2', '$info', '$hala', '$www', '$www_sklad', '$zal', '$webl', '$sukcesy')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowy klub.<br><a href=kluby.php>Powrót</a>";
      } else {
         echo "<br>Nie udało się dodać klubu.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $nazwa, $logo, $rozgrywki, $rozgrywki2, $info, $hala, $www, $www_sklad, $zal, $webl, $sukcesy);
   break;
   case "delete":
   usun($klub);
   break;
   case "edit":
   edytuj($klub, $tabela = "kluby", $nazwa, $logo, $rozgrywki, $rozgrywki2, $info, $hala, $www, $www_sklad, $zal, $webl, $sukcesy);
   break;
   case "edit_now":
   edycja($klub, "kluby", $nazwa, $logo, $rozgrywki, $rozgrywki2, $info, $hala, $www, $www_sklad, $zal, $webl, $sukcesy);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
