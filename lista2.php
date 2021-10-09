<script langue=javascript>
<!--
function rejestracja() {
   window.open("kom_rejestracja.php", "Rejestracja",'align=center,toolbar=no,status=no,location=no,directories=no,resizable=no,scrollbars=no,width=350,height=300,menubar=no');
}
//-->
</script>
<?
include("polacz.php");
print "<br><table border=0 bordercolor=black cellspacing=0 cellpadding=0><tr><td bgcolor=#dfdfdf height=15 width=100 align=left class=kwarta> <a class=kwarta href=?poddzial=35>&#171; Na pocz±tek...</a></td><td height=15 class=kwarta valign=middle width=430 bgcolor=#dfdfdf align=right><b>[ Lista dyskusyjna ]</b>&nbsp;</td></tr></table>";
print "<br><table border=0 cellspacing=0 cellpadding=0>";

print "<tr><td background=http://grafika.slask.e-basket.pl/grafika/kropkinews.jpg class=tytul_newsa width=515 align=center height=20>&nbsp;<a class=czarny href=javascript:rejestracja()>Zarejestruj nick</a> | <a class=czarny href=?poddzial=35&akcja=user>Najaktywniejsi</a> | <a class=czarny href=?poddzial=35&akcja=ustawienia>Ustawienia</a> | <a class=czarny href=?poddzial=35&akcja=archiwum>Archiwum</a> | <a class=czarny href=?poddzial=35&akcja=wykasuj>Usuñ info o u¿ytkowniku</a></td></tr>";

print "</table>";

function wpisuj($ciastko_kom_kto, $ciastko_kom_haslo, $ostatni) {
   print "<form action=\"index.php?poddzial=35&akcja=dodaj\" method=post>";
   print "<table border=0>";
   print "<tr><td width=50 class=tekst>Nick</td><td><input class=lista size=25 type=text name=kto value=\"$ciastko_kom_kto\"></td></tr>";
   print "<tr><td class=tekst>Has³o *</td><td><input class=lista size=26 type=password name=haslo value=\"$ciastko_kom_haslo\"></td></tr>";
   print "<tr><td class=tekst>Adresat *</td><td><input class=lista size=25 type=text name=adresat value=\"\"></td></tr>";
   $news = mysql_query("select id,tytul from newsy order by id desc limit 0,30");
   print "<tr><td class=tekst>Do newsa *</td><td>";
   print "<select name=rodzic class=lista>";
   print "<option value=0></option>";
   while($rekord = mysql_fetch_array($news)) {
      print "<option value=$rekord[id]>$rekord[tytul]</option>";
   }
   print "</select></td></tr>";
   print "<tr><td class=tekst>Tre¶æ</td><td><textarea class=lista cols=30 rows=7 name=tresc></textarea></td></tr>";
   print "<tr><td></td><td><input type=submit value=\"                Dodaj                \"></td></tr>";
   print "<tr><td colspan=2 class=tekst_gl>* - pole nieobowi±zkowe</td></tr>";
   print "$ostatni";
   print "</table>";
   print "</form>";
   print "<hr color=#666666>";
}

function wyswietl($wyswietlkom) {
   while($rekord = mysql_fetch_array($wyswietlkom)) {
      $tytul = mysql_fetch_array(mysql_query("select tytul from newsy where id='$rekord[rodzic]'"));
      if($rekord[adresat]!="") {
         $adresat = "- <font style='color:#000000; background-color:#eeeeee'>&nbsp;$rekord[adresat] </font>";
      } else {
         $adresat = "";
      }
      if(mysql_num_rows(mysql_query("select vip from kom_rejestracja where vip='tak' AND nick='$rekord[kto]'"))!=0) {
         $vip = "<img src=http://grafika.slask.e-basket.pl/vip.gif>";
      } else {
         $vip = "";
      }
      if($rekord[rodzic]!=0) {
         $naglowek = "<tr><td bgcolor=#f0f0f0 width=300 align=left><font class=tekst><font color=$rekord[kolornicka]><b>$rekord[kto]</b> $vip</font> $adresat</font></td><td width=30 bgcolor=#f0f0f0></td><td bgcolor=#f0f0f0 width=200 align=right><font class=male><font color=#999999>($rekord[data] $rekord[godzina])</font> #$rekord[id]</font></td></tr>";
         $naglowek .= "<tr><td class=tekst_gl bgcolor=#f0f0f0 width=530 colspan=3 align=left> &nbsp;<img src=http://grafika.slask.e-basket.pl/grafika/kwadrat.jpg alt=\"Wpis jest komentarzem do newsa\" align=middle> <a target=_blank href=?news=$rekord[rodzic] class=kwarta>$tytul[tytul]</a></td></tr>";
      } else {
         $naglowek = "<tr><td height=20 bgcolor=#f0f0f0 width=300 align=left><font class=tekst><font color=$rekord[kolornicka]><b>$rekord[kto]</b> $vip</font> $adresat</font></td><td class=tekst_gl bgcolor=#f0f0f0 width=30 align=left></td><td bgcolor=#f0f0f0 width=200 align=right><font class=male><font color=#999999>($rekord[data] $rekord[godzina])</font> #$rekord[id]</font></td></tr>";
      }
      $rekord[tresc] = eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])", "<a href=\"\\1://\\2\\3\" target=\"_blank\" target=\"_new\">\\1://\\2\\3</a>", $rekord[tresc]);
      $rekord[tresc] = eregi_replace("(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))", "<a href=\"mailto:\\1\" target=\"_new\">\\1</a>", $rekord[tresc]);
      print "<a name=$rekord[id]></a><table border=0 cellspacing=0 cellpadding=0>";
      print "$naglowek";
      print "<tr><td colspan=3 background=http://grafika.slask.e-basket.pl/grafika/pasek2.jpg width=530 height=1></td></tr>";
      print "<tr><td width=530 class=tekst colspan=3>$rekord[tresc]</td></tr>";
      print "</table><br><hr color=#eeeeee size=1><br>";
   }
}

function glowna() {
   global $ciastko_kom_kto, $ciastko_kom_email, $ciastko_kom_haslo, $ciastko_kom_ostatni, $ciastko_kom_wyswietl, $ciastko_kom_kolornicka, $ciastko_kom_ilosc;
   if((!$ciastko_kom_wyswietl) || ($ciastko_kom_wyswietl=="")) {
      $cowyswietl = "";
   } elseif($ciastko_kom_wyswietl=="kom") {
      $cowyswietl = "where rodzic!=0";
   } elseif($ciastko_kom_wyswietl=="lista") {
      $cowyswietl = "where rodzic=0";
   }
   $ostatniogladany = mysql_fetch_array(mysql_query("select id from komentarze order by id desc limit 1"));
   setcookie("ciastko_kom_ostatni",$ostatniogladany[id],time()+(60*60*24*365*10),"/");
   if($ciastko_kom_ostatni) {
      $ostatniwpis = mysql_query("select id from komentarze where id>'$ciastko_kom_ostatni' order by id desc");
      $ostatni = "<tr><td colspan=2 class=tekst_gl>Ostatni ogl±dany wpis: <a class=kwarta href=#$ciastko_kom_ostatni>#$ciastko_kom_ostatni</a> (Nie obejrzanych: ".mysql_num_rows($ostatniwpis).")</td></tr>";
      $limit = $ciastko_kom_ilosc;
      if(mysql_num_rows($ostatniwpis)>=$ciastko_kom_ilosc) {
         $limit = mysql_num_rows($ostatniwpis)+5;
      }
      $wyswietlkom = mysql_query("select*from komentarze $cowyswietl order by id desc limit 0,$limit");
   } else {
      $limit = 30;
      $wyswietlkom = mysql_query("select*from komentarze $cowyswietl order by id desc limit 0,$limit");
      setcookie("ciastko_kom_ilosc",$limit,time()+(60*60*24*365*10),"/");
   }

   wpisuj($ciastko_kom_kto, $ciastko_kom_haslo, $ostatni);
   wyswietl($wyswietlkom);
}

function szuk($autor,$tresc,$nr1,$nr2) {
   if(($nr1=="") || ($nr2=="")) {
      $numery = "";
   } else {
      $numery = "AND (id>='$nr1' AND id<='$nr2')";
   }
   if(($tresc=="") && ($autor=="")) {
      $wyswietlkom = mysql_query("select*from komentarze where id>='$nr1' AND id<='$nr2' order by id desc");
   } else {
      if($tresc=="") {
         $wyswietlkom = mysql_query("select*from komentarze where kto like '%$autor%' $numery order by id desc");
      } else {
         if($autor!="") {
            $wyswietlkom = mysql_query("select*from komentarze where kto like '%$autor%' AND tresc like '%$tresc%' $numery order by id desc");
         } else {
            $wyswietlkom = mysql_query("select*from komentarze where tresc like '%$tresc%' $numery order by id desc");
         }
      }
   }
   print "<br>Znaleziono <b> ".mysql_num_rows($wyswietlkom)."</b> wpisów.<br><br>";
   wyswietl($wyswietlkom);
}

function archiwum() {
   global $ciastko_kom_ilosc, $ktore;
   if(!$ktore) {
      $ktore="$ciastko_kom_ilosc";
   }
   $wyswietlkom = mysql_query("select*from komentarze order by id desc limit $ktore,50");
   print "<br>";
   $ktoretyl = $ktore-50;
   if($ktoretyl<=0) {
      $tyl = "<font class=kwarta>&#171; 50 nowszych wpisów</font>";
   } else {
      $tyl = "<a class=kwarta href=?poddzial=35&akcja=archiwum&ktore=$ktoretyl>&#171; 50 nowszych wpisów</a>";
   }
   $ktore = $ktore+50;
   print "<table border=0 cellspacing=0 cellpadding=0><tr><td bgcolor=#eeeeee width=250>$tyl</td><td bgcolor=#eeeeee width=30></td><td width=250 align=right bgcolor=#eeeeee><a class=kwarta href=?poddzial=35&akcja=archiwum&ktore=$ktore>50 starszych wpisów &#187;</a></td></tr></table>";
   print "<br>";
   wyswietl($wyswietlkom);
}

function dodaj($kto, $email, $tresc, $rodzic, $auth, $ip, $haslo, $adresat, $kolornicka) {
   global $ciastko_kom_kolornicka;
   $auth="tak";
   $top="nie";
   if(!$ciastko_kom_kolornicka) {
      $ciastko_kom_kolornicka = "#000000";
   }
   if(($kto=="") || ($tresc=="")) {
      print "<center><font class=tekst>Wpisz swój nick oraz tre¶æ!<br><br><a class=kwarta href=javascript:history.back()>Powrót...</a></center></font>";
   } else {
      $sprawdz_czy_jest = mysql_query("select nick from kom_rejestracja where nick='$kto'");
      if(mysql_num_rows($sprawdz_czy_jest)!=0) {
         $hasloo = mysql_fetch_array(mysql_query("select haslo from kom_rejestracja where nick='$kto'"));
         if($hasloo[haslo]!=$haslo) {
            print "<font class=tekst><center>Podany nick jest zarejestrowany / podano nieprawid³owe has³o!<br><br><a class=kwarta href=javascript:history.back()>Powrót...</a></center>";
         } else {
            $tresc = str_replace("\n","<br>",$tresc);
            $ip = $REMOTE_HOST;
            setcookie("ciastko_kom_kto",$kto,time()+(60*60*24*365*10),"/");
            setcookie("ciastko_kom_email",$email,time()+(60*60*24*365*10),"/");
            setcookie("ciastko_kom_haslo",$haslo,time()+(60*60*24*365*10),"/");

            $data = date("d.m.Y",time());
            $godzina = date("H:i:s",time());
            $nowy_wpis = mysql_query("insert into komentarze (kto, email, data, godzina, tresc, rodzic, auth, ip, adresat, kolornicka) values ('$kto', '$email', '$data', '$godzina', '$tresc', '$rodzic', '$auth', '$ip', '$adresat', '$ciastko_kom_kolornicka')");
            $wez_ilosc = mysql_fetch_array(mysql_query("select ilosc from kom_rejestracja where nick='$kto'"));
            $ilosc = $wez_ilosc[ilosc]+1;
            $dodaj = mysql_query("update kom_rejestracja set ilosc='$ilosc' where nick='$kto'");
            if(!$nowy_wpis) {
               print "<font class=tekst>Wyst±pi³ b³±d!<br>Szybko skontakuj siê <a href=mailto:slask@e-basket.pl>z redakcj±</a></font>";
            } else {
               ?> <script langue=javascript>window.location.href = 'http://slask.e-basket.pl/?poddzial=35'; </script> <?
            }
         }
      } else {
         setcookie("ciastko_kom_kto",$kto,time()+(60*60*24*365*10),"/");
         setcookie("ciastko_kom_email",$email,time()+(60*60*24*365*10),"/");
         setcookie("ciastko_kom_haslo",$haslo,time()+(60*60*24*365*10),"/");
         $data = date("d.m.Y",time());
         $godzina = date("H:i:s",time());
         $tresc = str_replace("\n","<br>",$tresc);
         $ip = $REMOTE_HOST;
         $nowy_wpis = mysql_query("insert into komentarze (kto, email, data, godzina, tresc, rodzic, auth, ip, adresat, kolornicka) values ('$kto', '$email', '$data', '$godzina', '$tresc', '$rodzic', '$auth', '$ip', '$adresat', '$ciastko_kom_kolornicka')");
         if(!$nowy_wpis) {
            print "<font class=tekst>Wyst±pi³ b³±d!<br>Szybko skontakuj siê <a href=mailto:slask@e-basket.pl>z redakcj±</a></font>";
         } else {
            ?> <script langue=javascript>window.location.href = 'http://slask.e-basket.pl/?poddzial=35'; </script> <?
         }
      }
   }
}

function wykasuj() {
       setcookie("ciastko_kom_kto","",time()-60,"/");
       setcookie("ciastko_kom_email","",time()-60,"/");
       setcookie("ciastko_kom_haslo","",time()-60,"/");
       setcookie("ciastko_kom_ostatni","",time()-60,"/");
       setcookie("ciastko_kom_wyswietl","",time()-60,"/");
       setcookie("ciastko_kom_kolornicka","",time()-60,"/");
       setcookie("ciastko_kom_ilosc","",time()-60,"/");
       ?> <script langue=javascript>window.location.href = 'http://slask.e-basket.pl/?poddzial=35'; </script> <?
}

function user() {
   $pobierz = mysql_query("select*from kom_rejestracja where ilosc>='50' order by ilosc desc");
   print "<br><br><table border=0 cellspacing=0 cellpadding=0>";
   print "<tr><td width=40 bgcolor=#eeeeee align=left></td><td class=tekst bgcolor=#eeeeee width=220 align=left><b>U¿ytkownik</b></td><td bgcolor=#eeeeee width=120 align=center><font class=tekst><b>Ilo¶æ wpisów</b></font></td><td bgcolor=#eeeeee width=160 align=right><font class=tekst><b>Ostatni wpis</b></font></td></tr>";
   $a=0;
   while ($rekord = mysql_fetch_array($pobierz)) {
      $a++;
      $ostatni = mysql_fetch_array(mysql_query("select data,godzina from komentarze where kto='$rekord[nick]' order by id desc"));
      print "<tr><td width=40 class=tekst>$a. </td><td class=tekst> $rekord[nick]</td><td align=center><font class=tekst>$rekord[ilosc]</font></td><td align=right><font class=tekst>$ostatni[data] $ostatni[godzina]</font></td></tr>";
   }
   print "</table>";
}

function ustawienia() {
   global $ciastko_kom_wyswietl, $ciastko_kom_kolornicka, $ciastko_kom_ilosc;
   print "<form action=?poddzial=35&akcja=zmien method=post>";
   print "<font class=tekst><b>Wy¶wietlaj:</b>";
   if((!$ciastko_kom_wyswietl) || ($ciastko_kom_wyswietl=="")) {
      $raz = " checked";
   } elseif($ciastko_kom_wyswietl=="kom") {
      $dwa = " checked";
   } elseif($ciastko_kom_wyswietl=="lista") {
      $trzy = " checked";
   }
   print "<br><input type=radio name=wyswietlaj value=\"\"$raz> Wszystko";
   print "<br><input type=radio name=wyswietlaj value=\"kom\"$dwa> Tylko komentarze";
   print "<br><input type=radio name=wyswietlaj value=\"lista\"$trzy> Tylko wpisy z listy";
   print "<br><br><b>Wybierz kolor nicka:</b>";
   print "<br><select name=kolornicka class=lista>";
   if(!$ciastko_kom_kolornicka) {
      $ciastko_kom_kolornicka = "#000000";
   }
   $wezkolory = mysql_query("select*from kom_kolory order by nazwa");
   while($rekord = mysql_fetch_array($wezkolory)) {
      if("$rekord[kod]"=="$ciastko_kom_kolornicka") {
         $to = " selected";
      } else {
         $to = "";
      }
      print "<option value=$rekord[kod] style='color:$rekord[kod]'$to>$rekord[nazwa]</option>";
   }
   print "</select>";
   print "<br><br><b>Ilo¶æ wy¶wietlanych wpisów:</b>";
   print "<br><select name=ilosc class=lista>";

   if(!$ciastko_kom_ilosc) {
      $trzy = " selected";
   } else {
      if($ciastko_kom_ilosc=="10") {
         $dycha = " selected";
      } elseif($ciastko_kom_ilosc=="20") {
         $dwa = " selected";
      } elseif($ciastko_kom_ilosc=="30") {
         $trzy = " selected";
      } elseif($ciastko_kom_ilosc=="50") {
         $piec = " selected";
      } elseif($ciastko_kom_ilosc=="70") {
         $siedem = " selected";
      } elseif($ciastko_kom_ilosc=="100") {
         $sto = " selected";
      } elseif($ciastko_kom_ilosc=="150") {
         $stopiec = " selected";
      }
   }

   print "<option value=10$dycha>10</option>";
   print "<option value=20$dwa>20</option>";
   print "<option value=30$trzy>30</option>";
   print "<option value=50$piec>50</option>";
   print "<option value=70$siedem>70</option>";
   print "<option value=100$sto>100</option>";
   print "<option value=150$stopiec>150</option>";
   print "</select>";
   print "<br><br><input class=lista type=submit value=Zmieñ>";
   print "</form>";
}

function zmien($wyswietlaj, $kolornicka, $ilosc) {
   setcookie("ciastko_kom_wyswietl",$wyswietlaj,time()+(60*60*24*365*10),"/");
   setcookie("ciastko_kom_kolornicka",$kolornicka,time()+(60*60*24*365*10),"/");
   setcookie("ciastko_kom_ilosc",$ilosc,time()+(60*60*24*365*10),"/");
   ?> <script langue=javascript>window.location.href = 'http://slask.e-basket.pl/?poddzial=35'; </script> <?
}

switch($akcja) {
   case "dodaj":
   dodaj($kto, $email, $tresc, $rodzic, $auth, $ip, $haslo, $adresat, $kolornicka);
   break;
   case "wykasuj":
   wykasuj();
   break;
   case "user":
   user();
   break;
   case "ustawienia":
   ustawienia();
   break;
   case "archiwum":
   archiwum();
   break;
   case "zmien":
   zmien($wyswietlaj, $kolornicka, $ilosc);
   break;
   case "find":
   szuk($autor, $tresc, $nr1, $nr2);
   break;
   default:
   glowna();
   break;
}
?>
