<?php

namespace App\Command;

use App\Service\EspressoMachineSimulator;
use App\Service\UsersDataManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EspressoMachineSimulatorCommand extends Command
{
    public const NAME = 'app:espresso_machine_simulator';
    private $usersDataManager;

    public function __construct(UsersDataManager $usersDataManager)
    {
        $this->usersDataManager = $usersDataManager;

        parent::__construct();
    }

    /**
     * php bin/console app:espresso_machine_simulator --help
     */
    protected function configure(): void
    {
        $help = 'This command allows you to simulate Espresso machine functionality.';
        $help .= PHP_EOL;
        $help .= 'Input data consists of user ID & it\'s optional busy schedule interval (from-to) hours.';

        $this
            ->setName(self::NAME)
            ->setDescription('Simulator for Espresso machine.')
            ->setHelp($help)
        ;

        $description = 'Input users in format (ID:start-end) hours. (separate multiple users with a space).';
        $description .= PHP_EOL;
        $description .= 'Example: 1:11-12 2:10-11 3 4:15-17 5:9-10 6 7 8:9-12';

        $this->addArgument(
            'users',
            InputArgument::IS_ARRAY | InputArgument::REQUIRED,
            $description
        );
    }

    /**
     * Example usage with sample `users` argument data
     * php bin/console app:espresso_machine_simulator 1:11-12 2:10-11 3 4:15-17 5:9-10 6 7 8:9-12
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $usersData = $input->getArgument('users');
        $users = $this->usersDataManager->manageUsersData($usersData);

        $espressoSimulator = new EspressoMachineSimulator($users);
        $usersServeOrderByHour = $espressoSimulator->serveUsers();

        foreach ($usersServeOrderByHour as $hour => $usersServeOrder) {
            echo 'Hour:' . $hour . ', Users serve order by ID : ' . implode(', ', $usersServeOrder);
            echo PHP_EOL;
        }
    }
}
