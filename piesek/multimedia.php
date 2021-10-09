<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<style type=text/css>
<!--
.klub {font-family:arial,verdana; font-size:11px};
//-->
</style>
</HEAD>
<?
require("polacz.htm");

function usun($mul, $tabela = "multimedia") {
   $query = "delete from $tabela where id='$mul'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=multimedia.php>Powrót...</a>";
   }
}

function edytuj($mul, $tabela, $adres, $opis, $kategoria, $obrazek) {
   if(!$mul) {
      $pobierz = mysql_query("select*from multimedia order by id desc");
      echo "<table border=1>";
      echo "<tr><td></td><td></td><td><b>Adres</b></td><td><b>Opis</b></td><td><b>Kategoria</b></td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         echo "<tr><td><a href=multimedia.php?akcja=edit&mul=$rekord[id]>edytuj</td><td><a href=multimedia.php?akcja=delete&mul=$rekord[id]>usuń</td><td>$rekord[adres]</td><td>$rekord[opis]</td><td>$rekord[kategoria]</td></tr>";
      }
      echo "</table>";
   } else {
      $query = "select*from $tabela where id='$mul'";
      $wynik = mysql_query($query);
      print "<form action=multimedia.php?mul=$mul method=post>";
      $rekord = mysql_fetch_array($wynik);
      print "<input type=hidden name=akcja value=edit_now>";
      print "Adres <input type=text name=adres value=\"$rekord[adres]\"><br>\n";
      print "Opis <input type=text name=opis value=\"$rekord[opis]\"><br>\n";

      $pobierz_kat = mysql_query("select*from multimedia_kat");
      echo "Kategoria";
      echo "<select name=kategoria>";
      while ($rekord2 = mysql_fetch_array($pobierz_kat)) {
         if($rekord2[id] == $rekord[kategoria]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option value=$rekord2[id]$to>$rekord2[kategoria]</option>";
      }
      echo "</select><br>";

      print "Obrazek (jesli galeria) <input type=text name=obrazek value=\"$rekord[obrazek]\"><br>\n";
      print "<input type=submit value=Zmień>\n";
      print "</form>\n";
   }
}

function edit_now($mul, $tabela, $adres, $opis, $kategoria, $obrazek) {
   $query = "update $tabela set adres='$adres', opis='$opis', kategoria='$kategoria', obrazek='$obrazek' where id='$mul'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=multimedia.php>Powrót...</a>";
   }
}

function wyswietl() {
   include("polacz.htm");
   $pobierz = mysql_query("select*from multimedia order by id desc");
   while ($rekord = mysql_fetch_array($pobierz)) {
      print "$rekord[adres] $rekord[opis] $rekord[dzial]";
   }
}

function dopisz($czy, $akcja, $adres, $opis, $kategoria, $obrazek) {
   if($czy!="tak") {
      echo "<form action=multimedia.php>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "Adres <input type=text name=adres>";
      echo "<br>Opis: <input typte=text name=opis>";

      $pobierz_kat = mysql_query("select*from multimedia_kat");
      echo "<br>Kategoria";
      echo "<select name=kategoria>";
      while ($rekord2 = mysql_fetch_array($pobierz_kat)) {
         echo "<option value=$rekord2[id]>$rekord2[kategoria]</option>";
      }
      echo "</select>";

      echo "<br>Obrazek (jesli galeria): <input typte=text name=obrazek>";
      echo "<br><input type=submit value=Dodaj>";
      echo "</form>";
   } else {
      $nowy = "insert into multimedia (adres, opis, kategoria, obrazek) values ('$adres', '$opis', '$kategoria', '$obrazek')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Adres: $adres<br>Dodałem nowy wpis.<br><a href=multimedia.php>Powrót</a>";
      } else {
         echo "Nie udało się dodać wpisu.";
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $adres, $opis, $kategoria, $obrazek);
   break;
   case "delete":
   usun($mul);
   break;
   case "edit":
   edytuj($mul, "multimedia", $adres, $opis, $kategoria, $obrazek);
   break;
   case "edit_now":
   edit_now($mul, "multimedia", $adres, $opis, $kategoria, $obrazek);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
