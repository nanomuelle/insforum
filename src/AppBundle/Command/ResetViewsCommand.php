<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\View;

class ResetViewsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:reset-views')
            ->setDescription('Reset views count.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getEntityManager();

        $view = $doctrine->getRepository(View::class)
            ->find(1);
        $view->setCount(0);
        $em->persist($view);
        $em->flush();
    }
}
