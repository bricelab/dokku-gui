<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

declare(strict_types=1);

namespace App\Message\Command;

/**
 * Class RenameApp
 * @package App\Message\Command
 */
class RenameApp
{
    /**
     * RenameApp constructor.
     * @param string $old
     * @param string $new
     */
    public function __construct(private string $old, private string $new)
    {
    }

    /**
     * @return string
     */
    public function getNew(): string
    {
        return $this->new;
    }

    /**
     * @return string
     */
    public function getOld(): string
    {
        return $this->old;
    }
}
