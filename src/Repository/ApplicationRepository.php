<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

namespace App\Repository;

use App\Entity\Application;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ApplicationRepository
 * @package App\Repository
 * @method Application|null find($id, $lockMode = null, $lockVersion = null)
 * @method Application|null findOneBy(array $criteria, array $orderBy = null)
 * @method Application[]    findAll()
 * @method Application[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    public function getAllAppsName(): array
    {
        return $this->createQueryBuilder('a')
            ->select('a.name')
            ->getQuery()
            ->getResult()
        ;
    }
}
