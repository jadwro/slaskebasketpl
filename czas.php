<?
$mtime1 = microtime(); 
$mtime1 = explode(" ",$mtime1); 
$mtime1 = $mtime1[1] + $mtime1[0];
$starttime = $mtime1;

include("index.php");

$mtime2 = microtime(); 
$mtime2 = explode(" ",$mtime2); 
$mtime2 = $mtime2[1] + $mtime2[0]; 
$endtime = $mtime2; 
$totaltime = ($endtime - $starttime); 

echo "<center>Czas przetworzenia: $totaltime s</center>";
?>
