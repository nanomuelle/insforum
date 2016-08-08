<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\View;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $view = $this->getDoctrine()->getRepository(View::class)->find(1);

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setImageOriginalName($post->getImageFile()->getClientOriginalName());
            $em->persist($post);
        } else {
            $view->setCount($view->getCount() + 1);
            $em->persist($view);
        }
        $em->flush();

        $posts = $this->getDoctrine()->getRepository(Post::class)
            ->findAll();
        $numPosts = count($posts);
        $numViews = $view->getCount();

        // replace this example code with whatever you need
        return $this->render('AppBundle:default:index.html.twig', array(
            'numPosts' => $numPosts,
            'numViews' => $numViews,
            'form' => $form->createView(),
            'posts' => $posts,
        ));

        // , array(
        //     'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
    }
}
