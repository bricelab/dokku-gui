<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

namespace App\MessageHandler\Command;


use App\Message\Command\CloneApp;
use App\Services\ManageApps;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class CloneAppHandler
 * @package App\MessageHandler\Command
 */
class CloneAppHandler implements MessageHandlerInterface
{
    /**
     * CloneAppHandler constructor.
     * @param ManageApps $manageApps
     */
    public function __construct(private ManageApps $manageApps)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(CloneApp $app)
    {
        if (!$this->manageApps->clone($app->getOld(), $app->getNew())) {
            throw new Exception('Erreur when rename app from: '. $app->getOld() . ' to '. $app->getNew());
        }
    }
}
