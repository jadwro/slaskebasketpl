<?
function tabela_wyniki($k,$r,$s) {
   $sql ="DELETE FROM tmp";
   $wykonaj = do_sl($sql);
   $sql = "SELECT *, sum(tabele.punkty) AS pkt, count(tabele.punkty) as mecze, sum(tabele.zdobyte) AS zdob1, sum(tabele.stracone) as strac1, sum(tabele.w) as wyg, sum(tabele.p) as prz FROM tabele where rozgrywki=\"$r\" AND kolejka<='$k' AND sezon='$s' GROUP BY tabele.klub ORDER BY pkt DESC;";
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
            $sql_tmp = "UPDATE tmp SET komp=$tmp_tmp WHERE nazwa=\"$nazwa_1\" AND rozgrywki='$r';";
            $wykonaj_tmp = do_sl($sql_tmp);
         }
      }
   }
   $sqlll = "SELECT * FROM tmp ORDER BY pkt DESC, komp DESC, male DESC";
   echo "<table border=0 cellpadding=1 cellspacing=1>";
   echo "<tr><td class=tekst bgcolor=#dfdfdf width=200><b><center>Klub</center></b></td><td class=tekst width=30 bgcolor=#dfdfdf><b><center>Mecze</center></b></td><td class=tekst width=25 bgcolor=#dfdfdf><b><center>Pkt</center></td><td class=tekst bgcolor=#dfdfdf><b><center>Wygrane</center></b></td><td class=tekst bgcolor=#dfdfdf><b><center>Przegrane</center></b></td><td class=tekst bgcolor=#dfdfdf width=60><b><center>Kosze</center></b></td><td bgcolor=#dfdfdf>&nbsp;</td></tr>";
   $wykonajjj = do_sl($sqlll);
   $a = 0;
   while($wiersz = mysql_fetch_array($wykonajjj)) {
      $druzyna = mysql_fetch_array(mysql_query("select nazwa from kluby where id='$wiersz[nazwa]'"));
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
      $roznica = $wiersz['zdobyte']-$wiersz['stracone'];
      if($roznica<0) {
         $plus = "";
      } else {
         $plus = "+";
      }
      if($a%2==0) {
         echo "<tr><td class=tekst bgcolor=#eeeeee>$druzyna[nazwa]</td><td class=tekst bgcolor=#eeeeee><center>$ile_meczow</td><td class=tekst bgcolor=#eeeeee><center>$punkty</td><td class=tekst bgcolor=#eeeeee><center>$w</td><td class=tekst bgcolor=#eeeeee><center>$p</td><td class=tekst bgcolor=#eeeeee><center>$zdob1:$strac1</td><td class=tekst bgcolor=#eeeeee><center>$plus$roznica</center></td></tr>";
      } else {                                            
         echo "<tr><td class=tekst bgcolor=#fafafa>$druzyna[nazwa]</td><td class=tekst bgcolor=#fafafa><center>$ile_meczow</td><td class=tekst bgcolor=#fafafa><center>$punkty</td><td class=tekst bgcolor=#fafafa><center>$w</td><td class=tekst bgcolor=#fafafa><center>$p</td><td class=tekst bgcolor=#fafafa><center>$zdob1:$strac1</td><td class=tekst bgcolor=#fafafa><center>$plus$roznica</center></td></tr>";
      }
      $a++;
   }
   echo "</table>";
}

function szostki($k,$r1,$r2,$s,$prawa) {
   $sql ="DELETE FROM tmp";
   $wykonaj = do_sl($sql);
   if(($r1==15)||($r2==15)) {
      $sql = "SELECT *, sum(tabele.punkty) AS pkt, count(tabele.punkty) as mecze, sum(tabele.zdobyte) AS zdob1, sum(tabele.stracone) as strac1, sum(tabele.w) as wyg, sum(tabele.p) as prz FROM tabele where klub!='LKS Spójnia Stargard Szczeciñski' AND klub!='Start Lublin' AND klub!='Legia Warszawa' AND klub!='ITK Noteæ Inowroc³aw' AND klub!='Unia Tarnów' AND klub!='Czarni S³upsk' AND rozgrywki=\"$r1\" OR rozgrywki=\"$r2\" AND kolejka<='$k' AND sezon='$s' GROUP BY tabele.klub ORDER BY pkt DESC;";
   } else {
      $sql = "SELECT *, sum(tabele.punkty) AS pkt, count(tabele.punkty) as mecze, sum(tabele.zdobyte) AS zdob1, sum(tabele.stracone) as strac1, sum(tabele.w) as wyg, sum(tabele.p) as prz FROM tabele where klub!='Anwil W³oc³awek' AND klub!='Prokom Trefl Sopot' AND klub!='Stal Ostrów Wielkopolski' AND klub!='¦l±sk Wroc³aw' AND klub!='MKS Pruszków' And klub!='Polonia Warszawa' AND rozgrywki=\"$r1\" OR rozgrywki=\"$r2\" AND kolejka<='$k' AND sezon='$s' AND klub!='Anwil W³oc³awek' AND klub!='¦l±sk Wroc³aw' AND klub!='Prokom Trefl Sopot' AND klub!='MKS Pruszków' AND klub!='Polonia Warszawa' AND klub!='Stal Ostrów Wielkopolski' GROUP BY tabele.klub ORDER BY pkt DESC;";
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
   if($prawa=="nie") {
      echo "<table border=0 cellpadding=1 cellspacing=1>";
      echo "<tr><td class=tekst bgcolor=#dfdfdf width=200><b><center>Klub</center></b></td><td class=tekst width=30 bgcolor=#dfdfdf><b><center>Mecze</center></b></td><td class=tekst width=25 bgcolor=#dfdfdf><b><center>Pkt</center></td><td class=tekst bgcolor=#dfdfdf><b><center>Wygrane</center></b></td><td class=tekst bgcolor=#dfdfdf><b><center>Przegrane</center></b></td><td class=tekst bgcolor=#dfdfdf width=60><b><center>Kosze</center></b></td><td bgcolor=#dfdfdf>&nbsp;</td></tr>";
   } else {
      echo "<center><b><FONT STYLE=\"color:#FF0000; font-family:Verdana; letter-spacing:10\">TABELA</font></b>";
      echo "<table border=0 cellpadding=1 cellspacing=1>";
      echo "<tr><td class=male width=40 bgcolor=#ebebeb><b>Klub</b></td><td class=male width=20 bgcolor=#ebebeb><b>M</b></td><td class=male width=20 bgcolor=#ebebeb><b>Pkt</td><td class=male bgcolor=#ebebeb><b>Kosze</b></td><td class=male bgoclor=#ebebeb>&nbsp;</td></tr>";
   }
   $wykonaj = do_sl($sql);
   $a = 0;
   while($wiersz = mysql_fetch_array($wykonaj)) {
      $sql2 = "select klub from tabele where rozgrywki='$r2' AND klub='$wiersz[nazwa]' AND kolejka<='$k'";
      $wykonaj2 = do_sl($sql2);
      $ile_meczow = mysql_num_rows($wykonaj2)+22;
      $klub = $wiersz['nazwa'];
      $punkty = $wiersz['pkt'];
      $zdob1 = $wiersz['zdobyte'];
      $komp = $wiersz['komp'];
      $strac1 = $wiersz['stracone'];
      $w = $wiersz['w'];
      $p = $wiersz['p'];
      $roznica = $wiersz['zdobyte']-$wiersz['stracone'];
      if($prawa=='tak') {
         $klub = explode(" ",$klub);
      }
      if($roznica<0) {
         $plus = "";
      } else {
         $plus = "+";
      }
      if($prawa=="nie") {
         if($a%2==0) {
            echo "<tr><td class=tekst bgcolor=#eeeeee>$klub</td><td class=tekst bgcolor=#eeeeee><center>$ile_meczow</td><td class=tekst bgcolor=#eeeeee><center>$punkty</td><td class=tekst bgcolor=#eeeeee><center>$w</td><td class=tekst bgcolor=#eeeeee><center>$p</td><td class=tekst bgcolor=#eeeeee><center>$zdob1:$strac1</td><td class=tekst bgcolor=#eeeeee><center>$plus$roznica</center></td></tr>";
         } else {
            echo "<tr><td class=tekst bgcolor=#fafafa>$klub</td><td class=tekst bgcolor=#fafafa><center>$ile_meczow</td><td class=tekst bgcolor=#fafafa><center>$punkty</td><td class=tekst bgcolor=#fafafa><center>$w</td><td class=tekst bgcolor=#fafafa><center>$p</td><td class=tekst bgcolor=#fafafa><center>$zdob1:$strac1</td><td class=tekst bgcolor=#fafafa><center>$plus$roznica</center></td></tr>";
         }
         $a++;
      } else {
         if($a%2==0) {
            echo "<tr><td class=male bgcolor=#bbbbbb>$klub[0]</td><td class=male bgcolor=#bbbbbb>$ile_meczow</td><td class=male bgcolor=#bbbbbb>$punkty</td><td class=male bgcolor=#bbbbbb>$zdob1:$strac1</td><td bgcolor=#bbbbbb class=male>$plus$roznica</td></tr>";
         } else {
            echo "<tr><td class=male bgcolor=#ebebeb>$klub[0]</td><td class=male bgcolor=#ebebeb>$ile_meczow</td><td class=male bgcolor=#ebebeb>$punkty</td><td class=male bgcolor=#ebebeb>$zdob1:$strac1</td><td bgcolor=#ebebeb class=male>$plus$roznica</td></tr>";
         }
         $a++;
      }
   }
   echo "</table>";
}
?>
