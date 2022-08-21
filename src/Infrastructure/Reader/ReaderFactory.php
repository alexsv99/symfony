<?php

namespace App\Infrastructure\Reader;

use Exception;

class ReaderFactory
{
    public function initialize(string $type): ReaderInterface
    {
        switch ($type) {
            case DataFormat::XML:
                return new ReaderXml();
            case DataFormat::CSV:
                return new ReaderCsv();
            case  DataFormat::JSON:
                return new ReaderJson();
            default:
                throw new Exception("Data format is not supported");
                break;
        }
    }
}
