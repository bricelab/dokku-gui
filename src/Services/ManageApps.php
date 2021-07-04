<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

declare(strict_types=1);

namespace App\Services;

/**
 * Class ManageApps
 * @package App\Services
 */
class ManageApps extends DokkuAbstractCommand
{
    public const COMMAND_CLONE = 'clone';
    public const COMMAND_CREATE = 'create';
    public const COMMAND_DESTROY = 'destroy';
    public const COMMAND_EXISTS = 'exists';
    public const COMMAND_LIST = 'list';
    public const COMMAND_LOCK = 'lock';
    public const COMMAND_LOCKED = 'locked';
    public const COMMAND_RENAME = 'rename';
    public const COMMAND_REPORT = 'report';
    public const COMMAND_UNLOCK = 'unlock';

    public const REPORT_FLAG_APP_DEPLOY_SOURCE = '--app-deploy-source';
    public const REPORT_FLAG_APP_DIR = '--app-dir';
    public const REPORT_FLAG_APP_LOCKED = '--app-locked';

    protected const PREFIX = 'apps';

    public function clone(string $old, string $new): bool
    {
        $output = $this->execute(
            sprintf('%s:%s %s %s', self::PREFIX, self::COMMAND_CLONE, $old, $new)
        );

        return 0 === $output[1];
    }

    public function create(string $name): bool
    {
        $output = $this->execute(
            sprintf('%s:%s %s', self::PREFIX, self::COMMAND_CREATE, $name)
        );

        return 0 === $output[1];
    }

    public function destroy(string $name): bool
    {
        $output = $this->execute(
            sprintf('%s:%s %s', self::PREFIX, self::COMMAND_DESTROY, $name),
            true,
            $name
        );

        return 0 === $output[1];
    }

    public function exists(string $name): bool
    {
        $output = $this->execute(
            sprintf('%s:%s %s', self::PREFIX, self::COMMAND_EXISTS, $name)
        );

        return 0 === $output[1];
    }

    public function list(): array|false
    {
        list($output, $code) = $this->execute(
            sprintf('%s:%s', self::PREFIX, self::COMMAND_LIST)
        );

        if (0 === $code) {
            return $output;
        }
        else {
            return false;
        }
    }

    public function lock(string $name): bool
    {
        $output = $this->execute(
            sprintf('%s:%s %s', self::PREFIX, self::COMMAND_LOCK, $name)
        );

        return 0 === $output[1];
    }

    public function locked(string $name): bool
    {
        $output = $this->execute(
            sprintf('%s:%s %s', self::PREFIX, self::COMMAND_LOCKED, $name)
        );

        return 0 === $output[1];
    }

    public function rename(string $old, string $new): bool
    {
        $output = $this->execute(
            sprintf('%s:%s %s %s', self::PREFIX, self::COMMAND_RENAME, $old, $new)
        );

        return 0 === $output[1];
    }

    public function report(string $name, string $flag = ''): array|false
    {
        list($output, $code) = $this->execute(
            sprintf('%s:%s %s %s', self::PREFIX, self::COMMAND_REPORT, $name, $flag)
        );

        if (0 === $code) {
            return $output;
        }
        else {
            return false;
        }
    }

    public function unlock(string $name): bool
    {
        $output = $this->execute(
            sprintf('%s:%s %s', self::PREFIX, self::COMMAND_UNLOCK, $name)
        );

        return 0 === $output[1];
    }
}
