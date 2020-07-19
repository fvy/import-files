<?php

namespace App\Entity;

use App\Repository\UsersVisitsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UsersVisitsRepository::class)
 */
class UsersVisits
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Type("\DateTimeInterface")
     *
     * @ORM\Column(type="date")
     */
    private $visit_date;

    /**
     * @Assert\Type("\DateTimeInterface")
     * @var string A "H:i:s" formatted value
     *
     * @ORM\Column(type="time")
     */
    private $visit_time;

    /**
     * @Assert\Ip
     * @ORM\Column(type="string", length=15)
     */
    private $visit_ip;

    /**
     * @Assert\Url(
     *    protocols = {"http", "https", "ftp"},
     *    payload={"severity" = "warning"},
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $visit_from;

    /**
     * @Assert\Url(
     *    protocols = {"http", "https", "ftp"},
     *    payload={"severity"="warning"},
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     *
     * @ORM\Column(type="string", length=255)
     */
    private $visit_to;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisitDate(): ?\DateTimeInterface
    {
        return $this->visit_date;
    }

    public function setVisitDate(\DateTimeInterface $visit_date): self
    {
        $this->visit_date = $visit_date;

        return $this;
    }

    public function getVisitTime(): ?\DateTimeInterface
    {
        return $this->visit_time;
    }

    public function setVisitTime(\DateTimeInterface $visit_time): self
    {
        $this->visit_time = $visit_time;

        return $this;
    }

    public function getVisitIp(): ?string
    {
        return $this->visit_ip;
    }

    public function setVisitIp(string $visit_ip): self
    {
        $this->visit_ip = $visit_ip;

        return $this;
    }

    public function getVisitFrom(): ?string
    {
        return $this->visit_from;
    }

    public function setVisitFrom(?string $visit_from): self
    {
        $this->visit_from = $visit_from;

        return $this;
    }

    public function getVisitTo(): ?string
    {
        return $this->visit_to;
    }

    public function setVisitTo(string $visit_to): self
    {
        $this->visit_to = $visit_to;

        return $this;
    }
}
