<?php

namespace App\Interface;

interface ReaderInterface
{
    /**
     * @param string $filePath
     *
     * @return array
     */
    public function readFromJson(string $filePath): array;
}
