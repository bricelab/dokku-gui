<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

declare(strict_types=1);

namespace App\Message\Command;

/**
 * Class DestroyApp
 * @package App\Message\Command
 */
class DestroyApp
{
    /**
     * DestroyApp constructor.
     * @param string $name
     */
    public function __construct(private string $name)
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
