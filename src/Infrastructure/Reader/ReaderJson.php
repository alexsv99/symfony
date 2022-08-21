<?php

namespace App\Infrastructure\Reader;

use Exception;

class ReaderJson implements ReaderInterface
{
    public function getData(string $filePath): array
    {
        try {
            $data = json_decode(file_get_contents($filePath), true)['results'];

            $result = json_decode(json_encode($data, JSON_NUMERIC_CHECK), true);
        } catch (Exception $e) {
            throw new Exception("Can't read data, wrong json format");
        }

        return $result;
    }
}
