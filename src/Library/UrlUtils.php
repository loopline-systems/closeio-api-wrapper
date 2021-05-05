<?php

declare(strict_types=1);

namespace LooplineSystems\CloseIoApiWrapper\Library;

final class UrlUtils
{
    public static function validate(string $url): bool
    {
        $host = parse_url($url, PHP_URL_HOST) ?: "";

        $encodedHost = idn_to_ascii($host, INTL_IDNA_VARIANT_UTS46);
        $url = str_replace($host, $encodedHost, $url);

        $path = parse_url($url, PHP_URL_PATH) ?: "";
        $encodedPath = array_map('urlencode', explode('/', $path));
        $url = str_replace($path, implode('/', $encodedPath), $url);

        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }
}
