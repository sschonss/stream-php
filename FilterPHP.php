<?php

class FilterPHP extends php_user_filter
{
    public $stream;

    public function onCreate(): bool
    {
        $this->stream = fopen('php://temp', 'w+');
        return $this->stream !== false;
    }

    public function filter($in, $out, &$consumed, $closing): int
    {
        $out_data = '';
        while ($bucket = stream_bucket_make_writeable($in)) {
            $data = json_decode($bucket->data, true);
            if (json_last_error() !== JSON_ERROR_NONE || !isset($data['terms']) || !is_array($data['terms'])) {
                continue;
            }

            $filteredTerms = array_filter($data['terms'], function ($term) {
                return stripos($term['name'], 'PHP') !== false || stripos($term['description'], 'PHP') !== false;
            });

            $out_data .= json_encode(['terms' => array_values($filteredTerms)], JSON_PRETTY_PRINT);
            $consumed += $bucket->datalen;
        }

        if ($out_data !== '') {
            $bucket_out = stream_bucket_new($this->stream, $out_data);
            stream_bucket_append($out, $bucket_out);
        }

        return PSFS_PASS_ON;
    }
}
