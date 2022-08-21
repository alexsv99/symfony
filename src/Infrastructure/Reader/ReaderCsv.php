<?php

namespace App\Infrastructure\Reader;

use Exception;

class ReaderCsv implements ReaderInterface
{
    public function getData(string $filePath): array
    {
        $keys = [];
        $data = [];

        try {
            if (($handle = fopen($filePath, "r")) !== false) {
                while (($row = fgetcsv($handle)) !== false) {
                    if (!$keys) {
                        $keys = $row;
                        continue;
                    }

                    $data[] = array_combine($keys, $row);
                }

                $result = json_decode(json_encode($data, JSON_NUMERIC_CHECK), true);
                fclose($handle);
            } else {
                throw new Exception("Can't read uploaded file");
            }
        } catch (Exception $e) {
            throw new Exception("Can't read data, wrong csv format");
        }

        return $result;
    }
}
