<?php

require_once("../../imageHandler.php");

// ==========================Making A New Image=====================
$image = new Image;
$result = $image->newImage(200,200,0,0,0);
$result = $image->saveImage("result");
$result = $image->destroyImage();
unset($image);
// =================================================================

?>
