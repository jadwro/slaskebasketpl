<HTML>
<HEAD>
<TITLE>Ca�a Polska w cieniu �l�ska</TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<style type=text/css>
<!--
.tekst {font-family:arial; font-size:13px};
a.tekst:link {color:black};
a.tekst:hover {color:black; text-decoration:underline};
.kto {font-family:verdana; font-size:23px; font-weight:bold};
//-->
</style>
</HEAD>
<BODY>
<?
include("polacz.htm");
$temat = "News ze strony http://slask.e-basket.pl";
$powitanie = "Witaj, $nick_adresata!\n \n";
$wstep = "$twoj_nick wys�a� do Ciebie newsa ze strony http://slask.e-basket.pl! Oto on:\n \n";
$tytul = mysql_query("select*from newsy where id='$news'");
while($rekord = mysql_fetch_array($tytul)) {
   $polozenie = strpos($rekord[tresc],"...");
   if($polozenie) {
      $wypisz = substr($rekord[tresc],0,$polozenie)."... \n \nDalsza cz�� pod adresem: http://slask.e-basket.pl/index.php3?id=aktualnosci&news=$rekord[id]";
   } else {
      $wypisz = "$rekord[tresc]";
   }
   $tytul2 = "Tytu�: $rekord[tytul] \n";
   $tresc = "Tre��: $wypisz";
   $wiadomosc = "$powitanie $wstep $tytul2 $tresc";
   $wyslij = mail($email_adresata, $temat, $wiadomosc, "From: $twoj_email");
   if($wyslij) {
      print "<center>E-mail zosta� wys�any.<br><a href=javascript:window.close()>Zamknij to okno</a>";
   } else {
      print "Niestety nie uda�o si� wys�a� newsa. Szybko skontaktuj si� ze <a href=mailto:slask@e-basket.pl>mn�</a>!";
   }
}
?>
</form>
</BODY>
</HTML>
