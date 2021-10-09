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

function usun($link, $tabela = "linki") {
   $query = "delete from $tabela where id='$link'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=linki.php>Powrót...</a>";
   }
}

function edytuj($link, $tabela, $adres, $opis, $dzial, $rodzaj) {
   if(!$link) {
      $pobierz = mysql_query("select*from linki order by id desc");
      echo "<table border=1>";
      echo "<tr><td></td><td></td><td><b>Adres</b></td><td><b>Opis</b></td><td><b>Dział</b></td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         echo "<tr><td><a href=linki.php?akcja=edit&link=$rekord[id]>edytuj</td><td><a href=linki.php?akcja=delete&link=$rekord[id]>usuń</td><td>$rekord[adres]</td><td>$rekord[nazwa]</td><td>$rekord[dzial]</td></tr>";
      }
      echo "</table>";
   } else {
      $query = "select*from $tabela where id='$link'";
      $wynik = mysql_query($query);
      print "<form action=linki.php?link=$link method=post>";
      $rekord = mysql_fetch_array($wynik);
      print "<input type=hidden name=akcja value=edit_now>";
      print "Adres <input type=text name=adres value=\"$rekord[adres]\"><br>\n";
      print "Opis <input type=text name=opis value=\"$rekord[opis]\"><br>\n";

      print "Rodzaj <select name=rodzaj>";
      if($rekord[rodzaj]!="") {
         $baner= " selected";
      } else {
         $baner = "";
      }
      print "<option value=\"\">Zwykły";
      print "<option value=\"baner\"$baner>Baner";
      print "</select><br>\n";

      $pobierz_kat = mysql_query("select*from linki_kat");
      echo "Kategoria";
      echo "<select name=dzial>";
      while ($rekord2 = mysql_fetch_array($pobierz_kat)) {
         if($rekord2[id] == $rekord[dzial]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option value=$rekord2[id]$to>$rekord2[kategoria]</option>";
      }
      echo "</select><br>";

      print "<input type=submit value=Zmień>\n";
      print "</form>\n";
   }
}

function edit_now($link, $tabela, $adres, $opis, $dzial, $rodzaj) {
   $query = "update $tabela set adres='$adres', opis='$opis', dzial='$dzial', rodzaj='$rodzaj' where id='$link'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=linki.php>Powrót...</a>";
   }
}

function wyswietl() {
   include("polacz.htm");
   $pobierz = mysql_query("select*from linki order by id desc");
   while ($rekord = mysql_fetch_array($pobierz)) {
      print "$rekord[adres] $rekord[opis] $rekord[dzial] $rekord[rodzaj]";
   }
}

function dopisz($czy, $akcja, $adres, $opis, $dzial, $rodzaj) {
   if($czy!="tak") {
      echo "<form action=linki.php>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "Adres (z http://): <input type=text name=adres>";
      echo "<br>Opis (lub adres banera): <input typte=text name=opis>";
      echo "<br>Rodzaj: <select name=rodzaj><option value=\"\">Zwykły<option value=baner>Baner</select>";

      $pobierz_kat = mysql_query("select*from linki_kat");
      echo "<br>Kategoria";
      echo "<select name=dzial>";
      while ($rekord2 = mysql_fetch_array($pobierz_kat)) {
         echo "<option value=$rekord2[id]>$rekord2[kategoria]</option>";
      }
      echo "</select>";

      echo "<br><input type=submit value=Dodaj>";
      echo "</form>";
   } else {
      $nowy = "insert into linki (adres, opis, dzial, rodzaj) values ('$adres', '$opis', '$dzial', '$rodzaj')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Adres: $adres<br>Dodałem nowy link.<br><a href=linki.php>Powrót</a>";
      } else {
         echo "Nie udało się dodać linku.";
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $adres, $opis, $dzial, $rodzaj);
   break;
   case "delete":
   usun($link);
   break;
   case "edit":
   edytuj($link, "linki", $adres, $opis, $dzial, $rodzaj);
   break;
   case "edit_now":
   edit_now($link, "linki", $adres, $opis, $dzial, $rodzaj);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
