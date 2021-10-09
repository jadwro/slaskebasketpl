<HTML>
<HEAD>
<TITLE>Cała Polska w cieniu Śląska</TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
</HEAD>
<BODY>
<?
include("polacz.htm");
if($czy!="tak") {
   print "<form action=statystyki.php>";
   print "<input type=hidden name=czy value=tak>";
   print "<table border=0>";

   $mecze = mysql_query("select*from mecze where druzyna1='1' or druzyna2='1'");
   print "<select name=mecz>";
   while($rekord = mysql_fetch_array($mecze)) {
      $druzyna1 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna1]'"));
      $druzyna2 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna2]'"));
      print "<option value=$rekord[id]>$druzyna1[nazwa] - $druzyna2[nazwa] ($rekord[dzien].$rekord[miesiac].$rekord[rok] r.)";
   }
   print "</select>";

   print "<tr><td class=tekst>Rozgrywki</td><td class=tekst><select name=rozgrywki><option value=plk>PLK<option value=fiba>FIBA EuroCUP<option value=euroliga>Euroliga<option value=2liga>2 liga</select></td></tr>";
   print "<tr><td class=tekst>Sezon</td><td class=tekst><input type=text name=sezon></td></tr>";
   print "<tr><td class=tekst>Ilość</td><td class=tekst><input type=text name=ilosc></td></tr>";
   print "<tr><td class=tekst>Gospodarz</td><td class=tekst><textarea name=druzyna1 cols=50 rows=20></textarea></td></tr>";
   print "<tr><td class=tekst>Ilość 2</td><td class=tekst><input type=text name=ilosc2></td></tr>";
   print "<tr><td class=tekst>Gość</td><td class=tekst><textarea name=druzyna2 cols=50 rows=20></textarea></td></tr>";
   print "<tr><td class=tekst><input type=submit value=Dopisz!></td></tr>";
   print "</table>";
   print "</form>";
} else {
   $klub = mysql_fetch_array(mysql_query("select*from mecze where id='$mecz'"));
   $gracze = explode("|",$druzyna1);
   for($i=0; $i<=$ilosc; $i++) {
      $stat = explode(" ",$gracze[$i]);
      if($rozgrywki == "plk") {
         $zawodnik = "$stat[1] $stat[0]";
         $min = "$stat[2]";
         $c2 = "$stat[3]";
         $w2 = "$stat[4]";
         $pr2 = "$stat[5]";
         $c3 = "$stat[6]";
         $w3 = "$stat[7]";
         $pr3 = "$stat[8]";
         $c1 = "$stat[9]";
         $w1 = "$stat[10]";
         $pr1 = "$stat[11]";
         $za = "$stat[12]";
         $zo = "$stat[13]";
         $z = "$stat[14]";
         $a = "$stat[15]";
         $f = "$stat[16]";
         $s = "$stat[17]";
         $p = "$stat[18]";
         $b = "$stat[19]";
         $pkt = "$stat[20]";
      } elseif($rozgrywki == "euroliga") {
         $zawodnik = "$stat[1] $stat[0]";
         $min = "$stat[2]";
         $c2 = "$stat[3]";
         $w2 = "$stat[4]";
         $pr2 = "$stat[5]";
         $c3 = "$stat[6]";
         $w3 = "$stat[7]";
         $pr2 = "$stat[8]";
         $c1 = "$stat[9]";
         $w1 = "$stat[10]";
         $pr1 = "$stat[11]";
         $za = "$stat[12]";
         $zo = "$stat[13]";
         $z = "$stat[14]";
         $b = "$stat[15]";
         $a = "$stat[16]";
         $p = "$stat[17]";
         $s = "$stat[18]";
         $f = "$stat[19]";
         $pkt = "$stat[20]";
         $eval = "$stat[21]";
      } elseif($rozgrywki == "fiba") {
         $zawodnik = "$stat[1] $stat[0]";
         $min = "$stat[2]";
         $c2 = "$stat[3]";
         $w2 = "$stat[4]";
         $pr2 = "$stat[5]";
         $c3 = "$stat[6]";
         $w3 = "$stat[7]";
         $pr2 = "$stat[8]";
         $c1 = "$stat[9]";
         $w1 = "$stat[10]";
         $pr1 = "$stat[11]";
         $za = "$stat[12]";
         $zo = "$stat[13]";
         $z = "$stat[14]";
         $a = "$stat[15]";
         $f = "$stat[16]";
         $s = "$stat[17]";
         $p = "$stat[18]";
         $b = "$stat[19]";
         $pkt = "$stat[20]";
      } elseif($rozgrywki == "2liga") {
         $zawodnik = "$stat[1] $stat[0]";
         $pkt = "$stat[2]";
         $min = "$stat[3]";
         $w2 = "$stat[4]";
         $c2 = "$stat[5]";
         $w3 = "$stat[6]";
         $c3 = "$stat[7]";
         $w1 = "$stat[8]";
         $c1 = "$stat[9]";
         $zb = "$stat[10]";
         $za = "$stat[11]";
         $z = "$stat[12]";
         $a = "$stat[13]";
         $b = "$stat[14]";
         $p = "$stat[15]";
         $s = "$stat[16]";
         $f = "$stat[17]";
      }
      $wpis = dopisz_statystyki($zawodnik, $mecz, $klub[druzyna1], $sezon, $rozgrywki, $klub[data], $min, $pkt, $c2, $w2, $c3, $w3, $c1, $w1, $za, $zo, $z, $a, $p, $s, $b, $f);
      if(!$wpis) {
         print "Wystąpił błąd!<br>Szybko skontakuj się <a href=mailto:slask@e-basket.pl>ze mną</a>";
      } else {
         print "<br>Statystyka dodana.";
         print "<br><a href=index.php3?id=statystyki_proba>Statystyki...</a>";
         print "<br><a href=javascript:hisotry.back(-1)>Powrót...</a>";
      }
   }

   $gracze = explode("|",$druzyna2);
   for($i=0; $i<=$ilosc2; $i++) {
      $stat = explode(" ",$gracze[$i]);
      if($rozgrywki == "plk") {
         $zawodnik = "$stat[1] $stat[0]";
         $min = "$stat[2]";
         $c2 = "$stat[3]";
         $w2 = "$stat[4]";
         $pr2 = "$stat[5]";
         $c3 = "$stat[6]";
         $w3 = "$stat[7]";
         $pr3 = "$stat[8]";
         $c1 = "$stat[9]";
         $w1 = "$stat[10]";
         $pr1 = "$stat[11]";
         $za = "$stat[12]";
         $zo = "$stat[13]";
         $z = "$stat[14]";
         $a = "$stat[15]";
         $f = "$stat[16]";
         $s = "$stat[17]";
         $p = "$stat[18]";
         $b = "$stat[19]";
         $pkt = "$stat[20]";
      } elseif($rozgrywki == "euroliga") {
         $zawodnik = "$stat[1] $stat[0]";
         $min = "$stat[2]";
         $c2 = "$stat[3]";
         $w2 = "$stat[4]";
         $pr2 = "$stat[5]";
         $c3 = "$stat[6]";
         $w3 = "$stat[7]";
         $pr2 = "$stat[8]";
         $c1 = "$stat[9]";
         $w1 = "$stat[10]";
         $pr1 = "$stat[11]";
         $za = "$stat[12]";
         $zo = "$stat[13]";
         $z = "$stat[14]";
         $b = "$stat[15]";
         $a = "$stat[16]";
         $p = "$stat[17]";
         $s = "$stat[18]";
         $f = "$stat[19]";
         $pkt = "$stat[20]";
         $eval = "$stat[21]";
      } elseif($rozgrywki == "fiba") {
         $zawodnik = "$stat[1] $stat[0]";
         $min = "$stat[2]";
         $c2 = "$stat[3]";
         $w2 = "$stat[4]";
         $pr2 = "$stat[5]";
         $c3 = "$stat[6]";
         $w3 = "$stat[7]";
         $pr2 = "$stat[8]";
         $c1 = "$stat[9]";
         $w1 = "$stat[10]";
         $pr1 = "$stat[11]";
         $za = "$stat[12]";
         $zo = "$stat[13]";
         $z = "$stat[14]";
         $a = "$stat[15]";
         $f = "$stat[16]";
         $s = "$stat[17]";
         $p = "$stat[18]";
         $b = "$stat[19]";
         $pkt = "$stat[20]";
      } elseif($rozgrywki == "2liga") {
         $zawodnik = "$stat[0] $stat[1]";
         $pkt = "$stat[2]";
         $min = "$stat[3]";
         $w2 = "$stat[4]";
         $c2 = "$stat[5]";
         $w3 = "$stat[6]";
         $c3 = "$stat[7]";
         $w1 = "$stat[8]";
         $c1 = "$stat[9]";
         $zb = "$stat[10]";
         $za = "$stat[11]";
         $z = "$stat[12]";
         $a = "$stat[13]";
         $b = "$stat[14]";
         $p = "$stat[15]";
         $s = "$stat[16]";
         $f = "$stat[17]";
      }
      $wpis = dopisz_statystyki($zawodnik, $mecz, $klub[druzyna2], $sezon, $rozgrywki, $klub[data], $min, $pkt, $c2, $w2, $c3, $w3, $c1, $w1, $za, $zo, $z, $a, $p, $s, $b, $f);
      if(!$wpis) {
         print "Wystąpił błąd!<br>Szybko skontakuj się <a href=mailto:slask@e-basket.pl>ze mną</a>";
      } else {
         print "<br>Statystyka dodana.";
         print "<br><a href=index.php3?id=statystyki_proba>Statystyki...</a>";
         print "<br><a href=javascript:hisotry.back(-1)>Powrót...</a>";
      }
   }
}

function dopisz_statystyki($zawodnik, $mecz, $druzyna, $sezon, $rozgrywki, $data, $min, $pkt, $c2, $w2, $c3, $w3, $c1, $w1, $za, $zo, $z, $a, $p, $s, $b, $f) {
   $nowy_wpis = "insert into statystyki (zawodnik, mecz, druzyna, sezon, rozgrywki, data, c2, w2, c3, w3, c1, w1, za, zo, z, a, p, s, b, f, min, pkt) values('$zawodnik', '$mecz', '$druzyna', '$sezon', '$rozgrywki', '$data', '$c2', '$w2','$c3', '$w3', '$c1', '$w1', '$za', '$zo', '$z', '$a', '$p', '$s', '$b', '$f', '$min', '$pkt')";
   if(!mysql_query($nowy_wpis)) {
      print "Nie mogę się połączyć bazą danych MySQL!<br>Szybko skontakuj się <a href=mailto:slask@e-basket.pl>ze mną</a>!<br>Informacje o błędzie: ".mysql_error();
      return false;
   }
   return true;
   mysql_close();
}
?>
</BODY>
</HTML>
