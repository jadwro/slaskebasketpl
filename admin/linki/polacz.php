<?
$url = "195.205.245.131"; //adres bazy danych
$login_pol = "slask"; //nazwa u¿ytkownika bazy danych
$haslo_pol = "Slask12"; //has³o u¿ytkownika bazy danych
$dbname = "eslask"; //nazwa bazy danych

mysql_connect($url,$login_pol,$haslo_pol) or die("<br><br><hr width=700 noshade color=red><font class=duze color=#1564ad><center>MAMY K£OPOTY TECHNICZNE! WRACAMY NIED£UGO; PRZEPRASZAMY ZA UTRUDNIENIA!</center></FONT><hr width=700 noshade color=red><br><br>");
mysql_select_db($dbname) or die("<font class=duze color=#edab81><center>MAMY K£OPOTY TECHNICZNE! WRACAMY NIED£UGO; PRZEPRASZAMY ZA UTRUDNIENIA!</center></FONT><br><br>");
?>
