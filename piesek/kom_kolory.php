<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<LINK href="../techniczne/style.css" type=text/css rel=stylesheet>
<style type=text/css>
<!--
.klub {font-family:arial,verdana; font-size:11px};
//-->
</style>
</HEAD>
<BODY>
<?
require("polacz.htm");

print "<font class=tyt_admin><center>Komentarze - kolory</center></font><br><br>";

function wyswietl() {
   $pobierz = mysql_query("select*from kom_kolory order by kod");
   print "<table border=0 cellspacing=0 cellpadding=0>";
   while($rekord = mysql_fetch_array($pobierz)) {
      print "<tr><td width=150 height=15 bgcolor=$rekord[kod]></td><td width=300 class=tekst bgcolor=#eeeeee><center><b><font color=$rekord[kod]>$rekord[nazwa]</font></b></center></td><td class=tekst>ID: <font color=$rekord[kod] width=100><b>$rekord[id]</b></font></td><td align=right width=150><font class=tekst>$rekord[kod]</font></td><td align=right width=150><a class=czarny href=kom_kolory.php?akcja=edytuj&kolor=$rekord[id]>Edycja</a> / <a class=czarny href=kom_kolory.php?akcja=delete&kolor=$rekord[id]>Usunięcie</a></td></tr>";
   }
   print "</table>";
}

function add($kolor,$id,$nazwa,$kod,$dod,$dodno) {
   if(!$dod) {
      print "<form action=kom_kolory.php>";
      print "<input type=hidden name=akcja value=dopisz>";
      print "<input type=hidden name=dod value=no>";
      print "<table border=0 cellspacing=0 cellpadding=0>";
      print "<tr><td width=200 class=tekst>Nazwa koloru</td><td><input class=szukaj type=text name=nazwa></td></tr>";
      print "<tr><td width=200 class=tekst>Kod koloru (np. #ffffff)</td><td><input class=szukaj type=text name=kod></td></tr>";
      print "<tr><td><input class=szukaj type=submit value=\"Sprawdź kolor\"></td></tr>";
      print "</table>";
      print "</form>";
   }
   if(($dod=="no") || ($dodno=="true")) {
      print "<form action=kom_kolory.php name=drugacz>";
      print "<input type=hidden name=akcja value=dopisz>";
      print "<table border=0 cellspacing=0>";
      print "<tr><td width=150 height=15 bgcolor=$kod></td><td width=300 class=tekst><center><b><font color=$rekord[kod]><input type=text class=szukaj value=$nazwa name=nazwa></font></b></center></td><td align=right width=150><font class=tekst><input type=text name=kod class=szukaj value=$kod></font></td></tr>";
      print "<tr><td colspan=3 with=100% class=tekst bgcolor=#eeeeee><center><font color=$kod><b>Przykładowy nick</b></font></center></td></tr>";
      print "<tr><td><button type=submit class=szukaj name=dodno onclick=\"this.value='true'\">Sprawdź</button> <button type=submit class=szukaj name=dod onclick=\"this.value='yes'\">Zatwierdź</button></td></tr>";
      print "</table>";
      print "</form>";
   } elseif($dod=="yes") {
      $dodaj = mysql_query("insert into kom_kolory (id,nazwa,kod) values ('$id', '$nazwa', '$kod')");
      if($dodaj) {
         print "Kolor dodany. <br><a href=kom_kolory.php>Powrót...</a>";
      } else {
         print "Coś nie tak...";
      }
   }
}

function usun($kolor, $tabela = "kom_kolory") {
   $query = "delete from $tabela where id='$kolor'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=kom_kolory.php>Powrót...</a>";
   }
}

switch($akcja) {
   case "dopisz":
   add($kolor,$id,$nazwa,$kod,$dod,$dodno);
   break;
   case "delete":
   usun($kolor);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
