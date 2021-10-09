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

function usun($kom, $tabela = "komentarze") {
   $query = "delete from $tabela where id='$kom'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=komentarze.php>Powrót...</a>";
   }
}

function edytuj($kom, $tabela = "komentarze", $kto, $email, $tresc, $auth, $top) {
   $query = "select*from $tabela where id='$kom'";
   $wynik = mysql_query($query);
   print "<form action=komentarze.php?akcja=edit_now method=post>";
   $rekord = mysql_fetch_array($wynik);
   print "<input type=hidden name=kom value=\"$rekord[id]\">";
   print "Autor: <input type=text name=kto value=\"$rekord[kto]\">\n";
   print "<br>E-mail: <input type=text name=email value=$rekord[email]><br>\n";
   print "<br>Treść: <textarea rows=10 cols=30 name=tresc>$rekord[tresc]</textarea><br>\n";

   if($rekord[auth] == "tak") { $tak = " checked"; } else { $tak=""; }
   if($rekord[auth] == "nie") { $nie = " checked"; } else { $nie=""; }

   echo "<br>Autoryzacja <input type=radio name=auth value=nie$nie>Nie <input type=radio name=auth value=tak$tak>Tak<br>";

   if($rekord[top] == "tak") { $tak = " checked"; } else { $tak=""; }
   if($rekord[top] == "nie") { $nie = " checked"; } else { $nie=""; }

   echo "<br>TOP dnia <input type=radio name=top value=nie$nie>Nie <input type=radio name=top value=tak$tak>Tak<br>";

   print "<input type=submit value=Zmień>\n";
   print "</form>\n";
}

function edycja($kom, $tabela = "komentarze", $kto, $email, $tresc, $auth, $top) {
   $query = "update $tabela set kto='$kto', email='$email', tresc='$tresc', auth='$auth', top='$top' where id='$kom'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=id=komentarze.php>Powrót...</a>";
   }
}

function wyswietl() {
   global $rodzic;
   $pobierz = mysql_query("select*from komentarze where rodzic='$rodzic' order by id desc");
   echo "<table border=1>";
   echo "<tr><td><b>Autor</b></td><td><b>Auth.</b></td><td><b>Treść</b></td><td><b>Host</b></td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
      echo "<tr><td>$rekord[kto]</td><td>$rekord[auth]</td><td width=250>$rekord[tresc]</td><td>$rekord[ip]</td><td><a href=komentarze.php?akcja=edit&kom=$rekord[id]>Edycja</a> / <a href=komentarze.php?akcja=delete&kom=$rekord[id]>Usunięcie</a></td></tr>";
   }
   echo "</table>";
}

function autoryzuj() {
   global $akcja,$czy,$kom;
   if($czy!="tak") {
      $pobierz = mysql_query("select*from komentarze where auth=\"nie\" order by id desc");
      echo "<table border=1>";
      echo "<tr><td><b>Autor</b></td><td><b>E-mail</b></td><td><b>Treść</b></td><td><b>News</b></td><td><b>Host</b></td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         $news = mysql_fetch_array(mysql_query("select tytul from newsy where id='$rekord[rodzic]'"));
         echo "<tr><td>$rekord[kto]</td><td>$rekord[email]</td><td width=250>$rekord[tresc]</td><td>$news[tytul]</td><td>$rekord[ip]</td><td><a href=komentarze.php?akcja=edit&kom=$rekord[id]>Edycja</a> / <a href=komentarze.php?akcja=delete&kom=$rekord[id]>Usunięcie</a> / <a href=komentarze.php?akcja=autoryzuj&kom=$rekord[id]&czy=tak><b>Autoryzuj</b></a></td></tr>";
      }
      echo "</table>";
   } else {
      $query = mysql_query("update komentarze set auth=\"tak\" where id='$kom'");
      print "Komentarz został zautoryzowany (Poprawiłem: ".mysql_affected_rows()." linii).<br><a href=javascript:history.back(-1)>Powrót...</a>";
   }

}

switch($akcja) {
   case "delete":
   usun($kom);
   break;
   case "edit":
   edytuj($kom, $tabela = "komentarze", $kto, $email, $tresc, $auth, $top);
   break;
   case "edit_now":
   edycja($kom, "komentarze", $kto, $email, $tresc, $auth, $top);
   break;
   case "autoryzuj":
   autoryzuj();
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
