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

function usun($news, $tabela = "newsy") {
   $query = "delete from $tabela where id='$news'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie uda�o si�.";
   } else {
      print "Uda�o si�.<br>Poprawi�em ".mysql_affected_rows()." wiersz(y).<br><a href=aktualnosci.php>Powr�t...</a>";
   }
}

function edytuj($news, $tabela = "newsy", $tytul, $kto, $email, $tresc, $rok, $miesiac, $miesiac_num, $dzien, $godzina, $dzial, $zdjecie, $zrodlo, $rodzaj, $zawodnik, $zawodnik2, $zawodnik3, $druzyna, $top, $ciekawe, $sezon, $autor) {
   global $ktory, $user, $haslo_user;
   $ktory2 = $ktory+30;
   $ktory3 = $ktory-30;
   if(!$news) {
      $pobierz = mysql_query("select*from newsy order by id desc limit $ktory,$ktory2");
      echo "<table border=1>";
      echo "<tr><td></td><td></td><td></td><td><b>Tytu�</b></td><td><b>Zdj�cie</b></td><td><b>Autor</b></td></tr>";
      while ($rekord = mysql_fetch_array($pobierz)) {
         $autor = mysql_fetch_array(mysql_query("select*from redakcja where id='$rekord[autor]'"));
         echo "<tr><td><a href=glowna.php?akcja=edit&news=$rekord[id]&user=$user&haslo_user=$haslo_user&plik=1>edytuj</td><td></td><td><a href=glowna.php?rodzic=$rekord[id]&user=$user&haslo_user=$haslo_user&plik=3>kom.</a></td><td>$rekord[tytul] [$rekord[kliki]]</td><td>$rekord[zdjecie]</td><td>$autor[login]</td></tr>";
      }
      echo "</table>";
      echo "<br><center>";
      if($ktory!=0) {
         echo "<a href=glowna.php?ktory=$ktory3&akcja=edit&user=$user&haslo_user=$haslo_user&plik=1>Nowsze</a> | <a href=glowna.php?ktory=$ktory2&akcja=edit&user=$user&haslo_user=$haslo_user&plik=1>Starsze</a>";
      } else {
         echo "Nowsze | <a href=glowna.php?ktory=$ktory2&akcja=edit&user=$user&haslo_user=$haslo_user&plik=1>Starsze</a>";
      }
      echo "</center>";
   } else {
      print "<table border=0>";
      $query = "select*from $tabela where id='$news'";
      $wynik = mysql_query($query);
      print "<form action=aktualnosci.php?akcja=edit_now method=post>";
      $rekord = mysql_fetch_array($wynik);
      print "<input type=hidden name=news value=\"$rekord[id]\">";
      print "<input type=hidden name=autor value=\"$rekord[user]\">";
      echo "<input type=hidden name=user value=$user>";
      echo "<input type=hidden name=haslo_user value=$haslo_user>";
      echo "<input type=hidden name=plik value=1>";
      print "<tr><td>Tytul: <input type=text name=tytul value=\"$rekord[tytul]\"></td></tr>";

      $pobierz_zdjecie = mysql_query("select*from zdjecia order by rodzaj");
      echo "<tr><td class=tekst>Zdj�cie ";
      echo "<select name=zdjecie>";
      echo "<option value=\"\">Brak";
      while ($rekord2 = mysql_fetch_array($pobierz_zdjecie)) {
         if($rekord2[id] == $rekord[zdjecie]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option name=zdjecie value=\"$rekord2[id]\"$to>$rekord2[rodzaj]: $rekord2[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      print "<tr><td>�r�d�o: <input type=text name=zrodlo value=\"$rekord[zrodlo]\"></td></tr>";
      print "<tr><td>Tresc:<br><textarea cols=60 rows=15 name=tresc>$rekord[tresc]</textarea></td></tr>";

      if($rekord[rodzaj] == "") { $nic = " checked"; } else { $nic=""; }
      if($rekord[rodzaj] == "Artyku�") { $art = " checked"; } else { $art=""; }
      if($rekord[rodzaj] == "Wywiad") { $wyw = " checked"; } else { $wyw=""; }
      if($rekord[rodzaj] == "Zapowied�") { $zap = " checked"; } else { $zap=""; }

      echo "<tr><td><input type=radio name=rodzaj value=\"\"$nic>Bez rodzaju <input type=radio name=rodzaj value=\"Artyku�\"$art>Artyku� <input type=radio name=rodzaj value=\"Wywiad\"$wyw>Wywiad <input type=radio name=rodzaj value=\"Zapowied�\"$zap>Zapowied�</td></tr>";

      $pobierz_zawodnik = mysql_query("select id,imie,nazwisko from zawodnicy order by nazwisko");
      echo "<tr><td>Zawodnik ";
      echo "<select name=zawodnik>";
      echo "<option value=\"\">�aden";
      while ($rekord2 = mysql_fetch_array($pobierz_zawodnik)) {
         if($rekord2[id] == $rekord[zawodnik]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option value=\"$rekord2[id]\"$to>$rekord2[nazwisko] $rekord2[imie]</option>";
      }
      echo "</select></td></tr>";

      $pobierz_zawodnik2 = mysql_query("select id,imie,nazwisko from zawodnicy order by nazwisko");
      echo "<tr><td>Zawodnik 2 ";
      echo "<select name=zawodnik2>";
      echo "<option value=\"\">�aden";
      while ($rekord2 = mysql_fetch_array($pobierz_zawodnik2)) {
         if($rekord2[id] == $rekord[zawodnik2]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option value=\"$rekord2[id]\"$to>$rekord2[nazwisko] $rekord2[imie]</option>";
      }
      echo "</select></td></tr>";

      $pobierz_zawodnik3 = mysql_query("select id,imie,nazwisko from zawodnicy order by nazwisko");
      echo "<tr><td>Zawodnik 3 ";
      echo "<select name=zawodnik3>";
      echo "<option value=\"\">�aden";
      while ($rekord2 = mysql_fetch_array($pobierz_zawodnik3)) {
         if($rekord2[id] == $rekord[zawodnik3]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option value=\"$rekord2[id]\"$to>$rekord2[nazwisko] $rekord2[imie]</option>";
      }
      echo "</select></td></tr>";

      $pobierz_druzyna = mysql_query("select id,nazwa from kluby order by rozgrywki,nazwa");
      echo "<tr><td>Dru�yna ";
      echo "<select name=druzyna>";
      echo "<option value=\"\">�adna";
      while ($rekord2 = mysql_fetch_array($pobierz_druzyna)) {
         if($rekord2[id] == $rekord[druzyna]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option name=druzyna value=\"$rekord2[id]\"$to>$rekord2[nazwa]</option>";
      }
      echo "</select></td></tr>";

      $pobierz_dzial = mysql_query("select*from dzialy where nazwa != 'Nasi...'");
      echo "<tr><td class=tekst>Dzia� ";
      echo "<select name=dzial>";
      while ($rekord2 = mysql_fetch_array($pobierz_dzial)) {
         if($rekord2[nazwa] == $rekord[dzial]) {
            $to = " selected";
         } else {
            $to = "";
         }
         echo "<option name=dzial value=\"$rekord2[nazwa]\"$to>$rekord2[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      print "<tr><td>Autor: <input type=text name=kto value=\"$rekord[kto]\"></td></tr>";
      print "<tr><td>E-mail: <input type=text name=email value=$rekord[email]></td></tr>";
      print "<tr><td>Sezon: <input type=text name=sezon value=\"$rekord[sezon]\"></td></tr>";

      if($rekord[top] == "tak") { $tak = " checked"; } else { $tak=""; }
      if($rekord[top] == "nie") { $nie = " checked"; } else { $nie=""; }

      echo "<tr><td>TOP dnia <input type=radio name=top value=nie$nie>Nie <input type=radio name=top value=tak$tak>Tak</td></tr>";

      if($rekord[ciekawe] == "tak") { $tak = " checked"; } else { $tak=""; }
      if($rekord[ciekawe] == "nie") { $nie = " checked"; } else { $nie=""; }

      echo "<tr><td>Ciekawe <input type=radio name=ciekawe value=nie$nie>Nie <input type=radio name=ciekawe value=tak$tak>Tak</td></tr>";

      print "<tr><td><input type=submit value=Zmie�></td></tr>";
      print "</form>";
      print "</table>";
   }
}

function edycja($news, $tabela = "newsy", $tytul, $kto, $email, $tresc, $rok, $miesiac, $miesiac_num, $dzien, $godzina, $dzial, $zdjecie, $zrodlo, $rodzaj, $zawodnik, $zawodnik2, $zawodnik3, $druzyna, $top, $ciekawe, $sezon, $autor) {
   global $user;
   $tresc = str_replace("[gziolo]","<br><br><img src=grafika/strzalka2.gif> <a target=_blank href=http://slask.e-basket.pl>Zapraszamy na wroclaw.e-basket.pl</a>",$tresc);
   $dzial_id = mysql_fetch_array(mysql_query("select id from dzialy where nazwa = '$dzial'"));
   $query = "update $tabela set tytul='$tytul', kto='$kto', email='$email', tresc='$tresc', dzial='$dzial', dzial_id='$dzial_id[id]', zdjecie='$zdjecie', zrodlo='$zrodlo', rodzaj='$rodzaj', zawodnik=\"$zawodnik\", zawodnik2=\"$zawodnik2\", zawodnik3=\"$zawodnik3\", druzyna=\"$druzyna\", top='$top', ciekawe='$ciekawe', sezon='$sezon', autor='$user' where id='$news'";
   $wynik = mysql_query($query);
   if(!$wynik) {
      print "Nie uda�o si� :(<br>".mysql_error();
   } else {
      print "Uda�o si�.<br>Poprawi�em ".mysql_affected_rows()." wiersz(y).<br><a href=id=aktualnosci.php>Powr�t...</a>";
   }
}

function wyswietl() {
   global $ktory;
   $ktory2 = $ktory+30;
   $ktory3 = $ktory-30;
   $pobierz = mysql_query("select*from newsy order by id desc limit $ktory,$ktory2");
   echo "<table border=1>";
   echo "<tr><td><b>Tytu�</b></td><td><b>Zdj�cie</b></td><td><b>Autor</b></td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
      $autor = mysql_fetch_array(mysql_query("select*from redakcja where id='$rekord[autor]'"));
      echo "<tr><td>$rekord[tytul] [$rekord[kliki]]</td><td>$rekord[zdjecie]</td><td>$autor[login]</td></tr>";
   }
   echo "</table>";
   echo "<br><center>";
   if($ktory!=0) {
      echo "<a href=aktualnosci.php?ktory=$ktory3>Nowsze</a> | <a href=aktualnosci.php?ktory=$ktory2>Starsze</a>";
   } else {
      echo "Nowsze | <a href=aktualnosci.php?ktory=$ktory2>Starsze</a>";
   }
   echo "</center>";
}

function dopisz($czy, $akcja, $tytul, $kto, $email, $tresc, $rok, $miesiac, $miesiac_num, $dzien, $godzina, $dzial, $zdjecie, $zrodlo, $rodzaj, $zawodnik, $zawodnik2, $zawodnik3, $druzyna, $top, $ciekawe, $sezon, $autor, $wysw) {
   global $user, $haslo_user;
   if($czy!="tak") {
      $rok = date("Y",time());
      $miesiac = date("m",time());
      $miesiac_num = date("m",time());
      $dzien = date("d",time());
      $godzina = date("H:i",time());
      if($miesiac==1) {
         $miesiac="stycznia";
         } elseif($miesiac==2) {
         $miesiac="lutego";
         } elseif($miesiac==2) {
         $miesiac="lutego";
         } elseif($miesiac==3) {
         $miesiac="marca";
         } elseif($miesiac==4) {
         $miesiac="kwietnia";
         } elseif($miesiac==5) {
         $miesiac="maja";
         } elseif($miesiac==6) {
         $miesiac="czerwca";
         } elseif($miesiac==7) {
         $miesiac="lipca";
         } elseif($miesiac==8) {
         $miesiac="sierpnia";
         } elseif($miesiac==9) {
         $miesiac="wrze�nia";
         } elseif($miesiac==10) {
         $miesiac="pa�dziernika";
         } elseif($miesiac==11) {
         $miesiac="listopada";
         } elseif($miesiac==12) {
         $miesiac="grudnia";
      }
      echo "<form action=glowna.php method=post>";
      echo "<table border=0>";
      echo "<input type=hidden name=rok value=$rok>";
      echo "<input type=hidden name=miesiac value=$miesiac>";
      echo "<input type=hidden name=miesiac_num value=$miesiac_num>";
      echo "<input type=hidden name=dzien value=$dzien>";
      echo "<input type=hidden name=godzina value=$godzina>";
      echo "<input type=hidden name=czy value=tak>";
      echo "<input type=hidden name=akcja value=dopisz>";
      echo "<input type=hidden name=user value=$user>";
      echo "<input type=hidden name=haslo_user value=$haslo_user>";
      echo "<input type=hidden name=plik value=1>";
      echo "<tr><td class=tekst><b>Tytu� newsa</td><td class=tekst><input type=text name=tytul></td></tr>";
      echo "<tr><td class=tekst><b>Tre��</td><td class=tekst><textarea cols=30 rows=10 name=tresc></textarea></td></tr>";
      echo "<tr><td class=tekst><b>Rodzaj</b> <td class=tekst><input type=radio name=rodzaj value=\"\" checked>Bez rodzaju <input type=radio name=rodzaj value=\"Artyku�\">Artyku� <input type=radio name=rodzaj value=\"Wywiad\">Wywiad <input type=radio name=rodzaj value=\"Zapowied�\">Zapowied�</td></tr>";

      $pobierz_zawodnika = mysql_query("select id,imie,nazwisko from zawodnicy order by nazwisko");
      echo "<tr><td class=tekst><b>Zawodnik</td><td>";
      echo "<select name=zawodnik>";
      echo "<option value=\"\">�aden";
      while ($rekord = mysql_fetch_array($pobierz_zawodnika)) {
         echo "<option value=\"$rekord[id]\">$rekord[nazwisko] $rekord[imie]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_zawodnika2 = mysql_query("select id,imie,nazwisko from zawodnicy order by nazwisko");
      echo "<tr><td class=tekst><b>Zawodnik 2</td><td>";
      echo "<select name=zawodnik2>";
      echo "<option value=\"\">�aden";
      while ($rekord = mysql_fetch_array($pobierz_zawodnika2)) {
         echo "<option value=\"$rekord[id]\">$rekord[nazwisko] $rekord[imie]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_zawodnika3 = mysql_query("select id,imie,nazwisko from zawodnicy order by nazwisko");
      echo "<tr><td class=tekst><b>Zawodnik 3</td><td>";
      echo "<select name=zawodnik3>";
      echo "<option value=\"\">�aden";
      while ($rekord = mysql_fetch_array($pobierz_zawodnika3)) {
         echo "<option value=\"$rekord[id]\">$rekord[nazwisko] $rekord[imie]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_klub = mysql_query("select id,nazwa from kluby order by nazwa");
      echo "<tr><td class=tekst><b>Dru�yna</td><td>";
      echo "<select name=druzyna>";
      echo "<option value=\"\">�adna";
      while ($rekord = mysql_fetch_array($pobierz_klub)) {
         echo "<option value=\"$rekord[id]\">$rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";

      $pobierz_dzial = mysql_query("select nazwa from dzialy where nazwa != 'Nasi...'");
      echo "<tr><td class=tekst><b>Dzia�</td><td>";
      echo "<select name=dzial>";
      while ($rekord = mysql_fetch_array($pobierz_dzial)) {
         echo "<option name=dzial value=\"$rekord[nazwa]\">$rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      echo "<tr><td class=tekst><b>�r�d�o</td><td class=tekst><input size=65 type=text name=zrodlo value=\"<a target=_blank href=http://www.adres_serwisu.pl>Nazwa_serwisu</a>\"><br><b>Je�li jest to informacja w�asna, usu� wszystko z pola �r�d�o !!!</td></tr>";

      $pobierz_zdj = mysql_query("select*from zdjecia order by rodzaj,nazwa");
      echo "<tr><td class=tekst><b>Zdj�cie</td><td>";
      echo "<select name=zdjecie>";
      echo "<option name=zdjecie value=\"\">Brak</option>";
      while ($rekord = mysql_fetch_array($pobierz_zdj)) {
         echo "<option name=zdjecie value=$rekord[id]>$rekord[rodzaj]: $rekord[nazwa]</option>";
      }
      echo "</select>";
      echo "</td></tr>";
      echo "<tr><td class=tekst><b>Autor</td><td class=tekst><input type=text name=kto>";
      echo "<tr><td class=tekst><b>E-mail</td><td class=tekst><input type=text name=email>";
      echo "<tr><td class=tekst><b>Sezon</td><td class=tekst><input type=text name=sezon value=2005/2006>";
      echo "<tr><td class=tekst><b>TOP dnia</td><td class=tekst><input type=radio name=top value=nie checked>Nie <input type=radio name=top value=tak>Tak";
      echo "<tr><td class=tekst><b>Ciekawe</td><td class=tekst><input type=radio name=ciekawe value=nie checked>Nie <input type=radio name=ciekawe value=tak>Tak";
      echo "<tr><td class=tekst><input type=submit value=Dodaj!></td></tr>";
      echo "</table>";
      echo "</form>";
   } else {
      $tytul = stripslashes($tytul);
      $tresc = stripslashes($tresc);
      $tresc = str_replace("[gziolo]","<br><br><img src=grafika/strzalka2.gif> <a target=_blank href=http://slask.e-basket.pl>Zapraszamy na wroclaw.e-basket.pl</a>",$tresc);
      $dzial_id = mysql_fetch_array(mysql_query("select id from dzialy where nazwa = '$dzial'"));
      $wysw = "tak";
      $nowy = "insert into newsy (tytul, kto, email, tresc, rok, miesiac, miesiac_num, dzien, godzina, dzial, dzial_id, zdjecie, zrodlo, rodzaj, zawodnik, zawodnik2, zawodnik3, druzyna, top, ciekawe, sezon, autor, wysw) values ('$tytul', '$kto', '$email', '$tresc', '$rok', '$miesiac', '$miesiac_num', '$dzien', '$godzina', '$dzial', '$dzial_id[id]', '$zdjecie', '$zrodlo', '$rodzaj', '$zawodnik', '$zawodnik2', '$zawodnik3', '$druzyna', '$top', '$ciekawe', '$sezon', '$user', '$wysw')";
      $nowy_wpis = mysql_query($nowy);
      if($nowy_wpis) {
         echo "Doda�em nowego newsa.<br><a href=aktualnosci.php>Powr�t</a>";
      } else {
         echo "Nie uda�o si� doda� newsa.<br>".mysql_error();
      }
   }
}

switch($akcja) {
   case "dopisz":
   dopisz($czy, $akcja, $tytul, $kto, $email, $tresc, $rok, $miesiac, $miesiac_num, $dzien, $godzina, $dzial, $zdjecie, $zrodlo, $rodzaj, $zawodnik, $zawodnik2, $zawodnik3, $druzyna, $top, $ciekawe, $sezon, $autor, $wysw);
   break;
   case "delete":
   usun($news);
   break;
   case "edit":
   edytuj($news, $tabela = "newsy", $tytul, $kto, $email, $tresc, $rok, $miesiac, $miesiac_num, $dzien, $godzina, $dzial, $zdjecie, $zrodlo, $rodzaj, $zawodnik, $zawodnik2, $zawodnik3, $druzyna, $top, $ciekawe, $sezon, $autor);
   break;
   case "edit_now":
   edycja($news, "newsy", $tytul, $kto, $email, $tresc, $rok, $miesiac, $miesiac_num, $dzien, $godzina, $dzial, $zdjecie, $zrodlo, $rodzaj, $zawodnik, $zawodnik2, $zawodnik3, $druzyna, $top, $ciekawe, $sezon, $autor);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
