<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

declare(strict_types=1);

namespace App\Message\Command;

/**
 * Class LockApp
 * @package App\Message\Command
 */
class LockApp
{
    /**
     * LockApp constructor.
     * @param string $name
     * @param bool $lock
     */
    public function __construct(private string $name, private bool $lock)
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isLock(): bool
    {
        return $this->lock;
    }
}
