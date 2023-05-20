<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Service\DumpFruitService;

#[AsCommand(
    name: 'fruits:fetch',
    description: 'Insert fruits to the database',
    hidden: false,
    aliases: ['fruits:fetch']
)]
class FruitFetchCommand extends Command
{
    public function __construct(private DumpFruitService $dumpFruitService)
    {
        $this->dumpFruitService = $dumpFruitService;

        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $response = $this->dumpFruitService->dumpFruits();
        
        $status = $response['status'];
        $response = $response['result'];
        
        if (true === $status) {
            $output->writeln("<info>".$response."</info>");
            $commandStatus = Command::SUCCESS;
        } else {
            $output->writeln("<error>".$response."</error>");
            $commandStatus = Command::FAILURE;
        }

        return $commandStatus;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}
