<?
if($dzial == "6") {
   $poddzial="11";
}

if($dzial == "7") {
   $poddzial="12";
}

if(($dzial) && ($dzial!=6)) {
   $poddzialy = mysql_query("select id,nazwa from poddzialy where dzial = '$dzial'");
?>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
<TR><TD ALIGN="CENTER">
<IMG SRC="http://grafika.slask.e-basket.pl/grafika/menu.gif" WIDTH=200 HEIGHT=20 BORDER=0>
</TD></TR>
</TABLE>
<TABLE bgcolor=#eeeeee WIDTH="200" CELLSPACING="0" CELLPADDING="0" BORDER="1" BORDERCOLOR="#dddddd" RULES="NONE" STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
<TR><TD VALIGN="TOP" WIDTH="200">

<table cellspacing=0 cellpadding=0 width=184 bgcolor=gray border=0 align=center>
<tr><td>
<table cellspacing=1 cellpadding=2 width="100%" bgcolor=gray border=0>
<?
while($rekord = mysql_fetch_array($poddzialy)) {
   print "<tr><td bgcolor=#eeeeee onmouseover=this.style.backgroundColor='#ffffff';this.style.cursor='hand';this.className='najedz' onmouseout=this.style.backgroundColor='#eeeeee';this.className='zjedz' onclick=window.location.href='?poddzial=$rekord[id]' class=zjedz>&nbsp;".strtoupper($rekord[nazwa])."</font></td></tr>";
}
?>
</table>
</td></tr>
</table>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
</td></tr>
</table>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
<TR><TD ALIGN="CENTER">
<IMG SRC="http://grafika.slask.e-basket.pl/grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>

<br><br>
<?
}

if((($poddzial) || ($podpoddzial)) && ($poddzial!=11)) {
if(($poddzial != 6) && ($poddzial != 22) && ($poddzial != 31) && ($poddzial != 32)) {
   if($podpoddzial) {
      $wez = mysql_fetch_array(mysql_query("select poddzial from podpoddzialy where id='$podpoddzial'"));
      $poddzial = $wez[poddzial];
   }
   $wezdzial1 = mysql_query("select dzial from poddzialy where id='$poddzial'");
   $wezdzial = mysql_fetch_array($wezdzial1);
   $dzial = "$wezdzial[dzial]";
   $wezpoddzialy = mysql_query("select id,nazwa from poddzialy where dzial='$wezdzial[dzial]'");
?>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
   <TR><TD ALIGN="CENTER">
   <IMG SRC="http://grafika.slask.e-basket.pl/grafika/menu.gif" WIDTH="200" HEIGHT="20" BORDER="0">
   </TD></TR>
   </TABLE>
   <TABLE bgcolor=#eeeeee WIDTH="200" CELLSPACING="0" CELLPADDING="0" BORDER="1" BORDERCOLOR="#dddddd" RULES="NONE" STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
   <TR><TD VALIGN="TOP" WIDTH="200">

   <table cellspacing=0 cellpadding=0 width=184 bgcolor=gray border=0 align=center>
   <tr><td>
   <table cellspacing=1 cellpadding=2 width="100%" bgcolor=gray border=0>
<?
while($rekord = mysql_fetch_array($wezpoddzialy)) {
   $podpoddzialy = mysql_query("select poddzial from podpoddzialy where poddzial='$poddzial'");
   $rekord2 = mysql_fetch_array($podpoddzialy);
   print "<tr><td bgcolor=#eeeeee onmouseover=this.style.backgroundColor='#ffffff';this.style.cursor='hand';this.className='najedz' onmouseout=this.style.backgroundColor='#eeeeee';this.className='zjedz' onclick=window.location.href='?poddzial=$rekord[id]' class=zjedz>&nbsp;".strtoupper($rekord[nazwa])."</font></td></tr>";
   if($rekord[id] == $rekord2[poddzial]) {
      $podpoddzialy2 = mysql_query("select id,nazwa,poddzial from podpoddzialy where poddzial='$poddzial'");
      print "<tr><td bgcolor=#f5f5f5><table border=0 cellspacing=0 cellpadding=0 width=184>";
      while($rekord3 = mysql_fetch_array($podpoddzialy2)) {
         print "<tr><td bgcolor=#f5f5f5 class=male>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=grafika/strzalka.gif> <a class=male href=?podpoddzial=$rekord3[id]>$rekord3[nazwa]</a></td></tr>";
      }
      print "</table></td></tr>";
   }
}
?>
</table>
</td></tr>
</table>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
</td></tr>
</table>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
<TR><TD ALIGN="CENTER">
<IMG SRC="http://grafika.slask.e-basket.pl/grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>

<br><br>
<?
}
}

if($poddzial=="11") {
?>
   <TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
   <TR><TD ALIGN="CENTER">
   <IMG SRC="http://grafika.slask.e-basket.pl/grafika/menu.gif" WIDTH="200" HEIGHT="20" BORDER="0">
   </TD></TR>
   </TABLE>
   <TABLE bgcolor=#eeeeee WIDTH="200" CELLSPACING="0" CELLPADDING="0" BORDER="1" BORDERCOLOR="#dddddd" RULES="NONE" STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
   <TR><TD VALIGN="TOP" WIDTH="200">

   <table cellspacing=0 cellpadding=0 width=184 bgcolor=gray border=0 align=center>
   <tr><td>
   <table cellspacing=1 cellpadding=2 width="100%" bgcolor=gray border=0>
<?
   $gracze = mysql_query("select id,imie,nazwisko from byligracze");
   print "<tr><td bgcolor=#eeeeee onmouseover=this.style.backgroundColor='#ffffff';this.style.cursor='hand';this.className='najedz' onmouseout=this.style.backgroundColor='#eeeeee';this.className='zjedz' onclick=window.location.href='?poddzial=11' class=zjedz>&nbsp;NASI BYLI GRACZE</font></td></tr>";
   while($rekord = mysql_fetch_array($gracze)) {
      print "<tr><td bgcolor=#f5f5f5 class=male>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=grafika/strzalka.gif> <a class=male href=?poddzial=11&zawodnik=$rekord[id]>$rekord[imie] $rekord[nazwisko]</a></td></tr>";
   }
   print "<tr><td bgcolor=#eeeeee onmouseover=this.style.backgroundColor='#ffffff';this.style.cursor='hand';this.className='najedz' onmouseout=this.style.backgroundColor='#eeeeee';this.className='zjedz' onclick=window.location.href='?poddzial=12' class=zjedz>&nbsp;NASI PRZECIWNICY</font></td></tr>";
   print "</table>";
?>
</td></tr>
</table>
</td></tr>
<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
</table>

<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
<TR><TD ALIGN="CENTER">
<IMG SRC="http://grafika.slask.e-basket.pl/grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>
<br><br>
<?
}
?>

