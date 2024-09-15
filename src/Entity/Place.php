<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
class Place
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $name = null;

    #[ORM\Column(length: 70)]
    private ?string $country = null;

    #[ORM\OneToOne(mappedBy: 'place', cascade: ['persist', 'remove'])]
    private ?Weather $weather = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getWeather(): ?Weather
    {
        return $this->weather;
    }

    public function setWeather(?Weather $weather): static
    {
        // unset the owning side of the relation if necessary
        if ($weather === null && $this->weather !== null) {
            $this->weather->setPlace(null);
        }

        // set the owning side of the relation if necessary
        if ($weather !== null && $weather->getPlace() !== $this) {
            $weather->setPlace($this);
        }

        $this->weather = $weather;

        return $this;
    }
}
