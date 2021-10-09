<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<style type=text/css>
<!--
a:link {color:blue; text-decoration:none; font-size:11px; font-family:arial,verdana};
a:visited {color:blue; text-decoration:none; font-size:11px; font-family:arial,verdana};
a:hover {color:red; font-size:11px; font-family:arial,verdana};
//-->
</style>
</HEAD>
<BODY>
<table border=1>
<?
include("polacz.php");
?>
<tr><td><b><a href=wydarzenia.php?ktory=0 target=admin>Wydarzenia</b></td></tr>
<tr><td><a href=wydarzenia.php?akcja=dopisz target=admin>Dopisz wydarzenie</a></td></tr>
<tr><td><a href=wydarzenia.php?akcja=edit&ktory=0 target=admin>Edytuj wydarzenie</a></td></tr>
<tr><td><a href=lista.php?akcja=usun target=admin><b>Usuń wpis z listy</b></a></td></tr>
<tr><td><a href=kom_kolory.php target=admin><b>K</b>olory</a></td></tr>
<tr><td><a href=kom_kolory.php?akcja=dopisz target=admin>Dopisz kolor</a></td></tr>
<tr><td><a href=kom_vip.php target=admin><b>N</b>adaj/odbierz vipa</a></td></tr>
</table>
</BODY>
</HTML>
