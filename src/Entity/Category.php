<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: GiftCategory::class)]
    private Collection $giftCategories;

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
            $giftCategory->setCategoryId($this);
        }

        return $this;
    }

    public function removeGiftCategory(GiftCategory $giftCategory): self
    {
        if ($this->giftCategories->removeElement($giftCategory)) {
            // set the owning side to null (unless already changed)
            if ($giftCategory->getCategoryId() === $this) {
                $giftCategory->setCategoryId(null);
            }
        }

        return $this;
    }
}
