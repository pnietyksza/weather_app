<?php

namespace App\Entity;

use App\Repository\WeatherRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeatherRepository::class)]
class Weather
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $temperature = null;

    #[ORM\Column]
    private ?float $wind = null;

    #[ORM\OneToOne(inversedBy: 'weather', cascade: ['persist', 'remove'])]
    private ?Place $place = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Date $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getWind(): ?float
    {
        return $this->wind;
    }

    public function setWind(float $wind): static
    {
        $this->wind = $wind;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getDate(): ?Date
    {
        return $this->date;
    }

    public function setDate(?Date $date): static
    {
        $this->date = $date;

        return $this;
    }
}
