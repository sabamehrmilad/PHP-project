<?php

require_once("../../imageHandler.php");

// ===================Opening An Existing Image=====================
$image = new Image;
$result = $image->openImage("../../images/cookie.png");
$result = $image->saveImage("result");
$result = $image->destroyImage();
unset($image);
// =================================================================

?>
