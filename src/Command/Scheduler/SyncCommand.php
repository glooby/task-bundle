<?php

namespace Glooby\TaskBundle\Command\Scheduler;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Emil Kilhage
 */
class SyncCommand extends Command
{
    private $container;

    public function __construct(ContainerInterface $container){
        parent::__construct();
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('scheduler:sync');
        $this->addOption('silent', 'S', InputOption::VALUE_NONE);
        $this->addOption('force', 'F', InputOption::VALUE_NONE);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->container->get('glooby_task.schedule_synchronizer');
        $client->setForce($input->getOption('force'));
        $client->sync();

        // TODO add logging (example if an error occurs) - and return zero
        return 1;
    }
}
