<?php

namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;
use App\Interface\FetchDataInterface;
use App\Service\MailService;
use App\Entity\Fruit;

class DumpFruitService
{
    private $em;
    public function __construct(
        private ManagerRegistry $mr,
        private FetchDataInterface $fetchDataInterface,
        private MailService $mailService
    ) {
        $this->em = $mr->getManagerForClass(get_class(new Fruit()));
    }

    /**
     * To dump fruits data
     * @return arrray
     */
    public function dumpFruits(): array
    {
        $response = ['status' => true, 'result' => 'Fruits data already exist.'];
        $totalRecords = $this->em->getRepository(Fruit::class)->findCountExistingRecords();
        if ($totalRecords <= 0) {
            $url = "https://fruityvice.com/api/fruit/all";
            $data = ['url' => $url];
            $dataArr = $this->fetchDataInterface->fetchData($data);

            try {
                foreach ($dataArr as $data) {
                    $fruit = new Fruit();

                    $fruit->setName($data["name"]);
                    $fruit->setFruitId($data["id"]);
                    $fruit->setFamily($data["family"]);
                    $fruit->setPlantOrder($data["order"]);
                    $fruit->setGenus($data["genus"]);

                    $nutritions = $data["nutritions"];
                    $fruit->setCalories($nutritions["calories"]);
                    $fruit->setFat($nutritions["fat"]);
                    $fruit->setSugar($nutritions["sugar"]);
                    $fruit->setCarbohydrate($nutritions["carbohydrates"]);
                    $fruit->setProtein($nutritions["protein"]);

                    $this->em->getRepository(Fruit::class)->save($fruit, true);
                }

                $mailInfo = [];
                $mailInfo['to'] = 'lovedeep.sony244@gmail.com';
                $mailInfo['subject'] = "Fruits dumped successfully";
                $mailInfo['body'] = "Fruits dumped into the database successfully";

                $this->mailService->sendMail($mailInfo);
                $response = ['status' => true, 'result' => 'Fruits data added and mail sent successfully.'];
            } catch (\Exception $e) {
                $response = ['status' => false, 'result' => "An error occurred while adding fruit data: " . $e->getMessage()];
            }
        }

        return $response;
    }
}
