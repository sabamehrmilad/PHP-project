<?php

class Image 
{
    public function __construct(Image $image = NULL ) {
        $this->image = $image;
        $this->type = "png";
    }
    public function getImageX()
    {
        try {
            return imagesx($this->image);
       } catch (\Throwable $th) {
            echo sprintf('something goes wrong: %s', var_export($th,true));
       }
    }
    public function getImageY()
    {
        try {
            return imagesy($this->image);
       } catch (\Throwable $th) {
            echo sprintf('something goes wrong: %s', var_export($th,true));
       }
    }
    public function newImage($x,$y,$r,$g,$b)
    {
       try {
            $this->image = imagecreate($x,$y);
            imagecolorallocate($this->image,$r,$g,$b);
            return $this->image;
       } catch (\Throwable $th) {
            echo sprintf('something goes wrong: %s', var_export($th,true));
       }
    }
    public function openImage(string $imagePath)
    {
        try {
            $imageExtention = strtolower(explode(".",$imagePath)[(count(explode(".",$imagePath))-1)]);
            if ($imageExtention == "jpeg" || $imageExtention == "jpg" || $imageExtention == "png" || $imageExtention == "gif") {
                switch ($imageExtention) {
                    case 'jpeg':
                        $this->image = imagecreatefromjpeg($imagePath);
                        break;
                    case 'jpg':
                        $this->image = imagecreatefromjpeg($imagePath);
                        break;
                    case 'gif':
                        $this->image = imagecreatefromgif($imagePath);
                        break;
                    default:
                        $this->image = imagecreatefrompng($imagePath);
                        break;
                }
                return $this->image;
            }
        } catch (\Throwable $th) {
            echo sprintf('something goes wrong: %s', var_export($th,true));
        }
        return false;
    }
    public function saveImage($imageName,$pathToNewImage = "")
    {
        try {
            return imagepng($this->image, $pathToNewImage.$imageName.".".$this->type);
        } catch (\Throwable $th) {
            echo sprintf('something goes wrong: %s', var_export($th,true));
        }
        return false;
    }
    public function destroyImage()
    {
        try {
            $result = imageDestroy($this->image);
            $this->image = NULL;
            return $result;
        } catch (\Throwable $th) {
            echo sprintf('something goes wrong: %s', var_export($th,true));
        }
        return false;
    }
    public function newColor($r,$g,$b)
    {
        try {
            return imagecolorallocate($this->image,$r,$g,$b);
        } catch (\Throwable $th) {
            echo sprintf('something goes wrong: %s', var_export($th,true));
        }
        return false;
    }
    public function addText($text,$font,$fontSize,$x,$y,$rotate,$color)
    {// $x , $y in percent
        try {
            return imagettftext ($this->image,$fontSize,$rotate,(imagesx($this->image)*$x/100),(imagesy($this->image)*$y/100),$color,$font,$text);
        } catch (\Throwable $th) {
            echo sprintf('something goes wrong: %s', var_export($th,true));
        }
        return false;
    }
    public function addImage($watermark_image,$x,$y,$transparency,$resize_x=NULL,$resize_y=NULL)
    {// $x , $y in percent
        try {
            if($resize_x && $resize_y)$watermark_image = imagescale($watermark_image,$resize_x,$resize_y);
            return imagecopymerge($this->image, $watermark_image, (imagesx($this->image)*$x/100), (imagesy($this->image)*$y/100), 0, 0, imagesx($watermark_image), imagesy($watermark_image), $transparency);
        } catch (\Throwable $th) {
            echo sprintf('something goes wrong: %s', var_export($th,true));
        }
        return false;
    }
    public function resizeImage($x,$y) 
    {// $x , $y in pixels
        try {
            $this->image = imagescale($this->image,$x,$y);
        } catch (\Throwable $th) {
            echo sprintf('something goes wrong: %s', var_export($th,true));
            return false;
        }
        return true;
    }
    // ==============================Extra Functions============================
    public function convertPointToPixel($p)
    {
        return doubleval($p)*1.333333;
    }
    public function convertPixelToPoint($p)
    {
        return doubleval($p)*0.75;
    }
    public function bendText(string $text , $font , $color , $heightPercent ,$curve = "up", $persian = false)
    {
        try {
            $text = trim($text);
            $this->persian_log2vis($text);
            $textArray = ($persian) ? $this->importSpaces(explode(' ' , $text)) : $this->strToArray($text) ;
            switch ($curve) {
                case 'up': $curveType = -1; break;
                case 'down': $curveType = 1; break;
                default: $curveType = 0; break;
            }
            $count = count($textArray) ;
            $charPixel = ( $persian ) ?
            (75.000 * doubleval(imagesx($this->image)) / 100.000) / count($this->strToArray($text)) :
            (75.000 * doubleval(imagesx($this->image)) / 100.000) / $count ;
            $fontSize = $this->convertPixelToPoint( $charPixel ) * (( $persian ) ? 3 : 1.2) ;
            $pixelPtr = 12.500 * doubleval(imagesx($this->image)) / 100.000 ;
            $a = (75 * doubleval(imagesx($this->image)) / 100)/2 ;
            $b = ( doubleval(imagesy($this->image)) / 100)/2 ;
            for ($i=0; $i < $count ; $i++) {
                $ptr = $i;
                if($i == 0) $ptr = 0.25;
                $x = abs( (doubleval($count) / 2.000) - doubleval($ptr) ) * $a / (doubleval($count) / 2.000);
                $ellipse = $b * sqrt(1-(pow($x,2) / pow($a,2)));
                $heightArray[$i] = imagesy($this->image) * ($heightPercent + $ellipse * $curveType ) / 100 ;
            }
            if(!$persian) $heightArray = $this->derivArray($heightArray);
            $rotateArray = $this->setRotate($count , $curveType);
            var_dump($charPixel , $fontSize , $pixelPtr , $heightArray , $rotateArray);
            for ($i=0; $i < $count ; $i++) { 
                imagettftext ($this->image,$fontSize,$rotateArray[$i],$pixelPtr,$heightArray[$i],$color,$font,$textArray[$i]);
                $pixelPtr += ( $persian ) ? (doubleval(count($this->strToArray($textArray[$i]))) * $charPixel) : $charPixel ;
            }
            return true;
        } catch (\Throwable $th) {
            echo sprintf('something goes wrong: %s', var_export($th,true));
            return false;
        }
        return false;
    }
    private function strToArray($str, $l = 0) {
        if ($l > 0) {
            $ret = array();
            $len = mb_strlen($str, "UTF-8");
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l, "UTF-8");
            }
            return $ret;
        }
        return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    }
    private function persian_log2vis(&$str)
    {
        include_once('bidi.php');
        $bidi = new bidi();
        $text = explode("\n", $str);
        $str = array();
        foreach($text as $line){
            $chars = $bidi->utf8Bidi($bidi->UTF8StringToArray($line), 'AL');
            $line = '';
            foreach($chars as $char){
                $line .= $bidi->unichr($char);
            }
            $str[] = $line;
        }
        $str = implode("\n", $str);
    }
    private function importSpaces(array $array)
    {
        foreach ($array as $key => $value) {
            $return[] = $value;
            $return[] = ' ';
        }
        unset($return[(count($return) - 1)]);
        return $return;
    }
    private function derivArray(array $array , $negative = false)
    {
        if(count($array) <= 1 ) return $array;
        $mid = floor(count($array) / 2);
        $counter =($mid % 2 === 0) ? 0 : 1;
        for ($i = ($mid % 2 === 0) ? $mid : $mid + 1 ; $i < count($array) ; $i++) { 
            $array[$i] = $array[($mid - $counter)] * ( $negative ? -1 : 1 );
            $counter += 1;
        }
        return $array;
    }
    private function setRotate(int $count , $curveType = 1 , float $limit = 20.000)
    {
        if($count < 1) return false;
        if($count === 1) return array(0);
        if($count === 2) return array((-$curveType)*($limit / 3) , ($curveType)*($limit / 3));
        if($count === 3) return array((-$curveType)*($limit / 2) , 0 , ($curveType)*($limit / 2));
        $range = doubleval($limit) * 2.000 / doubleval($count - 1);
        for ($i=0; $i < $count ; $i++) { 
            $return[] = $limit * (-$curveType);
            $limit -= $range;
        }
        return $return;
    }
}

// SCRIPT BY TadavomnisT

?>