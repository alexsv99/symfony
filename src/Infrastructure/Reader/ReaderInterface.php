<?php

namespace App\Infrastructure\Reader;

interface ReaderInterface
{
    public function getData(string $filePath);
}