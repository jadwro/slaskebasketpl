<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
</HEAD>
<BODY>
<?
include("polacz.php");
function usun($id) {
   if($id=="") {
      print "<form action=lista.php?akcja=usun method=post>";
      print "Podaj nr wpisu do usuniecia #<input type=text name=id size=3>";
      print " <input type=submit value=Usun!>";
      print "</form>";
   } else {
      $sio = mysql_query("delete from komentarze where id='$id'");
      if($sio) {
         print "Usunalem.<br><a href=javascript:history.back(-1)>Powrot</a>";
      } else {
         print "NIE usunalem.";
      }
   }
}

if($akcja=="usun") {
   usun($id);
}
?>
</BODY>
</HTML>
