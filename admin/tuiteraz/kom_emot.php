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

function usun($emot, $tabela = "kom_emot") {
   $query = "delete from $tabela where id='$emot'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=rozgrywki.php>Powrót...</a>";
   }
}

function edytuj($emot, $tabela = "kom_emot", $adres, $nazwa) {
   if(!$emot) {
      $pobierz = mysql_query("select*from kom_emot");
      print "<table border=0>";
      print "<tr><td><b>ID</td><td><b>Nazwa</td><td><b>Emotikon</td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         $rekord[nazwa] = str_replace("<","&#60;",$rekord[nazwa]);
         $rekord[nazwa] = str_replace(">","&#62;",$rekord[nazwa]);
         echo "<tr><td>$rekord[id]</td><td>$rekord[nazwa]</td><td><img src=http://grafika.slask.e-basket.pl/$rekord[adres]></td><td><a href=\"kom_emot.php?emot=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"kom_emot.php?emot=$rekord[id]&akcja=delete\">Usuń</a></td></tr>";
      }
      print "</table>";
   } else {
   $wynik = mysql_query("select*from $tabela where id='$emot'");
   print "<form action=\"kom_emot.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=emot2 value=\"$rekord[id]\">";
   print "<tr><td class=tekst>Nazwa</td><td class=tekst><input type=text name=nazwa value=\"$rekord[nazwa]\"></td></tr>\n";
   print "<tr><td class=tekst>Adres</td><td class=tekst><input type=text name=adres value=\"$rekord[adres]\"></td></tr>\n";
   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($emot, $tabela = "kom_emot", $emot2, $nazwa, $adres) {
   $wynik = mysql_query("update $tabela set adres='$adres', nazwa='$nazwa' where id='$emot2'");
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=kom_emot.php>Powrót...</a>";
   }
}

function wyswietl() {
   $pobierz = mysql_query("select*from rozgrywki");
   print "<table border=0>";
   print "<tr><td><b>ID</td><td><b>Nazwa</td><td><b>Emotikon</td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
      echo "<tr><td>$rekord[id]</td><td>$rekord[nazwa]</td><td><img src=http://grafika.slask.e-basket.pl/$rekord[adres]></td></tr>";
   }
   print "</table>";
}

function dopisz($czy, $akcja, $nazwa, $adres) {
   if($czy!="tak") {
      echo "<form action=kom_emot.php>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<tr><td class=tekst>Nazwa</td><td class=tekst><input type=text name=nazwa></td></tr>";
      echo "<tr><td class=tekst>Adres</td><td class=tekst><input type=text name=adres></td></tr>";
      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $nowy = "insert into kom_emot (nazwa, adres) values ('$nazwa', '$adres')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nową emotikone.<br><a href=kom_emot.php>Powrót</a>";
      } else {
         echo "Nie udało się dodać emotikony.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $nazwa, $adres);
   break;
   case "delete":
   usun($emot);
   break;
   case "edit":
   edytuj($emot, $tabela = "kom_emot", $nazwa, $adres);
   break;
   case "edit_now":
   edycja($emot, "kom_emot", $emot2, $nazwa, $adres);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
