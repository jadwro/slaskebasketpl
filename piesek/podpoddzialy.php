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

function usun($id, $tabela = "podpoddzialy") {
   $query = "delete from $tabela where id='$id'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie uda?o si?.<br>".mysql_error();
   } else {
      print "Uda?o si?.<br>Poprawi?em ".mysql_affected_rows()." wiersz(y).<br><a href=rozgrywki.php>Powr?t...</a>";
   }
}

function edytuj($id, $tabela = "podpoddzialy", $nazwa, $adres, $poddzial, $miejsce) {
   if(!$id) {
      $pobierz = mysql_query("select*from podpoddzialy");
      print "<table border=0>";
      print "<tr><td><b>ID</td><td width=100><b>Nazwa</td><td width=200><b>Adres</td><td><b>Poddzia?</td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         echo "<tr><td>$rekord[id]</td><td>$rekord[nazwa]</td><td>$rekord[adres]</td><td>$rekord[poddzial]</td><td><a href=\"podpoddzialy.php?id=$rekord[id]&akcja=edit\">Edycja</a> / <a href=\"podpoddzialy.php?id=$rekord[id]&akcja=delete\">Usu?</a></td></tr>";
      }
      print "</table>";
   } else {
   $wynik = mysql_query("select*from $tabela where id='$id'");
   print "<form action=\"podpoddzialy.php?akcja=edit_now\" method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<table border=0>";
   print "<input type=hidden name=id value=\"$rekord[id]\">";
   print "<tr><td class=tekst>Nazwa</td><td class=tekst><input type=text name=nazwa value=\"$rekord[nazwa]\"></td></tr>\n";
   print "<tr><td class=tekst>Adres</td><td class=tekst><input type=text name=adres value=\"$rekord[adres]\"></td></tr>\n";
   print "<tr><td class=tekst>Miejsce</td><td class=tekst><input type=text name=miejsce value=\"$rekord[miejsce]\"></td></tr>\n";

   $pobierz_poddzial = mysql_query("select*from poddzialy");
   echo "<tr><td class=tekst>Poddzia?</td><td>";
   echo "<select name=poddzial>";
   while ($rekord2 = mysql_fetch_array($pobierz_poddzial)) {
      if($rekord2[id] == $rekord[poddzial]) {
         $to = " selected";
      } else {
         $to = "";
      }
      echo "<option name=poddzial value=$rekord2[id]$to>$rekord2[nazwa] (ID: $rekord2[id])</option>";
   }
   echo "</select>";
   echo "</td></tr>";

   print "<tr><td class=tekst><input type=submit value=Zmie?>\n";
   print "</table>\n";
   print "</form>\n";
   }
}

function edycja($id, $tabela = "podpoddzialy", $nazwa, $adres, $poddzial, $miejsce) {
   $wynik = mysql_query("update $tabela set nazwa='$nazwa', adres='$adres', poddzial='$poddzial', miejsce='$miejsce' where id='$id'");
   if(!$wynik) {
      print "Nie uda?o si? :(<br>".mysql_error();
   } else {
      print "Uda?o si?.<br>Poprawi?em ".mysql_affected_rows()." wiersz(y).<br>ID dzialu <b>$nazwa</b> to <b>$id</b><br><a href=rozgrywki.php>Powr?t...</a>";
   }
}

function wyswietl() {
   $pobierz = mysql_query("select*from podpoddzialy");
   print "<table border=0>";
   print "<tr><td><b>ID</td><td width=100><b>Nazwa</td><td width=200><b>Adres</td><td><b>Poddzia?</td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
      echo "<tr><td>$rekord[id]</td><td>$rekord[nazwa]</td><td>$rekord[adres]</td><td>$rekord[poddzial]</td></tr>";
   }
   print "</table>";
}

function dopisz($czy, $akcja, $nazwa, $adres, $poddzial, $miejsce) {
   if($czy!="tak") {
      $ktory = mysql_query("select max(id) as id from podpoddzialy");
      $ktory1 = mysql_fetch_array($ktory);
      $ktory2 = $ktory1[id]+1;
      print "ID tego podpoddzia?u b?dzie oznaczone numerem: $ktory2";
      echo "<form action=podpoddzialy.php>";
      echo "<table border=0>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<tr><td class=tekst>Nazwa</td><td class=tekst><input type=text name=nazwa></td></tr>";
      echo "<tr><td class=tekst>Adres</td><td class=tekst><input type=text name=adres></td></tr>";
      echo "<tr><td class=tekst>Miejsce</td><td class=tekst><input type=text name=miejsce></td></tr>";

      $pobierz_poddzial = mysql_query("select*from poddzialy");
      echo "<tr><td class=tekst>Poddzia?</td><td>";
      echo "<select name=poddzial>";
      while ($rekord = mysql_fetch_array($pobierz_poddzial)) {
         echo "<option name=poddzial value=$rekord[id]>$rekord[nazwa] (ID: $rekord[id])</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      echo "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $nowy = "insert into podpoddzialy (nazwa, adres, poddzial, miejsce) values ('$nazwa', '$adres', '$poddzial', '$miejsce')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         $jakieid = mysql_query("select id from podpoddzialy where nazwa = '$nazwa'");
         $id = mysql_fetch_array($jakieid);
         echo "Doda?em do poddzia?u <b>$dzial</b> podpoddzia? <b>$nazwa</b>.<br>ID podpoddzia?u to <b>$id[id]</b>.<br><a href=podpoddzialy.php>Powr?t</a>";
      } else {
         echo "Nie uda?o si? doda? podpoddzia?u <b>$nazwa</b>.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $nazwa, $adres, $poddzial, $miejsce);
   break;
   case "delete":
   usun($id);
   break;
   case "edit":
   edytuj($id, $tabela = "podpoddzialy", $nazwa, $adres, $poddzial, $miejsce);
   break;
   case "edit_now":
   edycja($id, "podpoddzialy", $nazwa, $adres, $poddzial, $miejsce);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
