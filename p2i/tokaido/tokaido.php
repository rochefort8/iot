<?php

$csv=$argv[1];
$folder=$argv[2];
$fp = fopen($csv,'r') ;

$index = 0;
$kana_prev="";
$roman_prev="";
$ttf="../umefont_670/ume-hgo4.ttf" ;

function insertSpace($src) {
     $dst = $src ;
     $n = mb_strlen( $src );     
     for ($i = 0;$i < $n-1;$i++) {
          $dst = insertStr2($dst,' ',2*$i+1);
     }
     return $dst;
}

function imageWriteTextAtVirticalCenter($im,$text,$ttf,$size,$pos_y){
     imageWriteTextAt($im,$text,$ttf,$size,imagesx($im)/2,$pos_y);
}

function imageWriteTextAt($im,$text,$ttf,$size,$pos_x,$pos_y){
     $bbox=imagettfbbox($size, 0, $ttf, $text);
     $x = $pos_x - ($bbox[2] - $bbox[0]) / 2 ;
     imagettftext($im, $size, 0, $x, $pos_y, 0x0, $ttf, $text);
}

function insertStr2($text, $insert, $num){
    return preg_replace("/^.{0,$num}+\K/us", $insert, $text);
}

while (($data = fgetcsv($fp)) !== FALSE) {

     $im = imagecreatefromjpeg('./base.jpg');
	 
     $kanji = insertSpace ( $data[1] ) ;
     $kana  = insertSpace ( $data[2] ) ;
     $roman = $data[3] ;

     // 新 横 浜
     imageWriteTextAtVirticalCenter($im,$kanji,$ttf,50,80);

     // し ん よ こ は ま
     imageWriteTextAtVirticalCenter($im,$kana,$ttf,24,120);

     // Shin-Yokohama
     imageWriteTextAtVirticalCenter($im,$roman,$ttf,18,154);

     if ($index > 0) {
          // し ん よ こ は ま
	 imageWriteTextAt($im,$kana_prev,$ttf,18,500,205);

         // Shin-Yokohama
	 imageWriteTextAt($im,$roman_prev,$ttf,14,500,226);
     }
     
     $kana_prev=$kana ;
     $roman_prev=$roman ;

     imageJpeg($im, "$folder/$roman.jpg", 85);
     imagedestroy($im);

     $index++;

}


?>