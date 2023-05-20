<?php

namespace App\Entity;

use App\Repository\FruitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
class Fruit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $fruitId = null;

    #[ORM\Column(length: 255)]
    private ?string $family = null;

    #[ORM\Column(length: 255)]
    private ?string $plantOrder = null;

    #[ORM\Column(length: 255)]
    private ?string $genus = null;

    #[ORM\Column]
    private ?float $calories = null;

    #[ORM\Column]
    private ?float $fat = null;

    #[ORM\Column]
    private ?float $sugar = null;

    #[ORM\Column]
    private ?float $carbohydrate = null;

    #[ORM\Column]
    private ?float $protein = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isFavorite = null;

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

    public function getFruitId(): ?int
    {
        return $this->fruitId;
    }

    public function setFruitId(int $fruitId): self
    {
        $this->fruitId = $fruitId;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getPlantOrder(): ?string
    {
        return $this->plantOrder;
    }

    public function setPlantOrder(string $plantOrder): self
    {
        $this->plantOrder = $plantOrder;

        return $this;
    }

    public function getGenus(): ?string
    {
        return $this->genus;
    }

    public function setGenus(string $genus): self
    {
        $this->genus = $genus;

        return $this;
    }

    public function getCalories(): ?float
    {
        return $this->calories;
    }

    public function setCalories(float $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getFat(): ?float
    {
        return $this->fat;
    }

    public function setFat(float $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getSugar(): ?float
    {
        return $this->sugar;
    }

    public function setSugar(float $sugar): self
    {
        $this->sugar = $sugar;

        return $this;
    }

    public function getCarbohydrate(): ?float
    {
        return $this->carbohydrate;
    }

    public function setCarbohydrate(float $carbohydrate): self
    {
        $this->carbohydrate = $carbohydrate;

        return $this;
    }

    public function getProtein(): ?float
    {
        return $this->protein;
    }

    public function setProtein(float $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function isIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(?bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }
}
