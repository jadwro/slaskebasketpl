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

function usun($wyd, $tabela = "wydarzenia") {
   $query = "delete from $tabela where id='$wyd'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=aktualnosci.php>Powrót...</a>";
   }
}

function edytuj($wyd, $tabela = "wydarzenia", $tytul, $tresc, $obrazek, $tlo, $aktualne, $godzina, $dzien, $miesiac, $miesiac_num, $rok, $dzial) {
   global $ktory;
   $ktory2 = $ktory+30;
   $ktory3 = $ktory-30;
   if(!$wyd) {
      $pobierz = mysql_query("select*from wydarzenia order by id desc");
      echo "<table border=1>";
      echo "<tr><td></td><td></td><td><b>Tytuł</b></td><td><b>Tło</b></td><td><b>Aktualne</b></td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         echo "<tr><td><a href=wydarzenia.php?akcja=edit&wyd=$rekord[id]>edytuj</td><td><a href=wydarzenia.php?akcja=delete&wyd=$rekord[id]>usuń</td><td>$rekord[tytul]</td><td>$rekord[tlo]</td><td>$rekord[aktualne]</td></tr>";
      }
      echo "</table>";
      echo "<br><center>";
      if($ktory!=0) {
         echo "<a href=wydarzenia.php?ktory=$ktory3&akcja=edit>Nowsze</a> | <a href=wydarzenia.php?ktory=$ktory2&akcja=edit>Starsze</a>";
      } else {
         echo "Nowsze | <a href=wydarzenia.php?ktory=$ktory2&akcja=edit>Starsze</a>";
      }
      echo "</center>";
   } else {
      $query = "select*from $tabela where id='$wyd'";
      $wynik = mysql_query($query);
      print "<form action=wydarzenia.php?akcja=edit_now method=post>";
      $rekord = mysql_fetch_array($wynik);
      print "<input type=hidden name=wyd value=\"$rekord[id]\">";
      print "Tytul: <input type=text name=tytul value=\"$rekord[tytul]\"><br>\n";

      $pobierz_zdjecie = mysql_query("select*from zdjecia order by rodzaj,nazwa");
      echo "<tr><td class=tekst>Zdjęcie </td><td>";
      echo "<select name=obrazek>";
      echo "<option value=\"\">Brak";
      while ($rekord2 = mysql_fetch_array($pobierz_zdjecie)) {
         if($rekord2[id] == $rekord[obrazek]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option name=obrazek value=\"$rekord2[id]\"$to>$rekord2[rodzaj]: $rekord2[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      print "<br>Tresc:<br><textarea cols=60 rows=15 name=tresc>$rekord[tresc]</textarea><br>";

      $pobierz_dzial = mysql_query("select*from dzialy where nazwa != 'Nasi...'");
      echo "<tr><td class=tekst>Dział </td><td>";
      echo "<select name=dzial>";
      while ($rekord2 = mysql_fetch_array($pobierz_dzial)) {
         if($rekord2[nazwa] == $rekord[dzial]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option name=dzial value=\"$rekord2[nazwa]\"$to>$rekord2[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      print "<br>Tło: <input type=text name=tlo value=\"$rekord[tlo]\"><br>\n";
      print "Aktualne (tak lub nie): <input type=text name=aktualne value=\"$rekord[aktualne]\"><br>\n";

      print "<input type=submit value=Zmień>\n";
      print "</form>\n";
   }
}

function edycja($wyd, $tabela = "wydarzenia", $tytul, $tresc, $obrazek, $tlo, $aktualne, $godzina, $dzien, $miesiac, $miesiac_num, $rok, $dzial) {
   $query = "update $tabela set tytul='$tytul', tresc='$tresc', obrazek='$obrazek', tlo='$tlo', aktualne='$aktualne', dzial='$dzial' where id='$wyd'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=id=aktualnosci.php>Powrót...</a>";
   }
}

function wyswietl() {
   global $ktory;
   $ktory2 = $ktory+30;
   $ktory3 = $ktory-30;
   $pobierz = mysql_query("select*from wydarzenia order by id desc limit $ktory,$ktory2");
   echo "<table border=1>";
   echo "<tr><td><b>Tytuł</b></td><td><b>Zdjęcie</b></td><td><b></b></td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
      echo "<tr><td>$rekord[tytul]</td><td>$rekord[tlo]</td><td></td></tr>";
   }
   echo "</table>";
   echo "<br><center>";
   if($ktory!=0) {
      echo "<a href=wydarzenia.php?ktory=$ktory3>Nowsze</a> | <a href=wydarzenia.php?ktory=$ktory2>Starsze</a>";
   } else {
      echo "Nowsze | <a href=wydarzenia.php?ktory=$ktory2>Starsze</a>";
   }
   echo "</center>";
}

function dopisz($czy, $akcja, $tytul, $tresc, $obrazek, $tlo, $aktualne, $godzina, $dzien, $miesiac, $miesiac_num, $rok, $dzial) {
   if($czy!="tak") {
      $rok = date("Y",time());
      $miesiac = date("m",time());
      $miesiac_num = date("m",time());
      $dzien = date("d",time());
      $godzina = date("H:i",time());
      if($miesiac==1) {
         $miesiac="stycznia";
         } elseif($miesiac==2) {
         $miesiac="lutego";
         } elseif($miesiac==2) {
         $miesiac="lutego";
         } elseif($miesiac==3) {
         $miesiac="marca";
         } elseif($miesiac==4) {
         $miesiac="kwietnia";
         } elseif($miesiac==5) {
         $miesiac="maja";
         } elseif($miesiac==6) {
         $miesiac="czerwca";
         } elseif($miesiac==7) {
         $miesiac="lipca";
         } elseif($miesiac==8) {
         $miesiac="sierpnia";
         } elseif($miesiac==9) {
         $miesiac="września";
         } elseif($miesiac==10) {
         $miesiac="października";
         } elseif($miesiac==11) {
         $miesiac="listopada";
         } elseif($miesiac==12) {
         $miesiac="grudnia";
      }
      echo "<form action=wydarzenia.php method=post>";
      echo "<table border=0>";
      echo "<input type=hidden name=rok value=$rok>";
      echo "<input type=hidden name=miesiac value=$miesiac>";
      echo "<input type=hidden name=miesiac_num value=$miesiac_num>";
      echo "<input type=hidden name=dzien value=$dzien>";
      echo "<input type=hidden name=godzina value=$godzina>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<tr><td class=tekst><b>Tytuł wydarzenia</td><td class=tekst><input type=text name=tytul></td></tr>";
      echo "<tr><td class=tekst><b>Treść</td><td class=tekst><textarea cols=30 rows=10 name=tresc></textarea></td></tr>";

      $pobierz_dzial = mysql_query("select nazwa from dzialy where nazwa != 'Nasi...'");
      echo "<tr><td class=tekst><b>Dział</td><td>";
      echo "<select name=dzial>";
      while ($rekord = mysql_fetch_array($pobierz_dzial)) {
         echo "<option name=dzial value=\"$rekord[nazwa]\">$rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_zdj = mysql_query("select*from zdjecia order by rodzaj,nazwa");
      echo "<tr><td class=tekst><b>Zdjęcie</td><td>";
      echo "<select name=obrazek>";
      echo "<option name=obrazek value=\"\">Brak</option>";
      while ($rekord = mysql_fetch_array($pobierz_zdj)) {
         echo "<option name=obrazek value=$rekord[id]>$rekord[rodzaj]: $rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      echo "<tr><td class=tekst><b>Adres tła</td><td class=tekst><input type=text name=tlo>";
      echo "<tr><td class=tekst><b>Aktualne (tak lub nie)</td><td class=tekst><input type=text name=aktualne>";
      echo "<tr><td class=tekst><input type=submit value=Dodaj!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $wysw = "tak";
      $tytul = stripslashes($tytul);
      $tresc = stripslashes($tresc);
      $nowy = "insert into wydarzenia (tytul, tresc, obrazek, tlo, aktualne, godzina, dzien, miesiac, miesiac_num, rok, dzial) values ('$tytul', '$tresc', '$obrazek', '$tlo', '$aktualne', '$godzina', '$dzien', '$miesiac', '$miesiac_num', '$rok', '$dzial')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowe wydarzenie.<br><a href=wydarzenia.php>Powrót</a>";
      } else {
         echo "Nie udało się dodać newsa.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $tytul, $tresc, $obrazek, $tlo, $aktualne, $godzina, $dzien, $miesiac, $miesiac_num, $rok, $dzial);
   break;
   case "delete":
   usun($wyd);
   break;
   case "edit":
   edytuj($wyd, $tabela = "wydarzenia", $tytul, $tresc, $obrazek, $tlo, $aktualne, $godzina, $dzien, $miesiac, $miesiac_num, $rok, $dzial);
   break;
   case "edit_now":
   edycja($wyd, "wydarzenia", $tytul, $tresc, $obrazek, $tlo, $aktualne, $godzina, $dzien, $miesiac, $miesiac_num, $rok, $dzial);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
