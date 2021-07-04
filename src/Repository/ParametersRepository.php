<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

namespace App\Repository;

use App\Entity\Parameters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ParametersRepository
 * @package App\Repository
 * @method Parameters|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parameters|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parameters[]    findAll()
 * @method Parameters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parameters::class);
    }
}
