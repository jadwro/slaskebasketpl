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

function usun($kat, $tabela = "galeria_kat") {
   $query = "delete from $tabela where id='$kat'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=sezony.php>Powrót...</a>";
   }
}

function edytuj($kat, $tabela = "galeria_kat", $nazwa, $rozgrywki) {
   if(!$kat) {
      $pobierz = mysql_query("select*from galeria_kat");
      while ($rekord = mysql_fetch_array($pobierz)) {
         echo "$rekord[nazwa] <a href=\"galeria_kat.php?&kat=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"galeria_kat.php?&kat=$rekord[id]&akcja=delete\">Usuń</a><br>";
      }
      print "</table>";
   } else {
   $query = "select*from $tabela where id='$kat'";
   $wynik = mysql_query($query);
   print "<form action=\"galeria_kat.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=kat value=\"$rekord[id]\">";
   print "<tr><td class=tekst>Nazwa</td><td class=tekst><input type=text name=nazwa value=\"$rekord[nazwa]\"></td></tr>\n";
   print "<tr><td class=tekst>Rozgrywki (plk, euroliga, inne)</td><td class=tekst><input type=text name=rozgrywki value=\"$rekord[rozgrywki]\"></td></tr>\n";
   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($kat, $tabela = "galeria_kat", $nazwa, $rozgrywki) {
   $query = "update $tabela set nazwa='$nazwa', rozgrywki='$rozgrywki' where id='$kat'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=sezony.php>Powrót...</a>";
   }
}

function wyswietl() {
   $pobierz = mysql_query("select*from sezony");
   while ($rekord = mysql_fetch_array($pobierz)) {
      echo "Kategoria: <b>$rekord[nazwa]</b> (id: $rekord[id], $rekord[rozgrywki])<br>";
   }
}

function dopisz($czy, $akcja, $nazwa, $rozgrywki) {
   if($czy!="tak") {
      echo "<form action=galeria_kat.php>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<tr><td class=tekst>Nazwa galerii</td><td class=tekst><input type=text name=nazwa></td></tr>";
      echo "<tr><td class=tekst>Rozgrywki (plk, euroliga, inne)</td><td class=tekst><input type=text name=rozgrywki></td></tr>";
      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $nowy = "insert into galeria_kat (nazwa, rozgrywki) values ('$nazwa', '$rozgrywki')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowa kategorie.<br><a href=linki_kat.php>Powrót</a>";
      } else {
         echo "Nie udało się dodać sezonu.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $nazwa, $rozgrywki);
   break;
   case "delete":
   usun($kat);
   break;
   case "edit":
   edytuj($kat, $tabela = "galeria_kat", $nazwa, $rozgrywki);
   break;
   case "edit_now":
   edycja($kat, "galeria_kat", $nazwa, $rozgrywki);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
