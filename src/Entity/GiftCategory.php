<?php

namespace App\Entity;

use App\Repository\GiftCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GiftCategoryRepository::class)]
class GiftCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'giftCategories')]
    private ?Gift $gift = null;

    #[ORM\ManyToOne(inversedBy: 'giftCategories')]
    private ?Category $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGift(): ?Gift
    {
        return $this->gift;
    }

    public function setGift(?Gift $gift): self
    {
        $this->gift = $gift;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
