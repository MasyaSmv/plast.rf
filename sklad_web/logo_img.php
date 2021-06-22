<?php

$ex=strtolower(substr($_GET['foto'],-3));
$filename="/home/ruscableru/ruscableru/www".$_GET['foto'];
if ($ex=="jpg")	$source = imagecreatefromjpeg($filename);
else $source = imagecreatefromgif($filename);
header('Content-type: image/jpeg');



// Get new sizes

list($width, $height) = getimagesize($filename);



if ($width>=$height)

{

	$newwidth=100;

	$newheight=100*$height/$width;

	

}

else

{

	$newheight=100;

	$newwidth=100*$width/$height;

	

}

// Load

$thumb = imagecreatetruecolor($newwidth, $newheight);

$white = imagecolorallocate ($thumb, 255, 255, 255);

imagefill($thumb, 0, 0, $white);



// Resize

imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

if ($_GET['ex']=="jpg") imagejpeg($thumb);

else imagegif($thumb);





?>

