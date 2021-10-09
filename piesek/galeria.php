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
function sezon(s) {
var adres = s.options[s.selectedIndex].value;
window.location.href = adres;
}
-->
</SCRIPT>
</HEAD>
<?
require("polacz.htm");

function usun($zdj, $tabela = "galeria") {
   $query = "delete from $tabela where id='$zdj'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=galeria.htm>Powrót...</a>";
   }
}

function edytuj($zdj, $tabela = "galeria", $mecz, $rozgrywki, $slowa, $opis, $zawodnik1, $zawodnik2, $klub, $autor, $adres, $adres_male, $top, $data, $galeria) {
   if(!$zdj) {
      $pobierz = mysql_query("select*from galeria order by mecz,id desc");
      echo "<table border=1>";
      echo "<tr><td></td><td></td><td></td><td><b>Mecz</b></td><td><b>Opis</b></td><td><b>Adres</b></td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         $mecz = mysql_query("select*from mecze where id='$rekord[mecz]'");
         $zmecz = mysql_fetch_array($mecz);
         if(mysql_num_rows($mecz) == 0) {
            $mecz = "$rekord[opis]";
         } else {
            $mecz = "$zmecz[druzyna1]-$zmecz[druzyna2]";
         }
         echo "<tr><td><a href=galeria.php?akcja=edit&zdj=$rekord[id]>edytuj</td><td><a href=galeria.php?akcja=delete&zdj=$rekord[id]>usuń</td><td>$mecz [$rekord[kliki]]</td><td>$rekord[opis]</td><td>$autor[adres]</td></tr>";
      }
      echo "</table>";
   } else {
      $query = "select*from $tabela where id='$zdj'";
      $wynik = mysql_query($query);
      print "<form action=galeria.php?akcja=edit_now method=post>";
      print "<table border=0>";
      $rekord = mysql_fetch_array($wynik);
      print "<input type=hidden name=zdj value=\"$rekord[id]\">";

      $pobierz_mecz = mysql_query("select*from mecze");
      echo "<tr><td class=tekst>Mecz </td><td>";
      echo "<select name=mecz>";
      echo "<option value=\"\">";
      while ($rekord2 = mysql_fetch_array($pobierz_mecz)) {
         if($rekord2[id] == $rekord[mecz]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option name=mecz value=\"$rekord2[id]\"$to>$rekord2[rozgrywki]: $rekord2[druzyna1]-$rekord2[druzyna2] $rekord2[d1_wynik]:$rekord2[d2_wynik]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_galeria = mysql_query("select*from galeria_kat order by rozgrywki");
      echo "<tr><td class=tekst>Galeria </td><td>";
      echo "<select name=galeria>";
      echo "<option value=\"\">";
      while ($rekord2 = mysql_fetch_array($pobierz_galeria)) {
         if($rekord2[id] == $rekord[galeria]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option value=\"$rekord2[id]\"$to>$rekord2[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_zawodnik1 = mysql_query("select id,imie,nazwisko from zawodnicy order by nazwisko");
      echo "<tr><td>Zawodnik</td><td>";
      echo "<select name=zawodnik1>";
      echo "<option value=\"\">";
      while ($rekord2 = mysql_fetch_array($pobierz_zawodnik1)) {
         if($rekord2[id] == $rekord[zawodnik1]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option value=\"$rekord2[id]\"$to>$rekord2[nazwisko] $rekord2[imie]</option>";
      }
      echo "</select></td></tr>";

      $pobierz_zawodnik2 = mysql_query("select id,imie,nazwisko from zawodnicy order by nazwisko");
      echo "<tr><td>Zawodnik 2</td><td>";
      echo "<select name=zawodnik2>";
      echo "<option value=\"\">Żaden";
      while ($rekord2 = mysql_fetch_array($pobierz_zawodnik2)) {
         if($rekord2[id] == $rekord[zawodnik2]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option value=\"$rekord2[id]\"$to>$rekord2[nazwisko] $rekord2[imie]</option>";
      }
      echo "</select></td></tr>";

      $pobierz_druzyna = mysql_query("select id,nazwa from kluby order by rozgrywki,nazwa");
      echo "<tr><td>Drużyna</td><td>";
      echo "<select name=klub>";
      echo "<option value=\"\">";
      while ($rekord2 = mysql_fetch_array($pobierz_druzyna)) {
         if($rekord2[id] == $rekord[klub]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option name=klub value=\"$rekord2[id]\"$to>$rekord2[nazwa]</option>";
      }
      echo "</select></td></tr>";

      if($rekord[rozgrywki] == "plk") {
         $plk = " selected";
      }
      if($rekord[rozgrywki] == "euroliga") {
         $euroliga = " selected";
      }
      if($rekord[rozgrywki] == "inne") {
         $inne = " selected";
      }
      echo "<tr><td class=tekst>Rozgrywki </td><td>";
      echo "<select name=rozgrywki>";
      echo "<option name=rozgrywki value=\"plk\"$plk>PLK</option>";
      echo "<option name=rozgrywki value=\"euroliga\"$euroliga>Euroliga</option>";
      echo "<option name=rozgrywki value=\"inne\"$inne>Inne</option>";
      echo "</select>";
      echo "</td></tr>";

      if($rekord[top] == "tak") { $tak = " checked"; } else { $tak=""; }
      if($rekord[top] == "nie") { $nie = " checked"; } else { $nie=""; }

      echo "<tr><td>TOP dnia</td><td><input type=radio name=top value=nie$nie>Nie <input type=radio name=top value=tak$tak>Tak</td></tr>";

      print "<tr><td>Autor:</td><td><input type=text name=autor value=\"$rekord[autor]\"></td></tr>";
      print "<tr><td>Słowa kluczowe:</td><td><input type=text name=slowa value=\"$rekord[slowa]\"></td></tr>";
      print "<tr><td>Opis:</td><td><input type=text name=opis value=\"$rekord[opis]\"></td></tr>";
      print "<tr><td>Adres:</td><td><input type=text name=adres value=\"$rekord[adres]\"></td></tr>";
      print "<tr><td>Adres miniaturki:</td><td><input type=text name=adres_male value=\"$rekord[adres_male]\"></td></tr>";

      print "<tr><td><input type=submit value=Zmień></td></tr>";
      print "</table>";
      print "</form>\n";
   }
}

function edycja($zdj, $tabela = "galeria", $mecz, $rozgrywki, $slowa, $opis, $zawodnik1, $zawodnik2, $klub, $autor, $adres, $adres_male, $top, $data, $galeria) {
   $data = date("d.m.Y",time());
   $query = "update $tabela set mecz='$mecz', rozgrywki='$rozgrywki', slowa='$slowa', opis='$opis', zawodnik1='$zawodnik1', zawodnik2='$zawodnik2', klub='$klub', autor='$autor', adres='$adres', adres_male='$adres_male', top='$top', data='$data', galeria='$galeria' where id='$zdj'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=id=aktualnosci.php>Powrót...</a>";
   }
}

function wyswietl() {
   $pobierz = mysql_query("select*from galeria order by mecz,id desc");
   echo "<table border=1>";
   echo "<tr><td></td><td><b>Mecz</b></td><td><b>Opis</b></td><td><b>Adres</b></td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
      $mecz = mysql_query("select*from mecze where id='$rekord[mecz]'");
      $zmecz = mysql_fetch_array($mecz);
      if(mysql_num_rows($mecz) == 0) {
         $mecz = "$rekord[opis]";
      } else {
         $mecz = "$zmecz[druzyna1]-$zmecz[druzyna2]";
      }
      echo "<tr><td><a href=../$rekord[adres]><img src=../$rekord[adres_male] alt='$rekord[opis]' width=70></a></td><td>$mecz [$rekord[kliki]]</td><td>$rekord[opis]</td><td>$autor[adres]</td></tr>";
   }
   echo "</table>";
}

function dopisz($czy, $akcja, $mecz, $rozgrywki, $slowa, $opis, $zawodnik1, $zawodnik2, $klub, $autor, $adres, $adres_male, $top, $data, $galeria) {
   if($czy!="tak") {
      echo "<form action=galeria.php method=post>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";

      $pobierz_mecz = mysql_query("select*from mecze where druzyna1='1' OR druzyna2='1' order by kolejka");
      echo "<tr><td class=tekst>Mecz </td><td>";
      echo "<select name=mecz>";
      echo "<option value=\"\">";
      while ($rekord2 = mysql_fetch_array($pobierz_mecz)) {
         $druzyna1 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord2[druzyna1]'"));
         $druzyna2 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord2[druzyna2]'"));
         echo "<option name=mecz value=\"$rekord2[id]\">$rekord2[dzien].$rekord2[miesiac].$rekord2[rok] r.: $druzyna1[nazwa]-$druzyna2[nazwa] $rekord2[d1_wynik]:$rekord2[d2_wynik]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_galeria = mysql_query("select*from galeria_kat order by rozgrywki");
      echo "<tr><td class=tekst>Galeria </td><td>";
      echo "<select name=galeria>";
      echo "<option value=\"\">";
      while ($rekord2 = mysql_fetch_array($pobierz_galeria)) {
         echo "<option value=\"$rekord2[id]\">$rekord2[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_zawodnik1 = mysql_query("select id,imie,nazwisko from zawodnicy order by nazwisko");
      echo "<tr><td>Zawodnik</td><td>";
      echo "<select name=zawodnik1>";
      echo "<option value=\"\">";
      while ($rekord2 = mysql_fetch_array($pobierz_zawodnik1)) {
         echo "<option value=\"$rekord2[id]\">$rekord2[nazwisko] $rekord2[imie]</option>";
      }
      echo "</select></td></tr>";

      $pobierz_zawodnik2 = mysql_query("select id,imie,nazwisko from zawodnicy order by nazwisko");
      echo "<tr><td>Zawodnik 2</td><td>";
      echo "<select name=zawodnik2>";
      echo "<option value=\"\">Żaden";
      while ($rekord2 = mysql_fetch_array($pobierz_zawodnik2)) {
         echo "<option value=\"$rekord2[id]\">$rekord2[nazwisko] $rekord2[imie]</option>";
      }
      echo "</select></td></tr>";

      $pobierz_druzyna = mysql_query("select id,nazwa from kluby order by rozgrywki,nazwa");
      echo "<tr><td>Drużyna</td><td>";
      echo "<select name=klub>";
      echo "<option value=\"\">";
      while ($rekord2 = mysql_fetch_array($pobierz_druzyna)) {
         echo "<option name=klub value=\"$rekord2[id]\">$rekord2[nazwa]</option>";
      }
      echo "</select></td></tr>";

      echo "<tr><td class=tekst>Rozgrywki</td><td>";
      echo "<select name=rozgrywki>";
      echo "<option name=rozgrywki value=\"plk\">PLK</option>";
      echo "<option name=rozgrywki value=\"euroliga\">Euroliga</option>";
      echo "<option name=rozgrywki value=\"inne\">Inne</option>";
      echo "</select>";
      echo "</td></tr>";

      echo "<tr><td>TOP dnia</td><td><input type=radio name=top value=nie$nie>Nie <input type=radio name=top value=tak>Tak</td></tr>";

      print "<tr><td>Autor:</td><td><input type=text name=autor></td></tr>";
      print "<tr><td>Słowa kluczowe:</td><td><input type=text name=slowa></td></tr>";
      print "<tr><td>Opis:</td><td><input type=text name=opis></td></tr>";
      print "<tr><td>Adres:</td><td><input type=text name=adres></td></tr>";
      print "<tr><td>Adres miniaturki:</td><td><input type=text name=adres_male></td></tr>";

      print "<tr><td><input type=submit value=Zmień></td></tr>";
      print "</table>";
      echo "</form>";
   } else {
      $dzien = date("d",time());
      $miesiac = date("m",time());
      $rok = date("Y",time());
      $data = "$rok-$miesiac-$dzien";

      $nowy = "insert into galeria (mecz, rozgrywki, slowa, opis, zawodnik1, zawodnik2, klub, autor, adres, adres_male, top, data, galeria) values ('$mecz', '$rozgrywki', '$slowa', '$opis', '$zawodnik1', '$zawodnik2', '$klub', '$autor', '$adres', '$adres_male', '$top', '$data', '$galeria')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowe zdjęcie.<br><a href=javascript:history.back(-1)>Powrót</a>";
      } else {
         echo "Nie udało się dodać zdjęcia.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $mecz, $rozgrywki, $slowa, $opis, $zawodnik1, $zawodnik2, $klub, $autor, $adres, $adres_male, $top, $data, $galeria);
   break;
   case "delete":
   usun($zdj);
   break;
   case "edit":
   edytuj($zdj, $tabela = "galeria", $mecz, $rozgrywki, $slowa, $opis, $zawodnik1, $zawodnik2, $klub, $autor, $adres, $adres_male, $top, $data, $galeria);
   break;
   case "edit_now":
   edycja($zdj, "galeria", $mecz, $rozgrywki, $slowa, $opis, $zawodnik1, $zawodnik2, $klub, $autor, $adres, $adres_male, $top, $data, $galeria);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
