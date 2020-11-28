<?php
$im = imagecreatefrompng('gouki.png');


$idx = 0;

for ($y = 0; $y < 1344; $y += 192) {
    for ($x = 0; $x < 960; $x += 192) {
        $im2 = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => 192, 'height' => 192]);
        if ($im2 !== FALSE) {
            imagepng($im2, sprintf('fire_%02d.png', $idx));
            imagedestroy($im2);

            $idx++;
        }
    }
}

imagedestroy($im);
?>