<?php

require_once './FilterPHP.php';

$json = 'https://raw.githubusercontent.com/sschonss/stream-php/main/data.json';

$fileContents = file_get_contents($json);

if ($fileContents === false) {
    die('Failed to fetch data from the endpoint.');
}

stream_filter_register('filterphp', 'FilterPHP') or die("Failed to register filter.");

$tempStream = fopen('php://temp', 'r+');
fwrite($tempStream, $fileContents);
rewind($tempStream);

$out_fp = fopen('php://stdout', 'w') or die("Failed to open output stream.");
stream_filter_append($tempStream, 'filterphp');

while ($data = fread($tempStream, 1024)) {
    $data = str_replace('"name": ', '', $data);
    $data = str_replace('"description":', '', $data);
    echo $data;
}

fclose($tempStream);
fclose($out_fp);
