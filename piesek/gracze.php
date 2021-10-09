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

function usun($zawodnik, $tabela = "gracze") {
   $query = "delete from $tabela where id='$zawodnik'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=javascript:history.back(-1)>Powrót...</a>";
   }
}

function edytuj($zawodnik, $tabela = "gracze", $imie, $nazwisko, $pozycja, $pozycja_num, $dzien_ur, $miesiac_ur, $rok_ur, $miejsce_ur, $wzrost, $waga, $obywatelstwo, $kariera, $charakterystyka, $klub, $numer, $stan, $zwolniony1, $zwolniony2, $sezon1, $zdjecie, $wiecej) {
   if(!$zawodnik) {
      print "<font class=kto>Gracze rywali</font>";
      $pobierz = mysql_query("select*from gracze order by klub");
      print "<table border=0>";
      print "<tr><td class=tekst><b>Imię i nazwisko</td><td class=tekst><b>Wzrost</td><td class=tekst><b>Klub</td><td class=tekst><b>Sezon</td><td class=tekst><b>Akcja</td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         print "<tr><td class=tekst>$rekord[imie] $rekord[nazwisko]</td><td class=tekst>$rekord[wzrost] cm</td><td class=tekst>$rekord[klub]</td><td class=tekst>$rekord[sezon]</td><td class=tekst><a href=\"gracze.php?&zawodnik=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"gracze.php?&zawodnik=$rekord[id]&akcja=delete\">Usuń</a></td></tr>";
      }
      print "</table>";
   } else {
   $query = "select*from $tabela where id='$zawodnik'";
   $wynik = mysql_query($query);
   print "<form action=\"gracze.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=zawodnik value=\"$rekord[id]\">";
   print "<tr><td class=tekst>Imię</td><td class=tekst><input type=text name=imie value=\"$rekord[imie]\"></td></tr>\n";
   print "<tr><td class=tekst>Nazwisko</td><td class=tekst><input type=text name=nazwisko value=\"$rekord[nazwisko]\"></td></tr>\n";
   print "<tr><td class=tekst>Urodzony</td><td class=tekst><input type=text name=dzien_ur value=\"$rekord[dzien_ur]\" size=1> / <input type=text name=miesiac_ur value=\"$rekord[miesiac_ur]\" size=1> / <input type=text name=rok_ur value=\"$rekord[rok_ur]\" size=1>";
   print "<tr><td class=tekst>Miejsce ur.</td><td class=tekst><input type=text name=miejsce_ur value=\"$rekord[miejsce_ur]\"></td></tr>\n";
   print "<tr><td class=tekst>Pozycja (słownie)</td><td class=tekst><input type=text name=pozycja value=\"$rekord[pozycja]\"></td></tr>\n";
   print "<tr><td class=tekst>Numer pozycji</td><td class=tekst><input type=text name=pozycja_num value=\"$rekord[pozycja_num]\"></td></tr>\n";
   print "<tr><td class=tekst>Wzrost</td><td class=tekst><input type=text name=wzrost value=\"$rekord[wzrost]\"></td></tr>\n";
   print "<tr><td class=tekst>Waga</td><td class=tekst><input type=text name=waga value=\"$rekord[waga]\"></td></tr>\n";
   $pobierz_klub = mysql_query("select*from kluby");
   echo "<tr><td class=tekst>Klub</td><td>";
   echo "<select name=klub>";
   while ($rekord2 = mysql_fetch_array($pobierz_klub)) {
      if($rekord2[id] == $rekord[klub]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option value=$rekord2[id]$to>$rekord2[nazwa]</option>";
   }
   echo "</select>";
   echo "</td></tr>";
   print "<tr><td class=tekst>Numer</td><td class=tekst><input type=text name=numer value=\"$rekord[numer]\"></td></tr>\n";
   print "<tr><td class=tekst>Sezon</td><td class=tekst><input type=text name=sezon1 value=\"$rekord[sezon1]\"></td></tr>\n";
   print "<tr><td class=tekst>Stan</td><td class=tekst><input type=text name=stan value=\"$rekord[stan]\"> (kontuzja lub gra)</td></tr>\n";
   $pobierz_zdj = mysql_query("select*from zdjecia where rodzaj='zawodnik' order by nazwa");
   echo "<tr><td class=tekst>Zdjęcie</td><td>";
   echo "<select name=zdjecie>";
   echo "<option value=311>Brak";
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
   print "<tr><td class=tekst>Obywatelstwo</td><td class=tekst><input type=text name=obywatelstwo value=$rekord[obywatelstwo]></td></tr>\n";
   print "<tr><td class=tekst>Kariera</td><td class=tekst><textarea cols=50 rows=5 name=kariera>$rekord[kariera]</textarea></td></tr>";
   print "<tr><td class=tekst>Charakterystyka</td><td class=tekst><textarea cols=50 rows=15 name=charakterystyka>$rekord[charakterystyka]</textarea></td></tr>";
   $pobierz_klub = mysql_query("select*from kluby");
   echo "<tr><td class=tekst>Zwolniony 1 *</td><td>";
   echo "<select name=zwolniony1>";
   echo "<option value=''>Brak</option>";
   while ($rekord2 = mysql_fetch_array($pobierz_klub)) {
      if($rekord2[id] == $rekord[zwolniony1]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option value=$rekord2[id]$to>$rekord2[nazwa]</option>";
   }
   echo "</select>";
   echo "</td></tr>";
   $pobierz_klub = mysql_query("select*from kluby");
   echo "<tr><td class=tekst>Zwolniony 2 *</td><td>";
   echo "<select name=zwolniony2>";
   echo "<option value=''>Brak</option>";
   while ($rekord2 = mysql_fetch_array($pobierz_klub)) {
      if($rekord2[id] == $rekord[zwolniony2]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option value=$rekord2[id]$to>$rekord2[nazwa]</option>";
   }
   echo "</select>";
   echo "</td></tr>";
   print "<tr><td class=tekst>Link do więcej (z http://)</td><td class=tekst><input type=text name=wiecej value=$rekord[wiecej]></td></tr>\n";
   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($zawodnik, $tabela = "gracze", $imie, $nazwisko, $pozycja, $pozycja_num, $dzien_ur, $miesiac_ur, $rok_ur, $miejsce_ur, $wzrost, $waga, $obywatelstwo, $kariera, $charakterystyka, $klub, $numer, $stan, $zwolniony1, $zwolniony2, $sezon1, $zdjecie, $wiecej) {
   $query = "update gracze set imie='$imie', nazwisko='$nazwisko', pozycja='$pozycja', pozycja_num='$pozycja_num', dzien_ur='$dzien_ur', miesiac_ur='$miesiac_ur', rok_ur='$rok_ur', miejsce_ur='$miejsce_ur', wzrost='$wzrost', waga='$waga', obywatelstwo='$obywatelstwo', kariera='$kariera', charakterystyka='$charakterystyka', klub='$klub', numer='$numer', stan='$stan', zwolniony1='$zwolniony2', sezon1='$sezon1', zdjecie='$zdjecie', wiecej='$wiecej' where id='$zawodnik'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=zawodnicy_2.php>Powrót...</a>";
   }
}

function wyswietl() {
   global $sez;
   print "<table border=0>";
   print "<tr><td width=400><font class=napis_zawodnicy_2>";
   if(!$sez) {
      print "zawodnicy_2";
   } else {
      print "zawodnicy_2 (sezon: $sez)";
   }
   print "</font></td>";
   print "<td valign=bottom align=right><SELECT NAME=opis OnChange=sezon(this) class=sezon>";
   print "<OPTION VALUE=# selected>Wybierz sezon:</OPTION>";
   print "<OPTION VALUE=zawodnicy_2.php?sez=2002/2003>Sezon 2002/2003</OPTION>";
   print "<OPTION VALUE=zawodnicy_2.php?sez=2001/2002>Sezon 2001/2002</OPTION>";
   print "<OPTION VALUE=zawodnicy_2.php?sez=2000/2001>Sezon 2000/2001</OPTION>";
   print "<OPTION VALUE=zawodnicy_2.php>Wszystkie sezony</OPTION>";
   print "</select>";
   print "</td></tr></table>";
   if(!$sez) {
      $pobierz = mysql_query("select*from zawodnicy_2 order by stan,numer");
   } else {
      $pobierz = mysql_query("select*from zawodnicy_2 where sezon='$sez' OR sezon2='$sez' OR sezon3='$sez' order by stan,numer");
   }
   $ilu = mysql_num_rows($pobierz);

   print "<table border=0>";
   print "<tr><td></td><td class=tekst width=130 align=center><b>Imię i nazwisko</td><td class=tekst width=60 align=center><b>Wzrost</td><td align=center class=tekst width=100><b>Pozycja</td><td align=center class=tekst width=70><b>Obywatelstwo</td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
      if($rekord[stan] == "Gra") {
         print "<tr><td><img src=../$rekord[zdjecie] width=30></td><td align=center class=tekst><a href=\"../index.php3?id=zawodnicy_2&zawodnik=$rekord[imie] $rekord[nazwisko]\">$rekord[imie] $rekord[nazwisko]</td><td align=center class=tekst>$rekord[wzrost] cm</td><td align=center class=tekst>$rekord[pozycja]</td><td align=center class=tekst>$rekord[obywatelstwo]</td></tr>";
      } else {
         print "<tr><td><img src=../$rekord[zdjecie] width=30></td><td align=center class=tekst2><a href=\"../index.php3?id=zawodnicy_2&zawodnik=$rekord[imie] $rekord[nazwisko]\"><font class=tekst2>$rekord[imie] $rekord[nazwisko]</td><td align=center class=tekst2>$rekord[wzrost] cm</td><td align=center class=tekst2>$rekord[pozycja]</td><td class=tekst2 align=center>$rekord[obywatelstwo]</td><td class=tekst2>$rekord[stan]</tr>";
      }
   }
   print "</table>";
}

function dopisz($czy, $akcja, $imie, $nazwisko, $pozycja, $pozycja_num, $dzien_ur, $miesiac_ur, $rok_ur, $miejsce_ur, $wzrost, $waga, $obywatelstwo, $kariera, $charakterystyka, $klub, $numer, $stan, $zwolniony1, $zwolniony2, $sezon1, $zdjecie, $wiecej) {
   if($czy!="tak") {
      echo "<form action=gracze.php>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<tr><td class=tekst>Imię</td><td class=tekst><input type=text name=imie></td></tr>";
      echo "<tr><td class=tekst>Nazwisko</td><td class=tekst><input type=text name=nazwisko></td></tr>";
      echo "<tr><td class=tekst>Urodzony</td><td class=tekst><input type=text name=dzien_ur size=1> / <input type=text name=miesiac_ur size=1> / <input type=text name=rok_ur size=1 size=1></td></tr>";
      echo "<tr><td class=tekst>Miejsce ur.</td><td class=tekst><input type=text name=miejsce_ur></td></tr>";
      echo "<tr><td class=tekst>Pozycja (słownie)</td><td class=tekst><input type=text name=pozycja></td></tr>";
      echo "<tr><td class=tekst>Numer pozycji</td><td class=tekst><input type=text name=pozycja_num></td></tr>";
      echo "<tr><td class=tekst>Wzrost</td><td class=tekst><input type=text name=wzrost></td></tr>";
      echo "<tr><td class=tekst>Waga</td><td class=tekst><input type=text name=waga></td></tr>";
      echo "<tr><td class=tekst>Numer</td><td class=tekst><input type=text name=numer></td></tr>";
      echo "<tr><td class=tekst>Sezon</td><td class=tekst><input type=text name=sezon1 value=2003/2004></td></tr>";
      echo "<tr><td class=tekst>Stan</td><td class=tekst><input type=text name=stan value=gra> (kontuzjowany lub gra)</td></tr>";
      $pobierz_klub = mysql_query("select*from kluby order by nazwa");
      echo "<tr><td class=tekst>Klub</td><td>";
      echo "<select name=klub>";
      echo "<option value=0>Brak";
      while ($rekord = mysql_fetch_array($pobierz_klub)) {
         echo "<option value=$rekord[id]>$rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      $pobierz_zdj = mysql_query("select*from zdjecia where rodzaj='zawodnik' order by nazwa");
      echo "<tr><td class=tekst>Zdjęcie</td><td>";
      echo "<select name=zdjecie>";
      echo "<option value=311>Brak";
      while ($rekord = mysql_fetch_array($pobierz_zdj)) {
         echo "<option name=zdjecie value=$rekord[id]>$rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      echo "<tr><td class=tekst>Obywatelstwo</td><td class=tekst><input type=text name=obywatelstwo></td></tr>";
      echo "<tr><td class=tekst>Dotychczasowa kariera</td><td class=tekst><textarea name=kariera rows=8 cols=30></textarea></td></tr>";
      echo "<tr><td class=tekst>Charakterystyka</td><td class=tekst><textarea name=charakterystyka rows=8 cols=40></textarea></td></tr>";
      echo "</select>";
      echo "</td></tr>";
      $pobierz_klub = mysql_query("select*from kluby order by nazwa");
      echo "<tr><td class=tekst>Zwolniony 1 *</td><td>";
      echo "<select name=zwolniony1>";
      echo "<option value=0>Brak";
      while ($rekord = mysql_fetch_array($pobierz_klub)) {
         echo "<option value=$rekord[id]>$rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      $pobierz_klub = mysql_query("select*from kluby order by nazwa");
      echo "<tr><td class=tekst>Zwolniony 2 *</td><td>";
      echo "<select name=zwolniony2>";
      echo "<option value=0>Brak";
      while ($rekord = mysql_fetch_array($pobierz_klub)) {
         echo "<option value=$rekord[id]>$rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      echo "<tr><td class=tekst>Link do więcej (z http://)</td><td class=tekst><input type=text name=wiecej></td></tr>";
      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $charakterystyka = stripslashes($charakterystyka);
      $nowy = "insert into gracze (imie, nazwisko, dzien_ur, miesiac_ur, rok_ur, miejsce_ur, pozycja, pozycja_num, wzrost, waga, obywatelstwo, kariera, charakterystyka, klub, stan, zwolniony1, zwolniony2, sezon1, zdjecie, wiecej) values ('$imie', '$nazwisko', '$dzien_ur', '$miesiac_ur', '$rok_ur', '$miejsce_ur', '$pozycja', '$pozycja_num', '$wzrost', '$waga', '$obywatelstwo', '$kariera', '$charakterystyka', '$klub', '$stan', '$zwolniony1', '$zwolniony2', '$sezon1', '$zdjecie', '$wiecej')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowego zawodnika.<br><a href=javascript:history.back(-1)>Powrót</a>";
      } else {
         echo "Nie udało się dodać zawodnika.";
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $imie, $nazwisko, $pozycja, $pozycja_num, $dzien_ur, $miesiac_ur, $rok_ur, $miejsce_ur, $wzrost, $waga, $obywatelstwo, $kariera, $charakterystyka, $klub, $numer, $stan, $zwolniony1, $zwolniony2, $sezon1, $zdjecie, $wiecej);
   break;
   case "delete":
   usun($zawodnik);
   break;
   case "edit":
   edytuj($zawodnik, $tabela = "gracze", $imie, $nazwisko, $pozycja, $pozycja_num, $dzien_ur, $miesiac_ur, $rok_ur, $miejsce_ur, $wzrost, $waga, $obywatelstwo, $kariera, $charakterystyka, $klub, $numer, $stan, $zwolniony1, $zwolniony2, $sezon1, $zdjecie, $wiecej);
   break;
   case "edit_now":
   edycja($zawodnik, "gracze", $imie, $nazwisko, $pozycja, $pozycja_num, $dzien_ur, $miesiac_ur, $rok_ur, $miejsce_ur, $wzrost, $waga, $obywatelstwo, $kariera, $charakterystyka, $klub, $numer, $stan, $zwolniony1, $zwolniony2, $sezon1, $zdjecie, $wiecej);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
