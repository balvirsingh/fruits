<?php

namespace App\Service;

use App\Interface\ReaderInterface;

class ReaderService implements ReaderInterface
{
    /**
     * To read the json file
     *
     * @param string $filePath
     *
     * @return arrray
     */
    public function readFromJson(string $filePath): array
    {
        $dataArr = [];
        if (file_exists($filePath)) {
            $json = file_get_contents($filePath);

            $dataArr = json_decode($json, true);
        }

        return $dataArr;
    }
}
