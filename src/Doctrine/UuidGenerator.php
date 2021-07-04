<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

declare(strict_types=1);

namespace App\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\Uuid;

/**
 * Class UuidGenerator
 * @package App\Doctrine
 */
class UuidGenerator extends AbstractIdGenerator
{

    public function generate(EntityManager $em, $entity): Uuid
    {
        return Uuid::v4();
    }
}
