<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

namespace App\MessageHandler\Command;


use App\Message\Command\RenameApp;
use App\Services\ManageApps;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class RenameAppHandler
 * @package App\MessageHandler\Command
 */
class RenameAppHandler implements MessageHandlerInterface
{
    /**
     * RenameAppHandler constructor.
     * @param ManageApps $manageApps
     */
    public function __construct(private ManageApps $manageApps)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(RenameApp $app)
    {
        if (!$this->manageApps->rename($app->getOld(), $app->getNew())) {
            throw new Exception('Erreur when rename app from: '. $app->getOld() . ' to '. $app->getNew());
        }
    }
}
