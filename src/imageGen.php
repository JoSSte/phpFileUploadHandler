<?php


// create a 200*200 image
$img = imagecreate(200, 200);

// allocate some colors
$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);
$red = imagecolorallocate($img, 255, 0, 0);
$green = imagecolorallocate($img, 0, 255, 0);
$blue = imagecolorallocate($img, 0, 0, 255);
  
// draw a black circle
//imagearc($img, 100, 100, 150, 150, 270, 0, $black);

$segments = 13; //5 segments, 72degrees between each line
$seg_angle = floor(360/$segments);

$line_height = 75; //pixels

$centerX = 100;
$centerY = 100;

//prepare for first line (vertical)
$x2 = $centerX + $line_height;
$y2 = $centerY ;

//draw first line
imageline ( $img,  $centerX,  $centerY, $x2, $y2, $black );

//prepare for second line
$diffY = sin(deg2rad($seg_angle))*$line_height;
$diffX = cos(deg2rad($seg_angle))*$line_height;


//draw second line
imageline ( $img, $centerX, $centerY, floor($centerX+$diffX), floor($centerY+$diffY),$black);

if($seg_angle*2<90){
   //prepare for second line
		$diffY = sin(deg2rad($seg_angle*2))*$line_height;
		$diffX = cos(deg2rad($seg_angle*2))*$line_height;


    //draw second line 
		imageline ( $img, $centerX, $centerY, floor($centerX+$diffX), floor($centerY+$diffY),$black);

		if($seg_angle*3<90){
        //prepare for second line
				$diffY = sin(deg2rad($seg_angle*3))*$line_height;
				$diffX = cos(deg2rad($seg_angle*3))*$line_height;


        //draw second line 
				imageline ( $img, $centerX, $centerY, floor($centerX+$diffX), floor($centerY+$diffY),$black);
				
		}
}
imagearc($img, 100, 100, 150, 150, $seg_angle*3, 0, $black);


imagestring($img, 2, 0,  0, "Angle: ".$seg_angle, $black);
//imagestring($img, 2, 0, 10, "diffX: ".$diffX, $black);
//imagestring($img, 2, 0, 20, "diffY: ".$diffY, $black);

// output image in the browser
header("Content-type: image/png");
imagepng($img);




// free memory
imagedestroy($img);
