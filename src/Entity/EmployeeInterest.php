<?php

namespace App\Entity;

use App\Repository\EmployeeInterestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeInterestRepository::class)]
class EmployeeInterest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'employeeInterests')]
    private ?Employee $employee = null;

    #[ORM\ManyToOne(inversedBy: 'employeeInterests')]
    private ?Interest $interest = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getInterest(): ?Interest
    {
        return $this->interest;
    }

    public function setInterest(?Interest $interest): self
    {
        $this->interest = $interest;

        return $this;
    }
}
