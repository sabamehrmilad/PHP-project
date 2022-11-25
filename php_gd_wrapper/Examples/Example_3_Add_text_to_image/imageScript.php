<?php

require_once("../../imageHandler.php");

// =========================Add Text To Image==========================
$image = new Image;
$result = $image->openImage("../../images/cookie.png");
$black = $image->newColor(0,0,0);
$white = $image->newColor(255,255,255);
$font = realpath(getcwd()."/../../fonts/arial.ttf");
$fontSize = 15;
$x = 50;
$y = 50;
$rotate = 10;
$result = $image->addText("Hello",$font,$fontSize,$x,$y,$rotate,$white);
$result = $image->saveImage("result");
$result = $image->destroyImage();
unset($image);
// =================================================================

?>
