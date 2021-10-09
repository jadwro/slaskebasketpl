<?
setcookie("ciastko_kom_kto",$kto,time()+(60*60*24*365*10),"/");
setcookie("ciastko_kom_email",$email,time()+(60*60*24*365*10),"/");
setcookie("ciastko_kom_haslo",$haslo,time()+(60*60*24*365*10),"/");
?>
<HTML>
<HEAD>
<TITLE>Cała Polska w cieniu Śląska</TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<style type=text/css>
<!--
.tekst {FONT-SIZE: 12px; font-family:Verdana,Arial; TEXT-ALIGN:justify; FONT-VARIANT:normal}
a.kwarta:link {font-family:verdana,arial; font-size:10px; text-decoration:none; color:black};
a.kwarta:visited {font-family:verdana,arial; font-size:10px; text-decoration:none; color:black};
a.kwarta:hover {font-family:verdana,arial; font-size:10px; text-decoration:underline; color:black};
//-->
</style>
</HEAD>
<BODY bgcolor=#f0f0f0>
<?
include("polacz.htm");
if($kto=="") {
   print "<center><font class=tekst>Wpisz swój nick oraz treść komentarza!<br><br><a class=kwarta href=javascript:history.back()>Powrót...</a></center></font>";
} else {
   $sprawdz_czy_jest = mysql_query("select nick from kom_rejestracja where nick='$kto'");
   if(mysql_num_rows($sprawdz_czy_jest)!=0) {
      $hasloo = mysql_fetch_array(mysql_query("select haslo from kom_rejestracja where nick='$kto'"));
      if($hasloo[haslo]!=$haslo) {
         print "<font class=tekst><center>Podany nick jest zarejestrowany / podano nieprawidłowe hasło!<br><br><a class=kwarta href=javascript:history.back()>Powrót...</a></center>";
      } else {
         $tresc = str_replace("\n","<br>",$tresc);
         $ip = $REMOTE_HOST;
         if(mysql_num_rows(mysql_query("select vip from kom_rejestracja where vip='tak' AND nick='$kto'"))!=0) {
            $auth = "tak";
            $wyswtekst = "<font class=tekst><center>Komentarz dodany.<br></font><a class=kwarta href=javascript:window.close()><b>Zamknij to okno</b></a>";
         } else {
            $auth = "nie";
            $wyswtekst = "<font class=tekst><center>Dziękujemy za komentarz! Przed pojawieniem się w serwisie zostanie on poddany autoryzacji.</font><br><a class=kwarta href=javascript:window.close()><b>Zamknij to okno</b></a>";
         }
         $wpis = dopisz_komentarz($kto, $email, $data, $godzina, $tresc, $rodzic, $auth, $top, $ip);
         $wez_ilosc = mysql_fetch_array(mysql_query("select ilosc from kom_rejestracja where nick='$kto'"));
         $ilosc = $wez_ilosc[ilosc]+1;
         $dodaj = mysql_query("update kom_rejestracja set ilosc='$ilosc' where nick='$kto'");
         if(!$wpis) {
            print "<font class=tekst>Wystąpił błąd!<br>Szybko skontakuj się <a href=mailto:slask@e-basket.pl>z redakcją</a></font>";
         } else {
            print "$wyswtekst";
         }
      }
   } else {
      $tresc = str_replace("\n","<br>",$tresc);
      $ip = $REMOTE_HOST;
      $wpis = dopisz_komentarz($kto, $email, $data, $godzina, $tresc, $rodzic, $auth, $top, $ip);
      if(!$wpis) {
         print "<font class=tekst>Wystąpił błąd!<br>Szybko skontakuj się <a href=mailto:slask@e-basket.pl>z redakcją</a></font>";
      } else {
         print "<font class=tekst><center>Dziękujemy za komentarz! Przed pojawieniem się w serwisie zostanie on poddany autoryzacji.<br></font>";
         print "<a class=kwarta href=javascript:window.close()><b>Zamknij to okno</b></a>";
      }
   }
}

function dopisz_komentarz($kto, $email, $data, $godzina, $tresc, $rodzic, $auth, $top, $ip) {
   include("kom_emoty.php");
   $data = date("d.m.Y",time());
   $godzina = date("H:i:s",time());
   $nowy_wpis = "insert into komentarze (kto, email, data, godzina, tresc, rodzic, auth, top, ip) values ('$kto', '$email', '$data', '$godzina', '$tresc', '$rodzic', '$auth', '$top', '$ip')";
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
