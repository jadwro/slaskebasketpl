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
            $sql = "SELECT * FROM mecze WHERE rozgrywki='$r' AND (druzyna1=\"$nazwa_1\" and d1_wynik>d2_wynik) or (druzyna2=\"$nazwa_1\" and d2_wynik>d1_wynik)";
            $wykonaj_count = do_sl($sql);
            $tmp_tmp = mysql_num_rows($wykonaj_count);
            $sql_tmp = "UPDATE tmp SET komp=$tmp_tmp WHERE nazwa=\"$nazwa_1\" AND rozgrywki='$r';";
            $wykonaj_tmp = do_sl($sql_tmp);
         }
      }
   }
   $sql = "SELECT * FROM tmp ORDER BY pkt DESC, komp DESC, male DESC";
   echo "<center><b><FONT STYLE=\"color:#FF0000; font-family:Verdana; letter-spacing:10\">TABELA</font></b>";
   echo "<table border=0 cellpadding=1 cellspacing=1>";
   echo "<tr><td class=male width=40 bgcolor=#ebebeb><b>Klub</b></td><td class=male width=30 bgcolor=#ebebeb><b>Mecze</b></td><td class=male width=20 bgcolor=#ebebeb><b>Pkt</td><td class=male bgcolor=#ebebeb><b>Kosze</b></td><td class=male bgoclor=#ebebeb>&nbsp;</td></tr>";
   $wykonaj = do_sl($sql);
   $a = 0;
   while($wiersz = mysql_fetch_array($wykonaj)) {
      $sql2 = "select klub from tabele where klub='$wiersz[nazwa]' AND kolejka<='$k' AND rozgrywki='$r'";
      $wykonaj2 = do_sl($sql2);
      $ile_meczow = mysql_num_rows($wykonaj2);
      $klub = $wiersz['nazwa'];
      $punkty = $wiersz['pkt'];
      $zdob1 = $wiersz['zdobyte'];
      $komp = $wiersz['komp'];
      $strac1 = $wiersz['stracone'];
      $w = $wiersz['w'];
      $p = $wiersz['p'];
      $roznica = $wiersz[zdobyte]-$wiersz[stracone];
      if($roznica < 0) {
         $plus = "";
      } else {
         $plus = "+";
      }

      $klub = explode(" ",$klub);

      if($klub[0] == "Panathinaikos") {
         $klub[0] = "Panath.";
      }
      if($klub[0] == "Montepaschi") {
         $klub[0] = "Montepa.";
      }
      if($klub[0] == "Olympiakos") {
         $klub[0] = "Olymp.";
      }
      if($klub[0] == "Benetton") {
         $klub[0] = "Benet.";
      }

      if($a%2==0) {
         echo "<tr><td class=male bgcolor=#bbbbbb>$klub[0]</td><td class=male bgcolor=#bbbbbb>$ile_meczow</td><td class=male bgcolor=#bbbbbb>$punkty</td><td class=male bgcolor=#bbbbbb>$zdob1:$strac1</td><td bgcolor=#bbbbbb class=male>$plus$roznica</td></tr>";
      } else {
         echo "<tr><td class=male bgcolor=#ebebeb>$klub[0]</td><td class=male bgcolor=#ebebeb>$ile_meczow</td><td class=male bgcolor=#ebebeb>$punkty</td><td class=male bgcolor=#ebebeb>$zdob1:$strac1</td><td bgcolor=#ebebeb class=male>$plus$roznica</td></tr>";
      }
      $a++;
   }
   echo "</table></center>";
}

function tabela_szostki($r1, $r2, $k, $s) {
   $sql ="DELETE FROM tmp";
   $wykonaj = do_sl($sql);
   if(($r1==15)||($r2==15)) {
      $sql = "SELECT *, sum(tabele.punkty) AS pkt, count(tabele.punkty) as mecze, sum(tabele.zdobyte) AS zdob1, sum(tabele.stracone) as strac1, sum(tabele.w) as wyg, sum(tabele.p) as prz FROM tabele where klub!='LKS Sp?jnia Stargard Szczeci?ski' AND klub!='Start Lublin' AND klub!='Legia Warszawa' AND klub!='ITK Note? Inowroc?aw' AND klub!='Unia Tarn?w' AND klub!='Czarni S?upsk' AND rozgrywki=\"$r1\" OR rozgrywki=\"$r2\" AND sezon='$s' GROUP BY tabele.klub ORDER BY pkt DESC;";
   } else {
      $sql = "SELECT *, sum(tabele.punkty) AS pkt, count(tabele.punkty) as mecze, sum(tabele.zdobyte) AS zdob1, sum(tabele.stracone) as strac1, sum(tabele.w) as wyg, sum(tabele.p) as prz FROM tabele where klub!='Anwil W?oc?awek' AND klub!='Prokom Trefl Sopot' AND klub!='Stal Ostr?w Wielkopolski' AND klub!='?l?sk Wroc?aw' AND klub!='MKS Pruszk?w' And klub!='Polonia Warszawa' AND rozgrywki=\"$r1\" OR rozgrywki=\"$r2\" AND sezon='$s' AND klub!='Anwil W?oc?awek' AND klub!='?l?sk Wroc?aw' AND klub!='Prokom Trefl Sopot' AND klub!='MKS Pruszk?w' AND klub!='Polonia Warszawa' AND klub!='Stal Ostr?w Wielkopolski' GROUP BY tabele.klub ORDER BY pkt DESC;";
   }
   $wykonaj = do_sl($sql);
   while($wiersz = mysql_fetch_array($wykonaj)) {
      $klub = $wiersz['klub'];
      $punkty = $wiersz['pkt'];
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
            $sql_tmp = "UPDATE tmp SET komp=$tmp_tmp WHERE nazwa=\"$nazwa_1\" AND (rozgrywki='$r1' OR rozgrywki='$r2');";
            $wykonaj_tmp = do_sl($sql_tmp);
         }
      }
   }
   $sql = "SELECT * FROM tmp ORDER BY pkt DESC, komp DESC, male DESC";
   echo "<center><b><FONT STYLE=\"color:#FF0000; font-family:Verdana; letter-spacing:10\">TABELA</font></b>";
   echo "<table border=0 cellpadding=1 cellspacing=1>";
   echo "<tr><td class=male width=40 bgcolor=#ebebeb><b>Klub</b></td><td class=male width=30 bgcolor=#ebebeb><b>Mecze</b></td><td class=male width=20 bgcolor=#ebebeb><b>Pkt</td><td class=male bgcolor=#ebebeb><b>Kosze</b></td><td class=male bgoclor=#ebebeb>&nbsp;</td></tr>";
   $wykonaj = do_sl($sql);
   $a = 0;
   while($wiersz = mysql_fetch_array($wykonaj)) {
      $sql2 = "select klub from tabele where rozgrywki='$r2' AND klub='$wiersz[nazwa]'";
      $wykonaj2 = do_sl($sql2);
      $ile_meczow = mysql_num_rows($wykonaj2)+22;
      $klub = $wiersz['nazwa'];
      $punkty = $wiersz['pkt'];
      $zdob1 = $wiersz['zdobyte'];
      $komp = $wiersz['komp'];
      $strac1 = $wiersz['stracone'];
      $w = $wiersz['w'];
      $p = $wiersz['p'];
      $klub = explode(" ",$klub);
      $roznica = $wiersz['zdobyte']-$wiersz['stracone'];
      if($roznica<0) {
         $plus = "";
      } else {
         $plus = "+";
      }
      if($a%2==0) {
         echo "<tr><td class=male bgcolor=#bbbbbb>$klub[0]</td><td class=male bgcolor=#bbbbbb>$ile_meczow</td><td class=male bgcolor=#bbbbbb>$punkty</td><td class=male bgcolor=#bbbbbb>$zdob1:$strac1</td><td bgcolor=#bbbbbb class=male>$plus$roznica</td></tr>";
      } else {
         echo "<tr><td class=male bgcolor=#ebebeb>$klub[0]</td><td class=male bgcolor=#ebebeb>$ile_meczow</td><td class=male bgcolor=#ebebeb>$punkty</td><td class=male bgcolor=#ebebeb>$zdob1:$strac1</td><td bgcolor=#ebebeb class=male>$plus$roznica</td></tr>";
      }
      $a++;
   }
   echo "</table></center>";
}

function rozg_prawa($r, $s, $o) {
?>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
   <TR><TD ALIGN="CENTER">
<?
   print "<IMG SRC=http://grafika.slask.e-basket.pl/$o WIDTH=200 HEIGHT=20 BORDER=0>";
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
   <IMG SRC="http://grafika.slask.e-basket.pl/grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
   </TD></TR>
   </TABLE>
<?
}

function rozg_szostki($r1, $r2, $r3, $s, $o) {
?>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
   <TR><TD ALIGN="CENTER">
<?
   print "<IMG SRC=http://grafika.slask.e-basket.pl/$o WIDTH=200 HEIGHT=20 BORDER=0>";
?>
   </TD></TR>
   </TABLE>
   <TABLE WIDTH=200 CELLSPACING=0 CELLPADDING=0 BORDER=1 BORDERCOLOR=#dddddd RULES=NONE STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
   <TR><TD VALIGN=TOP WIDTH=200>
<?
   global $zrob;
   $wez_kolejke = mysql_query("select*from rozgrywki where id='$r2'");
   $zrob = mysql_fetch_array($wez_kolejke);
   $mecze = mysql_query("select id, druzyna1, druzyna2, d1_wynik, d2_wynik, data from mecze where rozgrywki='$r2' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $mecze2 = mysql_query("select data from mecze where rozgrywki='$r2' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $data = mysql_fetch_array($mecze2);
   print "<table border=0 cellspacing=0 cellpadding=0>";
   print "<tr><td colspan=2 class=male><font color=#bbbbbb><center><b>G?rna \"sz?stka\"</b></font></center></td></tr>";
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
   szostki(10, $r1, $r2, $s, 'tak');
?>
   </td></tr>
   <TR><TD>
   <hr noshade>
   </td></tr>
   <tr><td>
<?
   $wez_kolejke = mysql_query("select*from rozgrywki where id='$r3'");
   $zrob = mysql_fetch_array($wez_kolejke);
   $mecze = mysql_query("select id, druzyna1, druzyna2, d1_wynik, d2_wynik, data from mecze where rozgrywki='$r3' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $mecze2 = mysql_query("select data from mecze where rozgrywki='$r3' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $data = mysql_fetch_array($mecze2);
   print "<table border=0 cellspacing=0 cellpadding=0>";
   print "<tr><td colspan=2 class=male><font color=#bbbbbb><center><b>Dolna \"sz?stka\"</b></font></center></td></tr>";
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
   szostki(10, $r1, $r3, $s, 'tak');
?>
   </td></tr>
   </table>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
   <TR><TD ALIGN="CENTER">
   <IMG SRC="http://grafika.slask.e-basket.pl/grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
   </TD></TR>
   </TABLE>
<?
}

function play_off03() {
?>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
   <TR><TD ALIGN="CENTER">
   <IMG SRC=http://grafika.slask.e-basket.pl/grafika/liga.gif WIDTH=200 HEIGHT=20 BORDER=0>
   </TD></TR>
   </TABLE>
   <TABLE WIDTH=200 CELLSPACING=0 CELLPADDING=0 BORDER=1 BORDERCOLOR=#dddddd RULES=NONE STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
   <TR><TD VALIGN=TOP WIDTH=200>
<?
   print "<center><font color=#bbbbbb class=male><center><b>Fina?</b></font></center>";
   $pary_f = mysql_query("select*from pary_pf where rozgrywki='19'");
   while ($rekord = mysql_fetch_array($pary_f)) {
      $klub1 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna1]'"));
      $klub2 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna2]'"));
      $dr1 = explode(" ",$klub1[nazwa]);
      $dr2 = explode(" ",$klub2[nazwa]);
      print "<table border=0 bordercolor=black cellspacing=0 cellpadding=0>";
      print "<tr><td></td></tr><tr><td></td></tr>";
      print "<tr><td colspan=2 height=15 class=tekst_gl valign=middle width=195 bgcolor=#dddddd><b>&nbsp;&nbsp;$dr1[0] - $dr2[0] <font color=#C12A2A>$rekord[d1_stan]:$rekord[d2_stan]</b></font></td></tr>";
      $mecze = mysql_query("select*from mecze where para='$rekord[id]'");
      while ($mecz = mysql_fetch_array($mecze)) {
         $gosp = explode(" ",$mecz[druzyna1]);
         $gosc = explode(" ",$mecz[druzyna2]);
         $data = explode(",",$mecz[data]);
         if($mecz[d1_wynik]!=0) {
            $napisz = "$gosp[0] - $gosc[0] <a href=?mecz=$mecz[id]><font class=male>$mecz[d1_wynik]:$mecz[d2_wynik]</a></a>";
         } else {
            $napisz = "$gosp[0] - $gosc[0] <font color=#999999>($data[0])</font>";
         }
         print "<tr><td width=8></td><td class=male>$napisz</td></tr>";
      }
      print "</table>";
   }

   print "<br><center><font color=#bbbbbb class=male><center><b>O 3. miejsce</b></font></center>";
   $pary_o3 = mysql_query("select*from pary_pf where rozgrywki='20'");
   while ($rekord = mysql_fetch_array($pary_o3)) {
      $klub1 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna1]'"));
      $klub2 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna2]'"));
      $dr1 = explode(" ",$klub1[nazwa]);
      $dr2 = explode(" ",$klub2[nazwa]);
      print "<table border=0 bordercolor=black cellspacing=0 cellpadding=0>";
      print "<tr><td></td></tr><tr><td></td></tr>";
      print "<tr><td colspan=2 height=15 class=tekst_gl valign=middle width=195 bgcolor=#dddddd><b>&nbsp;&nbsp;$dr1[0] - $dr2[0] <font color=#C12A2A>$rekord[d1_stan]:$rekord[d2_stan]</b></font></td></tr>";
      $mecze = mysql_query("select*from mecze where para='$rekord[id]'");
      while ($mecz = mysql_fetch_array($mecze)) {
         $gosp = explode(" ",$mecz[druzyna1]);
         $gosc = explode(" ",$mecz[druzyna2]);
         $data = explode(",",$mecz[data]);
         if($mecz[d1_wynik]!=0) {
            $napisz = "$gosp[0] - $gosc[0] <a href=?mecz=$mecz[id]><font class=male>$mecz[d1_wynik]:$mecz[d2_wynik]</a></a>";
         } else {
            $napisz = "$gosp[0] - $gosc[0] <font color=#999999>($data[0])</font>";
         }
         print "<tr><td width=8></td><td class=male>$napisz</td></tr>";
      }
      print "</table>";
   }

   print "<br><center><font color=#bbbbbb class=male><center><b>1/2 fina?u</b></font></center>";
   $pary_12 = mysql_query("select*from pary_pf where rozgrywki='18'");
   while ($rekord = mysql_fetch_array($pary_12)) {
      $klub1 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna1]'"));
      $klub2 = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna2]'"));
      $dr1 = explode(" ",$klub1[nazwa]);
      $dr2 = explode(" ",$klub2[nazwa]);
      print "<table border=0 bordercolor=black cellspacing=0 cellpadding=0>";
      print "<tr><td></td></tr><tr><td></td></tr>";
      print "<tr><td colspan=2 height=15 class=tekst_gl valign=middle width=195 bgcolor=#dddddd><b>&nbsp;&nbsp;$dr1[0] - $dr2[0] <font color=#C12A2A>$rekord[d1_stan]:$rekord[d2_stan]</b></font></td></tr>";
      $mecze = mysql_query("select*from mecze where para='$rekord[id]'");
      while ($mecz = mysql_fetch_array($mecze)) {
         $gosp = explode(" ",$mecz[druzyna1]);
         $gosc = explode(" ",$mecz[druzyna2]);
         $data = explode(",",$mecz[data]);
         if($mecz[d1_wynik]!=0) {
            $napisz = "$gosp[0] - $gosc[0] <a href=?mecz=$mecz[id]><font class=male>$mecz[d1_wynik]:$mecz[d2_wynik]</a></a>";
         } else {
            $napisz = "$gosp[0] - $gosc[0] <font color=#999999>($data[0])</font>";
         }
         print "<tr><td width=8></td><td class=male>$napisz</td></tr>";
      }
      print "</table>";
   }
   print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
   print "<a href=?poddzial=34 class=kwarta><font class=male color=#0068D0>Play-off</font></a><br>";
?>
   </table>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
   <TR><TD ALIGN="CENTER">
   <IMG SRC="http://grafika.slask.e-basket.pl/grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
   </TD></TR>
   </TABLE>
<?
}

function euro_prawa($s,$czy) {
?>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
   <TR><TD ALIGN="CENTER">
   <IMG SRC=http://grafika.slask.e-basket.pl/grafika/euroliga.gif WIDTH=200 HEIGHT=20 BORDER=0>
   </TD></TR>
   </TABLE>
   <TABLE WIDTH=200 CELLSPACING=0 CELLPADDING=0 BORDER=1 BORDERCOLOR=#dddddd RULES=NONE STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
   <TR><TD VALIGN=TOP WIDTH=200>
<?
   global $zrob;
if($czy == "tak") {   print "<!-- GRUPA A //-->";
   $wez_kolejke = mysql_fetch_array(mysql_query("select kolejka from rozgrywki where id='27'"));
   $kolejka = mysql_fetch_array(mysql_query("select*from kolejki where id='$wez_kolejke[kolejka]'"));
   $mecze = mysql_query("select id, druzyna1, druzyna2, d1_wynik, d2_wynik, dzien, miesiac, rok from mecze where rozgrywki='27' AND kolejka='$kolekja[id]' AND sezon='$s'");
   print "<table border=0 cellspacing=0 cellpadding=0>";
   print "<tr><td colspan=2 class=male><font color=#bbbbbb><center><b>Grupa \"A\"</font></center></td></tr>";
   if($kolejka[dzien1]<=9) {
      $kolejka[dzien1] = "0$kolejka[dzien1]";
   }
   if($kolejka[dzien2]<=9) {
      $kolejka[dzien2] = "0$kolejka[dzien2]";
   }
   if($kolejka[miesiac]<=9) {
      $kolejka[miesiac] = "0$kolejka[miesiac]";
   }
   print "<tr><td colspan=2 class=male><center><b>$kolejka[numer] kolejka</b> ($kolejka[dzien1]-$kolejka[dzien2].$kolejka[miesiac].$kolejka[rok] r.)</center></td></tr>";
   while($rekord = mysql_fetch_array($mecze)) {
      $rekord[druzyna1] = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna1]'"));
      $rekord[druzyna2] = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$rekord[druzyna2]'"));
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
      <tr><td class=male>
   <?
      tabela_prawa(2, $zrob[kolejka], $s);
   ?>

<?
   print "<!-- GRUPA B //-->";
   $wez_kolejke = mysql_query("select*from rozgrywki where id='3'");
   $zrob = mysql_fetch_array($wez_kolejke);
   $mecze = mysql_query("select id, druzyna1, druzyna2, d1_wynik, d2_wynik, data from mecze where rozgrywki='3' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $mecze2 = mysql_query("select data from mecze where rozgrywki='3' AND kolejka='$zrob[kolejka]' AND sezon='$s'");
   $data = mysql_fetch_array($mecze2);
   print "<table border=0 cellspacing=0 cellpadding=0>";
   print "<tr><td colspan=2 class=male><br><font color=#bbbbbb><center><hr noshade align=center><b>Grupa \"B\"</font></center></td></tr>";
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
      <tr><td class=male>
   <?
      tabela_prawa(3, $zrob[kolejka], $s);
      print "<hr noshade align=center>";
   ?>

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
      <tr><td class=male>
   <?
      tabela_prawa(4, $zrob[kolejka], $s);
   ?>
      </td></tr>

   </table>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
   <TR><TD ALIGN="CENTER">
   <IMG SRC="http://grafika.slask.e-basket.pl/grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
   </TD></TR>
   </TABLE>
<?
}

function mecze_prawa() {
?>
<!-- Mecze -->
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
<TR><TD ALIGN="CENTER">
<IMG SRC="http://grafika.slask.e-basket.pl/grafika/mecze.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>
<TABLE WIDTH="200" HEIGHT="150" CELLSPACING="0" CELLPADDING="0" BORDER="1" BORDERCOLOR="#dddddd" RULES="NONE" STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
<TR><TD VALIGN="TOP" WIDTH="200">
<!-- Nastepny mecz -->
<?
$wez = mysql_fetch_array(mysql_query("select*from nast_poprz"));

if($wez[nastepny]!="0") {
   print "<FONT STYLE=\"color: #0068D0; letter-spacing: 5px; font-family: Verdana; font-size: 10px; font-weight: bold\"><CENTER>Nast?pny:</CENTER></FONT><BR>";
   $rekord = mysql_fetch_array(mysql_query("select*from mecze where id='$wez[nastepny]'"));
   $logo1 = mysql_fetch_array(mysql_query("select adres,nazwa from zdjecia where id='$rekord[d1_logo]'"));
   $logo2 = mysql_fetch_array(mysql_query("select adres,nazwa from zdjecia where id='$rekord[d2_logo]'"));
   $logo1 = explode(".",$logo1[adres]);
   $logo2 = explode(".",$logo2[adres]);
   print "<TABLE ALIGN=CENTER WIDTH=180 CELLSPACING=0 CELLPADDING=0 BORDER=0>";
   print "<TR><TD ALIGN=CENTER WIDTH=70><IMG SRC=http://grafika.slask.e-basket.pl/$logo1[0]_s.$logo1[1] alt=\"$logo1[nazwa]\" WIDTH=60 BORDER=0></TD>";
   print "<TD ALIGN=CENTER WIDTH=40><IMG SRC=http://grafika.slask.e-basket.pl/grafika/vs.gif WIDTH=40 HEIGHT=40 BORDER=0></TD>";
   print "<TD ALIGN=CENTER WIDTH=70><IMG SRC=http://grafika.slask.e-basket.pl/$logo2[0]_s.$logo2[1] alt=\"$logo2[nazwa]\" WIDTH=60 BORDER=0>";
   print "</TR></TD>";
   print "</TABLE>";
   print "<FONT STYLE=\"font-size: 10px; font-family: verdana\">";
   if($rekord[druzyna1]=="?l?sk Wroc?aw") {
      $zkim = "$rekord[druzyna2]";
      $hala = "$rekord[druzyna1]";
   } else {
      $zkim = "$rekord[druzyna1]";
      $hala = "$rekord[druzyna1]";
   }
   $miejsce = mysql_fetch_array(mysql_query("select hala from kluby where nazwa=\"$hala\""));
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
   print "<TR><TD ALIGN=CENTER WIDTH=70><IMG SRC=http://grafika.slask.e-basket.pl/$logo1[0]_s.$logo1[1] alt=\"$logo1[nazwa]\" WIDTH=60 BORDER=0></TD>";
   print "<TD ALIGN=CENTER WIDTH=40><IMG SRC=http://grafika.slask.e-basket.pl/grafika/vs.gif WIDTH=40 HEIGHT=40 BORDER=0></TD>";
   print "<TD ALIGN=CENTER WIDTH=70><IMG SRC=http://grafika.slask.e-basket.pl/$logo2[0]_s.$logo2[1] alt=\"$logo2[nazwa]\" WIDTH=60 BORDER=0>";
   print "</TR></TD>";
   print "</TABLE>";
   print "<center><a class=kwarta href=?mecz=$rekord2[id]><b><font color=red>$rekord2[d1_wynik]:$rekord2[d2_wynik]</font></b></a></center><br>";
   print "<FONT STYLE=\"font-size: 10px; font-family: verdana\">";
   if($rekord2[druzyna1]=="?l?sk Wroc?aw") {
      $zkim = "$rekord2[druzyna2]";
      $hala2 = "$rekord2[druzyna1]";
   } else {
      $zkim = "$rekord2[druzyna1]";
      $hala2 = "$rekord2[druzyna1]";
  }

   $miejsce2 = mysql_fetch_array(mysql_query("select hala from kluby where nazwa=\"$hala2\""));
   if($rekord2[id] == "79") {
      $miejsce2[hala] = "Hala Orbita (Wroc?aw)";
   }
   print "<B>Z kim:</B> $zkim<BR>";
   print "<B>Kiedy:</B> $rekord2[data]<BR>";
   print "<B>Gdzie:</B> $miejsce2[hala]<BR>";
}
?>

</TR></TD>
</TABLE>
</TD></TR>
<TR><TD>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
<TR><TD ALIGN="CENTER">
<IMG SRC="http://grafika.slask.e-basket.pl/grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
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
<IMG SRC="http://grafika.slask.e-basket.pl/grafika/newsy.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
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
   print "<img src=http://grafika.slask.e-basket.pl/grafika/strzalka2.gif> <a href=?news=$rekord[id]><font class=male>$rekord[tytul] (<i>$rekord[dzien].$rekord[miesiac_num].$rekord[rok])</i></font></a><br>";
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
<IMG SRC="http://grafika.slask.e-basket.pl/grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>
<?
}

function media() {
?>
<!-- media -->
<br><TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
<TR><TD ALIGN="CENTER">
<IMG SRC="http://grafika.slask.e-basket.pl/grafika/media.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>
<TABLE WIDTH="200" HEIGHT="150" CELLSPACING="0" CELLPADDING="0" BORDER="1" BORDERCOLOR="#dddddd" RULES="NONE" STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
<TR><TD VALIGN="TOP" WIDTH="200">
<?
print "<TABLE VALIGN=TOP BORDER=0>";
$wez_media = mysql_query("select*from media order by id desc limit 0,5");
while ($rekord = mysql_fetch_array($wez_media)) {
   print "<tr><td valign=top width=190><img src=http://grafika.slask.e-basket.pl/grafika/strzalka2.gif> <a target=_blank href=techniczne/przeniesienia.php?id=$rekord[id]&wh=media><font class=male>$rekord[opis]</a> [$rekord[kliki]]<br><b>/$rekord[strona]/</b></font></td></tr>";
}
?>
</TABLE>
</TD></TR>
</TABLE>
</TD></TR>
<TR><TD>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
<TR><TD ALIGN="CENTER">
<IMG SRC="http://grafika.slask.e-basket.pl/grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>
<?
}

if((!$dzial) && (!$mecz) && (!$news)) {
   play_off03();
   print "<br>";
   euro_prawa('2003/2004','nie');
   print "<br>";
   print "<P ALIGN=CENTER><br>";
   $wh = "glowna";
   include("ranking_zdjec.php");
   print "<br>";
   mecze_prawa();
   print "<br>";
   newsy_pr();
   print "<br>";
   include("techniczne/kalendarz.php");
   print "<br>";
   media();
   print "<br>";
   print "<a target=_blank href=http://www.wroclaw.e-basket.pl> <P ALIGN=CENTER><IMG SRC=http://grafika.slask.e-basket.pl/obrazki/loga/media/ziolkowscy_m.jpg WIDTH=120 HEIGHT=60 BORDER=0></a><BR>";

print "<P ALIGN=CENTER><IMG SRC=http://grafika.slask.e-basket.pl/obrazki/loga/kosynierka/kosynierka.jpg WIDTH=150 HEIGHT=65 BORDER=0></a><BR>";

   print "<br><center><a target=_blank href=http://www.hm.pl>Hosted by HM</a></center>";
} elseif ($mecz) {
   play_off03();
   print "<br>";
   euro_prawa('2002/2003','nie');
} elseif ($news) {
   include("techniczne/kalendarz.php");
} elseif(($dzial == '1') || ($dzial == '4') || ($dzial == '5')) {
   mecze_prawa();
   print "<br>";
   newsy_pr();
   print "<br>";
   include("techniczne/kalendarz.php");
} elseif($dzial == '2') {
   print "<center><img src=http://grafika.slask.e-basket.pl/obrazki/loga/plk_s.jpg></center>";
   print "<br><br>";
   play_off03();
   print "<br>";
   mecze_prawa();
   print "<br>";
   newsy_pr();
   print "<br>";
   include("techniczne/kalendarz.php");
} elseif($dzial == '3') {
   print "<center><img src=http://grafika.slask.e-basket.pl/obrazki/loga/euroliga_s.jpg></center>";
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
