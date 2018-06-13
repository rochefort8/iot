<?php

$im = imagecreatefromjpeg('tokaido1.jpg');

// get the image size
$w = imagesx($im);
$h = imagesy($im);

// place some text (top, left)
$bbox=imagettfbbox(24, 0, './umefont_670/ume-hgo4.ttf', 'し  な  が  わ');

print $bbox[0];
printf("\n") ;
print $bbox[1];
printf("\n") ;
print $bbox[2];
printf("\n") ;
print $bbox[3];
printf("\n") ;
print $bbox[4];
printf("\n") ;
print $bbox[5];
printf("\n") ;
print $bbox[6];
printf("\n") ;
print $bbox[7];
printf("\n") ;

$x = (imagesx($im) - ($bbox[2] - $bbox[0])) / 2 ;

print $x;
printf("\n") ;

imagettftext($im, 50, 0, 234, 80, 0x0, './umefont_670/ume-hgo4.ttf', '品  川');
imagettftext($im, 24, 0, 228, 120, 0x0, './umefont_670/ume-hgo4.ttf', 'し  な  が  わ');
imagettftext($im, 18, 0, 260, 154, 0x0, './umefont_670/ume-hgo4.ttf', 'Shinagawa');

//imageJpeg($im, "/share/001.jpg", 85);
imageJpeg($im, "001.jpg", 85);
imagedestroy($im);
?>