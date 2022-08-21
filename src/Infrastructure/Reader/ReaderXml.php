<?php

namespace App\Infrastructure\Reader;

use Exception;

class ReaderXml implements ReaderInterface
{
    public function getData(string $filePath): array
    {
        try {
            $string = file_get_contents($filePath);
            $xmlObj = simplexml_load_string($string);
            $encode = json_encode($xmlObj, JSON_NUMERIC_CHECK);
            $arr = json_decode($encode, true);

            $result = array_column($arr, 'result')[0];
        } catch (Exception $e) {
            throw new Exception("Can't read data, wrong xml format");
        }

        return $result;
    }
}