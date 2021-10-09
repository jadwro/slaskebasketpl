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

function usun($zawodnik, $tabela = "byligracze") {
   $query = "delete from $tabela where id='$zawodnik'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=byligracze.php>Powrót...</a>";
   }
}

function edytuj($zawodnik, $tabela = "byligracze", $imie, $nazwisko, $urodzony, $wzrost, $waga, $kariera, $charakterystyka, $obywatelstwo, $sezon, $sezon2, $sezon_slask, $zdjecie, $klub, $rozgrywki1, $rozgrywki2) {
   if(!$zawodnik) {
      print "<font class=kto>Nasi byli gracze</font>";
      $pobierz = mysql_query("select*from byligracze order by sezon,nazwisko desc");
      $ilu = mysql_num_rows($pobierz);
      print "<table border=0>";
      print "<tr><td></td><td class=tekst><b>Imię i nazwisko</td><td class=tekst><b>Wzrost</td><td class=tekst><b>Klub</td><td class=tekst><b>Sezon</td><td class=tekst><b>Akcja</td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
      print "<tr><td><img src=../$rekord[zdjecie] width=30></td><td class=tekst><a href=\"?poddzial=11&gracz=$rekord[imie] $rekord[nazwisko]\">$rekord[imie] $rekord[nazwisko]</td><td class=tekst>$rekord[wzrost] cm</td><td class=tekst>$rekord[klub]</td><td class=tekst>$rekord[sezon]</td><td class=tekst><a href=\"byligracze.php?&zawodnik=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"byligracze.php?&zawodnik=$rekord[id]&akcja=delete\">Usuń</a></td></tr>";
      }
      print "</table>";
   } else {
   $query = "select*from $tabela where id='$zawodnik'";
   $wynik = mysql_query($query);
   print "<form action=\"byligracze.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=zawodnik value=\"$rekord[id]\">";
   print "<tr><td class=tekst>Imię</td><td class=tekst><input type=text name=imie value=\"$rekord[imie]\"></td></tr>\n";
   print "<tr><td class=tekst>Nazwisko</td><td class=tekst><input type=text name=nazwisko value=\"$rekord[nazwisko]\"></td></tr>\n";
   print "<tr><td class=tekst>Urodzony</td><td class=tekst><input type=text name=urodzony value=\"$rekord[urodzony]\"></td></tr>\n";
   print "<tr><td class=tekst>Wzrost</td><td class=tekst><input type=text name=wzrost value=\"$rekord[wzrost]\"></td></tr>\n";
   print "<tr><td class=tekst>Waga</td><td class=tekst><input type=text name=waga value=\"$rekord[waga]\"></td></tr>\n";
   print "<tr><td class=tekst>Sezon</td><td class=tekst><input type=text name=sezon value=\"$rekord[sezon]\"></td></tr>\n";
   print "<tr><td class=tekst>Sezon2</td><td class=tekst><input type=text name=sezon2 value=\"$rekord[sezon2]\"></td></tr>\n";
   print "<tr><td class=tekst>Sezony w Śląsku</td><td class=tekst><input type=text name=sezon_slask value=\"$rekord[sezon_slask]\"></td></tr>\n";
   print "<tr><td class=tekst>Aktualny klub</td><td class=tekst><input type=text name=klub value=\"$rekord[klub]\"></td></tr>\n";

   $pobierz_zdj = mysql_query("select*from zdjecia where rodzaj='zawodnik' order by nazwa");
   echo "<tr><td class=tekst>Zdjęcie</td><td>";
   echo "<select name=zdjecie>";
   while ($rekord2 = mysql_fetch_array($pobierz_zdj)) {
      if($rekord2[id] == $rekord[zdjecie]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option value=$rekord2[id]$to>$rekord2[nazwa]</option>";
   }
   echo "</select>";
   echo "</td></tr>";

   $pobierz_rozg1 = mysql_query("select*from rozgrywki");
   echo "<tr><td class=tekst>Rozgrywki (liga)</td><td>";
   echo "<select name=rozgrywki1>";
   echo "<option value=\"\">Brak";
   while ($rekord2 = mysql_fetch_array($pobierz_rozg1)) {
      if($rekord2[rozgrywki] == $rekord[rozgrywki1]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option value=\"$rekord2[rozgrywki]\"$to>$rekord2[rozgrywki]</option>";
   }
   echo "</select>";
   echo "</td></tr>";

   $pobierz_rozg2 = mysql_query("select*from rozgrywki");
   echo "<tr><td class=tekst>Rozgrywki (inne)</td><td>";
   echo "<select name=rozgrywki2>";
   echo "<option value=\"\">Brak";
   while ($rekord2 = mysql_fetch_array($pobierz_rozg2)) {
      if($rekord2[rozgrywki] == $rekord[rozgrywki2]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option value=\"$rekord2[rozgrywki]\"$to>$rekord2[rozgrywki]</option>";
   }
   echo "</select>";
   echo "</td></tr>";

   print "<tr><td class=tekst>Obywatelstwo</td><td class=tekst><input type=text name=obywatelstwo value=$rekord[obywatelstwo]></td></tr>\n";
   print "<tr><td class=tekst>Kariera</td><td class=tekst><textarea cols=50 rows=5 name=kariera>$rekord[kariera]</textarea></td></tr>";
   print "<tr><td class=tekst>Charakterystyka</td><td class=tekst><textarea cols=50 rows=15 name=charakterystyka>$rekord[charakterystyka]</textarea></td></tr>";
   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($zawodnik, $tabela = "byligracze", $imie, $nazwisko, $urodzony, $wzrost, $waga, $kariera, $charakterystyka, $obywatelstwo, $sezon, $sezon2, $sezon_slask, $zdjecie, $klub, $rozgrywki1, $rozgrywki2) {
   $query = "update byligracze set imie='$imie', nazwisko='$nazwisko', urodzony='$urodzony', wzrost='$wzrost', waga='$waga', kariera='$kariera', charakterystyka='$charakterystyka', obywatelstwo='$obywatelstwo', sezon='$sezon', sezon2='$sezon2', sezon_slask='$sezon_slask', zdjecie='$zdjecie', klub='$klub', rozgrywki1='$rozgrywki1', rozgrywki2='$rozgrywki2' where id='$zawodnik'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=byligracze.php>Powrót...</a>";
   }
}

function wyswietl() {
   global $sez;
   print "<font class=napis_zawodnicy>";
   print "Nasi byli gracze";
   print "</font>";
   $pobierz = mysql_query("select*from byligracze order by sezon,nazwisko");
   $ilu = mysql_num_rows($pobierz);

   print "<table border=0>";
   print "<tr><td></td><td class=tekst width=130 align=center><b>Imię i nazwisko</td><td class=tekst width=60 align=center><b>Wzrost</td><td align=center class=tekst width=100><b>Klub</td><td align=center class=tekst width=70><b>Sezon</td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
      print "<tr><td><img src=../$rekord[zdjecie] width=30></td><td align=center class=tekst><a href=\"../3?poddzial=11&gracz=$rekord[imie] $rekord[nazwisko]\">$rekord[imie] $rekord[nazwisko]</td><td align=center class=tekst>$rekord[wzrost] cm</td><td align=center class=tekst>$rekord[klub]</td><td align=center class=tekst>$rekord[sezon]</td></tr>";
   }
   print "</table>";
}

function dopisz($czy, $akcja, $imie, $nazwisko, $urodzony, $wzrost, $waga, $kariera, $charakterystyka, $obywatelstwo, $sezon, $sezon2, $sezon_slask, $zdjecie, $klub, $rozgrywki1, $rozgrywki2, $zmien) {
   if(!$zmien) {
      $terazgraja = mysql_query("select id,imie,nazwisko from zawodnicy order by nazwisko,imie");
      print "<form action=byligracze.php>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "Wybierz gracza z listy...";
      echo "<select name=zmien>";
      while ($rekord2 = mysql_fetch_array($terazgraja)) {
         echo "<option value=$rekord2[id]>$rekord2[nazwisko] $rekord2[imie]</option>";
      }
      echo "</select>";
      print "<br><input type=submit value=Dodaj></form>";
      print "<br><br>... lub <a href=byligracze.php?akcja=dopisz&zmien=tak><b>dodaj nowego</b></a>";
   } else {
      if($czy!="tak") {
         echo "<form action=byligracze.php method=post>";
         echo "<table border=0>";
         echo "<input type=hidden name=czy value=tak>";
         echo "<input type=hidden name=zmien value=tak>";
         echo "<input type=hidden name=akcja value=dopisz>";
         $tengracz = mysql_fetch_array(mysql_query("select*from zawodnicy where id='$zmien'"));
         print "<tr><td class=tekst>Imię</td><td class=tekst><input type=text name=imie value='$tengracz[imie]'></td></tr>\n";
         print "<tr><td class=tekst>Nazwisko</td><td class=tekst><input type=text name=nazwisko value='$tengracz[nazwisko]'></td></tr>\n";
         print "<tr><td class=tekst>Urodzony</td><td class=tekst><input type=text name=urodzony value='$tengracz[urodzony]'></td></tr>\n";
         print "<tr><td class=tekst>Wzrost</td><td class=tekst><input type=text name=wzrost value='$tengracz[wzrost]'></td></tr>\n";
         print "<tr><td class=tekst>Waga</td><td class=tekst><input type=text name=waga value='$tengracz[waga]'></td></tr>\n";
         print "<tr><td class=tekst>Sezon</td><td class=tekst><input type=text name=sezon></td></tr>\n";
         print "<tr><td class=tekst>Sezon2</td><td class=tekst><input type=text name=sezon2></td></tr>\n";
         print "<tr><td class=tekst>Sezony w Śląsku</td><td class=tekst><input type=text name=sezon_slask></td></tr>\n";
         print "<tr><td class=tekst>Aktualny klub</td><td class=tekst><input type=text name=klub></td></tr>\n";
   
         $pobierz_zdj = mysql_query("select*from zdjecia where rodzaj='zawodnik' order by nazwa");
         echo "<tr><td class=tekst>Zdjęcie</td><td>";
         echo "<select name=zdjecie>";
         while ($rekord2 = mysql_fetch_array($pobierz_zdj)) {
            if($rekord2[id]==$tengracz[zdjecie]) {
               $to = " selected";
            } else {
               $to = "";
            }
            echo "<option value=$rekord2[id]$to>$rekord2[nazwa]</option>";
         }
         echo "</select>";
         echo "</td></tr>";
   
         $pobierz_rozg1 = mysql_query("select*from rozgrywki");
         echo "<tr><td class=tekst>Rozgrywki (liga)</td><td>";
         echo "<select name=rozgrywki1>";
         echo "<option value=\"\">Brak";
         while ($rekord2 = mysql_fetch_array($pobierz_rozg1)) {
            echo "<option value=\"$rekord2[rozgrywki]\">$rekord2[rozgrywki]</option>";
         }
         echo "</select>";
         echo "</td></tr>";

         $pobierz_rozg2 = mysql_query("select*from rozgrywki");
         echo "<tr><td class=tekst>Rozgrywki (inne)</td><td>";
         echo "<select name=rozgrywki2>";
         echo "<option value=\"\">Brak";
         while ($rekord2 = mysql_fetch_array($pobierz_rozg2)) {
            echo "<option value=\"$rekord2[rozgrywki]\">$rekord2[rozgrywki]</option>";
         }
         echo "</select>";
         echo "</td></tr>";
   
         print "<tr><td class=tekst>Obywatelstwo</td><td class=tekst><input type=text name=obywatelstwo value='$tengracz[obywatelstwo]'></td></tr>\n";
         print "<tr><td class=tekst>Kariera</td><td class=tekst><textarea cols=50 rows=5 name=kariera>$tengracz[kariera]</textarea></td></tr>";
         print "<tr><td class=tekst>Charakterystyka</td><td class=tekst><textarea cols=50 rows=15 name=charakterystyka>$tengracz[charakterystyka]</textarea></td></tr>";
         print "<tr><td class=tekst><input type=submit value=Dodaj>\n";
         print "</table>\n";
         echo "</form>";
      } else {
         $nowy = "insert into byligracze (imie, nazwisko, urodzony, wzrost, waga, kariera, charakterystyka, obywatelstwo, sezon, sezon2, sezon_slask, zdjecie, klub) values ('$imie', '$nazwisko', '$urodzony', '$wzrost', '$waga', '$kariera', '$charakterystyka', '$obywatelstwo', '$sezon', '$sezon2', '$sezon_slask', '$zdjecie', '$klub')";
         $nowy_wpis = mysql_query($nowy);
         if($nowy_wpis) {
            echo "Dodałem nowego zawodnika.<br><a href=byligracze.php>Powrót</a>";
         } else {
            echo "Nie udało się dodać zawodnika.<br>".mysql_error();
         }
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $imie, $nazwisko, $urodzony, $wzrost, $waga, $kariera, $charakterystyka, $obywatelstwo, $sezon, $sezon2, $sezon_slask, $zdjecie, $klub, $rozgrywki1, $rozgrywki2, $zmien);
   break;
   case "delete":
   usun($zawodnik);
   break;
   case "edit":
   edytuj($zawodnik, $tabela = "byligracze", $imie, $nazwisko, $urodzony, $wzrost, $waga, $kariera, $charakterystyka, $obywatelstwo, $sezon, $sezon2, $sezon_slask, $zdjecie, $klub, $rozgrywki1, $rozgrywki2);
   break;
   case "edit_now":
   edycja($zawodnik, "byligracze", $imie, $nazwisko, $urodzony, $wzrost, $waga, $kariera, $charakterystyka, $obywatelstwo, $sezon, $sezon2, $sezon_slask, $zdjecie, $klub, $rozgrywki1, $rozgrywki2);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
