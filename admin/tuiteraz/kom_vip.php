<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<LINK href="../../techniczne/style.css" type=text/css rel=stylesheet>
<style type=text/css>
<!--
.klub {font-family:arial,verdana; font-size:11px};
//-->
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
function rozgrywki(s) {
var adres = s.options[s.selectedIndex].value;
window.location.href = adres;
}
-->
</SCRIPT>
</HEAD>
<BODY>
<?
require("polacz.htm");

print "<font class=tyt_admin><center>Komentarze - VIP</center></font><br><br>";

function wyswietl() {
   $pobierz = mysql_query("select*from kom_rejestracja where vip='tak'");
   print "<form action=kom_vip.php>";
   print "<input type=hidden name=akcja value=szukaj>";
   print "<font class=tekst>Szukaj użytkownika <input type=text name=user class=szukaj></font> ";
   print " <input type=submit value=ok class=szukaj>";
   print "</form><br><br>";
   print "<font class=tekst>Lista użytkowników posiadających status VIPa (".mysql_num_rows(mysql_query("select id from kom_rejestracja where vip='tak'"))." osób)</font>";
   print "<table border=0>";
   print "<tr><td class=tekst width=50><b>ID</td><td class=tekst width=200><b>Nick</td><td class=tekst><b>E-mail</td></tr>";
   while ($rekord = mysql_fetch_array($pobierz)) {
      echo "<tr><td class=tekst>$rekord[id]</td><td class=tekst><a class=czarny href=kom_vip.php?akcja=szukaj&user=$rekord[nick]>$rekord[nick]</a></td><td class=tekst><a href=mailto:$rekord[email]>$rekord[email]</a></td></tr>";
   }
   print "</table>";
}

function found($user) {
   $pobierz = mysql_query("select*from kom_rejestracja where nick='$user'");
   if(mysql_num_rows($pobierz)=="0") {
      print "<font class=tekst>Nie znaleziono użytkownika <b>$user</b>...</font><br><br><a href='javascript:history.back(-1)'>Powrót...</a>";
   } else {
      $info = mysql_fetch_array(mysql_query("select*from kom_rejestracja where nick='$user'"));
      $pierwszy = mysql_fetch_array(mysql_query("select data from komentarze where kto='$user' order by id asc"));
      $ostatni = mysql_fetch_array(mysql_query("select data from komentarze where kto='$user' order by id desc"));
      print "<font class=tekst>Informacje o użytkowniku:";
      print "<table border=0>";
      print "<tr><td class=tekst>ID:</td><td class=tekst><b>$info[id]</b></td></tr>";
      print "<tr><td class=tekst>Nick:</td><td class=tekst><b>$info[nick]</b></td></tr>";
      print "<tr><td class=tekst>Komentarze:</td><td class=tekst><b>$info[ilosc]</b></td></tr>";
      print "<tr><td class=tekst>E-mail:</td><td class=tekst><b>$info[email]</b></td></tr>";
      print "<tr><td class=tekst>Pierwszy wpis:</td><td class=tekst><b>$pierwszy[data]</b></td></tr>";
      print "<tr><td class=tekst>Ostatni wpis:</td><td class=tekst><b>$ostatni[data]</b></td></tr>";
      print "<tr><td class=tekst>Status VIPa:</td><td class=tekst><b>$info[vip]</b></td></tr>";
      print "</table>";
      print "<center><a href=kom_vip.php?akcja=vip&id=$info[id]&co=daj><img src=dajv.gif border=0></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=kom_vip.php?akcja=vip&id=$info[id]&co=wez><img src=wezv.gif border=0></a></center>";
      print "<br><br><a href=javascript:history.back(-1)>Powrót..</a>";
   }
}

function dajwez($co, $id) {
   if($co == "daj") {
      $przyznaj = mysql_query("update kom_rejestracja set vip='tak' where id='$id'");
      if(!$przyznaj) {
         print "<font class=tekst>Nie udało się przyznać VIPa! Wystąpił następjący błąd:<br></font>".mysql_error();
      } else {
         $wezmail = mysql_fetch_array(mysql_query("select nick,email from kom_rejestracja where id='$id'"));
         if($wezmail[email]!="") {
            $email_adresata = "$wezmail[email]";
            $temat = "Dostałeś status VIPa";
            $wiadomosc = "Witaj, $wezmail[nick]! \n\n Miło nam poinformować, że redakcja serwisu SLASK.e-basket.pl przyznała Ci status VIPa, co oznacza, że Twoje komentarze będą pojawiały się na stronie natychmiast po dodaniu - bez autoryzacji. \n\n Pozdrawiamy \n redakcja SLASK.e-basket.pl";
            $wyslij = mail($email_adresata, $temat, $wiadomosc, "From: SLASK@e-basket.pl");
            if($wyslij) {
               $wys = "E-mail został wysłany do użytkownika.";
            } else {
               $wys = "Nie udało się jednak wysłać e-maila do użytkownika.";
            }
         }
         print "<font class=tekst>Udało się - użytkownik otrzymał status VIPa (poprawione ".mysql_affected_rows()." wierszy). $wys <br><a href=kom_vip.php>Powrót...</a></font>";
      }
   } else {
      $odbierz = mysql_query("update kom_rejestracja set vip='nie' where id='$id'");
      if(!$odbierz) {
         print "<font class=tekst>Nie udało się odebrać VIPa! Wystąpił następjący błąd:<br></font>".mysql_error();
      } else {
         print "<font class=tekst>Udało się - użytkownik nie ma już statusu VIPa [swoją drogą ciekawe, co narozrabiał] (poprawione ".mysql_affected_rows()." wierszy).<br><a href=kom_vip.php>Powrót...</a></font>";
      }
   }
}

switch($akcja) {
   case "szukaj":
   found($user);
   break;
   case "vip":
   dajwez($co, $id);
   break;
   case "edit":
   edytuj($emot, $tabela = "kom_emot", $nazwa, $adres);
   break;
   case "edit_now":
   edycja($emot, "kom_emot", $emot2, $nazwa, $adres);
   break;
   default:
   wyswietl();
   break;
}
?>
</BODY>
</HTML>
