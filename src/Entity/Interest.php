<?php

namespace App\Entity;

use App\Repository\InterestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterestRepository::class)]
class Interest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'interest', targetEntity: EmployeeInterest::class)]
    private Collection $employeeInterests;

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
            $employeeInterest->setInterestId($this);
        }

        return $this;
    }

    public function removeEmployeeInterest(EmployeeInterest $employeeInterest): self
    {
        if ($this->employeeInterests->removeElement($employeeInterest)) {
            // set the owning side to null (unless already changed)
            if ($employeeInterest->getInterestId() === $this) {
                $employeeInterest->setInterestId(null);
            }
        }

        return $this;
    }
}
