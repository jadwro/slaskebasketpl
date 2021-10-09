<?
$pobierz = mysql_query("select*from kom_emot");
while($rekord = mysql_fetch_array($pobierz)) {
   $tresc = str_replace("$rekord[nazwa]","<img src=$rekord[adres] align=middle>",$tresc);
}
?>
