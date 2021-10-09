<HTML>
<HEAD>
<TITLE>Cała Polska w cieniu Śląska</TITLE>
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
$tytul = mysql_query("select*from newsy where id='$news'");
?>
<font class=kto>Wyślij newsa</font>
<?
print "<table border=0>";
while($rekord = mysql_fetch_array($tytul)) {
   $tytul_newsa = $rekord[tytul];
   print "<tr><td width=350 bgcolor=#eeeeee><b>$rekord[tytul]</td></tr>";
}
print "</table>";
print "<form action=aktualnosci_wysylanie.php?news=$news method=post>";
print "<table border=0>";
print "<input type=hidden name=rodzic value='<? print $tytul_newsa ?>'>";
print "<tr><td class=tekst><b>Twój nick</b> <input type=text name=twoj_nick></td></tr>";
print "<tr><td class=tekst><b>Twój e-mail</b> <input type=text name=twoj_email></td></tr>";
print "<tr><td class=tekst><b>Nick adresata</b> <input type=text name=nick_adresata></td></tr>";
print "<tr><td class=tekst><b>E-mail adresata</b> <input type=text name=email_adresata></td></tr>";
print "<tr><td class=tekst><input type=submit value=Dodaj!></td></tr>";
print "</table>";
?>
</form>
</BODY>
</HTML>