<?php

namespace App\Infrastructure\Reader;

use Exception;

class DataFormat
{
    const XML = 'xml';
    const CSV = 'csv';
    const JSON = 'json';

    public function getType(string $filePath): string
    {
        if (!($handle = fopen($filePath, "r"))) {
            throw new Exception("Can't read uploaded file");
        }

        $line = fgets($handle);

        foreach ($this->patternTypes() as $type => $pattern) {
            if (preg_match($pattern, $line)) {
                fclose($handle);

                return $type;
            }
        }

        fclose($handle);
        throw new Exception("Can't determine data format in uploaded file");
    }

    private function patternTypes(): array
    {
        return [
            self::XML => '/^<\?xml/',
            self::CSV => '/^[a-zA-Z_][a-zA-Z0-9_]*\,/',
            self::JSON => '/^\{/',
        ];
    }
}
