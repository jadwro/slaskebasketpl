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

function usun($stat, $tabela = "byligracze_stat") {
   $query = "delete from $tabela where id=\"$stat\"";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=byligracz_stat.php>Powrót...</a>";
   }
}

function edytuj($stat, $tabela = "byligracze_stat", $id_gracza, $przeciwnik, $rozgrywki, $wynik, $min, $pkt, $c2, $w2, $c3, $w3, $c1, $w1, $z, $a, $p, $s, $b, $f, $data) {
   if(!$stat) {
      $pobierz = mysql_query("select*from byligracze_stat");
      print "<table border=0>";
      print "<tr><td class=tekst width=150><b>Zawodnik</td><td class=tekst width=150><b>Rozgrywki</td><td class=tekst><b>Przeciwnik</b></td><td class=tekst><b>Akcja</td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         $gracz = mysql_fetch_array(mysql_query("select*from byligracze where id='$rekord[id_gracza]'"));
         print "<tr><td class=tekst>$gracz[imie] $gracz[nazwisko]</td><td class=tekst>$rekord[rozgrywki]</td><td class=tekst>$rekord[przeciwnik] ($rekord[data] r.)</td><td class=tekst><a href=\"byligracze_stat.php?stat=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"byligracze_stat.php?stat=$rekord[id]&akcja=delete\">Usuń</a></td></tr>";
      }
      print "</table>";
   } else {
   $query = "select*from $tabela where id=\"$stat\"";
   $wynik = mysql_query($query);
   print "<form action=\"byligracze_stat.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=stat value=\"$rekord[id]\">";

   $pobierz_gracz = mysql_query("select*from byligracze order by nazwisko");
   echo "<tr><td class=tekst>Gracz</td><td>";
   echo "<select name=id_gracza>";
   while ($rekord2 = mysql_fetch_array($pobierz_gracz)) {
      if($rekord2[id] == $rekord[id_gracza]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option value=\"$rekord2[id]\"$to>$rekord2[imie] $rekord2[nazwisko]</option>";
   }
   echo "</select>";
   echo "</td></tr>";

   $pobierz_rozg = mysql_query("select*from rozgrywki");
   echo "<tr><td class=tekst>Rozgrywki</td><td>";
   echo "<select name=rozgrywki>";
   while ($rekord2 = mysql_fetch_array($pobierz_rozg)) {
      if($rekord2[rozgrywki] == $rekord[rozgrywki]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option name=rozgrywki value=\"$rekord2[rozgrywki]\"$to>$rekord2[rozgrywki]</option>";
   }
   echo "</select>";
   echo "</td></tr>";

   print "<tr><td class=tekst>Data</td><td class=tekst><input type=text name=data value=\"$rekord[data]\"></td></tr>";
   print "<tr><td class=tekst>Przeciwnik</td><td class=tekst><input type=text name=przeciwnik value=\"$rekord[przeciwnik]\"></td></tr>";
   print "<tr><td class=tekst>Wynik</td><td class=tekst><input type=text name=wynik value=\"$rekord[wynik]\"></td></tr>";
   print "<tr><td><hr width=200 noshade></td></tr>";
   print "<tr><td class=tekst>Punkty</td><td class=tekst><input type=text name=pkt value=\"$rekord[pkt]\"></td></tr>";
   print "<tr><td class=tekst>Minuty</td><td class=tekst><input type=text name=min value=\"$rekord[min]\"></td></tr>";
   print "<tr><td class=tekst>Celne za 2</td><td class=tekst><input type=text name=c2 value=\"$rekord[c2]\"></td></tr>";
   print "<tr><td class=tekst>Wykonane za 2</td><td class=tekst><input type=text name=w2 value=\"$rekord[w2]\"></td></tr>";
   print "<tr><td class=tekst>Celne za 3</td><td class=tekst><input type=text name=c3 value=\"$rekord[c3]\"></td></tr>";
   print "<tr><td class=tekst>Wykonane za 3</td><td class=tekst><input type=text name=w3 value=\"$rekord[w3]\"></td></tr>";
   print "<tr><td class=tekst>Celne za 1</td><td class=tekst><input type=text name=c1 value=\"$rekord[c1]\"></td></tr>";
   print "<tr><td class=tekst>Wykonane za 1</td><td class=tekst><input type=text name=w1 value=\"$rekord[w1]\"></td></tr>";
   print "<tr><td class=tekst>Zbiórki</td><td class=tekst><input type=text name=z value=\"$rekord[z]\"></td></tr>";
   print "<tr><td class=tekst>Asysty</td><td class=tekst><input type=text name=a value=\"$rekord[a]\"></td></tr>";
   print "<tr><td class=tekst>Przechwyty</td><td class=tekst><input type=text name=p value=\"$rekord[p]\"></td></tr>";
   print "<tr><td class=tekst>Straty</td><td class=tekst><input type=text name=s value=\"$rekord[s]\"></td></tr>";
   print "<tr><td class=tekst>Bloki</td><td class=tekst><input type=text name=b value=\"$rekord[b]\"></td></tr>";
   print "<tr><td class=tekst>Faule</td><td class=tekst><input type=text name=f value=\"$rekord[f]\"></td></tr>";
   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($stat, $tabela = "byligracze_stat", $id_gracza, $przeciwnik, $rozgrywki, $wynik, $min, $pkt, $c2, $w2, $c3, $w3, $c1, $w1, $z, $a, $p, $s, $b, $f, $data) {
   $query = "update $tabela set id_gracza=\"$id_gracza\", przeciwnik='$przeciwnik', rozgrywki='$rozgrywki', wynik='$wynik', min='$min', pkt='$pkt', c2='$c2', w2='$w2', c3='$c3', w3='$w3', c1='$c1', w1='$w1', z='$z', a='$a', p='$p', s='$s', b='$b', f='$f', data='$data' where id='$stat'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=byligracz_stat.php>Powrót...</a>";
   }
}

function dopisz($czy, $akcja, $id_gracza, $przeciwnik, $rozgrywki, $wynik, $min, $pkt, $c2, $w2, $c3, $w3, $c1, $w1, $z, $a, $p, $s, $b, $f, $data) {
   if($czy!="tak") {
      echo "<form action=byligracze_stat.php method=post>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";

      $pobierz_gracz = mysql_query("select*from byligracze order by nazwisko");
      echo "<tr><td class=tekst>Gracz</td><td>";
      echo "<select name=id_gracza>";
      while ($rekord2 = mysql_fetch_array($pobierz_gracz)) {
         echo "<option value=\"$rekord2[id]\">$rekord2[imie] $rekord2[nazwisko]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_rozg = mysql_query("select*from rozgrywki");
      echo "<tr><td class=tekst>Rozgrywki</td><td>";
      echo "<select name=rozgrywki>";
      while ($rekord2 = mysql_fetch_array($pobierz_rozg)) {
         echo "<option name=rozgrywki value=\"$rekord2[rozgrywki]\">$rekord2[rozgrywki]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      print "<tr><td class=tekst>Data</td><td class=tekst><input type=text name=data></td></tr>";
      print "<tr><td class=tekst>Przeciwnik</td><td class=tekst><input type=text name=przeciwnik></td></tr>";
      print "<tr><td class=tekst>Wynik</td><td class=tekst><input type=text name=wynik></td></tr>";
      print "<tr><td><hr width=200 noshade></td></tr>";
      print "<tr><td class=tekst>Punkty</td><td class=tekst><input type=text name=pkt></td></tr>";
      print "<tr><td class=tekst>Minuty</td><td class=tekst><input type=text name=min></td></tr>";
      print "<tr><td class=tekst>Celne za 2</td><td class=tekst><input type=text name=c2></td></tr>";
      print "<tr><td class=tekst>Wykonane za 2</td><td class=tekst><input type=text name=w2></td></tr>";
      print "<tr><td class=tekst>Celne za 3</td><td class=tekst><input type=text name=c3></td></tr>";
      print "<tr><td class=tekst>Wykonane za 3</td><td class=tekst><input type=text name=w3></td></tr>";
      print "<tr><td class=tekst>Celne za 1</td><td class=tekst><input type=text name=c1></td></tr>";
      print "<tr><td class=tekst>Wykonane za 1</td><td class=tekst><input type=text name=w1></td></tr>";
      print "<tr><td class=tekst>Zbiórki</td><td class=tekst><input type=text name=z></td></tr>";
      print "<tr><td class=tekst>Asysty</td><td class=tekst><input type=text name=a></td></tr>";
      print "<tr><td class=tekst>Przechwyty</td><td class=tekst><input type=text name=p></td></tr>";
      print "<tr><td class=tekst>Straty</td><td class=tekst><input type=text name=s></td></tr>";
      print "<tr><td class=tekst>Bloki</td><td class=tekst><input type=text name=b></td></tr>";
      print "<tr><td class=tekst>Faule</td><td class=tekst><input type=text name=f></td></tr>";
      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $nowy = "insert into byligracze_stat (id_gracza, przeciwnik, rozgrywki, wynik, min, pkt, c2, w2, c3, w3, c1, w1, z, a, p, s, b, f, data) values ('$id_gracza', '$przeciwnik', '$rozgrywki', '$wynik', '$min', '$pkt', '$c2', '$w2', '$c3', '$w3', '$c1', '$w1', '$z', '$a', '$p', '$s', '$b', '$f', '$data')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowe statystyki.<br><a href=byligracz_stat.php>Powrót</a>";
      } else {
         echo "<br>Nie udało się dodać klubu.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $id_gracza, $przeciwnik, $rozgrywki, $wynik, $min, $pkt, $c2, $w2, $c3, $w3, $c1, $w1, $z, $a, $p, $s, $b, $f, $data);
   break;
   case "delete":
   usun($stat);
   break;
   case "edit":
   edytuj($stat, $tabela = "byligracze_stat", $id_gracza, $przeciwnik, $rozgrywki, $wynik, $min, $pkt, $c2, $w2, $c3, $w3, $c1, $w1, $z, $a, $p, $s, $b, $f, $data);
   break;
   case "edit_now":
   edycja($stat, "byligracze_stat", $id_gracza, $przeciwnik, $rozgrywki, $wynik, $min, $pkt, $c2, $w2, $c3, $w3, $c1, $w1, $z, $a, $p, $s, $b, $f, $data);
   break;
}
?>
</BODY>
</HTML>
