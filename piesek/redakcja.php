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

function usun($kto, $tabela = "redakcja") {
   $query = "delete from $tabela where id='$kto'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się.";
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=redakcja.php>Powrót...</a>";
   }
}

function edytuj($kto, $tabela, $login, $haslo, $nazwa, $email, $gg, $tel, $funkcje) {
   if(!$kto) {
      $pobierz = mysql_query("select*from redakcja order by id desc");
      echo "<table border=1>";
      echo "<tr><td></td><td></td><td><b>Nazwa</b></td><td><b>Opis</b></td><td><b>GG</b></td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         echo "<tr><td><a href=redakcja.php?akcja=edit&kto=$rekord[id]>edytuj</td><td><a href=redakcja.php?akcja=delete&kto=$rekord[id]>usuń</td><td>$rekord[nazwa]</td><td>$rekord[funkcje]</td><td>$rekord[gg]</td></tr>";
      }
      echo "</table>";
   } else {
      $query = "select*from $tabela where id='$kto'";
      $wynik = mysql_query($query);
      print "<form action=redakcja.php?kto=$kto method=post>";
      $rekord = mysql_fetch_array($wynik);
      print "<input type=hidden name=akcja value=edit_now>";
      print "Login <input type=text name=login value=\"$rekord[login]\"><br>\n";
      print "Hasło <input type=text name=haslo value=\"$rekord[haslo]\"><br>\n";
      print "Imię i nazwisko <input type=text name=nazwa value=\"$rekord[nazwa]\"><br>\n";
      print "E-mail <input type=text name=email value=\"$rekord[email]\"><br>\n";
      print "#GG <input type=text name=gg value=\"$rekord[gg]\"><br>\n";
      print "Tel. <input type=text name=tel value=\"$rekord[tel]\"><br>\n";
      print "Funkcje <input type=text name=funkcje value=\"$rekord[funkcje]\"><br>\n";
      print "<input type=submit value=Zmień>\n";
      print "</form>\n";
   }
}

function edit_now($kto, $tabela, $login, $haslo, $nazwa, $email, $gg, $tel, $funkcje) {
   $query = "update $tabela set login='$login', haslo='$haslo', nazwa='$nazwa', email='$email', gg='$gg', tel='$tel', funkcje='$funkcje' where id='$kto'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie udało się :(<br>".mysql_error();
   } else {
      print "Udało się.<br>Poprawiłem ".mysql_affected_rows()." wiersz(y).<br><a href=multimedia.php>Powrót...</a>";
   }
}

function wyswietl() {
   include("polacz.htm");
   $pobierz = mysql_query("select*from redakcja order by id desc");
   while ($rekord = mysql_fetch_array($pobierz)) {
      print "$rekord[login] $rekord[haslo] $rekord[nazwa]";
   }
}

function dopisz($czy, $akcja, $login, $haslo, $nazwa, $email, $gg, $tel, $funkcje) {
   if($czy!="tak") {
      $dzien = date("d",time());
      $miesiac = date("m",time());
      $rok = date("Y",time());
      $data = "$rok-$miesiac-$dzien";
      echo "<form action=redakcja.php>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "Login <input type=text name=login>";
      echo "<br>Hasło: <input type=text name=haslo>";
      echo "<br>Imię i nazwisko: <input type=text name=nazwa>";
      echo "<br>E-mail: <input type=text name=email>";
      echo "<br>#GG: <input type=text name=gg>";
      echo "<br>Tel.: <input type=text name=tel>";
      echo "<br>Funkcje: <input type=text name=funkcje>";
      echo "<br><input type=submit value=Dodaj>";
      echo "</form>";
   } else {
      $dzien = date("d",time());
      $miesiac = date("m",time());
      $rok = date("Y",time());
      $data = "$rok-$miesiac-$dzien";

      $nowy = "insert into redakcja (login, haslo, nazwa, email, gg, tel, funkcje, dodany) values ('$login', '$haslo', '$nazwa', '$email', '$gg', '$tel', '$funkcje', '$data')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Dodałem nowy wpis.<br><a href=redakcja.php>Powrót</a>";
      } else {
         echo "Nie udało się dodać wpisu.";
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $login, $haslo, $nazwa, $email, $gg, $tel, $funkcje);
   break;
   case "delete":
   usun($kto);
   break;
   case "edit":
   edytuj($kto, "redakcja", $login, $haslo, $nazwa, $email, $gg, $tel, $funkcje);
   break;
   case "edit_now":
   edit_now($kto, "redakcja", $login, $haslo, $nazwa, $email, $gg, $tel, $funkcje);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
