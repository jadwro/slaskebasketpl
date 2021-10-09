<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
</HEAD>
<BODY>
<?
include("polacz.php");

print "<form action=glowna.php method=post>";
print "<input type=hidden name=czy value=tak>";
print "Login <input type=text name=loginek>";
print "<br>Hasło <input type=password name=haslo_user>";
print "<br><input type=submit value=Loguj>";
print "</form>";
?>
</BODY>
</HTML>
