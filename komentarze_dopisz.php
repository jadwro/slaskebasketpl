<?
if($wykasuj) {
   setcookie("ciastko_kom_kto","",time()-60,"/");
   setcookie("ciastko_kom_email","",time()-60,"/");
   setcookie("ciastko_kom_haslo","",time()-60,"/");
   print "<center><font class=tekst_gl>Informacje wykasowane.<br><a class=kwarta href=javascript:window.close()>Zamknij okno</a></center></font>";
} else {
?>
<HTML>
<HEAD>
<TITLE>Dodaj komentarz :: SLASK.e-basket.pl ::</TITLE>
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
<script langue=javascript>
<!--
function rejestracja() {
   window.open("kom_rejestracja.php", "Rejestracja",'align=center,toolbar=no,status=no,location=no,directories=no,resizable=no,scrollbars=no,width=350,height=300,menubar=no');
}

function okno_vip() {
   window.open("kom_ovip.php", "Rejestracja",'align=center,toolbar=no,status=no,location=no,directories=no,resizable=no,scrollbars=no,width=350,height=400,menubar=no');
}
//-->
</script>
</HEAD>
<BODY bgcolor=#f0f0f0>
<script langue=javascript>
<!--
function emoticon(text) {
   var txtarea = document.komen.tresc;
   text = ' ' + text + ' ';
   if (txtarea.createTextRange && txtarea.caretPos) {
      var caretPos = txtarea.caretPos;
      caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
      txtarea.focus();
   } else {
      txtarea.value  += text;
      txtarea.focus();
   }
}
//-->
</script>
<?
include("polacz.htm");
$tytul = mysql_query("select tytul from newsy where id='$news'");
?>
<font class=kto>Dodaj komentarz</font>
<?
print "<table border=0>";
while($rekord = mysql_fetch_array($tytul)) {
   print "<tr><td width=350 bgcolor=#dddddd class=tekst><b>$rekord[tytul]</td></tr>";
}
print "</table>";
print "<form name=komen action=komentarze_dodaj.php>";
print "<table border=0>";
print "<input type=hidden name=rodzic value=$news>";
print "<input type=hidden name=auth value=nie>";
print "<input type=hidden name=zglos value=nie>";
print "<input type=hidden name=top value=nie>";
print "<tr><td class=tekst_gl><b>Treść komentarza</td><td class=tekst><textarea cols=25 rows=10 name=tresc></textarea></td></tr>";
print "<tr><td class=tekst_gl><b>Nick</td><td class=tekst><input size=17 type=text name=kto value=$ciastko_kom_kto> <a href=javascript:rejestracja() class=kwarta><b>[ Zarejestruj ]</b></a></td></tr>";
print "<tr><td class=tekst_gl><b>Hasło <sup>*</sup></td><td class=tekst><input size=17 type=password name=haslo value=$ciastko_kom_haslo> <a href=komentarze_dopisz.php?wykasuj=tak class=kwarta><b>[ Wykasuj ]</b></a>";
print "<tr><td class=tekst_gl><b>E-mail</td><td class=tekst><input size=17 type=text name=email value=$ciastko_kom_email></td></tr>";
print "<tr><td class=tekst><input type=submit value=Dodaj!></td></tr>";
print "</table>";
?>
<font class=tekst_gl>* - tylko dla zarejestrowanych użytkowników</font>
<br><a class=kwarta href=javascript:okno_vip()><img border=0 src=http://grafika.slask.e-basket.pl/vip.gif> - o co chodzi? Czym jest VIP?</a>
<table border=0>
<tr><td width=350 bgcolor=#dddddd class=tekst><b><center>Emotikony</center></b></td></tr>
</table>
<?
$pobierz = mysql_query("select*from kom_emot limit 0,28");
while($rekord = mysql_fetch_array($pobierz)) {
   print "<a href=\"javascript:emoticon('$rekord[nazwa]')\"><img border=0 src=$rekord[adres] alt=\"$rekord[nazwa]\"></a>&nbsp;&nbsp;&nbsp;";
}
print "<a href=kom_emoty_wiecej.php onclick=\"window.open('kom_emoty_wiecej.php', 'Emotikony', 'HEIGHT=350,resizable=yes,scrollbars=yes,WIDTH=350');return false;\" target=\"_Emotikony\" class=kwarta><b>[ Więcej Emotikon ]</b></a>";
print "<br><center><a class=kwarta href=javascript:window.close()>Zamknij okno</a></center>";

}
?>
</form>
</BODY>
</HTML>
