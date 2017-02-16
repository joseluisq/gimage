<?php

function Request_Fopen($url)
{
    $file = fopen($url, 'r');
    $data = stream_get_contents($file);
    fclose($file);
    return $data;
}

function Request_Curl($url)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($c);
    curl_close($c);
    return $data;
}

$filename = 'https://quintana.io/me.jpg';
$filename = 'https://assets-cdn.github.com/images/modules/logos_page/Octocat.png';
$size = getimagesize($filename);

function is_jpeg($pict)
{
    return (bin2hex($pict[0]) == 'ff' && bin2hex($pict[1]) == 'd8');
}

function is_png($pict)
{
    return (bin2hex($pict[0]) == '89' && $pict[1] == 'P' && $pict[2] == 'N' && $pict[3] == 'G');
}

$fopen = Request_Fopen($filename);//This returns the data using fopen.
// $fopen = file_get_contents('https://quintana.io/me.jpg');//This returns the data using curl.

var_dump(is_png($fopen));
