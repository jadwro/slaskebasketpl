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
require("polacz.php");

function usun($mecz, $tabela = "mecze") {
   $query = "delete from $tabela where id='$mecz'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.<br>";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=mecze.php>Powrót...</a><br>";
   }
   $query = "delete from tabele where id_meczu='$mecz'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=mecze.php>Powrót...</a>";
   }
}

function edytuj($mecz, $tabela = "mecze", $druzyna1, $druzyna2, $d1_kosze, $d2_kosze, $d1_wynik, $d2_wynik, $kwarty, $opis, $dzien, $miesiac, $rok, $rozgrywki, $sezon, $kolejka, $gracz_meczu, $gracz_meczu_czemu, $zobacz_tez, $nastepny, $poprzedni, $dodatkowe, $para, $godzina, $miejsce) {
   if(!$mecz) {
      $pobierz = mysql_query("select*from mecze where sezon='2005/2006' AND rozgrywki='48' order by rozgrywki,kolejka");
      $ilu = mysql_num_rows($pobierz);
      print "<br><table border=0>";
      print "<tr><td class=tekst><b>Mecz</td><td class=tekst><b>Wynik</td><td class=tekst><b>Kolejka</td><td class=tekst><b>Sezon</td><td class=tekst><b>Akcja</td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         $kolejka = mysql_fetch_array(mysql_query("select numer from kolejki where id='$rekord[kolejka]'"));
         $druzyna1 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna1]'"));
         $druzyna2 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna2]'"));
         print "<tr><td class=tekst><a href=\"../index.php?mecz=$rekord[id]\">$druzyna1[nazwa] - $druzyna2[nazwa]</td><td class=tekst>$rekord[d1_wynik]:$rekord[d2_wynik]</td><td class=tekst>$kolejka[numer]</td><td class=tekst>$rekord[sezon]</td><td class=tekst><a href=\"mecze.php?mecz=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"mecze.php?mecz=$rekord[id]&akcja=delete\">Usuń</a></td></tr>";
      }
      print "</table>";
   } else {
   $query = "select*from $tabela where id='$mecz'";
   print "<form action=\"mecze.php?akcja=edit_now\" method=post>";
   $wynik = mysql_query($query);
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=mecz value=\"$rekord[id]\">";
   echo "<tr><td class=tekst>Data</td><td class=tekst><input type=text name=dzien value=\"$rekord[dzien]\" size=1> / <input type=text name=miesiac value=\"$rekord[miesiac]\" size=1> / <input type=text name=rok value=\"$rekord[rok]\" size=1> r., Godzina <input type=text name=godzina value=\"$rekord[godzina]\" size=3> miejsce <input type=text name=miejsce value=\"$rekord[miejsce]\" size=5></td></tr>";
   $pobierz_klub = mysql_query("select*from kluby order by nazwa");
   echo "<tr><td class=tekst>Gospodarz</td><td>";
   echo "<select name=druzyna1>";
   while ($rekord2 = mysql_fetch_array($pobierz_klub)) {
      if($rekord2[id] == $rekord[druzyna1]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option name=druzyna1 value=\"$rekord2[id]\"$to>$rekord2[nazwa]</option>";
   }
   echo "</select>";
   echo "</td></tr>";
   $pobierz_klub2 = mysql_query("select*from kluby order by nazwa");
   echo "<tr><td class=tekst>Gość</td><td>";
   echo "<select name=druzyna2>";
   while ($rekord2 = mysql_fetch_array($pobierz_klub2)) {
      if($rekord2[id] == $rekord[druzyna2]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option name=druzyna2 value=\"$rekord2[id]\"$to>$rekord2[nazwa]</option>";
   }
   echo "</select>";
   echo "</td></tr>";
   echo "<tr><td class=tekst>Wynik</td><td class=tekst><input type=text name=d1_wynik size=1 value=$rekord[d1_wynik]> : <input size=1 type=text name=d2_wynik value=$rekord[d2_wynik]></td></tr>";
   echo "<tr><td class=tekst>Kwarty</td><td class=tekst><input type=text name=kwarty value=\"$rekord[kwarty]\" size=30></td></tr>";
   echo "<tr><td class=tekst>Punkty dla gospodarzy</td><td class=tekst><textarea name=d1_kosze cols=60 rows=2>$rekord[d1_kosze]</textarea></td></tr>";
   echo "<tr><td class=tekst>Punkty dla gości</td><td class=tekst><textarea name=d2_kosze cols=60 rows=2>$rekord[d2_kosze]</textarea></td></tr>";
   $pobierz_sezon = mysql_query("select*from sezony");
   echo "<tr><td class=tekst>Sezon</td><td>";
   echo "<select name=sezon>";
   while ($rekord2 = mysql_fetch_array($pobierz_sezon)) {
      if($rekord2[sezon] == $rekord[sezon]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option name=sezon value=\"$rekord2[sezon]\"$to>$rekord2[sezon]</option>";
   }
   echo "</select>";
   echo "</td></tr>";
   $pobierz_rozg = mysql_query("select*from rozgrywki order by sezon desc");
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
   $pobierz_pare = mysql_query("select*from pary_pf");
   echo "<tr><td class=tekst>Para play-off</td><td>";
   echo "<select name=para>";
   echo "<option name=para value=\"\">Nie dotyczy</option>";
   while ($rekord2 = mysql_fetch_array($pobierz_pare)) {
      $klub1 = mysql_fetch_array(mysql_query("select*from kluby where id='$rekord2[druzyna1]'"));
      $klub2 = mysql_fetch_array(mysql_query("select*from kluby where id='$rekord2[druzyna2]'"));
      if($rekord2[id] == $rekord[para]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option name=para value=\"$rekord2[id]\"$to>$klub1[nazwa] - $klub2[nazwa]</option>";
   }
   echo "</select>";
   echo "</td></tr>";
   $pobierz_kol = mysql_query("select*from kolejki");
   echo "<tr><td class=tekst>Kolejka</td><td>";
   echo "<select name=kolejka>";
   while ($rekord2 = mysql_fetch_array($pobierz_kol)) {
      $rozg = mysql_fetch_array(mysql_query("select rozgrywki from rozgrywki where id='$rekord2[rozgrywki]'"));
      if($rekord2[id] == $rekord[kolejka]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option name=kolejka value=\"$rekord2[id]\"$to>$rekord2[numer] ($rekord2[dzien1]-$rekord2[dzien2].$rekord2[miesiac].$rekord2[rok] r.) - $rozg[rozgrywki]</option>";
   }
   echo "</select>";
   echo "</td></tr>";
   $nazwa = explode(" ",$rekord[gracz_meczu]);
   $jeden = "$nazwa[0]";
   $dwa = "$nazwa[1]";
   $pobierz_gracza = mysql_query("select*from zawodnicy");
   echo "<tr><td class=tekst>Gracz meczu (tylko ze Śląska)</td><td>";
   echo "<select name=gracz_meczu>";
   echo "<option name=gracz_meczu value=\"\">Nie dotyczy</option>";
   while ($rekord2 = mysql_fetch_array($pobierz_gracza)) {
      if("$rekord2[id]" == "$rekord[gracz_meczu]") {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option name=gracz_meczu value=\"$rekord2[id]\"$to>$rekord2[imie] $rekord2[nazwisko]</option>";
   }
   echo "</select>";
   echo "</td></tr>";
   echo "<tr><td class=tekst>Za co? (gracz meczu, max 255 znaków)</td><td class=tekst><input type=text name=gracz_meczu_czemu value=\"$rekord[gracz_meczu_czemu]\"></td></tr>";
   echo "<tr><td class=tekst>Opis meczu</td><td class=tekst><textarea name=opis cols=60 rows=15>$rekord[opis]</textarea></td></tr>";
   echo "<tr><td class=tekst>Zobacz też</td><td class=tekst><textarea name=zobacz_tez cols=60 rows=5>$rekord[zobacz_tez]</textarea></td></tr>";
   echo "<tr><td class=tekst>Dodatkowe (np. przełożenie meczu)</td><td class=tekst><input type=text name=dodatkowe value=\"$rekord[dodatkowe]\" size=30></td></tr>";
   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($mecz, $tabela = "mecze", $druzyna1, $druzyna2, $d1_kosze, $d2_kosze, $d1_wynik, $d2_wynik, $kwarty, $opis, $dzien, $miesiac, $rok, $rozgrywki, $sezon, $kolejka, $gracz_meczu, $gracz_meczu_czemu, $zobacz_tez, $dodatkowe, $para, $godzina, $miejsce) {
   $opis = stripslashes($opis);
   $pobierz_logo = mysql_query("select logo from kluby where id='$druzyna1'");
   $czy1 = mysql_num_rows($pobierz_logo);
   if($czy1!=0) {
      $wez = mysql_fetch_array($pobierz_logo);
      $d1_logo = $wez[logo];
   } else {
      echo "Nie ma takiego klubu!";
   }
   $pobierz_logo2 = mysql_query("select logo from kluby where id='$druzyna2'");
   $czy2 = mysql_num_rows($pobierz_logo2);
   if($czy2 != 0) {
      $wez2 = mysql_fetch_array($pobierz_logo2);
      $d2_logo = $wez2[logo];
   } else {
      echo "Nie ma takiego klubu!";
   }
   $query = "update $tabela set druzyna1='$druzyna1', druzyna2='$druzyna2', d1_kosze='$d1_kosze', d2_kosze='$d2_kosze', d1_logo='$d1_logo', d2_logo='$d2_logo', d1_wynik='$d1_wynik', d2_wynik='$d2_wynik', kwarty='$kwarty', opis='$opis', dzien='$dzien', miesiac='$miesiac', rok='$rok', rozgrywki='$rozgrywki', sezon='$sezon', kolejka='$kolejka', gracz_meczu='$gracz_meczu', gracz_meczu_czemu='$gracz_meczu_czemu', zobacz_tez='$zobacz_tez', dodatkowe='$dodatkowe', para='$para', godzina='$godzina', miejsce='$miejsce' where id='$mecz'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=mecze.php>Powrót...</a>";
   }
   if($d1_wynik < $d2_wynik) {
      $d1_punkty = 1;
      $d2_punkty = 2;
      $d1_w = 0;
      $d2_w = 1;
      $d1_p = 1;
      $d2_p = 0;
   } else {
      $d1_punkty = 2;
      $d2_punkty = 1;
      $d1_w = 1;
      $d2_w = 0;
      $d1_p = 0;
      $d2_p = 1;
   }
   $spr = mysql_query("select id_meczu from tabele where id_meczu='$mecz'");
   $jest = mysql_num_rows($spr);
   if($jest != 0) {
      if(($d1_wynik != "0") && ($d1_wynik != "") && ($d2_wynik != "0") && ($d2_wynik != "")) {
         $usun = mysql_query("delete from tabele where id_meczu = '$mecz'");
         $wez_id = mysql_query("select id from mecze where id='$mecz'");
         $wczytaj_id = mysql_fetch_row($wez_id);
         $nowy = "insert into tabele (id_meczu, klub, punkty, zdobyte, stracone, w, p, rozgrywki, kolejka, sezon) values ('$wczytaj_id[0]', '$druzyna1', '$d1_punkty', '$d1_wynik', '$d2_wynik', '$d1_w', '$d1_p', '$rozgrywki', '$kolejka', '$sezon')";
         $nowy_wpis = mysql_query($nowy);
         if($nowy_wpis) {
            echo "Dodałem nowy mecz do tabeli (1).<br><a href=mecze.php>Powrót</a><br>";
         } else {
            echo "Nie udało się dodać tabeli(1).";
         }
         $nowy = "insert into tabele (id_meczu, klub, punkty, zdobyte, stracone, w, p, rozgrywki, kolejka, sezon) values ('$wczytaj_id[0]', '$druzyna2', '$d2_punkty', '$d2_wynik', '$d1_wynik', '$d2_w', '$d2_p', '$rozgrywki', '$kolejka', '$sezon')";
         $nowy_wpis = mysql_query($nowy);
         if($nowy_wpis) {
            echo "Dodałem nowy mecz do tabeli (2).<br><a href=mecze.php>Powrót</a><br>";
         } else {
            echo "Nie udało się dodać tabeli (2).";
         }
      }
   } else {
      if(($d1_wynik != "0") && ($d1_wynik != "") && ($d2_wynik != "0") && ($d2_wynik != "")) {
         $wez_id = mysql_query("select id from mecze where id='$mecz'");
         $wczytaj_id = mysql_fetch_row($wez_id);
         $nowy = "insert into tabele (id_meczu, klub, punkty, zdobyte, stracone, w, p, rozgrywki, kolejka, sezon) values ('$wczytaj_id[0]', '$druzyna1', '$d1_punkty', '$d1_wynik', '$d2_wynik', '$d1_w', '$d1_p', '$rozgrywki', '$kolejka', '$sezon')";
         $nowy_wpis = mysql_query($nowy);
         if($nowy_wpis) {
            echo "Dodałem nowy mecz do tabeli (1).<br><a href=mecze.php>Powrót</a><br>";
         } else {
            echo "Nie udało się dodać tabeli(1).";
         }
         $nowy = "insert into tabele (id_meczu, klub, punkty, zdobyte, stracone, w, p, rozgrywki, kolejka, sezon) values ('$wczytaj_id[0]', '$druzyna2', '$d2_punkty', '$d2_wynik', '$d1_wynik', '$d2_w', '$d2_p', '$rozgrywki', '$kolejka', '$sezon')";
         $nowy_wpis = mysql_query($nowy);
         if($nowy_wpis) {
            echo "Dodałem nowy mecz do tabeli (2).<br><a href=mecze.php>Powrót</a><br>";
         } else {
            echo "Nie udało się dodać tabeli (2).";
         }
      }
   }
}

function wyswietl() {
      print "<font class=kto>Mecze</font>";
      $pobierz = mysql_query("select*from mecze order by kolejka");
      $ilu = mysql_num_rows($pobierz);
      print "<table border=0>";
      print "<tr><td class=tekst><b>Mecz</td><td class=tekst><b>Wynik</td><td class=tekst><b>Kolejka</td><td class=tekst><b>Sezon</td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
      print "<tr><td class=tekst><a href=\"../index.php3?id=mecze&mecz=$rekord[id]\">$rekord[druzyna1] - $rekord[druzyna2]</td><td class=tekst>$rekord[d1_wynik]:$rekord[d2_wynik]</td><td class=tekst>$rekord[kolejka]</td><td class=tekst>$rekord[sezon]</td></tr>";
      }
      print "</table>";
}

function dopisz($czy, $akcja, $druzyna1, $druzyna2, $d1_kosze, $d2_kosze, $d1_wynik, $d2_wynik, $kwarty, $opis, $dzien, $miesiac, $rok, $rozgrywki, $sezon, $kolejka, $gracz_meczu, $gracz_meczu_czemu, $zobacz_tez, $dodatkowe, $para, $godzina, $miejsce, $ktore) {
   if($czy!="tak") {
      echo "<form action=mecze.php method=post>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=ktore value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<tr><td class=tekst>Data</td><td class=tekst><input type=text name=dzien size=1> / <input type=text name=miesiac size=1> / <input type=text name=rok size=1> r., godzina <input type=text name=godzina size=3> miejsce <input type=text name=miejsce size=5></td></tr>";

      $pobierz_klub = mysql_query("select*from kluby where rozgrywki='48' OR rozgrywki2='48' order by nazwa");
      $pobierz_klub2 = mysql_query("select*from kluby where rozgrywki='48' OR rozgrywki2='48' order by nazwa");
      $pobierz_kol = mysql_query("select*from kolejki where rozgrywki='48'");

      echo "<tr><td class=tekst>Gospodarz</td><td>";
      echo "<select name=druzyna1>";
      while ($rekord = mysql_fetch_array($pobierz_klub)) {
         echo "<option name=druzyna1 value=\"$rekord[id]\">$rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      echo "<tr><td class=tekst>Gość</td><td>";
      echo "<select name=druzyna2>";
      while ($rekord = mysql_fetch_array($pobierz_klub2)) {
         echo "<option name=druzyna2 value=\"$rekord[id]\">$rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      echo "<tr><td class=tekst>Wynik</td><td class=tekst><input type=text name=d1_wynik size=1> : <input size=1 type=text name=d2_wynik></td></tr>";
      echo "<tr><td class=tekst>Kwarty</td><td class=tekst><input type=text name=kwarty size=30></td></tr>";
      echo "<tr><td class=tekst>Punkty dla gospodarzy</td><td class=tekst><textarea name=d1_kosze cols=60 rows=2></textarea></td></tr>";
      echo "<tr><td class=tekst>Punkty dla gości</td><td class=tekst><textarea name=d2_kosze cols=60 rows=2></textarea></td></tr>";
      $pobierz_sezon = mysql_query("select*from sezony");
      echo "<tr><td class=tekst>Sezon</td><td>";
      echo "<select name=sezon>";
      while ($rekord = mysql_fetch_array($pobierz_sezon)) {
         if($rekord[sezon]=="2005/2006") {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option name=sezon value=\"$rekord[sezon]\"$to>$rekord[sezon]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      $pobierz_rozg = mysql_query("select*from rozgrywki where id='48' order by sezon desc");
      echo "<tr><td class=tekst>Rozgrywki</td><td>";
      echo "<select name=rozgrywki>";
      while ($rekord = mysql_fetch_array($pobierz_rozg)) {
         if($rekord[id] == $ktore) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option name=rozgrywki value=\"$rekord[id]\"$to>$rekord[rozgrywki] - $rekord[sezon]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      echo "<tr><td class=tekst>Kolejka</td><td>";
      echo "<select name=kolejka>";
      while ($rekord2 = mysql_fetch_array($pobierz_kol)) {
         $rozg = mysql_fetch_array(mysql_query("select rozgrywki from rozgrywki where id='$rekord2[rozgrywki]'"));
         echo "<option name=kolejka value=\"$rekord2[id]\"$to>$rekord2[numer] ($rekord2[dzien1]-$rekord2[dzien2].$rekord2[miesiac].$rekord2[rok] r.) - $rozg[rozgrywki]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      $pobierz_gracza = mysql_query("select*from zawodnicy_2 where sezon='2005/2006'");
      echo "<tr><td class=tekst>Gracz meczu (tylko ze Śląska)</td><td>";
      echo "<select name=gracz_meczu>";
         echo "<option name=gracz_meczu value=\"\">Nie dotyczy</option>";
      while ($rekord = mysql_fetch_array($pobierz_gracza)) {
         echo "<option name=gracz_meczu value=\"$rekord[id]\">$rekord[imie] $rekord[nazwisko]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      echo "<tr><td class=tekst>Za co? (gracz meczu, max 255 znaków)</td><td class=tekst><input type=text name=gracz_meczu_czemu value=\"\"></td></tr>";
      echo "<tr><td class=tekst>Opis meczu</td><td class=tekst><textarea name=opis cols=60 rows=15></textarea></td></tr>";
      echo "<tr><td class=tekst>Zobacz też</td><td class=tekst><textarea name=zobacz_tez cols=60 rows=5></textarea></td></tr>";
      echo "<tr><td class=tekst>Dodatkowe (np. przełożenie meczu)</td><td class=tekst><input type=text name=dodatkowe size=30></td></tr>";
      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $opis = stripslashes($opis);
      $pobierz_logo = mysql_query("select logo from kluby where id='$druzyna1'");
      $czy1 = mysql_num_rows($pobierz_logo);
      if($czy1!=0) {
         $wez = mysql_fetch_array($pobierz_logo);
         $d1_logo = $wez[logo];
      } else {
         echo "Nie ma takiego klubu!";
      }
      $pobierz_logo2 = mysql_query("select logo from kluby where id='$druzyna2'");
      $czy2 = mysql_num_rows($pobierz_logo2);
      if($czy2 != 0) {
         $wez2 = mysql_fetch_array($pobierz_logo2);
         $d2_logo = $wez2[logo];
      } else {
         echo "Nie ma takiego klubu!";
      }
      if($d1_wynik < $d2_wynik) {
         $d1_punkty = 1;
         $d2_punkty = 2;
         $d1_w = 0;
         $d2_w = 1;
         $d1_p = 1;
         $d2_p = 0;
      } else {
         $d1_punkty = 2;
         $d2_punkty = 1;
         $d1_w = 1;
         $d2_w = 0;
         $d1_p = 0;
         $d2_p = 1;
      }
      $nowy = "insert into mecze (druzyna1, druzyna2, d1_kosze, d2_kosze, d1_logo, d2_logo, d1_wynik, d2_wynik, kwarty, opis, dzien, miesiac, rok, rozgrywki, sezon, kolejka, gracz_meczu, gracz_meczu_czemu, zobacz_tez, para, godzina, miejsce) values ('$druzyna1', '$druzyna2', '$d1_kosze', '$d2_kosze', '$d1_logo', '$d2_logo', '$d1_wynik', '$d2_wynik', '$kwarty', '$opis', '$dzien', '$miesiac', '$rok', '$rozgrywki', '$sezon', '$kolejka', '$gracz_meczu', '$gracz_meczu_czemu', '$zobacz_tez', '$para', '$godzina', '$miejsce')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowy mecz.<br><a href=mecze.php>Powrót</a><br>";
      } else {
         echo "Nie udało się dodać meczu.";
      }
      if(($d1_wynik != "--") && ($d1_wynik != "") && ($d2_wynik != "--") && ($d2_wynik != "")) {
         $wez_id = mysql_query("select max(id) from mecze");
         $wczytaj_id = mysql_fetch_row($wez_id);
         $nowy = "insert into tabele (id_meczu, klub, punkty, zdobyte, stracone, w, p, rozgrywki, kolejka, sezon) values ('$wczytaj_id[0]', '$druzyna1', '$d1_punkty', '$d1_wynik', '$d2_wynik', '$d1_w', '$d1_p', '$rozgrywki', '$kolejka', '$sezon')";
         $nowy_wpis = mysql_query($nowy);
         if($nowy_wpis) {
            echo "Dodałem nowy mecz do tabeli (1).<br><a href=mecze.php>Powrót</a><br>";
         } else {
            echo "Nie udało się dodać tabeli(1).";
         }
         $nowy = "insert into tabele (id_meczu, klub, punkty, zdobyte, stracone, w, p, rozgrywki, kolejka, sezon) values ('$wczytaj_id[0]', '$druzyna2', '$d2_punkty', '$d2_wynik', '$d1_wynik', '$d2_w', '$d2_p', '$rozgrywki', '$kolejka', '$sezon')";
         $nowy_wpis = mysql_query($nowy);
         if($nowy_wpis) {
            echo "Dodałem nowy mecz do tabeli (2).<br><a href=mecze.php>Powrót</a><br>";
         } else {
            echo "Nie udało się dodać tabeli (2).";
         }
      }
   }
}

function nast_poprz($czy, $akcja, $nastepny, $poprzedni) {
   if($czy!="tak") {
      $slask = mysql_query("select*from mecze where druzyna1='1' OR druzyna2='1'");
      $slask2 = mysql_query("select*from mecze where druzyna1='1' OR druzyna2='1'");
      $wez = mysql_fetch_array(mysql_query("select*from nast_poprz"));
      print "<form action=mecze.php>";
      print "<input type=hidden name=czy value=tak>";
      print "<input type=hidden name=akcja value=nast_poprz>";
      print "Następny mecz <select name=nastepny>";
      print "<option value=\"\">Brak";
      while ($rekord = mysql_fetch_array($slask)) {
         if($wez[nastepny] == $rekord[id]) {
            $to = " selected";
         } else {
            $to = "";
         }
         $druzyna1 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna1]'"));
         $druzyna2 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna2]'"));
         print "<option value=\"$rekord[id]\"$to>$druzyna1[nazwa] - $druzyna2[nazwa] ($rekord[dzien].$rekord[miesiac].$rekord[rok] r.)";
      }
      print "</select>";

      print "<br>Poprzedni mecz <select name=poprzedni>";
      print "<option value=\"\">Brak";
      while ($rekord = mysql_fetch_array($slask2)) {
         if($wez[poprzedni] == $rekord[id]) {
            $to = " selected";
         } else {
            $to = "";
         }
         $druzyna1 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna1]'"));
         $druzyna2 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna2]'"));
         print "<option value=\"$rekord[id]\"$to>$druzyna1[nazwa] - $druzyna2[nazwa] ($rekord[dzien].$rekord[miesiac].$rekord[rok] r.)";
      }
      print "</select>";
      print "<br><input type=submit value=Aktualizuj>";
      print "</form>";
   } else {
      $nowy_wpis = mysql_query("update nast_poprz set nastepny='$nastepny',poprzedni='$poprzedni'");
      if($nowy_wpis) {
         echo "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=javascript:history.back(-1)>Powrót</a><br>";
      } else {
         echo "Nie udało się.";
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $druzyna1, $druzyna2, $d1_kosze, $d2_kosze, $d1_wynik, $d2_wynik, $kwarty, $opis, $dzien, $miesiac, $rok, $rozgrywki, $sezon, $kolejka, $gracz_meczu, $gracz_meczu_czemu, $zobacz_tez, $dodatkowe, $para, $godzina, $miejsce, $ktore);
   break;
   case "nast_poprz":
   nast_poprz($czy, $akcja, $nastepny, $poprzedni);
   break;
   case "delete":
   usun($mecz);
   break;
   case "edit":
   edytuj($mecz, $tabela = "mecze", $druzyna1, $druzyna2, $d1_kosze, $d2_kosze, $d1_wynik, $d2_wynik, $kwarty, $opis, $dzien, $miesiac, $rok, $rozgrywki, $sezon, $kolejka, $gracz_meczu, $gracz_meczu_czemu, $zobacz_tez, $nastepny, $poprzedni, $dodatkowe, $para, $godzina, $miejsce);
   break;
   case "edit_now":
   edycja($mecz, "mecze", $druzyna1, $druzyna2, $d1_kosze, $d2_kosze, $d1_wynik, $d2_wynik, $kwarty, $opis, $dzien, $miesiac, $rok, $rozgrywki, $sezon, $kolejka, $gracz_meczu, $gracz_meczu_czemu, $zobacz_tez, $dodatkowe, $para, $godzina, $miejsce);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
