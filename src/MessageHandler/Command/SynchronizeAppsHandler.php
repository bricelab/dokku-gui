<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

namespace App\MessageHandler\Command;


use App\Entity\Application;
use App\Message\Command\CreateNewApp;
use App\Message\Command\SynchronizeApps;
use App\Repository\ApplicationRepository;
use App\Services\ManageApps;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class SynchronizeAppsHandler
 * @package App\MessageHandler\Command
 */
class SynchronizeAppsHandler implements MessageHandlerInterface
{
    /**
     * SynchronizeAppsHandler constructor.
     * @param ManageApps $manageApps
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private ManageApps $manageApps, private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(SynchronizeApps $synchronizeApps)
    {
        $serverAppsList = $this->manageApps->list();
        if (false === $serverAppsList) {
            throw new Exception('Erreur when synchronizing apps');
        }

        $applicationRepository = $this->entityManager->getRepository(Application::class);
        $dbAppsList = array_column($applicationRepository->getAllAppsName(), 'name');

        $result = array_diff($dbAppsList, $serverAppsList);
        foreach ($result as $item) {
            $this->manageApps->create($item);
        }

        $result = array_diff($serverAppsList, $dbAppsList);
        foreach ($result as $item) {
            $app = new Application();
            $app->setName($item);
            $this->entityManager->persist($app);
        }
        $this->entityManager->flush();
    }
}
