<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
</HEAD>
<BODY>
<?
include("polacz.htm");
$dzien = date("d",time());
$miesiac = date("m",time());
$rok = date("Y",time());

$wez_wyd = mysql_query("select id,godzina,dzien,miesiac,miesiac_num,rok,tytul,tresc,obrazek,tlo,aktualne,dzial from wydarzenia where aktualne='tak' order by id desc");
if(mysql_num_rows($wez_wyd) != 0) {
   $rekord = mysql_fetch_array($wez_wyd);
   print "<br><table border=0 cellspacing=0 cellpadding=1>";
   print "<tr><td background=http://grafika.slask.e-basket.pl/grafika/kropkinews.jpg class=tytul_newsa width=515 colspan=2 height=20>&nbsp;<font color=#CC3300>Wydarzenia:</font> $rekord[tytul]</td></tr>";
   print "<tr><td bgcolor=#efefef class=data_newsa>$rekord[dzien] $rekord[miesiac] $rekord[rok] ($rekord[godzina]) - <b>$rekord[dzial]</b></font>";
   print "</td>";
   print "<td valign=top bgcolor=#efefef align=right class=male></td></tr>";
   print "<tr><td width=500 background=$rekord[tlo] bgcolor=#efefef class=tekst_gl colspan=2>";
   if($rekord[obrazek] != "") {
      $zdj = mysql_fetch_array(mysql_query("select adres,nazwa,wys,szer from zdjecia where id='$rekord[obrazek]'"));
      if($zdj[wys] == 0) {
         $wys = "";
      } else {
         $wys = "height=$zdj[wys]";
      }
      print "<img src='http://grafika.slask.e-basket.pl/$zdj[adres]' alt='$zdj[nazwa]' width=$zdj[szer] $wys border=1 hspace=7 align=left>";
   }
   print "<font color=#ffffff>$rekord[tresc]</font>";
   print "</td></tr>";
   print "<tr><td bgcolor=#efefef></td><td bgcolor=#efefef></td></tr><tr><td bgcolor=#efefef></td><td bgcolor=#efefef></td></tr>";
   print "</table>";
   print "<br>";
}
?>
</BODY>
</HTML>
