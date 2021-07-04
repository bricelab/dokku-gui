<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

namespace App\MessageHandler\Command;


use App\Message\Command\CreateNewApp;
use App\Services\ManageApps;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class CreateNewAppHandler
 * @package App\MessageHandler\Command
 */
class CreateNewAppHandler implements MessageHandlerInterface
{
    /**
     * CreateNewAppHandler constructor.
     * @param ManageApps $manageApps
     */
    public function __construct(private ManageApps $manageApps)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateNewApp $newApp)
    {
        if (!$this->manageApps->create($newApp->getName())) {
            throw new Exception('Erreur when creating new app: '. $newApp->getName());
        }
    }
}
