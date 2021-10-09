<?
require("polacz.php");

$pobierz = mysql_query("select*from galeria");
while ($rekord = mysql_fetch_array($pobierz)) {
   $roz = explode("/",$rekord[adres]);
   $zrob = mysql_query("update galeria set adres=adres_male where id='$rekord[id]'");
}
?>


