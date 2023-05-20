<?php

namespace App\Service;

use App\Interface\FetchDataInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FetchDataService implements FetchDataInterface
{
    public function __construct(private HttpClientInterface $client)
    {

    }
    
    /**
     * To fetch data from third party api
     *
     * @param array $data
     *
     * @return arrray
     */
    public function fetchData(array $data): array
    {
        $response = $this->client->request(
            $data['method']?? "GET",
            $data['url']
        );

        //$statusCode = $response->getStatusCode();
        
        $content = $response->toArray();
       
        return $content;
    }
}
