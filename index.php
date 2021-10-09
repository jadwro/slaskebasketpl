<?
ob_start("ob_gzhandler");
include("techniczne/tabele.php");
?>
<HTML>
<HEAD>
<TITLE>Cała Polska w cieniu Śląska :: SLASK.e-basket.pl ::</TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<meta name="Keywords" CONTENT="era, fiba, euro, cup, eurocup, śląsk, slask, wrocław, wroclaw, Śląsk Wrocław, Slask Wroclaw, Slask, Wroclaw, Idea, idea, Śląsk, Wrocław, koszykówka, koszykowka, basket, slask.e-basket.pl, e-basket, kosz, sport, wójcik, wojcik, zieliński, zieliński, massie, aubry, tomczyk, wiekiera, skibniewski, skiba, tein, miglinieks, marciulionis, phlelps, mroz, mróz, ignerski, chanas, schetyna, prezes, katzurin, muli, urlep, repesa, buchhi, mecz, mecze, sparing, plk, polska, liga, koszykowki, polska liga koszykowki, euro, euroliga, suproliga, uleb, fiba, cala, cała, cala polska w cieniu slaska, cała polska w cieniu śląska, wks, qrczakmazur">
<meta name="DESCRIPTION" content="Nieoficjalny serwis Ery śląska Wrocław. Newsy, relacje, wywiady, zdjęcia, Dominet Basket Liga, FIBA EuroCUP... Zapraszamy!">
<LINK href="techniczne/style.css" type=text/css rel=stylesheet>
<script langue=javascript>
<!--
function duze(adres) {
var myWin = window.open('duze.php?id='+adres,'zdjecie','align=center,toolbar=no,status=no,location=no,directories=no,resizable=no,scrollbars=yes,width=417,height=550,menubar=no');
}

function zglos(id) {
var myWin = window.open('zglos.php?id='+id,'zdjecie','align=center,toolbar=no,status=no,location=no,directories=no,resizable=no,scrollbars=yes,width=150,height=150,menubar=no');
}
-->
</script>
</HEAD>

<?
function do_sl($zapytanie) {
   $er = "eb_slask";
   $ord ="sd345@#";
   $db = "ebasket_slask";
   $sql = mysql_connect("192.168.11.102",$er,$ord);
   $err = mysql_error();
   if ($err !="") { echo"<br>awaria polaczenia: $err";die(); }
   $err="";
   mysql_select_db($db,$sql);
   $err = mysql_error();
   if ($err !="") { echo"<br>awaria bazy: $err";die();}
   $err="";
   $wykonaj = mysql_query($zapytanie);
   $err = mysql_error();
   if ($err !="") {echo"<br>awaria sql: $err";die();}
   return $wykonaj;
}
?>
<BODY onload=init2() bgcolor=#aaaaaa>
<? include("polacz.php"); ?>
<!---------------------------------- GLOWNA TABELA --------------------------------->
<center>
<table border=0 cellspacing=0 cellpadding=1 width=740 bgcolor=black>
<tr><td>
<TABLE height=80 cellSpacing=0 cellPadding=0 width="100%" bgColor=#ececec border=0>
<!-------------------------------- TABELA STRONY ----------------------------->
<TR><TD colspan=2>
<?
include("logo.php");
?>
</td></tr>
</table>
</TD></TR>
<TR><TD valign=top colspan=2 valign=top>
<table border=0 cellspacing=0 cellpadding=0>
<tr><td>
<script langue=javascript src="techniczne/menu/stm31.js"></script>
<SCRIPT language=JavaScript>
<!--
beginSTM("exnvfhr","static","0","0","left","false","true","310","50","0","0","","blank.gif");
beginSTMB("auto","0","0","horizontally","blank.gif","0","0","0","2","#ffffff","","tiled","#000000","1","solid","0","Normal","50","0","0","0","0","0","0","2","#000000","false","#000000","#000000","#000000","none");
appendSTMI("false","Drużyna&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","left","top","","","-1","-1","0","normal","#eeeeee","#bcbfc0","","1","-1","-1","blank.gif","blank.gif","0","0","0","","http://slask.e-basket.pl/?dzial=1","_self","Verdana","9pt","#000000","bolder","normal","none","Verdana","9pt","#000000","bold","normal","none","0","none","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Drużyna","","","tiled","tiled");
beginSTMB("auto","-1","0","vertically","","0","0","0","1","#ffffff","","tiled","#000000","1","solid","0","Normal","50","0","0","0","0","0","0","0","#000000","false","#000000","#000000","#000000","none");
appendSTMI("false","Skład","left","top","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=1","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Skład","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#000000","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Arial","8pt","#ffffff","bold","normal","none","Arial","8pt","#ff0000","bold","normal","none","0","none","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","","","","tiled","tiled");
appendSTMI("false","Hala","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=3","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Hala","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#000000","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Arial","8pt","#ffffff","bold","normal","none","Arial","8pt","#ff0000","bold","normal","none","0","none","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","","","","tiled","tiled");
appendSTMI("false","Informacje&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=4","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Informacje","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#000000","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Arial","8pt","#ffffff","bold","normal","none","Arial","8pt","#ff0000","bold","normal","none","0","none","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","","","","tiled","tiled");
appendSTMI("false","Historia","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=5","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Historia","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#000000","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Arial","8pt","#ffffff","bold","normal","none","Arial","8pt","#ff0000","bold","normal","none","0","none","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","","","","tiled","tiled");
appendSTMI("false","Galeria","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=23","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Galeria","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#000000","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Arial","8pt","#ffffff","bold","normal","none","Arial","8pt","#ff0000","bold","normal","none","0","none","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","","","","tiled","tiled");
appendSTMI("false","Śląsk II","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?dzial=8","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Galeria","","","tiled","tiled");
endSTMB();
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#000000","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Arial","8pt","#ffffff","bold","normal","none","Arial","8pt","#ff0000","bold","normal","none","0","none","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","","","","tiled","tiled");
appendSTMI("false","Liga&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","left","middle","","","-1","-1","0","normal","#eeeeee","#bcbfc0","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?dzial=2","_self","Verdana","9pt","#000000","bolder","normal","none","Verdana","9pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Liga","","","tiled","tiled");
beginSTMB("auto","-1","0","vertically","","0","0","0","1","#ffffff","","tiled","#000000","1","solid","0","Normal","50","0","0","0","0","0","0","0","#000000","false","#000000","#000000","#000000","none");
appendSTMI("false","Terminarz","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=8","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Terminarz","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#000000","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Arial","8pt","#ffffff","bold","normal","none","Arial","8pt","#ff0000","bold","normal","none","0","none","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","","","","tiled","tiled");
appendSTMI("false","Wyniki&nbsp;i&nbsp;tabele","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=9","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Wyniki i tabele","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#000000","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Arial","8pt","#ffffff","bold","normal","none","Arial","8pt","#ff0000","bold","normal","none","0","none","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","","","","tiled","tiled");
appendSTMI("false","Kluby","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=10","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Kluby","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#000000","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Arial","8pt","#ffffff","bold","normal","none","Arial","8pt","#ff0000","bold","normal","none","0","none","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","","","","tiled","tiled");
appendSTMI("false","Statystyki","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=17","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Statystyki","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","Teksty","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=13","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Teksty","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#000000","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Arial","8pt","#ffffff","bold","normal","none","Arial","8pt","#ff0000","bold","normal","none","0","none","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","","","","tiled","tiled");
appendSTMI("false","Śląsk II","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?dzial=8","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Galeria","","","tiled","tiled");
endSTMB();
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","FIBA EuroCUP&nbsp;&nbsp;&nbsp;","left","middle","","","-1","-1","0","normal","#eeeeee","#bcbfc0","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?dzial=11","_self","Verdana","9pt","#000000","bolder","normal","none","Verdana","9pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","FIBA EuroCUP","","","tiled","tiled");
beginSTMB("auto","-1","0","vertically","","0","0","0","1","#ffffff","","tiled","#000000","1","solid","0","Normal","50","0","0","0","0","0","0","0","#7f7f7f","false","#000000","#000000","#000000","none");
appendSTMI("false","Terminarz","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=45","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Terminarz","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","Wyniki&nbsp;i&nbsp;tabele","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=46","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Wyniki i tabele","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","Statystyki","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=48","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Statystyki","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","Teksty","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=47","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Teksty","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","Euroliga","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?dzial=3","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Euroliga","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","Puchar ULEB","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?dzial=9","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Euroliga","","","tiled","tiled");
endSTMB();
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","Nasi...&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","left","middle","","","-1","-1","0","normal","#eeeeee","#bcbfc0","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?dzial=4","_self","Verdana","9pt","#000000","bolder","normal","none","Verdana","9pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Nasi...","","","tiled","tiled");
beginSTMB("auto","-1","0","vertically","","0","0","0","1","#ffffff","","tiled","#000000","1","solid","0","Normal","50","0","0","0","0","0","0","0","#7f7f7f","false","#000000","#000000","#000000","none");
appendSTMI("false","...&nbsp;byli&nbsp;gracze","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=11","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","... byli gracze","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","...&nbsp;przeciwnicy","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=12","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","... przeciwnicy","","","tiled","tiled");
endSTMB();
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","Inne&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","left","middle","","","-1","-1","0","normal","#eeeeee","#bcbfc0","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?dzial=5","_self","Verdana","9pt","#000000","bolder","normal","none","Verdana","9pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Inne","","","tiled","tiled");
beginSTMB("auto","-26","0","vertically","","0","0","0","1","#ffffff","","tiled","#000000","1","solid","0","Normal","50","0","0","0","0","0","0","0","#7f7f7f","false","#000000","#000000","#000000","none");
appendSTMI("false","L. dyskusyjna","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://lista.slask.e-basket.pl","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","L. dyskusyjna","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","Multimedia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=20","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Multimedia","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","Linki&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=19","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Linki","","","tiled","tiled");
appendSTMI("false","Menu&nbsp;Item&nbsp;1","left","middle","","","-1","-1","0","sepline","#000000","#eeeeee","blank.gif","1","-1","-1","","","-1","-1","0","","","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","","","","tiled","tiled");
appendSTMI("false","Chat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","left","middle","","","-1","-1","0","normal","#0068d0","#eeeeee","","1","-1","-1","blank.gif","blank.gif","-1","-1","0","","http://slask.e-basket.pl/?poddzial=30","_self","Verdana","8pt","#ffffff","bold","normal","none","Verdana","8pt","#000000","bold","normal","none","0","solid","#000000","#000000","#000000","#000000","#000000","#000000","#000000","#000000","Chat","","","tiled","tiled");
endSTMB();
endSTMB();
endSTM();
//-->
</SCRIPT>
</td>
<form action=index.php>
<td class=gora>
<table border=0 cellspacing=0 cellpadding=0>
<tr><td><input type=text name=szukaj size=15 class=szukaj onfocus="if(this.value=='Szukaj...') {this.value='';}" onblur="if(this.value=='') {this.value='Szukaj...';}" value='Szukaj...'>&nbsp;<select name=gdzie class=zawodnicy><option value=news >w newsach<option value=zdjecia>w galerii</select>&nbsp;<input class=szukaj type=submit value=Szukaj></td></tr>
</table>
</td></tr>
</form>
<tr><td width=740 colspan=2 background=http://grafika.slask.e-basket.pl/grafika/kropki_gora.jpg></td></tr>
<tr><td class=miejsce>&nbsp;<? include("techniczne/miejsce.php"); ?></td><td class=kwarta align=right><a class=kwarta href=http://slask.e-basket.pl/?poddzial=23><b>GALERIA</b></a> | <a class=kwarta target=_blank href=http://lista.slask.e-basket.pl><b>LISTA DYSKUSYJNA</b></a> | <a class=kwarta href=http://slask.e-basket.pl/?poddzial=30><b>CHAT [<script language="javascript" src="http://www.polchat.pl/ile/?room=slask.e-basket.pl"></script>]</b></a> &nbsp;</a></td></tr>
<tr><td></td></tr>
</table>
</td></tr>
<tr><td colspan=2 background=http://grafika.slask.e-basket.pl/grafika/kropki_gora.jpg></td></tr>
<tr><td width=535 valign=top background=http://grafika.slask.e-basket.pl/grafika/kropki_prawo.jpg>
<!--------------------------------- TRESC STRONY ----------------------------->
<table cellspacing=0 cellpadding=0 align=center width=525 border=0>
<tr><td><font class=tekst>
<?
if($szukaj) {
   include("szukaj.htm");
} elseif($news) {
   include("aktualnosci.htm");
} else {
   if($dzial) {
      $wez_dzialy = mysql_fetch_array(mysql_query("select*from dzialy where id='$dzial'"));
      include("$wez_dzialy[adres]");
   } elseif($poddzial) {
      $wez_poddzialy = mysql_fetch_array(mysql_query("select*from poddzialy where id='$poddzial'"));
      include("$wez_poddzialy[adres]");
   } elseif($podpoddzial) {
      $wez_podpoddzialy = mysql_fetch_array(mysql_query("select*from podpoddzialy where id='$podpoddzial'"));
      include("$wez_podpoddzialy[adres]");
   } elseif($mecz) {
      include("mecze.htm");
   } elseif((!isset($id)) || ((!$dzial) && (!$poddzial) && (!$podpoddzialu)) && (!$news) && (!$szukaj)) {
      include("aktualnosci.htm");
   }
}
?>
<br><br>
</td></tr>
</table>
<!-------------------------------------- KONIEC TRESCI ------------------------>
</td>
<td valign=top align=center width=205 bgcolor=#eeeeee>
<!--------------------------- PRAWA -------------------------------->
<TABLE cellSpacing=0 cellPadding=0 align=center border=0 width=195>
<TR><TD>
<br>
<?
if($poddzial!=35) {
   include("techniczne/menu.php");
   include("techniczne/wyswietl.php");
} else {
   include("lista_prawa.php");
}
?>

</TD></TR>
</TABLE>

<!-- flash -->
<P ALIGN="CENTER"><OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0"
 WIDTH=150 HEIGHT=70>
 <PARAM NAME=movie VALUE="http://grafika.slask.e-basket.pl/grafika/design.swf"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF> <EMBED src="http://grafika.slask.e-basket.pl/grafika/design.swf" quality=high bgcolor=#FFFFFF  WIDTH=150 HEIGHT=70 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>
</OBJECT></P><br>
<!-- koniec flasha :) -->
<!-------------------------------- KONIEC PRAWEJ ---------------------------->
</td></tr>
<tr><td width=740 colspan=2 background=http://grafika.slask.e-basket.pl/grafika/kropki_gora.jpg></td></tr>
<tr><td bgcolor=#dfdfdf align=center class=tekst_gl><b><center>Copyright &copy by slask.e-basket.pl. All rights reserved.</td><td bgcolor=#dfdfdf align=center class=tekst_gl><img src=grafika/kwadrat.jpg align=middle> <a href=?poddzial=22 class=czarny><b>Redakcja</b></a> <img src=grafika/kwadrat.jpg align=middle> <a href=?poddzial=31 class=czarny><b>Współpraca</b></a> <img src=grafika/kwadrat.jpg align=middle> <a href=?poddzial=32 class=czarny><b>Reklama</b></a></CENTER></B>
<!-- KONIEC TABELI STRONY -->
</table>
</td></tr>
</table>
<!-- KONIEC GLOWNEJ TABELI -->
</BODY>
</HTML>
<?
  ob_end_flush(); 
?>

