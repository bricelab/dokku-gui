<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

declare(strict_types=1);

namespace App\Services;


use App\Repository\ParametersRepository;

/**
 * Class DokkuAbstractCommand
 * @package App\Services
 */
abstract class DokkuAbstractCommand
{
    protected ExecuteCommandOnHost $onHost;

    public function __construct(
        protected ParametersRepository $parametersRepository
    ) {
        $this->initialize();
    }

    protected function execute(string $command, bool $withInput = false, $inputs = ''): array
    {
        return $this->onHost->execute($command, $withInput, $inputs);
    }

    private function initialize(): void
    {
        $parameters = $this->parametersRepository->findOneBy(['configName' => 'main']);
        if (!$parameters) {
            throw new \LogicException('Please specify a valid host path info');
        }
        $this->onHost = new ExecuteCommandOnHost($parameters->getDokkuHost(), $parameters->getDokkuConnectUser(), $parameters->getDokkuConnectPort());
    }
}
