<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

namespace App\MessageHandler\Command;


use App\Message\Command\CreateNewApp;
use App\Message\Command\DestroyApp;
use App\Services\ManageApps;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class DestroyAppHandler
 * @package App\MessageHandler\Command
 */
class DestroyAppHandler implements MessageHandlerInterface
{
    /**
     * DestroyAppHandler constructor.
     * @param ManageApps $manageApps
     */
    public function __construct(private ManageApps $manageApps)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(DestroyApp $app)
    {
        if (!$this->manageApps->destroy($app->getName())) {
            throw new Exception('Erreur when creating new app: '. $app->getName());
        }
    }
}
