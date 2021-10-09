<?
$url = "192.168.11.102"; //adres bazy danych
$login_pol = "eb_slask"; //nazwa u¿ytkownika bazy danych
$haslo_pol = "sd345@#"; //has³o u¿ytkownika bazy danych
$dbname = "ebasket_slask"; //nazwa bazy danych

mysql_connect($url,$login_pol,$haslo_pol) or die("<br><br><hr width=700 noshade color=red><font class=duze color=#1564ad><center>MAMY K£OPOTY TECHNICZNE! WRACAMY NIED£UGO; PRZEPRASZAMY ZA UTRUDNIENIA!</center></FONT><hr width=700 noshade color=red><br><br>");
mysql_select_db($dbname) or die("<font class=duze color=#edab81><center>MAMY K£OPOTY TECHNICZNE! WRACAMY NIED£UGO; PRZEPRASZAMY ZA UTRUDNIENIA!</center></FONT><br><br>");
?>
