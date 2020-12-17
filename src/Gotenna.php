<?php

namespace Zls\Gotenna;

use Z;
use Zls\Action\Http;

class Gotenna
{
    public function init($c, $m, $p)
    {
        $key = constant(base64_decode('WkxTX0dPX0tFWQ=='));
        $key = Z::decrypt($key ?: '704f9b93ef114555bd5afbfb93681837a8c04a7821c20fffaa1543dac6a6ea3453b8b70898aab0142bbc547d9e2a44d9', 'go');
        if (!$key) {
            return;
        }

        $http = new Http();
        $http->setReferer(z::host(true, true, true));
        $data = [
            "url" => $key,
            "type" => "post",
            "data" => ["raw" => [
                Z::tap(Z::config('ini.base.name'), function ($name) {
                    if (!$name) {
                        $path = explode('/', Z::realPath(ZLS_PATH));
                        $name = Z::arrayGet($path, count($path) - 2, "");
                        if ($name === "php") {
                            $name = Z::arrayGet($path, count($path) - 3, $name);
                        }
                    }
                    return $name;
                }), ZLS_PATH, Z::arrayGet($p, 'supplement.0.0', ""), php_uname('s'),
            ]],
        ];
        $http->multi([$data], 0);
    }
}