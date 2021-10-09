<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
</HEAD>
<BODY>
<?
include("polacz.php");

function media() {
   global $id;
   $wez = mysql_fetch_array(mysql_query("select adres,kliki from media where id='$id'"));
   $klik = $wez[kliki]+1;
   $popraw = mysql_query("update media set kliki='$klik' where id='$id'");
   print "Przekierowywanie na adres: <a href=$wez[adres]>$wez[adres]</a>...";
   print "<script langue=javascript>window.location.href='$wez[adres]'</script>";
}

function linki() {
   global $id;
   $wez = mysql_fetch_array(mysql_query("select adres,kliki from linki where id='$id'"));
   $klik = $wez[kliki]+1;
   $popraw = mysql_query("update linki set kliki='$klik' where id='$id'");
   print "Przekierowywanie na adres: <a href=$wez[adres]>$wez[adres]</a>...";
   print "<script langue=javascript>window.location.href='$wez[adres]'</script>";
}

switch($wh) {
   case "media":
   media();
   break;
   case "linki":
   linki();
   break;
}
?>
</BODY>
</HTML>
