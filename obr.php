<?php
require("./include/config.php");

$method = @$_GET["method"];
$width = intval(@$_GET["width"]);
$height = intval(@$_GET["height"]);
$doplnit = true;
if ($width == 0) { $width = NULL; $doplnit = false; }
if ($height == 0) { $height = NULL; $doplnit = false; }

$pom_dir = @$_GET["pom_dir"];
$pom_id = @$_GET["pom_id"];
$soubor = @$_GET["soubor"];
 
use Nette\Image;
$image = Image::fromFile("./data/" . $pom_dir . "/" . $pom_id . "/foto/" . $soubor);
if ($method =="crop") { $image->resize($width,$height,Image::FILL); } 
else { $image->resize($width,$height,Image::SHRINK_ONLY); }
$image->sharpen();
if ($doplnit == false) {
	$image->send();
} else {
	$blank = Image::fromBlank($width, $height, Image::rgb(255, 255, 255));
	$blank->place($image, ($width/2)-($image->width/2), ($height/2)-($image->height/2));
	$blank->send();
}
?>