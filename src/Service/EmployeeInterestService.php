<?php

namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Employee;

class EmployeeInterestService
{
    private $em;
    public function __construct(private ManagerRegistry $mr)
    {
        $this->em = $mr->getManagerForClass(get_class(new Employee()));
    }

    /**
     * @param integer $employeeId
     *
     * @return array
     */
    public function getEmployeeInterestsById($employeeId): array
    {
        $interestsArr = [];
        $interests = $this->em->getRepository(Employee::class)->findEmployeeInterests($employeeId);
        if ($interests) {
            foreach ($interests as $interest) {
                $interestsArr[] = reset($interest);
            }
        }

        return $interestsArr;
    }
}
