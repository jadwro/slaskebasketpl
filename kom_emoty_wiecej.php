<HTML>
<HEAD>
<TITLE>Emotikony :: SLASK.e-basket.pl ::</TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
</HEAD>
<style type=text/css>
<!--
.tekst_gl {FONT-SIZE: 11px; font-family:Verdana,Arial; text-align:justify}
.tekst {FONT-SIZE: 12px; font-family:Verdana,Arial; TEXT-ALIGN:justify; FONT-VARIANT:normal}
a.tekst:link {color:black};
a.tekst:hover {color:black; text-decoration:underline};
.kto {font-family:verdana; font-size:23px; font-weight:bold};
a.kwarta:link {font-family:verdana,arial; font-size:10px; text-decoration:none; color:black};
a.kwarta:visited {font-family:verdana,arial; font-size:10px; text-decoration:none; color:black};
a.kwarta:hover {font-family:verdana,arial; font-size:10px; text-decoration:underline; color:black};
//-->
</style>
<BODY bgcolor=#f0f0f0>
<SCRIPT language=javascript type=text/javascript>
<!--
function emoticon(text) {
   text = ' ' + text + ' ';
   if (opener.document.forms['komen'].tresc.createTextRange && opener.document.forms['komen'].tresc.caretPos) {
      var caretPos = opener.document.forms['komen'].tresc.caretPos;
      caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
      opener.document.forms['komen'].tresc.focus();
   } else {
      opener.document.forms['komen'].tresc.value  += text;
      opener.document.forms['komen'].tresc.focus();
   }
}
//-->
</SCRIPT>
<?
include("polacz.php");
$pobierz = mysql_query("select*from kom_emot");
print "<center><a class=kwarta href=javascript:window.close()>Zamknij okno</a></center>";
print "<br><table border=1 bordercolor=black cellspacing=0 cellpadding=1>";
while($rekord = mysql_fetch_array($pobierz)) {
   $rekord[nazwa] = str_replace("<","&#60;",$rekord[nazwa]);
   $rekord[nazwa] = str_replace(">","&#62;",$rekord[nazwa]);
   print "<tr><td><center><a href=javascript:emoticon('$rekord[nazwa]')><img border=0 src=http://grafika.slask.e-basket.pl/$rekord[adres] alt=\"$rekord[nazwa]\"></center></a></td><td class=tekst><center>$rekord[nazwa]</center></td></tr>";
}
print "</table>";
print "<br><center><a class=kwarta href=javascript:window.close()>Zamknij okno</a></center>";
?>
</BODY>
</HTML>
