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

function usun($id, $tabela = "kolejki") {
   $query = "delete from $tabela where id='$id'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=kolejki.php>Powrót...</a>";
   }
}

function edytuj($id, $tabela = "kolejki", $numer, $dzien1, $dzien2, $miesiac, $rok, $sezon, $rozgrywki, $s) {
   if(!$id) {
      if(($s=="") || (!$s)) {
         $sez = "2005/2006";
      } else {
         $sez = "$s";
      }
      $pobierz = mysql_query("select*from kolejki where sezon='$sez' order by sezon,numer,rok,miesiac");
      print "<table border=0>";
      print "<tr><td><b>ID</td><td><b>Rozgrywki</td><td><b>Data</td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         $rozgrywki = mysql_fetch_array(mysql_query("select rozgrywki from rozgrywki where id='$rekord[rozgrywki]'"));
         echo "<tr><td>$rekord[id]</td><td>$rozgrywki[rozgrywki]</td><td>$rekord[dzien1]-$rekord[dzien2].$rekord[miesiac].$rekord[rok] ($rekord[numer]. kolejka)</td><td><a href=\"kolejki.php?id=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"kolejki.php?id=$rekord[id]&akcja=delete\">Usuń</a></td></tr>";
      }
      print "</table>";
   } else {
   $wynik = mysql_query("select*from $tabela where id='$id'");
   print "<form action=\"kolejki.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=id value=\"$rekord[id]\">";
   print "<tr><td class=tekst>Numer kolejki</td><td class=tekst><input type=text name=numer value=\"$rekord[numer]\"></td></tr>\n";
   $pobierz_rozg = mysql_query("select*from rozgrywki order by sezon desc");
   echo "<tr><td class=tekst>Rozgrywki</td><td>";
   echo "<select name=rozgrywki>";
   while ($rekord2 = mysql_fetch_array($pobierz_rozg)) {
      if($rekord2[id] == $rekord[rozgrywki]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option value=$rekord2[id]$to>$rekord2[rozgrywki] - $rekord2[sezon]</option>";
   }
   echo "</select>";
   echo "</td></tr>";
   print "<tr><td class=tekst>Sezon</td><td class=tekst><input type=text name=sezon value=\"$rekord[sezon]\"></td></tr>\n";
   print "<tr><td class=tekst>Data</td><td class=tekst><input type=text name=dzien1 value=\"$rekord[dzien1]\" size=1> - <input type=text name=dzien2 value=\"$rekord[dzien2]\" size=1> / <input type=text name=miesiac value=\"$rekord[miesiac]\" size=1> / <input type=text name=rok value=\"$rekord[rok]\" size=1> r.</td></tr>\n";
   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($id, $tabela = "kolejki", $numer, $dzien1, $dzien2, $miesiac, $rok, $sezon, $rozgrywki) {
   $wynik = mysql_query("update $tabela set numer='$numer', dzien1='$dzien1', dzien2='$dzien2', miesiac='$miesiac', rok='$rok', sezon='$sezon', rozgrywki='$rozgrywki' where id='$id'");
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=kolejki.php>Powrót...</a>";
   }
}

function wyswietl() {
   $pobierz = mysql_query("select*from kolejki order by sezon desc, numer");
   print "<table border=0>";
   print "<tr><td><b>ID</td><td><b>Rozgrywki</td><td><b>Kolejka</td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
      $rozgrywki = mysql_fetch_array(mysql_query("select rozgrywki from rozgrywki where id='$rekord[rozgrywki]'"));
      echo "<tr><td>$rekord[id]</td><td>$rozgrywki[rozgrywki]</td><td>$rekord[kolejka] ($rekord[dzien1]-$rekord[dzien2].$rekord[miesiac].$rekord[rok] r.)</td></tr>";
   }
   print "</table>";
}

function dopisz($czy, $akcja, $numer, $dzien1, $dzien2, $miesiac, $rok, $sezon, $rozgrywki) {
   if($czy!="tak") {
      echo "<form action=kolejki.php>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      print "<tr><td class=tekst>Numer kolejki</td><td class=tekst><input type=text name=numer></td></tr>\n";
      $pobierz_rozg = mysql_query("select*from rozgrywki order by sezon desc");
      echo "<tr><td class=tekst>Rozgrywki</td><td>";
      echo "<select name=rozgrywki>";
      while ($rekord2 = mysql_fetch_array($pobierz_rozg)) {
         echo "<option value=$rekord2[id]>$rekord2[rozgrywki] - $rekord2[sezon]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      print "<tr><td class=tekst>Sezon</td><td class=tekst><input type=text name=sezon></td></tr>\n";
      print "<tr><td class=tekst>Data</td><td class=tekst><input type=text name=dzien1 size=1> - <input type=text name=dzien2 size=1> / <input type=text name=miesiac size=1> / <input type=text name=rok size=1> r.</td></tr>\n";
      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $nowy = "insert into kolejki (numer, dzien1, dzien2, miesiac, rok, sezon, rozgrywki) values ('$numer', '$dzien1', '$dzien2', '$miesiac', '$rok', '$sezon', '$rozgrywki')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowa kolejke.<br><a href=javascript:history.back(-1)>Powrót</a>";
      } else {
         echo "Nie udało się dodać kolejki.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $numer, $dzien1, $dzien2, $miesiac, $rok, $sezon, $rozgrywki);
   break;
   case "delete":
   usun($id);
   break;
   case "edit":
   edytuj($id, $tabela = "kolejki", $numer, $dzien1, $dzien2, $miesiac, $rok, $sezon, $rozgrywki, $s);
   break;
   case "edit_now":
   edycja($id, "kolejki", $numer, $dzien1, $dzien2, $miesiac, $rok, $sezon, $rozgrywki);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
