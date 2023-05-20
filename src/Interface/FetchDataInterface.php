<?php

namespace App\Interface;

interface FetchDataInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function fetchData(array $data): array;
}
