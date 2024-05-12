<?php

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
    $cut = imagecreatetruecolor($src_w, $src_h);
    imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
    imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
    imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
} 

$back_img     = imagecreatefromjpeg('https://exorion.biz/card/tinkoff.jpg');
$product_mask = imagecreatefrompng('https://exorion.biz/images/749342e7d2699cb4.png');

imagecopymerge_alpha($back_img, $product_mask, 33, 20, 0, 0, 550, 130, 100);

$color = imagecolorallocate( $back_img, 255, 255, 255 );
$color2 = imagecolorallocate( $back_img, 255, 255, 255 );
$color3 = imagecolorallocate( $back_img, 255, 255, 255 );
// указываем путь к шрифту
$font = './whitrabt.ttf';
$hello = $_GET['hello']; // записываем в переменную, то что введено в строке
$hello = mb_strtoupper($hello, 'utf-8'); // делаем буковки большими
$nal = $_GET['nal']; // записываем в переменную, то что введено в строке
$nal = mb_strtoupper($nal, 'utf-8'); // делаем буковки большими
$text = urldecode( $hello );
$text2 = urldecode( '' . $_GET['time'] );
$text3 = urldecode( $nal );
// Добавляем текст
imagettftext( $back_img, 55, 0, 65, 390, $color, $font, $text );
imagettftext( $back_img, 30, 0, 120, 480, $color2, $font, $text2 );
imagettftext( $back_img, 20, 0, 425, 480, $color3, $font, $text3 );
header( 'Content-type: image/png' );
imagejpeg( $back_img, NULL, 100 );

?>