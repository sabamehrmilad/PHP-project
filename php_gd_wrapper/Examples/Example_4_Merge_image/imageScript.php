<?php

require_once("../../imageHandler.php");

// =========================Merge Image============================
$image = new Image;
$image2 = new Image;
$result = $image->openImage("../../images/joker.png");
$result = $image2->openImage("../../images/cookie.png");
$x = 50;
$y = 50;
$resize_x = 200;
$resize_y = 200;
$transparency = 50;
$result = $image->addImage($image2->image,$x,$y,$transparency,$resize_x,$resize_y);
$result = $image->saveImage("result");
$result = $image->destroyImage();
$result = $image2->destroyImage();
unset($image);
unset($image2);
// =================================================================

?>
