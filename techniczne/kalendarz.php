<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0">
<TR><TD ALIGN="CENTER">
<IMG SRC="grafika/archiwum.gif" WIDTH="200" HEIGHT="20" BORDER="0">
</TD></TR>
</TABLE>
<TABLE WIDTH="200" CELLSPACING="0" CELLPADDING="0" BORDER="1" BORDERCOLOR="#dddddd" RULES="NONE" STYLE="margin-top: -5px; padding-top: 3; padding-bottom: 3; padding-left: 3; padding-right: 3">
<TR><TD VALIGN="TOP" WIDTH="200">

<form method=get action=index.php>
<center>

<?php
if($m) {
$tmpd = getdate(mktime(0, 0, 0, $m, 0, $r));
#$month = $tmpd["mon"];
$month = date("m",time());

if($month == 1) { $miesiac = "Styczeñ"; }
if($month == 2) { $miesiac = "Luty"; }
if($month == 3) { $miesiac = "Marzec"; }
if($month == 4) { $miesiac = "Kwiecieñ"; }
if($month == 5) { $miesiac = "Maj"; }
if($month == 6) { $miesiac = "Czerwiec"; }
if($month == 7) { $miesiac = "Lipiec"; }
if($month == 8) { $miesiac = "Sierpieñ"; }
if($month == 9) { $miesiac = "Wrzesieñ"; }
if($month == 10) { $miesiac = "Pa¼dziernik"; }
if($month == 11) { $miesiac = "Listopad"; }
if($month == 12) { $miesiac = "Grudzieñ"; }

$fwday= $tmpd["wday"];
#$year = $tmpd["year"];
$year = date("Y",time());
$month_textual = $tmpd["month"];
#$today = date("F, Y");            
echo"<a class=monthyear href=?poddzial=6&m=$month&r=$year&kat=$kat>$miesiac $year</a>";
}
else {
$month=$sel_month;
$tmpd = getdate(mktime(0, 0, 0, date("m"), 0, date("Y")));
#$month = $tmpd["mon"];
$month = date("m",time());

if($month == 1) { $miesiac = "Styczeñ"; }
if($month == 2) { $miesiac = "Luty"; }
if($month == 3) { $miesiac = "Marzec"; }
if($month == 4) { $miesiac = "Kwiecieñ"; }
if($month == 5) { $miesiac = "Maj"; }
if($month == 6) { $miesiac = "Czerwiec"; }
if($month == 7) { $miesiac = "Lipiec"; }
if($month == 8) { $miesiac = "Sierpieñ"; }
if($month == 9) { $miesiac = "Wrzesieñ"; }
if($month == 10) { $miesiac = "Pa¼dziernik"; }
if($month == 11) { $miesiac = "Listopad"; }
if($month == 12) { $miesiac = "Grudzieñ"; }

$fwday= $tmpd["wday"];
#$year = $tmpd["year"];
$year = date("Y",time());
$month_textual = $tmpd["month"];
echo "<a class=monthyear href=?poddzial=6&m=$month&r=$year&kat=$kat>$miesiac $year</a>";
}
echo"<br>";
if($month == 2) {
 if(($year%4) == 0) {
  $no_days = 29;
}
 else {
  $no_days = 28;
 }
}
elseif(($month == 1) || ($month == 3) || ($month == 5) ||  
($month == 7) ||  ($month == 8) ||  ($month == 10) ||  ($month == 12)) {
 $no_days = 31;
}
else {
 $no_days = 30;
}

echo"<table width=175 border=0 cellspacing=0 cellpadding=2 class=daynames>";
echo"<td class=male width=25>Pn</td><td class=male width=25>Wt</td><td class=male width=25>¦r</td>
<td width=25 class=male>Czw</td><td width=25 class=male>Pt</td><td width=25 class=male width=25>Sob</td><td width=25 class=male>Nie</td>";
echo"</tr></table>";
echo "<table border=0 cellspacing=2 cellpadding=1 width=175>";
echo "<TR>";

#$firstday = date("l", mktime(0, 0, 0, 7, 1, 2001));

if($fwday == 0) {
 $index = 1;
}
if($fwday == 1) {
 $index = 2;
}
if($fwday == 2) {
 $index = 3;
}
if($fwday == 3) {
 $index = 4;
}
if($fwday == 4) {
 $index = 5;
}
if($fwday == 5) {
 $index = 6;
}
if($fwday == 6) {
 $index = 7;
}

#echo $index;
$count = 0;
#$day = date("l", mktime(0, 0, 0, 8, $i, 2001));
for($a = 1; $a <= $fwday; $a++) {
 echo"<td></td>";
}
for($i = 1; $i <= (7 - $fwday) ; $i++) {
echo"<td class=dates align=center>
<a href=?poddzial=6&d=$i&m=$month&r=$year&kat=$kat>
$i</td>";
$count++;
}
echo"</tr>";

echo"<tr>";
for($j = $i; $j <= ($i + 6); $j++) {
echo"<td class=dates align=center>
<a href=?poddzial=6&d=$j&m=$month&r=$year&kat=$kat>
$j </td>";
}
echo"</tr>";

echo"<tr>";
for($k = $j; $k <= ($j + 6); $k++) {
echo"<td class=dates align=center>
<a href=?poddzial=6&d=$k&m=$month&r=$year&kat=$kat>
$k</td>";
}
echo"</tr>";

echo"<tr>";
for($l = $k; $l <= ($k + 6); $l++) {
echo"<td class=dates align=center>
<a href=?poddzial=6&d=$l&m=$month&r=$year&kat=$kat>
$l</td>";
}
echo"</tr>";


if(($no_days - $l) >= 7) {
echo"<tr>";
$tr = "</tr>";
$roll_over = $l + 6;
}
for($m = $l; $m <= $roll_over; $m++) {
echo"<td class=dates align=center>
<a href=?poddzial=6&d=$m&m=$month&r=$year&kat=$kat>
$m </td>";
}
echo $tr;

echo"<tr>";
for($n = $m; $n <= $no_days; $n++) {
echo"<td class=dates align=center>
<a href=?poddzial=6&d=$n&m=$month&r=$year&kat=$kat>
$n</td>";
}
echo"</tr>";

echo"</table>";
echo"<hr>";
?>
<table>
<tr><td>
<input type=hidden value=6 name=poddzial>
<input type=hidden value="<?$kat?>" name=kat>
<select name="m">
<option value=1>Styczeñ
<option value=2>Luty
<option value=3>Marzec
<option value=4>Kwiecieñ
<option value=5>Maj
<option value=6>Czerwiec
<option value=7>Lipiec
<option value=8>Sierpieñ
<option value=9>Wrzesieñ
<option value=10>Pa¼dziernik
<option value=11>Listopad
<option value=12>Grudzieñ
</select>
<select name="r">
<option value=2002>2002
<option value=2003>2003
<option value=2004>2004
<option value=2005 selected>2005
</select>
<input type=submit value=Id¼>
</td></tr>
</table>
</center>

</td></tr>
</table>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" STYLE="margin-top: -5px">
<TR><TD ALIGN="CENTER">
<IMG SRC="grafika/ramka-dol.gif" WIDTH="200" HEIGHT="20" BORDER="0" ALT="">
</TD></TR>
</TABLE>
