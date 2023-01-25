<?php

namespace App\Service;

use App\Interface\ReaderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Employee;
use App\Entity\Interest;
use App\Entity\EmployeeInterest;
use App\Entity\Gift;
use App\Entity\Category;
use App\Entity\GiftCategory;

class DataDumpService
{
    private $interestData = [];
    private $categoryData = [];
    private $em;
    public function __construct(
        private ParameterBagInterface $params,
        private ManagerRegistry $mr,
        private ReaderInterface $readerInterface
    ) {
        $this->em = $mr->getManagerForClass(get_class(new Employee()));
    }

    /**
     * To dump data
     * @return arrray
     */
    public function dumpData(): array
    {
        //Dump employee Data
        $empFilePath = $this->params->get('employee_file_path');
        $dataArr = $this->readerInterface->readFromJson($empFilePath);
        $employeeResponse = $this->dumpEmployeeData($dataArr);

        //dump Gift Data
        $giftFilePath = $this->params->get('gift_file_path');
        $dataArr = $this->readerInterface->readFromJson($giftFilePath);
        $giftResponse = $this->dumpGiftData($dataArr);

        return ['status' => true, 'employeeDataResponse' => $employeeResponse, 'giftDataResponse' => $giftResponse];
    }

    /**
     * @param array $dataArr
     *
     * @return string
     */
    private function dumpEmployeeData(array $dataArr): string
    {
        $response = "Employee data already exist.";
        $totalRecords = $this->em->getRepository(Employee::class)->findCountExistingRecords();
        if ($totalRecords <= 0) {
            foreach ($dataArr as $data) {
                $employee = new Employee();

                $employee->setName($data["name"]);
                $this->em->persist($employee);

                $this->addEmployeeIntersts($data["interests"], $employee);
            }
            $this->em->flush();
            $response = "Employee data added successfully.";
        }

        return $response;
    }

    /**
     * @param array $interests
     * @param Employee $employee
     *
     * @return void
     */
    private function addEmployeeIntersts(array $interests, Employee $employee): void
    {
        foreach ($interests as $name) {
            $interest = $this->addInterest($name);

            $employeeInterest = new EmployeeInterest();

            $employeeInterest->setEmployee($employee);
            $employeeInterest->setInterest($interest);
            $this->em->persist($employeeInterest);
        }
    }

    /**
     * @param mixed $name
     *
     * @return object
     */
    private function addInterest($name): object
    {
        if (!array_key_exists($name, $this->interestData)) {
            $interest = new Interest();

            $interest->setName($name);
            $this->em->persist($interest);
            $this->interestData[$name] = $interest;
        } else {
            $interest = $this->interestData[$name];
        }

        return $interest;
    }

    /**
     * @param array $dataArr
     *
     * @return string
     */
    private function dumpGiftData(array $dataArr): string
    {
        $response = "Gift data already exist.";
        $totalRecords = $this->em->getRepository(Gift::class)->findCountExistingRecords();
        if ($totalRecords <= 0) {
            foreach ($dataArr as $data) {
                $gift = new Gift();

                $gift->setName($data["name"]);
                $this->em->persist($gift);

                $this->addGiftCategories($data["categories"], $gift);
            }
            $this->em->flush();
            $response = "Gift data added successfully.";
        }

        return $response;
    }

    /**
     * @param array $categories
     * @param Gift $gift
     *
     * @return void
     */
    private function addGiftCategories(array $categories, Gift $gift): void
    {
        foreach ($categories as $name) {
            $category = $this->addCategory($name);

            $giftCategory = new GiftCategory();

            $giftCategory->setGift($gift);
            $giftCategory->setCategory($category);
            $this->em->persist($giftCategory);
        }
    }

    /**
     * @param mixed $name
     *
     * @return object
     */
    private function addCategory($name): object
    {
        if (!array_key_exists($name, $this->categoryData)) {
            $category = new Category();

            $category->setName($name);
            $this->em->persist($category);
            $this->categoryData[$name] = $category;
        } else {
            $category = $this->categoryData[$name];
        }

        return $category;
    }
}
