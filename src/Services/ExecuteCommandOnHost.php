<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

declare(strict_types=1);

namespace App\Services;

/**
 * Class ExecuteCommandOnHost
 * @package App\Services
 */
class ExecuteCommandOnHost
{
    public function __construct(
        private string $host = 'localhost',
        private string $user = 'root',
        private int $port = 22
    ) {
    }

    public function execute(string $command, bool $withInput = false, $inputs = ''): array
    {
        return $withInput ? $this->executeWithInput($command, $inputs) : $this->executeWithoutInput($command);
    }

    private function commandPrefix(): string
    {
        return sprintf(
            'ssh %s@%s -p %s dokku --quiet',
            $this->user,
            $this->host,
            $this->port
        );
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPort(): int|string
    {
        return $this->port;
    }

    private function executeWithInput(string $command, string $inputs): array
    {
        $commandOutput = null;
        $code = -1;
        $descriptors = [
            0 => ["pipe", "r"],  // // stdin est un pipe où le processus va lire
            1 => ["pipe", "w"],  // stdout est un pipe où le processus va écrire
            2 => ["file", "/tmp/error-output.txt", "a"] // stderr est un fichier
        ];
        $process = proc_open(
            sprintf(
                '%s %s',
                $this->commandPrefix(),
                $command
            ),
            $descriptors,
            $pipes,
            null,
            null,
            null
        );
        if (is_resource($process)) {
            fwrite($pipes[0], $inputs);
            fclose($pipes[0]);

            $commandOutput = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            $code = proc_close($process);
        }
        return [$commandOutput, $code];
    }

    private function executeWithoutInput(string $command): array
    {
        exec(
            sprintf(
                '%s %s',
                $this->commandPrefix(),
                $command
            ),
            $commandOutput,
            $code
        );
        return [$commandOutput, $code];
    }
}
