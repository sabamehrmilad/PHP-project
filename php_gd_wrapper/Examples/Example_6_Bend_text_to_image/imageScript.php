<?php

require_once("../../imageHandler.php");

// =========================Bend Text To Image==========================
$image = new Image;
$result = $image->openImage("../../images/cookie.png");
// $result = $image->newImage(2000,2000,0,0,0);
// -----------do things--------
$white = $image->newColor(255,255,255);
$text_1 = "من کلوچه دوست دارم:)";
$text_2 = "I love cookie :)";
$font_1 = realpath(getcwd()."/../../fonts/xxx.ttf");
$font_2 = realpath(getcwd()."/../../fonts/arial.ttf");
$color = $white;
$heightPercent = 15;
$result = $image->bendText($text_1 , $font_1 , $color , $heightPercent , "up" , true ); //persian
$heightPercent = 95;
$result = $image->bendText($text_2 , $font_2 , $color , $heightPercent , "down" ); //english
// ----------------------------
$result = $image->saveImage("result");
$result = $image->destroyImage();
unset($image);
var_dump($result);
// =================================================================




?>
