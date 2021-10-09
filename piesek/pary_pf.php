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

function usun($para, $tabela = "pary_pf") {
   $query = "delete from $tabela where id='$para'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=pary_pf.php>Powrót...</a>";
   }
}

function edytuj($para, $tabela = "pary_pf", $druzyna1, $druzyna2, $d1_stan, $d2_stan, $rozgrywki) {
   if(!$para) {
      $pobierz = mysql_query("select*from pary_pf");
      while ($rekord = mysql_fetch_array($pobierz)) {
         $klub1 = mysql_fetch_array(mysql_query("select*from kluby where id='$rekord[druzyna1]'"));
         $klub2 = mysql_fetch_array(mysql_query("select*from kluby where id='$rekord[druzyna2]'"));
         $rozg = mysql_fetch_array(mysql_query("select*from rozgrywki where id='$rekord[rozgrywki]'"));
         echo "$klub1[nazwa] - $klub2[nazwa] <b>$rekord[d1_stan]:$rekord[d2_stan]</b> - $rozg[rozgrywki] <a href=\"pary_pf.php?para=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"pary_pf.php?para=$rekord[id]&akcja=delete\">Usuń</a><br>";
      }
      print "</table>";
   } else {
   $query = "select*from $tabela where id='$para'";
   $wynik = mysql_query($query);
   print "<form action=\"pary_pf.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=para value=\"$rekord[id]\">";

   $pobierz_klub = mysql_query("select*from kluby order by nazwa");
   echo "<tr><td class=tekst>Drużyna 1</td><td>";
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
   echo "<tr><td class=tekst>Drużyna 2</td><td>";
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

   echo "<tr><td class=tekst>Stan rywalizacji</td><td class=tekst><input type=text name=d1_stan size=1 value=$rekord[d1_stan]> : <input size=1 type=text name=d2_stan value=$rekord[d2_stan]></td></tr>";

   $pobierz_rozg = mysql_query("select*from rozgrywki");
   echo "<tr><td class=tekst>Rozgrywki</td><td>";
   echo "<select name=rozgrywki>";
   while ($rekord2 = mysql_fetch_array($pobierz_rozg)) {
      if($rekord2[id] == $rekord[rozgrywki]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option name=rozgrywki value=\"$rekord2[id]\"$to>$rekord2[rozgrywki]</option>";
   }
   echo "</select>";
   echo "</td></tr>";

   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($para, $tabela = "pary_pf", $druzyna1, $druzyna2, $d1_stan, $d2_stan, $rozgrywki) {
   $query = "update $tabela set druzyna1='$druzyna1', druzyna2='$druzyna2', d1_stan='$d1_stan', d2_stan='$d2_stan', rozgrywki='$rozgrywki' where id='$para'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=pary_pf.php>Powrót...</a>";
   }
}

function wyswietl() {
   $pobierz = mysql_query("select*from pary_pf");
   while ($rekord = mysql_fetch_array($pobierz)) {
      $klub = mysql_fetch_array(mysql_query("select*from kluby where id='$rekord[id]'"));
      echo "$klub[druzyna1] - $klub[druzyna2] <b>$rekord[d1_stan]:$rekord[d2_stan]</b> - $rekord[rozgrywki])<br>";
   }
}

function dopisz($czy, $akcja, $druzyna1, $druzyna2, $d1_stan, $d2_stan, $rozgrywki) {
   if($czy!="tak") {
      echo "<form action=pary_pf.php>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";

      $pobierz_klub = mysql_query("select*from kluby order by nazwa");
      echo "<tr><td class=tekst>Drużyna 1</td><td>";
      echo "<select name=druzyna1>";
      while ($rekord = mysql_fetch_array($pobierz_klub)) {
         echo "<option name=druzyna1 value=\"$rekord[id]\">$rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_klub2 = mysql_query("select*from kluby order by nazwa");
      echo "<tr><td class=tekst>Drużyna 2</td><td>";
      echo "<select name=druzyna2>";
      while ($rekord = mysql_fetch_array($pobierz_klub2)) {
         echo "<option name=druzyna2 value=\"$rekord[id]\">$rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      echo "<tr><td class=tekst>Stan rywalizacji</td><td class=tekst><input type=text name=d1_stan size=1> : <input size=1 type=text name=d2_stan></td></tr>";

      $pobierz_rozg = mysql_query("select*from rozgrywki");
      echo "<tr><td class=tekst>Rozgrywki</td><td>";
      echo "<select name=rozgrywki>";
      while ($rekord = mysql_fetch_array($pobierz_rozg)) {
         echo "<option name=rozgrywki value=\"$rekord[id]\">$rekord[rozgrywki]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $nowy = "insert into pary_pf (druzyna1, druzyna2, d1_stan, d2_stan, rozgrywki) values ('$druzyna1', '$druzyna2', '$d1_stan', '$d2_stan', '$rozgrywki')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowa parę.<br><a href=pary_pf.php>Powrót</a>";
      } else {
         echo "Nie udało się dodać pary.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $druzyna1, $druzyna2, $d1_stan, $d2_stan, $rozgrywki);
   break;
   case "delete":
   usun($para);
   break;
   case "edit":
   edytuj($para, $tabela = "pary_pf", $druzyna1, $druzyna2, $d1_stan, $d2_stan, $rozgrywki);
   break;
   case "edit_now":
   edycja($para, "pary_pf", $druzyna1, $druzyna2, $d1_stan, $d2_stan, $rozgrywki);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
