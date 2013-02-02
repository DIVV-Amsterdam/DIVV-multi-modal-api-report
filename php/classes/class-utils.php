<?php

function rd2wgs ($x, $y)
{
    // Calculate WGS84 coördinates
    $dX = ($x - 155000) * pow(10, - 5);
    $dY = ($y - 463000) * pow(10, - 5);
    $SomN = (3235.65389 * $dY) + (- 32.58297 * pow($dX, 2)) + (- 0.2475 *
         pow($dY, 2)) + (- 0.84978 * pow($dX, 2) *
         $dY) + (- 0.0655 * pow($dY, 3)) + (- 0.01709 *
         pow($dX, 2) * pow($dY, 2)) + (- 0.00738 *
         $dX) + (0.0053 * pow($dX, 4)) + (- 0.00039 *
         pow($dX, 2) * pow($dY, 3)) + (0.00033 * pow(
            $dX, 4) * $dY) + (- 0.00012 *
         $dX * $dY);
    $SomE = (5260.52916 * $dX) + (105.94684 * $dX * $dY) + (2.45656 *
         $dX * pow($dY, 2)) + (- 0.81885 * pow(
            $dX, 3)) + (0.05594 *
         $dX * pow($dY, 3)) + (- 0.05607 * pow(
            $dX, 3) * $dY) + (0.01199 *
         $dY) + (- 0.00256 * pow($dX, 3) * pow(
            $dY, 2)) + (0.00128 *
         $dX * pow($dY, 4)) + (0.00022 * pow($dY,
            2)) + (- 0.00022 * pow(
            $dX, 2)) + (0.00026 *
         pow($dX, 5));
 
    $Latitude = 52.15517 + ($SomN / 3600);
    $Longitude = 5.387206 + ($SomE / 3600);
 
    return array(
        'latitude' => $Latitude ,
        'longitude' => $Longitude);
}


?>