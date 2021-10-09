<?
function glowna_zdjecia() {
   $pobierz = mysql_query("select id,kliki,adres,adres_male,opis,data,srednia from galeria");
   while($rekord = mysql_fetch_array($pobierz)) {
      $ile = mysql_fetch_array(mysql_query("select data from galeria where id='$rekord[id]'"));
      $dni = mysql_fetch_array(mysql_query("select to_days(curdate())-to_days('$rekord[data]') as dni from galeria where id='$rekord[id]'"));
      $kliki = mysql_fetch_array(mysql_query("select kliki from galeria where id='$rekord[id]'"));
      $dni[dni] = $dni[dni]+1;
      $srednia = $kliki[kliki]/$dni[dni];
      $red = mysql_query("update galeria set srednia='$srednia' where id='$rekord[id]'");
      $sr = mysql_fetch_array(mysql_query("select srednia from galeria where id='$rekord[id]'"));
   }
   $zdjecie = mysql_fetch_array(mysql_query("select id,adres,opis,srednia,kliki from galeria order by srednia DESC"));
   print "<b><FONT STYLE=\"color:#FF0000; font-family:Verdana; letter-spacing:10; font-size:9px\">RANKING ZDJÊÆ</font></b>";
   print "<br>";
   print "<a class=galeria href=javascript:duze('$zdjecie[id]')><img border=0 src=http://grafika.slask.e-basket.pl/$zdjecie[adres] width=200></a>";
   print "<br><font class=male>$zdjecie[opis] <br><font color=#bbbbbb>(".round($zdjecie[srednia],2)." ods³on dziennie)</font><br>";
   print "<a href=?podpoddzial=15&wh=srednio class=male><b>&#187; Zobacz ca³y ranking &#171;</b></a><br>";
}

function srednio() {
   global $p;
   print "<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td height=15 class=kwarta valign=middle width=520 bgcolor=#dfdfdf align=right><b>[ Galeria ] - Ranking zdjêæ</b>&nbsp;</td></tr></table>";

   print "<br><center><a href=?podpoddzial=15&wh=srednio class=gora>Sortowanie wed³ug ¶redniej</a> | <a href=?podpoddzial=15&wh=suma class=gora>Sortowanie wed³ug sumy</a></center>";

   print "<!------ do paska nawigacyjnego -------->";
   $lacznie = mysql_num_rows(mysql_query("select id from galeria"));
   $poprz = $p-10;
   $naste = $p+10;
   if($p==0) {
      $pop = "<b>&#171;</b>";
   } else {
      $pop = "<a class=kwarta href=?podpoddzial=15&wh=srednio&p=$poprz><b>&#171;</b></a>";
   }
   if($lacznie<=$naste) {
      $nast = "<b>&#187;</b>";
   } else {
      $nast = "<a class=kwarta href=?podpoddzial=15&wh=srednio&p=$naste><b>&#187;</b></a>";
   }
   print "<!------- koniec do paska ----------->";

   print "<br><table border=0 cellspacing=0 cellpadding=0><tr><td width=125 class=kwarta bgcolor=#eeeeee>&nbsp;$pop [ Poprzednie 10 ]</td><td bgcolor=#eeeeee class=kwarta width=270><center>£±cznie w bazie: $lacznie zdjêæ</td><td class=kwarta width=125 align=right bgcolor=#eeeeee>[ Nastêpne 10 ] $nast</td></tr></table>";

   $pobierz = mysql_query("select id,kliki,adres,adres_male,opis,data,srednia from galeria");
   while($rekord = mysql_fetch_array($pobierz)) {
      $ile = mysql_fetch_array(mysql_query("select data from galeria where id='$rekord[id]'"));

      $dni = mysql_fetch_array(mysql_query("select to_days(curdate())-to_days('$rekord[data]') as dni from galeria where id='$rekord[id]'"));
      $kliki = mysql_fetch_array(mysql_query("select kliki from galeria where id='$rekord[id]'"));
      $dni[dni] = $dni[dni]+1;
      $srednia = $kliki[kliki]/$dni[dni];

      $red = mysql_query("update galeria set srednia='$srednia' where id='$rekord[id]'");
      $sr = mysql_fetch_array(mysql_query("select srednia from galeria where id='$rekord[id]'"));
   }
   if(!$p) {
      $pobierz = mysql_query("select id,kliki,adres,adres_male,opis,data,srednia from galeria order by srednia DESC limit 0,10");
   } else {
      $pobierz = mysql_query("select id,kliki,adres,adres_male,opis,data,srednia from galeria order by srednia DESC limit $p,10");
   }
   print "<BR>";
   print "<table border=1 bordercolor=#eeeeee>";
   $a=0+$p;
   while($rekord = mysql_fetch_array($pobierz)) {
      $a++;
      print "<tr><td width=130><center><a class=galeria href=javascript:duze('$rekord[id]')><img src=http://grafika.slask.e-basket.pl/$rekord[adres_male] border=0></a></center></td><td class=tekst valign=top width=370><table border=0><tr><td class=tekst valign=top height=35><b>$a. miejsce</b></td></tr><tr><td class=tekst height=55 valign=middle>$rekord[opis]</td></tr><tr><td class=kwarta height=43 valign=bottom><font color=#bbbbbb>Zdjêcie ogl±dane $rekord[kliki] razy - $rekord[srednia] dziennie (od $rekord[data])</td></tr></table></td></tr>";
   }
   print "</table>";

   print "<br><table border=0 cellspacing=0 cellpadding=0><tr><td width=125 class=kwarta bgcolor=#eeeeee>&nbsp;$pop [ Poprzednie 10 ]</td><td bgcolor=#eeeeee class=kwarta width=270><center>£±cznie w bazie: $lacznie zdjêæ</td><td class=kwarta width=125 align=right bgcolor=#eeeeee>[ Nastêpne 10 ] $nast</td></tr></table>";
}

function sumarycznie() {
   global $p;
   print "<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td height=15 class=kwarta valign=middle width=520 bgcolor=#dfdfdf align=right><b>[ Galeria ] - Ranking zdjêæ</b>&nbsp;</td></tr></table>";

   print "<br><center><a href=?podpoddzial=15&wh=srednio class=gora>Sortowanie wed³ug ¶redniej</a> | <a href=?podpoddzial=15&wh=suma class=gora>Sortowanie wed³ug sumy</a></center>";

   print "<!------ do paska nawigacyjnego -------->";
   $lacznie = mysql_num_rows(mysql_query("select id from galeria"));
   $poprz = $p-10;
   $naste = $p+10;
   if($p==0) {
      $pop = "<b>&#171;</b>";
   } else {
      $pop = "<a class=kwarta href=?podpoddzial=15&wh=suma&p=$poprz><b>&#171;</b></a>";
   }
   if($lacznie<=$naste) {
      $nast = "<b>&#187;</b>";
   } else {
      $nast = "<a class=kwarta href=?podpoddzial=15&wh=suma&p=$naste><b>&#187;</b></a>";
   }
   print "<!------- koniec do paska ----------->";

   print "<br><table border=0 cellspacing=0 cellpadding=0><tr><td width=125 class=kwarta bgcolor=#eeeeee>&nbsp;$pop [ Poprzednie 10 ]</td><td bgcolor=#eeeeee class=kwarta width=270><center>£±cznie w bazie: $lacznie zdjêæ</td><td class=kwarta width=125 align=right bgcolor=#eeeeee>[ Nastêpne 10 ] $nast</td></tr></table>";

   if(!$p) {
      $pobierz = mysql_query("select id,kliki,adres,adres_male,opis,data,srednia from galeria order by kliki DESC limit 0,10");
   } else {
      $pobierz = mysql_query("select id,kliki,adres,adres_male,opis,data,srednia from galeria order by kliki DESC limit $p,10");
   }
   print "<BR>";
   print "<table border=1 bordercolor=#eeeeee>";
   $a=0+$p;
   while($rekord = mysql_fetch_array($pobierz)) {
      $a++;
      print "<tr><td width=130><center><a class=galeria href=javascript:duze('$rekord[id]')><img src=http://grafika.slask.e-basket.pl/$rekord[adres_male] border=0></a></center></td><td class=tekst valign=top width=370><table border=0><tr><td class=tekst valign=top height=35><b>$a. miejsce</b></td></tr><tr><td class=tekst height=55 valign=middle>$rekord[opis]</td></tr><tr><td class=kwarta height=43 valign=bottom><font color=#bbbbbb>Zdjêcie ogl±dane $rekord[kliki] razy - $rekord[srednia] dziennie (od $rekord[data])</td></tr></table></td></tr>";
   }
   print "</table>";

   print "<br><table border=0 cellspacing=0 cellpadding=0><tr><td width=125 class=kwarta bgcolor=#eeeeee>&nbsp;$pop [ Poprzednie 10 ]</td><td bgcolor=#eeeeee class=kwarta width=270><center>£±cznie w bazie: $lacznie zdjêæ</td><td class=kwarta width=125 align=right bgcolor=#eeeeee>[ Nastêpne 10 ] $nast</td></tr></table>";
}

switch($wh) {
   case "srednio":
   srednio();
   break;
   case "suma":
   sumarycznie();
   break;
   case "glowna":
   glowna_zdjecia();
   break;
   default:
   srednio();
   break;
}
?>
