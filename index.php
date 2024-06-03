<?php

require_once 'FilterPHP.php';

$json = 'https://api.github.com/repos/php/php-src/git/trees/master?recursive=1';

$stream = fopen($json, 'r');

if ($stream === false) {
    die('Failed to open stream to the endpoint.');
}

$tempStream = fopen('php://temp', 'r+');

stream_copy_to_stream($stream, $tempStream);

rewind($tempStream);

stream_filter_register('php.filter', 'FilterPHP');
stream_filter_append($tempStream, 'php.filter');

while (!feof($tempStream)) {
    echo fread($tempStream, 1024);
}

fclose($stream);
fclose($tempStream);
