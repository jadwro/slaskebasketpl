<HTML>
<HEAD>
<TITLE>   </TITLE>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=iso-8859-2">
<style type=text/css>
<!--
a:link {color:blue; text-decoration:none; font-size:11px; font-family:arial,verdana};
a:visited {color:blue; text-decoration:none; font-size:11px; font-family:arial,verdana};
a:hover {color:red; font-size:11px; font-family:arial,verdana};
//-->
</style>
</HEAD>
<body>
<table border=0>
<tr><td width=150 align=left valign=top>

<table border=1>
<?
include("polacz.php");

$loginn = mysql_fetch_array(mysql_query("select*from redakcja where login='$loginek' OR id='$user'"));
$login2 = mysql_query("select*from redakcja where login='$loginek' OR id='$user'");

if(mysql_num_rows($login2)==0) {
   print "Nie ma takiego użytkownika!<br><a href=javascript:history.back(-1)>Powrót...</a>";
   return false;
}

if($haslo_user == $loginn[haslo]) {
   $ok = "true";
   $user = "$loginn[id]";
} else {
   print "Nieprawidłowe hasło!<br><a href=javascript:history.back(-1)>Powrót...</a>";
   return false;
}

if($ok == "true") {
   $autoryzacja = mysql_query("select*from komentarze where zglos=\"tak\"");
   $czy_sa = mysql_num_rows($autoryzacja);
   if($czy_sa != 0) {
       print "<tr><td><a target=admin href=komentarze.php?akcja=autoryzuj><font color=red><b>KOMENTARZE ($czy_sa)</font></b></a></td></tr>";
   }

   print "<tr><td><b><a href=glowna.php?ktory=0&user=$user&haslo_user=$haslo_user&plik=1>Newsy</b></td></tr>";
   print "<tr><td><a href=glowna.php?akcja=dopisz&user=$user&haslo_user=$haslo_user&plik=1>Dopisz newsa</a></td></tr>";
   print "<tr><td><a href=glowna.php?akcja=edit&ktory=0&plik=1&user=$user&haslo_user=$haslo_user>Edytuj newsa</a></td></tr>";
   print "<tr><td><b><a href=glowna.php?plik=2&user=$user&haslo_user=$haslo_user>Media</b></td></tr>";
   print "<tr><td><a href=glowna.php?akcja=dopisz&plik=2&user=$user&haslo_user=$haslo_user>Dodaj wpis</a></td></tr>";
   print "<tr><td><a href=glowna.php?akcja=edit&plik=2&user=$user&haslo_user=$haslo_user>Edytuj wpis</a></td></tr>";
   print "</table>";

   print "</td><td width=650 valign=top>";

   if($plik == "1") {
      $plik = "aktualnosci.php";
   } elseif($plik == "2") {
      $plik = "media.php";
   } elseif($plik == "3") {
      $plik = "komentarze.php";
   } elseif(!$plik) {
      $plik = "gl.php";
   }

   include("$plik");

   print "</td></tr>";
   print "</table>";
}
?>
</HTML>
