<?php

$xml = simplexml_load_file('coverage.xml');

$coveredStatements = $xml->project->metrics['coveredstatements'];
$totalStatements = $xml->project->metrics['statements'];
$percentage = round(min(1, $coveredStatements / $totalStatements) * 100);
$percentageString = $percentage . '%';
$imageHeight = 20;
$imageWidth = 160;
$xMargin = 5;
$font = 3;

$image = imagecreate($imageWidth, $imageHeight);

$backgroundColor = imagecolorallocate($image, 0, 20, 0);
$foregroundColor = imagecolorallocate($image, 0, 245, 0);
$borderColor = imagecolorallocate($image, 0, 190, 0);

imagerectangle($image, 0, 0, $imageWidth - 1, $imageHeight - 1, $borderColor);

imagestring($image, $font, $xMargin, 3, 'PHPUnit Coverage:', $foregroundColor);

$width = imagefontwidth($font) * strlen($percentageString);
imagestring($image, $font,$imageWidth - $xMargin - $width, 3, $percentageString, $foregroundColor);

imagepng($image, 'docs/code-coverage.png');

imagedestroy($image);