<?php

class FilterPHP extends php_user_filter
{
    public $stream;
    public string $filter;

    public function onCreate(): bool
    {
        $this->stream = fopen('php://temp', 'w+');
        return $this->stream !== false;
    }

    public function filter($in, $out, &$consumed, $closing): int
    {
        $this->filter = 'PHP';
        $out_data = '';
        while ($bucket = stream_bucket_make_writeable($in)) {
            $line = explode("\n", $bucket->data);
            foreach ($line as $l) {
                if (str_contains($l, $this->filter)) {
                    $out_data .= $l . "\n";
                }
            }
        }

        $bucket_out = stream_bucket_new($this->stream, $out_data);
        stream_bucket_append($out, $bucket_out);

        return PSFS_PASS_ON;
    }
}
