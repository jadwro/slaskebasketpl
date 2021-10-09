<?
function tabela_prawa($r, $k, $s) {
   $sql ="DELETE FROM tmp";
   $wykonaj = do_sl($sql);
   $sql = "SELECT *, sum(tabele.punkty) AS pkt, count(tabele.punkty) as mecze, sum(tabele.zdobyte) AS zdob1, sum(tabele.stracone) as strac1, sum(tabele.w) as wyg, sum(tabele.p) as prz FROM tabele where rozgrywki='$r' AND kolejka<='$k' AND sezon='$s' GROUP BY tabele.klub ORDER BY pkt DESC;";
   $wykonaj = do_sl($sql);
   while($wiersz = mysql_fetch_array($wykonaj)) {
      $klub = $wiersz['klub'];
      $punkty = $wiersz[pkt];
      $zdob1 = $wiersz['zdob1'];
      $strac1 = $wiersz['strac1'];
      $male = $wiersz[zdob1]-$wiersz[strac1];
      $w = $wiersz['wyg'];
      $p = $wiersz['prz'];
      $mecze = $wiersz['mecze'];
      $sql_tmp= "INSERT INTO tmp (nazwa,pkt,komp,zdobyte,stracone,male,w,p,ile) VALUES (\"$klub\", $punkty,0, $zdob1, $strac1, $male, $w, $p, $mecze);";
      $wykonaj1 = do_sl($sql_tmp);
   }
   $sql = "SELECT COUNT(pkt) AS ilosc, pkt FROM tmp GROUP BY pkt;";
   $wykonaj = do_sl($sql);
   while($wiersz = mysql_fetch_array($wykonaj)) {
      $ile = $wiersz['ilosc'];
      $punkty = $wiersz['pkt'];
      $ilosciowo[] = $ile;
      $punktacja[] = $punkty;
   }
   while (list($nr,$liczba) = each ($punktacja)) {
      if ($ilosciowo[$nr]!=1) {
         $sql = "SELECT nazwa FROM tmp WHERE pkt = $liczba";
         $wykonaj = do_sl($sql);
         while($wiersz = mysql_fetch_array($wykonaj)) {
            $nazwa = $wiersz['nazwa'];
            $tabela_tmp[] = $nazwa;
         }
         while (list($nr_1,$nazwa_1) = each ($tabela_tmp)) {
            $sql = "SELECT * FROM mecze WHERE (druzyna1=\"$nazwa_1\" and d1_wynik>d2_wynik) or (druzyna2=\"$nazwa_1\" and d2_wynik>d1_wynik)";
            $wykonaj_count = do_sl($sql);
            $tmp_tmp = mysql_num_rows($wykonaj_count);
            $sql_tmp = "UPDATE tmp SET komp=$tmp_tmp WHERE nazwa=\"$nazwa_1\";";
            $wykonaj_tmp = do_sl($sql_tmp);
         }
      }
   }
   $sql = "SELECT * FROM tmp ORDER BY pkt DESC, komp DESC, male DESC";
   echo "<center><b><FONT STYLE=\"color:#FF0000; font-family:Verdana; letter-spacing:10\">TABELA</font></b>";
   echo "<table border=0 cellpadding=1 cellspacing=1>";
   echo "<tr><td class=male width=60 bgcolor=#ebebeb><b>Klub</b></td><td class=male width=30 bgcolor=#ebebeb><b>Mecze</b></td><td class=male width=30 bgcolor=#ebebeb><b>Pkt</td><td class=male bgcolor=#ebebeb><b>Kosze</b></td></tr>";
   $wykonaj = do_sl($sql);
   $a = 0;
   while($wiersz = mysql_fetch_array($wykonaj)) {
      $sql2 = "select klub from tabele where klub='$wiersz[nazwa]' AND kolejka<='$k'";
      $wykonaj2 = do_sl($sql2);
      $ile_meczow = mysql_num_rows($wykonaj2);
      $klub = $wiersz['nazwa'];
      $punkty = $wiersz['pkt'];
      $zdob1 = $wiersz['zdobyte'];
      $komp = $wiersz['komp'];
      $strac1 = $wiersz['stracone'];
      $w = $wiersz['w'];
      $p = $wiersz['p'];
      $klub = explode(" ",$klub);
      if($a%2==0) {
         echo "<tr><td class=male bgcolor=#bbbbbb>$klub[0]</td><td class=male bgcolor=#bbbbbb>$ile_meczow</td><td class=male bgcolor=#bbbbbb>$punkty</td><td class=male bgcolor=#bbbbbb>$zdob1:$strac1</td></tr>";
      } else {                                            
         echo "<tr><td class=male bgcolor=#ebebeb>$klub[0]</td><td class=male bgcolor=#ebebeb>$ile_meczow</td><td class=male bgcolor=#ebebeb>$punkty</td><td class=male bgcolor=#ebebeb>$zdob1:$strac1</td></tr>";
      }
      $a++;
   }
   echo "</table></center>";
}

function euro_prawa($s,$czy) {
?>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
   <TR><TD ALIGN="CENTER">
   <IMG SRC=grafika/euroliga.gif WIDTH=200 HEIGHT=20 BORDER=0>
   </TD></TR>
   </TABLE>
   <TABLE WIDTH=200 CELLSPACING=0 CELLPADDING=0 BORDER=1 BORDERCOLOR=#dddddd RULES=NONE STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
   <TR><TD VALIGN=TOP WIDTH=200>
<?
   global $zrob;

if($czy == "tak") {
   print "<!-- GRUPA A //-->";
   $wez_kolejke = mysql_query("select*from rozgrywki where id='2'");
   $zrob = mysql_fetch_array($wez_kolejke);
   $mecze = mysql_query("select id, druzyna1, druzyna2, d1_wynik, d2_wynik, data from mecze where rozgrywki='2' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $mecze2 = mysql_query("select data from mecze where rozgrywki='2' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $data = mysql_fetch_array($mecze2);
   print "<table border=0 cellspacing=0 cellpadding=0>";
   print "<tr><td colspan=2 class=male><font color=#bbbbbb><center><b>Grupa \"A\"</font></center></td></tr>";
   print "<tr><td colspan=2 class=male><center><b>$zrob[kolejka] kolejka</b> ($data[data])</center></td></tr>";
   while($rekord = mysql_fetch_array($mecze)) {
      $nazwa1 = explode(" ",$rekord[druzyna1]);
      $nazwa2 = explode(" ",$rekord[druzyna2]);
      if(($rekord[d1_wynik] != 0) && ($rekord[d2_wynik] != 0)) {
         print "<tr><td class=male width=150>$nazwa1[0] - $nazwa2[0]</td><td class=male><a href=index.php3?id=mecze&mecz=$rekord[id] class=male>$rekord[d1_wynik]:$rekord[d2_wynik]</a></b></td></tr>";
      } else {
         print "<tr><td class=male width=150>$nazwa1[0] - $nazwa2[0]</td><td class=male>--:--</td></tr>";
      }
   }
?>
   <!--
      <tr><td class=male>
   <?
      tabela_prawa(2, $zrob[kolejka], $s);
   ?>
      </td></tr>
   //-->
<?
   print "<!-- GRUPA B //-->";
   $wez_kolejke = mysql_query("select*from rozgrywki where id='3'");
   $zrob = mysql_fetch_array($wez_kolejke);
   $mecze = mysql_query("select id, druzyna1, druzyna2, d1_wynik, d2_wynik, data from mecze where rozgrywki='3' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $mecze2 = mysql_query("select data from mecze where rozgrywki='3' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $data = mysql_fetch_array($mecze2);
   print "<table border=0 cellspacing=0 cellpadding=0>";
   print "<tr><td colspan=2 class=male><br><font color=#bbbbbb><center><b>Grupa \"B\"</font></center></td></tr>";
   print "<tr><td colspan=2 class=male><center><b>$zrob[kolejka] kolejka</b> ($data[data])</center></td></tr>";
   while($rekord = mysql_fetch_array($mecze)) {
      $nazwa1 = explode(" ",$rekord[druzyna1]);
      $nazwa2 = explode(" ",$rekord[druzyna2]);
      if(($rekord[d1_wynik] != 0) && ($rekord[d2_wynik] != 0)) {
         print "<tr><td class=male width=150>$nazwa1[0] - $nazwa2[0]</td><td class=male><a href=index.php3?id=mecze&mecz=$rekord[id] class=male>$rekord[d1_wynik]:$rekord[d2_wynik]</a></b></td></tr>";
      } else {
         print "<tr><td class=male width=150>$nazwa1[0] - $nazwa2[0]</td><td class=male>--:--</td></tr>";
      }
   }
   print "<tr><td colspan=2><br></td></tr>";
?>
   <!--
      <tr><td class=male>
   <?
      tabela_prawa(3, $zrob[kolejka], $s);
   ?>
      </td></tr>
   //-->
<?
}

   print "<!-- GRUPA C //-->";
   $wez_kolejke = mysql_query("select*from rozgrywki where id='4'");
   $zrob = mysql_fetch_array($wez_kolejke);
   $mecze = mysql_query("select id, druzyna1, druzyna2, d1_wynik, d2_wynik, data from mecze where rozgrywki='4' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $mecze2 = mysql_query("select data from mecze where rozgrywki='4' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $data = mysql_fetch_array($mecze2);
   print "<table border=0 cellspacing=0 cellpadding=0>";
   print "<tr><td colspan=2 class=male><font color=#bbbbbb><center><b>Grupa \"C\"</font></center></td></tr>";
   print "<tr><td colspan=2 class=male><center><b>$zrob[kolejka] kolejka</b> ($data[data])</center></td></tr>";
   while($rekord = mysql_fetch_array($mecze)) {
      $nazwa1 = explode(" ",$rekord[druzyna1]);
      $nazwa2 = explode(" ",$rekord[druzyna2]);
      if(($rekord[d1_wynik] != 0) && ($rekord[d2_wynik] != 0)) {
         print "<tr><td class=male width=150>$nazwa1[0] - $nazwa2[0]</td><td class=male><a href=index.php3?id=mecze&mecz=$rekord[id] class=male>$rekord[d1_wynik]:$rekord[d2_wynik]</a></b></td></tr>";
      } else {
         print "<tr><td class=male width=150>$nazwa1[0] - $nazwa2[0]</td><td class=male>--:--</td></tr>";
      }
   }
   print "</table><br>";
   print "</td></tr>";
?>
   <!--
      <tr><td class=male>
   <?
      tabela_prawa(4, $zrob[kolejka], $s);
   ?>
      </td></tr>
   //-->

   </table>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
   <TR><TD ALIGN="CENTER">
   <IMG SRC="grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
   </TD></TR>
   </TABLE>
<?
}

function rozg_prawa($r, $s, $o) {
?>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
   <TR><TD ALIGN="CENTER">
<?
   print "<IMG SRC=$o WIDTH=200 HEIGHT=20 BORDER=0>";
?>
   </TD></TR>
   </TABLE>
   <TABLE WIDTH=200 CELLSPACING=0 CELLPADDING=0 BORDER=1 BORDERCOLOR=#dddddd RULES=NONE STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
   <TR><TD VALIGN=TOP WIDTH=200>
<?
   global $zrob;
   $wez_kolejke = mysql_query("select*from rozgrywki where id='$r'");
   $zrob = mysql_fetch_array($wez_kolejke);
   $mecze = mysql_query("select id, druzyna1, druzyna2, d1_wynik, d2_wynik, data from mecze where rozgrywki='$r' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $mecze2 = mysql_query("select data from mecze where rozgrywki='$r' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $data = mysql_fetch_array($mecze2);
   print "<table border=0 cellspacing=0 cellpadding=0>";
   print "<tr><td colspan=2 class=male><center><b>$zrob[kolejka] kolejka</b> ($data[data])</center></td></tr>";
   while($rekord = mysql_fetch_array($mecze)) {
      $nazwa1 = explode(" ",$rekord[druzyna1]);
      $nazwa2 = explode(" ",$rekord[druzyna2]);
      if(($rekord[d1_wynik] != 0) && ($rekord[d2_wynik] != 0)) {
         print "<tr><td class=male width=150>$nazwa1[0] - $nazwa2[0]</td><td class=male><a href=index.php3?id=mecze&mecz=$rekord[id] class=male>$rekord[d1_wynik]:$rekord[d2_wynik]</a></b></td></tr>";
      } else {
         print "<tr><td class=male width=150>$nazwa1[0] - $nazwa2[0]</td><td class=male>--:--</td></tr>";
      }
   }
?>
   </table><br>
   </td></tr>
   <tr><td class=male>
<?
   tabela_prawa($r, $zrob[kolejka], $s);
?>
   </td></tr>
   </table>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
   <TR><TD ALIGN="CENTER">
   <IMG SRC="grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
   </TD></TR>
   </TABLE>
<?
}

function mecze_prawa() {
?>
<!-- Mecze -->
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
<TR><TD ALIGN="CENTER">
<IMG SRC="grafika/mecze.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>
<TABLE WIDTH="200" HEIGHT="150" CELLSPACING="0" CELLPADDING="0" BORDER="1" BORDERCOLOR="#dddddd" RULES="NONE" STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
<TR><TD VALIGN="TOP" WIDTH="200">
<!-- Nastepny mecz -->
<?
$wez = mysql_fetch_array(mysql_query("select*from nast_poprz"));

if($wez[nastepny]!="0") {
   print "<FONT STYLE=\"color: #0068D0; letter-spacing: 5px; font-family: Verdana; font-size: 10px; font-weight: bold\"><CENTER>Nastêpny:</CENTER></FONT><BR>";
   $rekord = mysql_fetch_array(mysql_query("select*from mecze where id='$wez[nastepny]'"));
   $logo1 = mysql_fetch_array(mysql_query("select adres,nazwa from zdjecia where id='$rekord[d1_logo]'"));
   $logo2 = mysql_fetch_array(mysql_query("select adres,nazwa from zdjecia where id='$rekord[d2_logo]'"));
   $logo1 = explode(".",$logo1[adres]);
   $logo2 = explode(".",$logo2[adres]);
   print "<TABLE ALIGN=CENTER WIDTH=180 CELLSPACING=0 CELLPADDING=0 BORDER=0>";
   print "<TR><TD ALIGN=CENTER WIDTH=70><IMG SRC=$logo1[0]_s.$logo1[1] alt=\"$logo1[nazwa]\" WIDTH=60 BORDER=0></TD>";
   print "<TD ALIGN=CENTER WIDTH=40><IMG SRC=grafika/vs.gif WIDTH=40 HEIGHT=40 BORDER=0></TD>";
   print "<TD ALIGN=CENTER WIDTH=70><IMG SRC=$logo2[0]_s.$logo2[1] alt=\"$logo2[nazwa]\" WIDTH=60 BORDER=0>";
   print "</TR></TD>";
   print "</TABLE>";
   print "<FONT STYLE=\"font-size: 10px; font-family: verdana\">";
   if($rekord[druzyna1]=="¦l±sk Wroc³aw") {
      $zkim = "$rekord[druzyna2]";
      $my = "$rekord[druzyna1]";
   } else {
      $zkim = "$rekord[druzyna1]";
      $my = "$rekord[druzyna2]";
   }
   $miejsce = mysql_fetch_array(mysql_query("select hala from kluby where nazwa=\"$my\""));
   print "<B>Z kim:</B> $zkim<BR>";
   print "<B>Kiedy:</B> $rekord[data]<BR>";
   print "<B>Gdzie:</B> $miejsce[hala]<BR>";
}

if($wez[poprzedni]!="0") {
   print "<br><FONT STYLE=\"color: #0068D0; letter-spacing: 5px; font-family: Verdana; font-size: 10px; font-weight: bold\"><CENTER>Poprzedni:</CENTER></FONT><BR>";
   $rekord2 = mysql_fetch_array(mysql_query("select*from mecze where id='$wez[poprzedni]'"));
   $logo1 = mysql_fetch_array(mysql_query("select adres,nazwa from zdjecia where id='$rekord2[d1_logo]'"));
   $logo2 = mysql_fetch_array(mysql_query("select adres,nazwa from zdjecia where id='$rekord2[d2_logo]'"));
   $logo1 = explode(".",$logo1[adres]);
   $logo2 = explode(".",$logo2[adres]);
   print "<TABLE ALIGN=CENTER WIDTH=180 CELLSPACING=0 CELLPADDING=0 BORDER=0>";
   print "<TR><TD ALIGN=CENTER WIDTH=70><IMG SRC=$logo1[0]_s.$logo1[1] alt=\"$logo1[nazwa]\" WIDTH=60 BORDER=0></TD>";
   print "<TD ALIGN=CENTER WIDTH=40><IMG SRC=grafika/vs.gif WIDTH=40 HEIGHT=40 BORDER=0></TD>";
   print "<TD ALIGN=CENTER WIDTH=70><IMG SRC=$logo2[0]_s.$logo2[1] alt=\"$logo2[nazwa]\" WIDTH=60 BORDER=0>";
   print "</TR></TD>";
   print "</TABLE>";
   print "<FONT STYLE=\"font-size: 10px; font-family: verdana\">";
   if($rekord[druzyna1]=="¦l±sk Wroc³aw") {
      $zkim = "$rekord2[druzyna2]";
   } else {
      $zkim = "$rekord2[druzyna1]";
   }
   $miejsce = mysql_fetch_array(mysql_query("select hala from kluby where nazwa=\"$zkim\""));
   print "<B>Z kim:</B> $zkim<BR>";
   print "<B>Kiedy:</B> $rekord2[data]<BR>";
   print "<B>Gdzie:</B> $miejsce[hala]<BR>";
}
?>

</TR></TD>
</TABLE>
</TD></TR>
<TR><TD>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
<TR><TD ALIGN="CENTER">
<IMG SRC="grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>
<!-- Koniec mecze -->
<?
}

function newsy_pr() {
?>
<!-- newsy -->
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
<TR><TD ALIGN="CENTER">
<IMG SRC="grafika/newsy.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>
<TABLE WIDTH="200" HEIGHT="150" CELLSPACING="0" CELLPADDING="0" BORDER="1" BORDERCOLOR="#dddddd" RULES="NONE" STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
<TR><TD VALIGN="TOP" WIDTH="200">
<TABLE VALIGN="TOP" BORDER="0">
<?
$wez_id = mysql_fetch_array(mysql_query("select max(id) as id from newsy"));
$id = $wez_id[id]-50;
$wez_newsy = mysql_query("select id,tytul,dzien,miesiac_num,rok from newsy where id >= '$id' AND ciekawe='tak' order by id desc limit 0,8");
while ($rekord = mysql_fetch_array($wez_newsy)) {
   if($rekord[miesiac_num] < 10) {
      $rekord[miesiac_num] = "0$rekord[miesiac_num]";
   }
   if($rekord[dzien] < 10) {
      $rekord[dzien] = "0$rekord[dzien]";
   }
   print "<img src=grafika/strzalka2.gif> <a href=?news=$rekord[id]><font class=male>$rekord[tytul] (<i>$rekord[dzien].$rekord[miesiac_num].$rekord[rok])</i></font></a><br>";
}
?>
</TR></TABLE>
</TD></TR>
</TABLE>
</TD></TR>
<TR><TD>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
<TR>
<TD ALIGN="CENTER">
<IMG SRC="grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD>
</TR>
</TABLE>
<?
}

function media() {
?>
<!-- media -->
<br><TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
<TR><TD ALIGN="CENTER">
<IMG SRC="grafika/media.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>
<TABLE WIDTH="200" HEIGHT="150" CELLSPACING="0" CELLPADDING="0" BORDER="1" BORDERCOLOR="#dddddd" RULES="NONE" STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
<TR><TD VALIGN="TOP" WIDTH="200">
<?
print "<TABLE VALIGN=TOP BORDER=0>";
$wez_media = mysql_query("select*from media order by id desc limit 0,5");
while ($rekord = mysql_fetch_array($wez_media)) {
   print "<tr><td valign=top width=190><img src=grafika/strzalka2.gif> <a target=_blank href=$rekord[adres]><font class=male>$rekord[opis]</a><br><b>/$rekord[strona]/</b></font></td></tr>";
}
?>
</TABLE>
</TD></TR>
</TABLE>
</TD></TR>
<TR><TD>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
<TR>
<TD ALIGN="CENTER">
<IMG SRC="grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD>
</TR>
</TABLE>
<?
}

if(!$dzial) {
   rozg_prawa('1','2002/2003','grafika/liga.gif');
   print "<br>";
   euro_prawa('2002/2003','nie');
   print "<br>";
   mecze_prawa();
   print "<br>";
   newsy_pr();
   print "<br>";
   include("techniczne/kalendarz.php");
   print "<br>";
   media();
   print "<br><center><a target=_blank href=http://www.hm.pl>Hosted by HM</a></center>";
} elseif(($dzial == '1') || ($dzial == '4') || ($dzial == '5')) {
   mecze_prawa();
   print "<br>";
   newsy_pr();
   print "<br>";
   include("techniczne/kalendarz.php");
} elseif($dzial == '2') {
   print "<center><img src=obrazki/loga/plk_s.jpg></center>";
   print "<br><br>";
   rozg_prawa('1','2002/2003','grafika/liga.gif');
   print "<br>";
   mecze_prawa();
   print "<br>";
   newsy_pr();
   print "<br>";
   include("techniczne/kalendarz.php");
} elseif($dzial == '3') {
   print "<center><a target=_blank href=obrazki/loga/euroliga_d.jpg><img src=obrazki/loga/euroliga_s.jpg border=0 alt=Powiêksz...></a></center>";
   print "<br><br>";
   euro_prawa('2002/2003','tak');
   print "<br>";
   mecze_prawa();
   print "<br>";
   newsy_pr();
   print "<br>";
   include("techniczne/kalendarz.php");
}

?>


