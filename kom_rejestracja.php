<HTML>
<HEAD>
<TITLE>Zarejestruj nick :: SLASK.e-basket.pl ::</TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<style type=text/css>
<!--
.tekst_gl {FONT-SIZE: 11px; font-family:Verdana,Arial; text-align:justify}
.tekst {FONT-SIZE: 12px; font-family:Verdana,Arial; TEXT-ALIGN:justify; FONT-VARIANT:normal}
a.tekst:link {color:black};
a.tekst:hover {color:black; text-decoration:underline};
.kto {font-family:verdana; font-size:23px; font-weight:bold};
a.kwarta:link {font-family:verdana,arial; font-size:10px; text-decoration:none; color:black};
a.kwarta:visited {font-family:verdana,arial; font-size:10px; text-decoration:none; color:black};
a.kwarta:hover {font-family:verdana,arial; font-size:10px; text-decoration:underline; color:black};
//-->
</style>
</HEAD>
<BODY bgcolor=#f0f0f0>
<?
include("polacz.php");
if($rejestracja!="tak") {
?>
   <font class=kto>Rejestracja nicka</font>
   <br><br>
   <form action=kom_rejestracja.php name=rejestracja>
   <table border=0>
   <tr><td class=tekst>Nick</td><td><input type=text name=nick></td></tr>
   <tr><td class=tekst>Hasło</td><td><input type=password name=haslo></td></tr>
   <tr><td class=tekst>Powtórz hasło</td><td><input type=password name=haslo2></td></tr>
   <tr><td class=tekst>E-mail <sup>*</sup></td><td><input type=text name=email></td></tr>
   <tr><td class=tekst></td><td><input type=submit value=Zarejestruj><input type=hidden name=rejestracja value=tak></td></tr>
   </table>
   <font class=tekst_gl>* - pole nieobowiązkowe</font>
   <br><br><center><a class=kwarta href=javascript:window.close()>Zamknij okno</a></center>
   </form>
<?
} else {
   if(($haslo!=$haslo2) || ($haslo=="") || ($nick=="")) {
      print "<font class=tekst><center>Nieprawidłowo wypełniony formularz! Spróbuj jeszcze raz.<br><a href=javascript:history.back()>Powrót...</a></center></font>";
   } else {
      $sprawdz_czy_jest = mysql_query("select nick from kom_rejestracja where nick='$nick'");
      if(mysql_num_rows($sprawdz_czy_jest)!=0) {
         print "<font class=tekst><center>Podany nick jest już zarejestrowany. Podaj inny.<br><a href=javascript:history.back()>Powrót...</a></center></font>";
      } else {
         $dodaj = mysql_query("insert into kom_rejestracja (nick,haslo,email) values ('$nick','$haslo','$email')");
         if($dodaj) {
            print "<font class=tekst><center>Nick <b>$nick</b> został zarejestrowany!<br><a href=javascript:window.close()>Zamknij to okno</a></center></font>";
         } else {
            print "<font class=tekst><center>Nie udało się zarejestrować nicka! Prosimy o kontakt na adres - <a href=mailto:slask@e-basket.pl>slask@e-basket.pl</a><br><a href=javascript:history.back()>Powrót...</a></center></font>";
         }
      }
   }
}
?>
</BODY>
</HTML>
