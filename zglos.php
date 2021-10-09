<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<LINK href="techniczne/style.css" type=text/css rel=stylesheet>
</HEAD>
<BODY bgcolor=#eeeeee>
<center>
<?
include("polacz.php");
$zglos = mysql_query("update komentarze set zglos='tak' where id='$id'");
if($zglos) {
   print "<font class=tekst>Zgłoszenie zostało wysłane do moderatora.<br>Dziękujemy!<br><br><a href=javascript:window.close()>Zamknij okno</a>";
}
?>
</center>
</BODY>
</HTML>
