<HTML>
<HEAD>
<TITLE>Zdjęcie :: SLASK.e-basket.pl ::</TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<script langue=javascript>
<!--
function duze(adres) {
var myWin = window.open('duze.php?id='+adres,'zdjecie','align=center,toolbar=no,status=no,location=no,directories=no,resizable=no,scrollbars=yes,width=417,height=550,menubar=no');
}
-->
</SCRIPT>
<style type=text/css>
<!--
.tekst {font-family:verdana,arial; font-size:12px; font-weight:bold};
.tekst2 {font-family:verdana,arial; font-size:12px};
//-->
</style>
</HEAD>
<BODY leftmargin=0 topmargin=0 bgcolor=#eeeeee>
<?
include("polacz.php");
print "<center>";

if(($co=="pop") || ($co=="next")) {
   $znak = ($co=="next") ? '>' : '<';
   $ukl = ($co=="next") ? 'ASC' : 'DESC';
   $zdjecie = mysql_fetch_array(mysql_query("select id,opis,data,kliki,autor,galeria,adres from galeria where id". $znak ."'$id' AND galeria!=0 order by id $ukl limit 1"));
   $id="$zdjecie[id]";
} else {
   $zdjecie = mysql_fetch_array(mysql_query("select opis,data,kliki,autor,galeria,adres from galeria where id='$id' AND galeria!=0"));
}
$zdjecie[kliki] = $zdjecie[kliki]+1;
$kliki = mysql_query("update galeria set kliki='$zdjecie[kliki]' where id='$id'");
$dni = mysql_fetch_array(mysql_query("select to_days(curdate())-to_days('$zdjecie[data]') as dni from galeria where id='$id'"));
$dni[dni] = $dni[dni]+1;
$srednia = $zdjecie[kliki]/$dni[dni];
$galeria = mysql_fetch_array(mysql_query("select id,nazwa from galeria_kat where id='$zdjecie[galeria]'"));

print "<table border=0 cellspacing=0 cellpadding=0><tr><td width=50 class=tekst2>&nbsp;&nbsp;  <a href=javascript:duze('$id&co=pop')><img border=0 src=http://grafika.slask.e-basket.pl/grafika/strzalka4.gif></a></td><td class=tekst align=center width=300>$galeria[nazwa]</td><td class=tekst2 align=right width=50><font color=red><a href=javascript:duze('$id&co=next')><img border=0 src=http://grafika.slask.e-basket.pl/grafika/strzalka3.gif></a>  &nbsp;&nbsp;</font></td></tr></table>";
print "<a href=javascript:window.close()><img src=http://grafika.slask.e-basket.pl/$zdjecie[adres] border=0 alt=\"Kliknij, aby zamknąć\"></a>";
print "<br><br><font class=tekst>$zdjecie[opis]</font>";
print "<br><br><font class=tekst2>Zdjęcie oglądane $zdjecie[kliki] razy od $zdjecie[data] (".round($srednia,1)." razy dziennie)</font>";
print "<br><br><font class=tekst2><b>Fot.</b> $zdjecie[autor]</font>";
print "<br><br></center>";
?>
</BODY>
</HTML>