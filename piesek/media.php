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

function usun($med, $tabela = "media") {
   $query = "delete from $tabela where id='$med'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=multimedia.php>Powrót...</a>";
   }
}

function edytuj($med, $tabela, $adres, $opis, $strona) {
   if(!$med) {
      $pobierz = mysql_query("select*from media order by id desc");
      echo "<table border=1>";
      echo "<tr><td></td><td></td><td><b>Adres</b></td><td><b>Opis</b></td><td><b>Strona</b></td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         echo "<tr><td><a href=media.php?akcja=edit&med=$rekord[id]>edytuj</td><td><a href=media.php?akcja=delete&med=$rekord[id]>usuń</td><td>$rekord[adres]</td><td>$rekord[opis]</td><td>$rekord[strona]</td></tr>";
      }
      echo "</table>";
   } else {
      $query = "select*from $tabela where id='$med'";
      $wynik = mysql_query($query);
      print "<form action=media.php?med=$med method=post>";
      $rekord = mysql_fetch_array($wynik);
      print "<input type=hidden name=akcja value=edit_now>";
      print "Adres (z http://) <input type=text name=adres value=\"$rekord[adres]\"><br>\n";
      print "Opis (np. wywiad z M. Zielińskim) <input type=text name=opis value=\"$rekord[opis]\"><br>\n";

      print "Strona (np. gazeta.pl; bez http://) <input type=text name=strona value=\"$rekord[strona]\"><br>\n";
      print "<input type=submit value=Zmień>\n";
      print "</form>\n";
   }
}

function edit_now($med, $tabela, $adres, $opis, $strona) {
   $query = "update $tabela set adres='$adres', opis='$opis', strona='$strona' where id='$med'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=media.php>Powrót...</a>";
   }
}

function wyswietl() {
   include("polacz.htm");
   $pobierz = mysql_query("select*from media order by id desc");
   while ($rekord = mysql_fetch_array($pobierz)) {
      print "$rekord[adres]; $rekord[opis]; $rekord[strona];";
   }
}

function dopisz($czy, $akcja, $adres, $opis, $strona) {
   if($czy!="tak") {
      echo "<form action=media.php>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "Adres (z http://) <input type=text name=adres>";
      echo "<br>Opis (np. Wywiad z M. Zielińskim): <input typte=text name=opis>";
      echo "<br>Strona (np. gazeta.pl; bez http://): <input typte=text name=strona>";
      echo "<br><input type=submit value=Dodaj>";
      echo "</form>";
   } else {
      $nowy = "insert into media (adres, opis, strona) values ('$adres', '$opis', '$strona')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Adres: $adres<br>Dodałem nowy wpis.<br><a href=media.php>Powrót</a>";
      } else {
         echo "Nie udało się dodać wpisu.";
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $adres, $opis, $strona);
   break;
   case "delete":
   usun($med);
   break;
   case "edit":
   edytuj($med, "media", $adres, $opis, $strona);
   break;
   case "edit_now":
   edit_now($med, "media", $adres, $opis, $strona);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
