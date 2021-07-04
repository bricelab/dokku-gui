<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

namespace App\MessageHandler\Command;


use App\Message\Command\CreateNewApp;
use App\Message\Command\DestroyApp;
use App\Message\Command\LockApp;
use App\Services\ManageApps;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class LockAppHandler
 * @package App\MessageHandler\Command
 */
class LockAppHandler implements MessageHandlerInterface
{
    /**
     * LockAppHandler constructor.
     * @param ManageApps $manageApps
     */
    public function __construct(private ManageApps $manageApps)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(LockApp $app)
    {
        if ($app->isLock()) {
            if (!$this->manageApps->lock($app->getName())) {
                throw new Exception('Erreur when locking app: '. $app->getName());
            }
        } else {
            if (!$this->manageApps->unlock($app->getName())) {
                throw new Exception('Erreur when unlocking app: '. $app->getName());
            }
        }
    }
}
