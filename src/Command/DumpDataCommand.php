<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Service\DataDumpService;

#[AsCommand(
    name: 'app:dump-data',
    description: 'Insert data to the database',
    hidden: false,
    aliases: ['app:dump-data']
)]
class DumpDataCommand extends Command
{
    private $dataDumpService;

    public function __construct(DataDumpService $dataDumpService)
    {
        $this->dataDumpService = $dataDumpService;

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
        $response = $this->dataDumpService->dumpData();
        $status = $response['status'];
        $employeeDataResponse = $response['employeeDataResponse'];
        $giftDataResponse = $response['giftDataResponse'];
        if (true === $status) {
            $output->writeln("<info>".$employeeDataResponse."</info>");
            $output->writeln("<info>".$giftDataResponse."</info>");
        }

        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}
