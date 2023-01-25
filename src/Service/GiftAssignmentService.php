<?php

namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Employee;
use App\Entity\Gift;
use App\Entity\EmployeeGift;

class GiftAssignmentService
{
    private $em;
    public function __construct(private ManagerRegistry $mr, private EmployeeInterestService $employeeInterestService)
    {
        $this->em = $mr->getManagerForClass(get_class(new Employee()));
    }

    /**
     * @param mixed $employeeId
     *
     * @return string
     */
    public function fetchAndAssignGiftToEmployee($employeeId): string
    {
        $response = "Employee not found!";
        $employee = $this->em->getRepository(Employee::class)->find($employeeId);
        if ($employee) {
            $response = "No gift found!";
            $employeeGift = $this->em->getRepository(EmployeeGift::class)->findByEmployee($employeeId);
            if (count($employeeGift) <= 0) {
                $gift = $this->assignGiftToEmployee($employee);
                if ($gift) {
                    $response = $gift->getName();
                }
            } else {
                $employeeGift = reset($employeeGift);
                $response = $employeeGift->getGift()->getName();
            }
        }

        return $response;
    }

    /**
     * @param mixed $employee
     *
     * @return object
     */
    private function assignGiftToEmployee($employee)
    {
        $gift = null;
        $interests = $this->employeeInterestService->getEmployeeInterestsById($employee->getId());
        if ($interests) {
            $gift = $this->em->getRepository(Gift::class)->findGiftForEmployee($employee->getId(), $interests);
            if (count($gift) > 0) {
                $gift = reset($gift);
                $this->addGiftToEmployeeAccount($employee, $gift);
            }
        }

        return $gift;
    }

    /**
     * @param $employee
     * @param $gift
     *
     */
    private function addGiftToEmployeeAccount($employee, $gift): void
    {
        $employeeGift = new EmployeeGift();
        $employeeGift->setEmployee($employee);
        $employeeGift->setGift($gift);
        $employeeGift->setCreatedAt(new \DateTimeImmutable('now'));

        $this->em->persist($employeeGift);
        $this->em->flush();
    }
}
