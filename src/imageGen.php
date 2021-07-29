<?php

$w = intval(filter_input(INPUT_GET, "w", FILTER_SANITIZE_NUMBER_INT));
$h = intval(filter_input(INPUT_GET, "h", FILTER_SANITIZE_NUMBER_INT));
if ($w == 0) {
	$w = 200;
}
if ($h == 0) {
	$h = 200;
}


// create a image
$img = imagecreate($w, $h);

// allocate some colors
$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);
$red = imagecolorallocate($img, 255, 0, 0);
$green = imagecolorallocate($img, 0, 255, 0);
$blue = imagecolorallocate($img, 0, 0, 255);

// draw a black circle
//imagearc($img, 100, 100, 150, 150, 270, 0, $black);

$segments = 13; //5 segments, 72degrees between each line
$seg_angle = floor(360 / $segments);

$line_height = 75; //pixels

$centerX = floor($w/2);
$centerY = floor($h/2);

//prepare for first line (vertical)
$x2 = $centerX + $line_height;
$y2 = $centerY;

//draw first line (horizontal)
imageline($img,  $centerX,  $centerY, $x2, $y2, $green);

//prepare for second line
$diffY = sin(deg2rad($seg_angle)) * $line_height;
$diffX = cos(deg2rad($seg_angle)) * $line_height;


//draw second line
imageline($img, $centerX, $centerY, floor($centerX + $diffX), floor($centerY + $diffY), $blue);

if ($seg_angle * 2 < 90) {
	//prepare for second line
	$diffY = sin(deg2rad($seg_angle * 2)) * $line_height;
	$diffX = cos(deg2rad($seg_angle * 2)) * $line_height;


	//draw second line 
	imageline($img, $centerX, $centerY, floor($centerX + $diffX), floor($centerY + $diffY), $red);

	if ($seg_angle * 3 < 90) {
		//prepare for second line
		$diffY = sin(deg2rad($seg_angle * 3)) * $line_height;
		$diffX = cos(deg2rad($seg_angle * 3)) * $line_height;


		//draw second line 
		imageline($img, $centerX, $centerY, floor($centerX + $diffX), floor($centerY + $diffY), $black);
	}
}
$circleRadius = floor(min($centerX, $centerY));
imagearc($img, $centerX, $centerY, $circleRadius, $circleRadius, $seg_angle * 3, 0, $black);


imagestring($img, 2, 0,  0, "Angle: " . $seg_angle, $black);
//imagestring($img, 2, 0, 10, "diffX: ".$diffX, $black);
//imagestring($img, 2, 0, 20, "diffY: ".$diffY, $black);


//save as selected fileType
$fileType = filter_input(INPUT_GET, "fileType", FILTER_SANITIZE_STRING);
if ($fileType == "") {
	$fileType = "png";
}
imagestring($img, 2, 0,  12, "FileType: " . $fileType, $black);
header("Content-Disposition: Inline; filename=generated_image".date('Y-m-d').".".$fileType);

switch ($fileType) {
	default:
	case "png":
		header("Content-type: image/png");
		imagepng($img);
		break;
	case "jpg":
		header("Content-type: image/jpeg");
		imagejpeg($img);
		break;
	case "gif":
		header("Content-type: image/gif");
		imagegif($img);
		break;
	case "bmp":
		header("Content-type: image/bmp");
		imagebmp($img);
		break;
	case "webp":
		imagepalettetotruecolor($img);
		header("Content-type: image/webp");
		imagewebp($img);
		break;
}
// output image in the browser





// free memory
imagedestroy($img);
