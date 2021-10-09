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
function kategorie(s) {
var adres = s.options[s.selectedIndex].value;
window.location.href = adres;
}
-->
</SCRIPT>
</HEAD>
<?
require("polacz.htm");

function usun($kategorie, $tabela = "kategorie") {
   $query = "delete from $tabela where kategorie='$kategorie'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=kategorie.php>Powrót...</a>";
   }
}

function edytuj($kategorie, $tabela = "kategorie", $kategorie) {
   if(!$kategorie) {
      $pobierz = mysql_query("select*from kategorie");
      while ($rekord = mysql_fetch_array($pobierz)) {
         echo "kategorie: <b>$rekord[kategorie]</b> <a href=\"kategorie.php?&kategorie=$rekord[kategorie]&akcja=edit\">Edycja</a> / <a href=\"kategorie.php?&kategorie=$rekord[kategorie]&akcja=delete\">Usuń</a><br>";
      }
      print "</table>";
   } else {
   $query = "select*from $tabela where kategorie='$kategorie'";
   $wynik = mysql_query($query);
   print "<form action=\"kategorie.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=kategorie2 value=\"$rekord[kategorie]\">";
   print "<tr><td class=tekst>kategorie</td><td class=tekst><input type=text name=kategorie value=\"$rekord[kategorie]\"></td></tr>\n";
   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($kategorie, $tabela = "kategorie", $kategorie, $kategorie2) {
   $query = "update $tabela set kategorie='$kategorie' where kategorie='$kategorie2'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=kategorie.php>Powrót...</a>";
   }
}

function wyswietl() {
   $pobierz = mysql_query("select*from kategorie order by id");
   while ($rekord = mysql_fetch_array($pobierz)) {
      echo "kategorie: <b>$rekord[kategorie]</b> (id: $rekord[id])<br>";
   }
}

function dopisz($czy, $akcja, $kategorie) {
   if($czy!="tak") {
      echo "<form action=kategorie.php>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<tr><td class=tekst>kategorie</td><td class=tekst><input type=text name=kategorie></td></tr>";
      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $nowy = "insert into kategorie (kategorie) values ('$kategorie')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowy kategorie.<br><a href=kategorie.php>Powrót</a>";
      } else {
         echo "Nie udało się dodać kategorie.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $kategorie);
   break;
   case "delete":
   usun($kategorie);
   break;
   case "edit":
   edytuj($kategorie, $tabela = "kategorie", $kategorie);
   break;
   case "edit_now":
   edycja($kategorie, "kategorie", $kategorie, $kategorie2);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
