<?php

$csv=$argv[1];
$folder=$argv[2];
$fp = fopen($csv,'r') ;

$index = 0;
$kana_prev="";
$roman_prev="";
$ttf_1="../umefont_670/ume-hgo5.ttf" ;
$ttf="../fonts/GenShinGothic-Bold.ttf" ;

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
     imagettftext($im, $size, 0, $x, $pos_y, 0xffffff, $ttf, $text);
}

function imageWriteTextAt($im,$text,$color,$ttf,$size,$pos_x,$pos_y){
     $bbox=imagettfbbox($size, 0, $ttf, $text);
     $x = $pos_x - ($bbox[2] - $bbox[0]) / 2 ;
     imagettftext($im, $size, 0, $x, $pos_y, $color, $ttf, $text);
}


function insertStr2($text, $insert, $num){
    return preg_replace("/^.{0,$num}+\K/us", $insert, $text);
}

while (($data = fgetcsv($fp)) !== FALSE) {

     $im = imagecreatefromjpeg('./base.jpg');


     if (mb_strlen( $data[1] ) >= 6) {
 	$kanji = data[1] ;
     } else {
        $kanji = insertSpace ( $data[1] ) ;
     }
     if (mb_strlen( $data[2] ) >= 6) {
          $kana  = $data[2] ;
     } else {
          $kana  = insertSpace ( $data[2] ) ;
     }
     $roman = $data[3] ;
     $extra = '(' . $data[4] . ')' ;

     // し ん よ こ は ま
     imageWriteTextAtVirticalCenter($im,$kana,$ttf,40,85);

     imageWriteTextAtVirticalCenter($im,$roman,$ttf_1,24,125);

     imageWriteTextAtVirticalCenter($im,$kanji,$ttf,18,155);

     imageWriteTextAtVirticalCenter($im,$extra,$ttf_1,18,205);

     if ($index > 0) {
          // し ん よ こ は ま
	 imageWriteTextAt($im,$kana_prev,0xffffff,$ttf,20,540,180);

         // Shin-Yokohama
	 imageWriteTextAt($im,$roman_prev,0xffffff,$ttf_1,14,540,200);
     }
     
     $kana_prev=$kana ;
     $roman_prev=$roman ;

     imageJpeg($im, "$folder/$roman.jpg", 85);
     imagedestroy($im);

     $index++;

}


?>