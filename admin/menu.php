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
$autoryzacja = mysql_query("select*from komentarze where auth=\"nie\"");
$czy_sa = mysql_num_rows($autoryzacja);
if($czy_sa != 0) {
    print "<tr><td><a target=admin href=komentarze.php?akcja=autoryzuj><font color=red><b>KOMENTARZE ($czy_sa)</font></b></a></td></tr>";
}
print "aaaaa $user tttt $haslo";
print "<tr><td><b><a href=aktualnosci.php?ktory=0 target=admin>Newsy</b></td></tr>";
print "<tr><td><a href=aktualnosci.php?akcja=dopisz&user=$user&haslo=$haslo target=admin>Dopisz newsa</a></td></tr>";
print "<tr><td><a href=aktualnosci.php?akcja=edit&ktory=0 target=admin>Edytuj newsa</a></td></tr>";
print "<tr><td><b><a href=media.php target=admin>Media</b></td></tr>";
print "<tr><td><a href=media.php?akcja=dopisz target=admin>Dodaj wpis</a></td></tr>";
print "<tr><td><a href=media.php?akcja=edit target=admin>Edytuj wpis</a></td></tr>";
print "</table>";
?>
</BODY>
</HTML>
