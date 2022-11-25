<?php

require_once("../../imageHandler.php");

// =========================Resize Image===========================
$image = new Image;
$result = $image->openImage("../../images/cookie.png");
$x = 50;
$y = 100;
$result = $image->resizeImage($x,$y);
$result = $image->saveImage("result");
$result = $image->destroyImage();
unset($image);
var_dump($result);
// =================================================================



?>
