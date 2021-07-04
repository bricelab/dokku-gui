<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

namespace App\Entity;

use App\Repository\ParametersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Parameters
 * @package App\Entity
 * @ORM\Entity(repositoryClass=ParametersRepository::class)
 */
class Parameters
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, options={"default": "main"})
     */
    private ?string $configName = 'main';

    /**
     * @ORM\Column(type="string", length=255, options={"default": "localhost"})
     */
    private ?string $dokkuHost = 'localhost';

    /**
     * @ORM\Column(type="string", length=255, options={"default": "root"})
     */
    private ?string $dokkuConnectUser = 'root';

    /**
     * @ORM\Column(type="integer", options={"default": 22})
     */
    private ?int $dokkuConnectPort = 22;

    public function getDokkuHost(): ?string
    {
        return $this->dokkuHost;
    }

    public function setDokkuHost(string $dokkuHost): self
    {
        $this->dokkuHost = $dokkuHost;

        return $this;
    }

    public function getDokkuConnectUser(): ?string
    {
        return $this->dokkuConnectUser;
    }

    public function setDokkuConnectUser(string $dokkuConnectUser): self
    {
        $this->dokkuConnectUser = $dokkuConnectUser;

        return $this;
    }

    public function getDokkuConnectPort(): ?int
    {
        return $this->dokkuConnectPort;
    }

    public function setDokkuConnectPort(int $dokkuConnectPort): self
    {
        $this->dokkuConnectPort = $dokkuConnectPort;

        return $this;
    }

    public function getConfigName(): ?string
    {
        return $this->configName;
    }

    public function setConfigName(string $configName): self
    {
        $this->configName = $configName;

        return $this;
    }
}
