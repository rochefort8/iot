<?php

$csv=$argv[1];
$folder=$argv[2];
$fp = fopen($csv,'r') ;

$index = 0;
$kana_prev="";
$roman_prev="";
$ttf="../umefont_670/ume-hgo5.ttf" ;

function insertSpace($src) {
     $dst = $src ;
     $n = mb_strlen( $src );     
     for ($i = 0;$i < $n-1;$i++) {
          $dst = insertStr2($dst,' ',2*$i+1);
     }
     return $dst;
}

function imageWriteTextAtVirticalCenter($im,$text,$ttf,$size,$pos_y){
     $pos_x = imagesx($im)/2 ;
     $bbox=imagettfbbox($size, 0, $ttf, $text);
     $x = $pos_x - ($bbox[2] - $bbox[0]) / 2 ;
     imagettftext($im, $size, 0, $x, $pos_y, 0, $ttf, $text);
}

function imageWriteTextAt($im,$text,$color,$ttf,$size,$pos_x,$pos_y){
     $bbox=imagettfbbox($size, 0, $ttf, $text);
     imagettftext($im, $size, 0, $pos_x, $pos_y, $color, $ttf, $text);
}


function insertStr2($text, $insert, $num){
    return preg_replace("/^.{0,$num}+\K/us", $insert, $text);
}

while (($data = fgetcsv($fp)) !== FALSE) {

     $im = imagecreatefromjpeg('./base.jpg');
	 
     $kanji = insertSpace ( $data[1] ) ;
//     $kana  = insertSpace ( $data[2] ) ;
     $kana  = $data[2] ;
     $roman = $data[3] ;

     $kana_roman = $data[2] . '  '  . $data[3];

     // 新 横 浜
     imageWriteTextAtVirticalCenter($im,$kanji,$ttf,50,90);

     // し ん よ こ は ま   Shin-Yokohama
     imageWriteTextAtVirticalCenter($im,$kana_roman,$ttf,24,130);

     if ($index > 0) {
          // し ん よ こ は ま
	 imageWriteTextAt($im,$kana_prev,0xffffff,$ttf,18,40,200);

         // Shin-Yokohama
	 imageWriteTextAt($im,$roman_prev,0xffffff,$ttf,14,40,220);
     }
     
     $kana_prev=$kana ;
     $roman_prev=$roman ;

     imageJpeg($im, "$folder/$roman.jpg", 85);
     imagedestroy($im);

     $index++;

}


?>