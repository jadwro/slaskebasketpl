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

function usun($sezon, $tabela = "sezony") {
   $query = "delete from $tabela where sezon='$sezon'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie uda�o si�.<br>".mysql_error();
   } else {
      print "Uda�o si�.<br>Poprawi�em ".mysql_affected_rows()." wiersz(y).<br><a href=sezony.php>Powr�t...</a>";
   }
}

function edytuj($sezon, $tabela = "sezony", $sezon) {
   if(!$sezon) {
      $pobierz = mysql_query("select*from sezony");
      while ($rekord = mysql_fetch_array($pobierz)) {
         echo "Sezon: <b>$rekord[sezon]</b> <a href=\"sezony.php?&sezon=$rekord[sezon]&akcja=edit\">Edycja</a> / <a href=\"sezony.php?&sezon=$rekord[sezon]&akcja=delete\">Usu�</a><br>";
      }
      print "</table>";
   } else {
   $query = "select*from $tabela where sezon='$sezon'";
   $wynik = mysql_query($query);
   print "<form action=\"sezony.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=sezon2 value=\"$rekord[sezon]\">";
   print "<tr><td class=tekst>Sezon</td><td class=tekst><input type=text name=sezon value=$rekord[sezon]></td></tr>\n";
   print "<tr><td class=tekst><input type=submit value=Zmie�>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($sezon, $tabela = "sezony", $sezon, $sezon2) {
   $query = "update $tabela set sezon='$sezon' where sezon='$sezon2'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie uda�o si� :(<br>".mysql_error();
   } else {
      print "Uda�o si�.<br>Poprawi�em ".mysql_affected_rows()." wiersz(y).<br><a href=sezony.php>Powr�t...</a>";
   }
}

function wyswietl() {
   $pobierz = mysql_query("select*from sezony");
   while ($rekord = mysql_fetch_array($pobierz)) {
      echo "Sezon: <b>$rekord[sezon]</b> (id: $rekord[id])<br>";
   }
}

function dopisz($czy, $akcja, $sezon) {
   if($czy!="tak") {
      echo "<form action=sezony.php>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<tr><td class=tekst>Sezon</td><td class=tekst><input type=text name=sezon></td></tr>";
      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $nowy = "insert into sezony (sezon) values ('$sezon')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Doda�em nowy sezon.<br><a href=sezony.php>Powr�t</a>";
      } else {
         echo "Nie uda�o si� doda� sezonu.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $sezon);
   break;
   case "delete":
   usun($sezon);
   break;
   case "edit":
   edytuj($sezon, $tabela = "sezony", $sezon);
   break;
   case "edit_now":
   edycja($sezon, "sezony", $sezon, $sezon2);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
