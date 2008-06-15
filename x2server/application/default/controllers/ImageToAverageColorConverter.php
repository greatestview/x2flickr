<?php

class ImageToAverageColorConverter {

	function __construct() {
		 var_dump($this->createAverageColor("bild.jpg"));
	}
	
	function createAverageColor($imagepath) {
		$imagesize = getimagesize($imagepath);
		$width = $imagesize[0];
		$height = $imagesize[1];
		
		$oldImage = imagecreatefromjpeg($imagepath);
		$newImage = imagecreatetruecolor(1, 1);
		
		imagecopyresampled ($newImage, $oldImage, 0, 0, 0, 0, 1, 1, $width, $height);

		$rgb = imagecolorat($newImage, 0, 0);
//		$r = ($rgb >> 16) & 0xFF;
//		$g = ($rgb >> 8) & 0xFF;
//		$b = $rgb & 0xFF;
//		echo $r.$g.$b;
		
		return $rgb;
	}
}

new ImageToAverageColorConverter();
