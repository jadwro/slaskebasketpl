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

function usun($kat, $tabela = "multimedia_kat") {
   $query = "delete from $tabela where kategoria='$kat'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=sezony.php>Powrót...</a>";
   }
}

function edytuj($kat, $tabela = "multimedia_kat", $kategoria, $rodzaj) {
   if(!$kat) {
      $pobierz = mysql_query("select*from multimedia_kat");
      while ($rekord = mysql_fetch_array($pobierz)) {
         echo "Kategoria: <b>$rekord[kategoria]</b> <a href=\"multimedia_kat.php?&kat=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"multimedia_kat.php?&kat=$rekord[id]&akcja=delete\">Usuń</a><br>";
      }
      print "</table>";
   } else {
   $query = "select*from $tabela where id='$kat'";
   $wynik = mysql_query($query);
   print "<form action=\"multimedia_kat.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=kat value=\"$rekord[id]\">";
   print "<tr><td class=tekst>Kategoria</td><td class=tekst><input type=text name=kategoria value=\"$rekord[kategoria]\"></td></tr>\n";

   print "<tr><td class=tekst>Rodzaj</td>";
   print "<td><select name=rodzaj>";
   if($rekord[rodzaj]!="") {
      $gal= " selected";
   } else {
      $gal = "";
   }
   print "<option value=\"\">Bez galerii";
   print "<option value=\"galeria\"$gal>Z galerią";
   print "</select></td></tr>";

   print "<tr><td class=tekst><input type=submit value=Zmień>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($kat, $tabela = "multimedia_kat", $kategoria, $rodzaj) {
   $query = "update $tabela set kategoria='$kategoria', rodzaj='$rodzaj' where id='$kat'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=sezony.php>Powrót...</a>";
   }
}

function wyswietl() {
   $pobierz = mysql_query("select*from multimedia_kat");
   while ($rekord = mysql_fetch_array($pobierz)) {
      echo "Kategoria: <b>$rekord[kategoria]</b> ($rekord[rodzaj]<br>";
   }
}

function dopisz($czy, $akcja, $kategoria, $rodzaj) {
   if($czy!="tak") {
      echo "<form action=multimedia_kat.php>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<tr><td class=tekst>Kategoria</td><td class=tekst><input type=text name=kategoria></td></tr>";

      echo "<tr><td class=tekst>Rodzaj</td>";
      echo "<td><select name=rodzaj>";
      echo "<option value=\"\">Bez galerii";
      echo "<option value=galeria>Z galerią";
      echo "</select></td></tr>";

      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $nowy = "insert into multimedia_kat (kategoria, rodzaj) values ('$kategoria','$rodzaj')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowa kategorie.<br><a href=multimedia_kat.php>Powrót</a>";
      } else {
         echo "Nie udało się dodać sezonu.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $kategoria, $rodzaj);
   break;
   case "delete":
   usun($sezon);
   break;
   case "edit":
   edytuj($kat, $tabela = "multimedia_kat", $kategoria, $rodzaj);
   break;
   case "edit_now":
   edycja($kat, "multimedia_kat", $kategoria, $rodzaj);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
