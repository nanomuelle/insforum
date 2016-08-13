<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Entity\Post;

class ClearPostsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:clear-posts')
            ->setDescription('Delete all post entries and their associated image files.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getEntityManager();

        $posts = $doctrine->getRepository(Post::class)
            ->findAll();

        foreach ($posts as $post) {
            $em->remove($post);
        }
        $em->flush();
    }
}
