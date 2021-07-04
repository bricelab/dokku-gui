<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

namespace App\Entity;

use App\Doctrine\UuidGenerator;
use App\Repository\ApplicationRepository;
use Bricelab\Doctrine\TimestampSetter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * Class Application
 * @package App\Entity
 * @ORM\Entity(repositoryClass=ApplicationRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Application
{
    use TimestampSetter;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(UuidGenerator::class)
     * @ORM\Column(type="uuid")
     */
    private ?Uuid $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private ?bool $locked = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $dir = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $deploySource =null;

    public function getId(): ?Uuid
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLocked(): ?bool
    {
        return $this->locked;
    }

    public function setLocked(bool $locked): self
    {
        $this->locked = $locked;

        return $this;
    }

    public function getDir(): ?string
    {
        return $this->dir;
    }

    public function setDir(?string $dir): self
    {
        $this->dir = $dir;

        return $this;
    }

    public function getDeploySource(): ?string
    {
        return $this->deploySource;
    }

    public function setDeploySource(?string $deploySource): self
    {
        $this->deploySource = $deploySource;

        return $this;
    }
}
