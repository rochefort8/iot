<?php



$fp = fopen('./data.csv','r') ;


$index = 0;
$kana_prev="";
$roman_prev="";

while (($data = fgetcsv($fp)) !== FALSE) {

     $im = imagecreatefromjpeg('tokaido/base.jpg');

     $ttf="./umefont_670/ume-hgo4.ttf" ;
	 
     $n = mb_strlen( $data[1] );
     $kanji = $data[1] ;
     for ($i = 0;$i < $n-1;$i++) {
          $kanji = insertStr2($kanji,' ',2*$i+1);
     }
     $kana  = $data[2] ;
     $n = mb_strlen( $data[2] );     
     for ($i = 0;$i < $n-1;$i++) {
          $kana = insertStr2($kana,' ',2*$i+1);
     }
     $roman = $data[3] ;

     // 新 横 浜
     $bbox=imagettfbbox(50, 0, $ttf, $kanji);
     $x = (imagesx($im) - ($bbox[2] - $bbox[0])) / 2 ;
     imagettftext($im, 50, 0, $x, 80, 0x0, $ttf, $kanji);

     // し ん よ こ は ま
     $bbox=imagettfbbox(24, 0, $ttf, $kana);
     $x = (imagesx($im) - ($bbox[2] - $bbox[0])) / 2 ;
     imagettftext($im, 24, 0, $x, 120, 0x0, $ttf, $kana);

     // Shin-Yokohama
     $bbox=imagettfbbox(18, 0, $ttf, $roman);
     $x = (imagesx($im) - ($bbox[2] - $bbox[0])) / 2 ;
     imagettftext($im, 18, 0, $x, 154, 0x0, $ttf, $roman);

     if ($index > 0) {
          // し ん よ こ は ま
         $bbox=imagettfbbox(18, 0, $ttf, $kana_prev);
	 $x = 520 - ($bbox[2] - $bbox[0])/2 ;
         imagettftext($im, 18, 0, $x, 205, 0x0, $ttf, $kana_prev);

         // Shin-Yokohama
         $bbox=imagettfbbox(14, 0, $ttf, $roman_prev);
         $x = 520 - ($bbox[2] - $bbox[0]) / 2 ;
         imagettftext($im, 14, 0, $x, 225, 0x0, $ttf, $roman_prev);
     }
     
     $kana_prev=$kana ;
     $roman_prev=$roman ;

     imageJpeg($im, "tokaido/$roman.jpg", 85);
     imagedestroy($im);

     $index++;

}

function insertStr2($text, $insert, $num){
    return preg_replace("/^.{0,$num}+\K/us", $insert, $text);
}

?>