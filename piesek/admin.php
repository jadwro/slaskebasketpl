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
<BODY>
<table border=1>
<?
include("polacz.php");
$autoryzacja = mysql_query("select*from komentarze where auth=\"nie\" OR zglos=\"tak\"");
$czy_sa = mysql_num_rows($autoryzacja);
if($czy_sa != 0) {
    print "<tr><td><a target=admin href=komentarze.php?akcja=autoryzuj><font color=red><b>KOMENTARZE ($czy_sa)</font></b></a></td></tr>";
}
?>
<tr><td><b><a href=aktualnosci.php?ktory=0 target=admin>Newsy</b></td></tr>
<tr><td><a href=aktualnosci.php?akcja=dopisz target=admin>Dopisz newsa</a></td></tr>
<tr><td><a href=aktualnosci.php?akcja=edit&ktory=0 target=admin>Edytuj newsa</a></td></tr>
<tr><td><a href=wydarzenia.php?ktory=0 target=admin><b>Wydarzenia</b></a></td></tr>
<tr><td><a href=wydarzenia.php?akcja=dopisz target=admin>Dopisz wydarzenie</a></td></tr>
<tr><td><a href=wydarzenia.php?akcja=edit&ktory=0 target=admin>Edytuj wydarzenie</a></td></tr>
<tr><td><b><a href=zawodnicy.php target=admin>Zawodnicy</b></td></tr>
<tr><td><a href=zawodnicy.php?akcja=dopisz target=admin>Dopisz zawodnika</a></td></tr>
<tr><td><a href=zawodnicy.php?akcja=edit target=admin>Edytuj zawodnika</a></td></tr>
<tr><td><b><a href=gracze.php target=admin>Gracze rywali</b></td></tr>
<tr><td><a href=gracze.php?akcja=dopisz target=admin>Dopisz gracza</a></td></tr>
<tr><td><a href=gracze.php?akcja=edit target=admin>Edytuj gracza</a></td></tr>
<tr><td><b><a href=zdjecia.php target=admin>Zdjęcia</b></td></tr>
<tr><td><a href=zdjecia.php?akcja=dopisz_zdj target=admin>Dopisz zdjęcie</a></td></tr>
<tr><td><a href=zdjecia.php?akcja=edit_zdj target=admin>Edytuj zdjęcie</a></td></tr>
<tr><td><b><a href=kluby.php target=admin>Kluby</b></td></tr>
<tr><td><a href=kluby.php?akcja=dopisz target=admin>Dopisz klub</a></td></tr>
<tr><td><a href=kluby.php?akcja=edit target=admin>Edytuj klub</a></td></tr>
<tr><td><b><a href=mecze.php target=admin>Mecze</b></td></tr>
<tr><td><a href=mecze.php?akcja=dopisz target=admin>Dopisz mecz</a></td></tr>
<tr><td><a href=mecze.php?akcja=edit target=admin>Edytuj mecz</a></td></tr>
<tr><td><a href=mecze.php?akcja=nast_poprz target=admin>Nast./Poprz.</a></td></tr>
<tr><td><a href=kolejki.php?akcja=dopisz target=admin>Dopisz kolejkę</a></td></tr>
<tr><td><a href=kolejki.php?akcja=edit target=admin>Edytuj kolejkę</a></td></tr>
<tr><td><a href=pary_pf.php?akcja=dopisz target=admin>Dopisz parę P-O</a></td></tr>
<tr><td><a href=pary_pf.php?akcja=edit target=admin>Edytuj parę P-O</a></td></tr>
<tr><td><b><a href=sezony.php target=admin>Sezony</b></td></tr>
<tr><td><a href=sezony.php?akcja=dopisz target=admin>Dopisz sezon</a></td></tr>
<tr><td><a href=sezony.php?akcja=edit target=admin>Edytuj sezon</a></td></tr>
<tr><td><b><a href=rozgrywki.php target=admin>Rozgrywki</b></td></tr>
<tr><td><a href=rozgrywki.php?akcja=dopisz target=admin>Dopisz rozgrywki</a></td></tr>
<tr><td><a href=rozgrywki.php?akcja=edit target=admin>Edytuj rozgrywki</a></td></tr>
<tr><td><b><a href=dzialy.php target=admin>Działy</b></td></tr>
<tr><td><a href=dzialy.php?akcja=dopisz target=admin>Dopisz dział</a></td></tr>
<tr><td><a href=dzialy.php?akcja=edit target=admin>Edytuj dział</a></td></tr>
<tr><td><b><a href=poddzialy.php target=admin>Poddziały</b></td></tr>
<tr><td><a href=poddzialy.php?akcja=dopisz target=admin>Dopisz poddział</a></td></tr>
<tr><td><a href=poddzialy.php?akcja=edit target=admin>Edytuj poddział</a></td></tr>
<tr><td><b><a href=podpoddzialy.php target=admin>Podpoddziały</b></td></tr>
<tr><td><a href=podpoddzialy.php?akcja=dopisz target=admin>Dopisz podpoddział</a></td></tr>
<tr><td><a href=podpoddzialy.php?akcja=edit target=admin>Edytuj podpoddział</a></td></tr>
<tr><td><b><a href=byligracze.php target=admin>Byli gracze</b></td></tr>
<tr><td><a href=byligracze.php?akcja=dopisz target=admin>Dopisz byłego gracza</a></td></tr>
<tr><td><a href=byligracze.php?akcja=edit target=admin>Edytuj byłego gracza</a></td></tr>
<tr><td><a href=byligracze_stat.php?akcja=dopisz target=admin>Dopisz statystyki</a></td></tr>
<tr><td><a href=byligracze_stat.php?akcja=edit target=admin>Edytuj statystyki</a></td></tr>
<tr><td><b><a href=statystyki.php target=admin>Statystyki</b></td></tr>
<tr><td><b><a href=linki.php target=admin>Linki</b></td></tr>
<tr><td><a href=linki.php?akcja=dopisz target=admin>Dopisz link</a></td></tr>
<tr><td><a href=linki.php?akcja=edit target=admin>Edytuj link</a></td></tr>
<tr><td><a href=linki_kat.php?akcja=dopisz target=admin>Dopisz kategorię</a></td></tr>
<tr><td><a href=linki_kat.php?akcja=edit target=admin>Edytuj kategorię</a></td></tr>
<tr><td><b><a href=multimedia.php target=admin>Multimedia</b></td></tr>
<tr><td><a href=multimedia.php?akcja=dopisz target=admin>Dopisz wpis</a></td></tr>
<tr><td><a href=multimedia.php?akcja=edit target=admin>Edytuj wpis</a></td></tr>
<tr><td><a href=multimedia_kat.php?akcja=dopisz target=admin>Dopisz kategorię</a></td></tr>
<tr><td><a href=multimedia_kat.php?akcja=edit target=admin>Edytuj kategorię</a></td></tr>
<tr><td><b><a href=media.php target=admin>Media</b></td></tr>
<tr><td><a href=media.php?akcja=dopisz target=admin>Dopisz wpis</a></td></tr>
<tr><td><a href=media.php?akcja=edit target=admin>Edytuj wpis</a></td></tr>
<tr><td><b><a href=redakcja.php target=admin>Redakcja</b></td></tr>
<tr><td><a href=redakcja.php?akcja=dopisz target=admin>Dopisz newsmana</a></td></tr>
<tr><td><a href=redakcja.php?akcja=edit target=admin>Edytuj newsmana</a></td></tr>
<tr><td><b><a href=galeria.php target=admin>Galeria</b></td></tr>
<tr><td><a href=galeria.php?akcja=dopisz target=admin>Dopisz zdjęcie</a></td></tr>
<tr><td><a href=galeria.php?akcja=edit target=admin>Edytuj zdjęcie</a></td></tr>
<tr><td><a href=galeria_kat.php?akcja=dopisz target=admin>Dopisz galerię</a></td></tr>
<tr><td><a href=galeria_kat.php?akcja=edit target=admin>Edytuj galerię</a></td></tr>
<tr><td><b><a href=komentarze.php target=admin>Komentarze</b></td></tr>
<tr><td><a href=kom_emot.php?akcja=dopisz target=admin>Dopisz emotikone</a></td></tr>
<tr><td><a href=kom_emot.php?akcja=edit target=admin>Edytuj emotikone</a></td></tr>
<tr><td><a href=kom_kolory.php target=admin><b>K</b>olory</a></td></tr>
<tr><td><a href=kom_kolory.php?akcja=dopisz target=admin>Dopisz kolor</a></td></tr>
<tr><td><a href=kom_vip.php target=admin><b>N</b>adaj/odbierz vipa</a></td></tr>
<tr><td><b>II LIGA</b></td></tr>
<tr><td><b><a href=zawodnicy2.php target=admin>Śląsk II</b></td></tr>
<tr><td><a href=zawodnicy2.php?akcja=dopisz target=admin>Dopisz gracze</a></td></tr>
<tr><td><a href=zawodnicy2.php?akcja=edit target=admin>Edytuj gracza</a></td></tr>
<tr><td><b>LISTA</b></td></tr>
<tr><td><a href=lista.php?akcja=usun target=admin>Usuń wpis</td></tr>
</table>
</BODY>
</HTML>
