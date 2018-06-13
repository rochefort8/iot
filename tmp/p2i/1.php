<?php

$im = imagecreatefromjpeg('tokaido1.jpg');

$fp = fopen('./data.csv','r') ;

while (($data = fgetcsv($fp)) !== FALSE) {
      draw($data);
}

function insertStr2($text, $insert, $num){
    return preg_replace("/^.{0,$num}+\K/us", $insert, $text);
}
    
function draw($data) {

     $im = imagecreatefromjpeg('tokaido1.jpg');
     $ttf="./umefont_670/ume-hgo4.ttf" ;
	 
     $n = mb_strlen( $data[0] );
     $kanji = $data[0] ;
     for ($i = 0;$i < $n-1;$i++) {
          $kanji = insertStr2($kanji,' ',2*$i+1);
     }
     
     $n = mb_strlen( $data[1] );
     $kana  = $data[1] ;
     for ($i = 0;$i < $n-1;$i++) {
          $kana = insertStr2($kana,' ',2*$i+1);
     }
     $roman = $data[2] ;

     $bbox=imagettfbbox(50, 0, $ttf, $kanji);

     $x = (imagesx($im) - ($bbox[2] - $bbox[0])) / 2 ;
     
     imagettftext($im, 50, 0, $x, 80, 0x0, $ttf, $kanji);
     
     $bbox=imagettfbbox(24, 0, $ttf, $kana);
     $x = (imagesx($im) - ($bbox[2] - $bbox[0])) / 2 ;
     imagettftext($im, 24, 0, $x, 120, 0x0, $ttf, $kana);

     $bbox=imagettfbbox(18, 0, $ttf, $roman);
     $x = (imagesx($im) - ($bbox[2] - $bbox[0])) / 2 ;
     imagettftext($im, 18, 0, $x, 154, 0x0, $ttf, $roman);

     imageJpeg($im, "$roman.jpg", 85);
     imagedestroy($im);
}

?>