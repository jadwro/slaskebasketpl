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

function usun($id, $tabela = "dzialy") {
   $query = "delete from $tabela where id='$id'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=rozgrywki.php>Powrót...</a>";
   }
}

function edytuj($id, $tabela = "dzialy", $nazwa, $adres, $miejsce) {
   if(!$id) {
      $pobierz = mysql_query("select*from dzialy");
      print "<table border=0>";
      print "<tr><td><b>ID</td><td width=100><b>Nazwa</td><td width=200><b>Adres</td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         echo "<tr><td>$rekord[id]</td><td>$rekord[nazwa]</td><td>$rekord[adres]</td><td><a href=\"dzialy.php?id=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"dzialy.php?id=$rekord[id]&akcja=delete\">Usuń</a></td></tr>";
      }
      print "</table>";
   } else {
   $wynik = mysql_query("select*from $tabela where id='$id'");
   print "<form action=\"dzialy.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=id value=\"$rekord[id]\">";
   print "<tr><td class=tekst>Nazwa</td><td class=tekst><input type=text name=nazwa value=\"$rekord[nazwa]\"></td></tr>\n";
   print "<tr><td class=tekst>Adres</td><td class=tekst><input type=text name=adres value=\"$rekord[adres]\"></td></tr>\n";
   print "<tr><td class=tekst>Miejsce</td><td class=tekst><input type=text name=miejsce value=\"$rekord[miejsce]\"></td></tr>\n";

   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($id, $tabela = "dzialy", $nazwa, $adres, $miejsce) {
   $wynik = mysql_query("update $tabela set nazwa='$nazwa', adres='$adres', miejsce='$miejsce' where id='$id'");
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br>ID dzialu <b>$nazwa</b> to <b>$id</b><br><a href=rozgrywki.php>Powrót...</a>";
   }
}

function wyswietl() {
   $pobierz = mysql_query("select*from dzialy");
   print "<table border=0>";
   print "<tr><td><b>ID</td><td width=100><b>Nazwa</td><td width=200><b>Adres</td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
      echo "<tr><td>$rekord[id]</td><td>$rekord[nazwa]</td><td>$rekord[adres]</td></tr>";
   }
   print "</table>";
}

function dopisz($czy, $akcja, $nazwa, $adres, $miejsce) {
   if($czy!="tak") {
      echo "<form action=dzialy.php>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<tr><td class=tekst>Nazwa</td><td class=tekst><input type=text name=nazwa></td></tr>";
      echo "<tr><td class=tekst>Adres</td><td class=tekst><input type=text name=adres></td></tr>";
      echo "<tr><td class=tekst>Miejsce</td><td class=tekst><input type=text name=miejsce></td></tr>";

      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $nowy = "insert into dzialy (nazwa, adres, miejsce) values ('$nazwa', '$adres', '$miejsce')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         $jakieid = mysql_query("select id from dzialy where nazwa = '$nazwa'");
         $id = mysql_fetch_array($jakieid);
         echo "Dodałem dział <b>$nazwa</b>.<br>ID działu to <b>$id[id]</b>.<br><a href=dzialy.php>Powrót</a>";
      } else {
         echo "Nie udało się dodać działu <b>$nazwa</b>.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $nazwa, $adres, $miejsce);
   break;
   case "delete":
   usun($id);
   break;
   case "edit":
   edytuj($id, $tabela = "dzialy", $nazwa, $adres, $miejsce);
   break;
   case "edit_now":
   edycja($id, "dzialy", $nazwa, $adres, $miejsce);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
