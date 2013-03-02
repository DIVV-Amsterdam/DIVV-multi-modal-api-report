<?php

$url = $_POST["url"];


$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch1, CURLOPT_URL, $url);

$result1 = curl_exec($ch1);

//echo "<pre>";
echo $result1;
//echo "</pre>";

?>