<?php

namespace App\Entity;

use App\Repository\GiftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GiftRepository::class)]
class Gift
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'gift', targetEntity: GiftCategory::class)]
    private Collection $giftCategories;

    #[ORM\OneToOne(mappedBy: 'gift', cascade: ['persist', 'remove'])]
    private ?EmployeeGift $employeeGift = null;

    public function __construct()
    {
        $this->giftCategories = new ArrayCollection();
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
     * @return Collection<int, GiftCategory>
     */
    public function getGiftCategories(): Collection
    {
        return $this->giftCategories;
    }

    public function addGiftCategory(GiftCategory $giftCategory): self
    {
        if (!$this->giftCategories->contains($giftCategory)) {
            $this->giftCategories->add($giftCategory);
            $giftCategory->setGiftId($this);
        }

        return $this;
    }

    public function removeGiftCategory(GiftCategory $giftCategory): self
    {
        if ($this->giftCategories->removeElement($giftCategory)) {
            // set the owning side to null (unless already changed)
            if ($giftCategory->getGiftId() === $this) {
                $giftCategory->setGiftId(null);
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
            $this->employeeGift->setGift(null);
        }

        // set the owning side of the relation if necessary
        if ($employeeGift !== null && $employeeGift->getGift() !== $this) {
            $employeeGift->setGift($this);
        }

        $this->employeeGift = $employeeGift;

        return $this;
    }
}
