<?php
/*
 * Copyright (c) 2021. bricelab<bricehessou@gmail.com>.
 */

declare(strict_types=1);

namespace App\Command;

use App\Entity\Application;
use App\Services\ExecuteCommandOnHost;
use App\Services\ManageApps;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class TestDokkuCommand
 * @package App\Command
 */
#[AsCommand(
    name: 'test-dokku',
    description: 'Add a short description for your command',
)]
class TestDokkuCommand extends Command
{
    public function __construct(private ManageApps $apps, private EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

//        $executeCommandOnHost = new ExecuteCommandOnHost('paas01.numeris.bj', 'brice');

//        $result = $this->apps->destroy('test1');
//        $result = $this->apps->exists('baby-stuff');
//        $result ? $io->success('Exists!') : $io->error('Not exists!');
        $result = $this->apps->list();
//        [$commandOutput, $code] = $executeCommandOnHost->execute('apps:destroy testprime');

        $io->section('Synchronisation des applications :');
        $cpt = 0;
        foreach ($result as $item) {
            $app = $this->entityManager->getRepository(Application::class)->findOneBy(['name' => $item]);
            if (!$app) {
                $io->writeln("====> Ajout de $item en base de données.");
                $app = new Application();
                $app->setName($item);
                $this->entityManager->persist($app);
                $cpt++;
            }
        }
        $this->entityManager->flush();
//        $io->writeln('');
//        $result = $this->apps->report('baby-stuff', ManageApps::REPORT_FLAG_APP_DIR);
//        $io->section('Rapport de baby-stuff');
//        foreach ($result as $line) {
//            $io->writeln('====> '.$line);
//        }
//        dump($commandOutput, $code);

        $io->success("Synchronisation des applications OK. $cpt apps ajoutés avec succès");

        return Command::SUCCESS;
    }
}
