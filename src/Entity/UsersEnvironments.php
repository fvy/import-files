<?php

namespace App\Entity;

use App\Repository\UsersEnvironmentsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsersEnvironmentsRepository::class)
 */
class UsersEnvironments
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $user_ip;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $user_browser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_os;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserIp(): ?string
    {
        return $this->user_ip;
    }

    public function setUserIp(string $user_ip): self
    {
        $this->user_ip = $user_ip;

        return $this;
    }

    public function getUserBrowser(): ?string
    {
        return $this->user_browser;
    }

    public function setUserBrowser(string $user_browser): self
    {
        $this->user_browser = $user_browser;

        return $this;
    }

    public function getUserOs(): ?string
    {
        return $this->user_os;
    }

    public function setUserOs(string $user_os): self
    {
        $this->user_os = $user_os;

        return $this;
    }
}
