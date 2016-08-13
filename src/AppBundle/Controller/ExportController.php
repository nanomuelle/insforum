<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\View;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;

class ExportController extends Controller
{
    /**
     * @Route("/export/csv", name="export_csv")
     */
    public function exportCsvAction(Request $request)
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)
            ->findAllRecentFirst();

        $response = $this->render('AppBundle:export:posts.csv.twig', array(
            'posts' => $posts,
        ));
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="posts.csv"');

        return $response;
    }
}
