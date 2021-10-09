<?
if($szukaj) {
   print "<a class=miejsce href=http://slask.e-basket.pl>SLASK.e-basket.pl</a> / Wyszukiwarka";
} elseif($news) {
   $dzial_news = mysql_fetch_array(mysql_query("select dzial,dzial_id from newsy where id='$news'"));
   print "<a class=miejsce href=http://slask.e-basket.pl>SLASK.e-basket.pl</a> / <a class=miejsce href=?dzial=$dzial_news[dzial_id]>$dzial_news[dzial]</a> / News";
} else {
   if($dzial) {
      $wez_dzialy = mysql_fetch_array(mysql_query("select miejsce from dzialy where id='$dzial'"));
      print "$wez_dzialy[miejsce]";
   } elseif($poddzial) {
      $wez_poddzialy = mysql_fetch_array(mysql_query("select miejsce from poddzialy where id='$poddzial'"));
      print "$wez_poddzialy[miejsce]";
   } elseif($podpoddzial) {
      $wez_podpoddzialy = mysql_fetch_array(mysql_query("select miejsce from podpoddzialy where id='$podpoddzial'"));
      print "$wez_podpoddzialy[miejsce]";
   } elseif((!isset($id)) || ((!$dzial) && (!$poddzial) && (!$podpoddzialu)) && (!$news) && (!$szukaj)) {
      print "Witamy na stronie SLASK.e-basket.pl";
   }
}
?>
