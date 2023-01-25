<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: EmployeeInterest::class)]
    private Collection $employeeInterests;

    #[ORM\OneToOne(mappedBy: 'employee', cascade: ['persist', 'remove'])]
    private ?EmployeeGift $employeeGift = null;

    public function __construct()
    {
        $this->employeeInterests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, EmployeeInterest>
     */
    public function getEmployeeInterests(): Collection
    {
        return $this->employeeInterests;
    }

    public function addEmployeeInterest(EmployeeInterest $employeeInterest): self
    {
        if (!$this->employeeInterests->contains($employeeInterest)) {
            $this->employeeInterests->add($employeeInterest);
            $employeeInterest->setEmployeeId($this);
        }

        return $this;
    }

    public function removeEmployeeInterest(EmployeeInterest $employeeInterest): self
    {
        if ($this->employeeInterests->removeElement($employeeInterest)) {
            // set the owning side to null (unless already changed)
            if ($employeeInterest->getEmployeeId() === $this) {
                $employeeInterest->setEmployeeId(null);
            }
        }

        return $this;
    }

    public function getEmployeeGift(): ?EmployeeGift
    {
        return $this->employeeGift;
    }

    public function setEmployeeGift(?EmployeeGift $employeeGift): self
    {
        // unset the owning side of the relation if necessary
        if ($employeeGift === null && $this->employeeGift !== null) {
            $this->employeeGift->setEmployee(null);
        }

        // set the owning side of the relation if necessary
        if ($employeeGift !== null && $employeeGift->getEmployee() !== $this) {
            $employeeGift->setEmployee($this);
        }

        $this->employeeGift = $employeeGift;

        return $this;
    }
}
