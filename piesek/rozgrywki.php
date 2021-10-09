<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<style type=text/css>
<!--
.klub {font-family:arial,verdana; font-size:11px};
//-->
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
function rozgrywki(s) {
var adres = s.options[s.selectedIndex].value;
window.location.href = adres;
}
-->
</SCRIPT>
</HEAD>
<?
require("polacz.htm");

function usun($rozgrywki, $tabela = "rozgrywki") {
   $query = "delete from $tabela where id='$rozgrywki'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=rozgrywki.php>Powrót...</a>";
   }
}

function edytuj($rozgrywki, $tabela = "rozgrywki", $rozgrywki, $kolejka, $sezon) {
   if(!$rozgrywki) {
      $pobierz = mysql_query("select*from rozgrywki");
      print "<table border=0>";
      print "<tr><td><b>ID</td><td><b>Rozgrywki</td><td><b>Kolejka</td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         echo "<tr><td>$rekord[id]</td><td>$rekord[rozgrywki]</td><td>$rekord[kolejka]</td><td><a href=\"rozgrywki.php?&rozgrywki=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"rozgrywki.php?&rozgrywki=$rekord[id]&akcja=delete\">Usuń</a></td></tr>";
      }
      print "</table>";
   } else {
   $wynik = mysql_query("select*from $tabela where id='$rozgrywki'");
   print "<form action=\"rozgrywki.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=rozgrywki2 value=\"$rekord[id]\">";
   print "<tr><td class=tekst>Rozgrywki</td><td class=tekst><input type=text name=rozgrywki value=\"$rekord[rozgrywki]\"></td></tr>\n";
   print "<tr><td class=tekst>Sezon</td><td class=tekst><input type=text name=sezon value=\"$rekord[sezon]\"></td></tr>\n";
   $pobierz_kol = mysql_query("select*from kolejki");
   echo "<tr><td class=tekst>Aktualna kolejka</td><td>";
   echo "<select name=kolejka>";
   while ($rekord2 = mysql_fetch_array($pobierz_kol)) {
      if($rekord2[id]==$rekord[kolejka]) {
         $to = " selected";
      } else {
          $to = "";
      }
      $rozg = mysql_fetch_array(mysql_query("select rozgrywki from rozgrywki where id='$rekord2[rozgrywki]'"));
      echo "<option value=\"$rekord2[id]\"$to>$rekord2[numer] - $rozg[rozgrywki] ($rekord2[dzien1]-$rekord2[dzien2].$rekord2[miesiac].$rekord2[rok] r.)</option>";
   }
   echo "</select>";
   echo "</td></tr>";
   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($rozgrywki, $tabela = "rozgrywki", $rozgrywki, $rozgrywki2, $kolejka, $sezon) {
   $wynik = mysql_query("update $tabela set rozgrywki='$rozgrywki', kolejka='$kolejka', sezon='$sezon' where id='$rozgrywki2'");
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=rozgrywki.php>Powrót...</a>";
   }
}

function wyswietl() {
   $pobierz = mysql_query("select*from rozgrywki");
   print "<table border=0>";
   print "<tr><td><b>ID</td><td><b>Rozgrywki</td><td><b>Kolejka</td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
      echo "<tr><td>$rekord[id]</td><td>$rekord[rozgrywki]</td><td>$rekord[kolejka]</td></tr>";
   }
   print "</table>";
}

function dopisz($czy, $akcja, $rozgrywki, $kolejka, $sezon) {
   if($czy!="tak") {
      echo "<form action=rozgrywki.php>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<tr><td class=tekst>Rozgrywki</td><td class=tekst><input type=text name=rozgrywki></td></tr>";
      echo "<tr><td class=tekst>Sezon</td><td class=tekst><input type=text name=sezon></td></tr>";
      $pobierz_kol = mysql_query("select*from kolejki");
      echo "<tr><td class=tekst>Aktualna kolejka</td><td>";
      echo "<select name=kolejka>";
      while ($rekord2 = mysql_fetch_array($pobierz_kol)) {
         $rozg = mysql_fetch_array(mysql_query("select rozgrywki from rozgrywki where id='$rekord2[rozgrywki]'"));
         echo "<option value=\"$rekord2[id]\"$to>$rekord2[numer] - $rozg[rozgrywki] ($rekord2[dzien1]-$rekord2[dzien2].$rekord2[miesiac].$rekord2[rok] r.)</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $nowy = "insert into rozgrywki (rozgrywki, kolejka, sezon) values ('$rozgrywki', '$kolejka', '$sezon')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowy rozgrywki.<br><a href=rozgrywki.php>Powrót</a>";
      } else {
         echo "Nie udało się dodać rozgrywki.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $rozgrywki, $kolejka, $sezon);
   break;
   case "delete":
   usun($rozgrywki);
   break;
   case "edit":
   edytuj($rozgrywki, $tabela = "rozgrywki", $rozgrywki, $kolejka, $sezon);
   break;
   case "edit_now":
   edycja($rozgrywki, "rozgrywki", $rozgrywki, $rozgrywki2, $kolejka, $sezon);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
