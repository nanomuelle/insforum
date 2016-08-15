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
    * @Route("/ajax/topBar", name="ajax_topBar")
    */
    public function topBarAction(Request $request) {
        $numPosts = $this->getDoctrine()->getRepository(Post::class)->getCount();

        $view = $this->getDoctrine()->getRepository(View::class)->find(1);
        $numViews = $view->getCount();

        return $this->render('AppBundle:default:topBar.html.twig', array(
            'numPosts' => $numPosts,
            'numViews' => $numViews,
        ));
    }

    private function incrementViews() {
        $view = $this->getDoctrine()->getRepository(View::class)->find(1);
        $view->incrementCount();
        $this->getDoctrine()->getManager()->persist($view);
    }

    /**
    * @Route("/ajax/postList/{fromPostId}", name="ajax_postList", defaults={"fromPostId" = null})
    **/
    public function postListAction(Request $request, $fromPostId = null) {
        $postRepo = $this->getDoctrine()->getRepository(Post::class);
        $posts = $postRepo->findNextNPosts($fromPostId);

        return $this->render('AppBundle:default:postList.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form->getData()->getImageFile() !== null) {
            $post = $form->getData();
            $post->setImageOriginalName($post->getImageFile()->getClientOriginalName());
            $em->persist($post);
        } else {
            $this->incrementViews();
        }
        $em->flush();

        return $this->render('AppBundle:default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
