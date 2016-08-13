<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\View;

/**
 * View controller.
 */
class ViewAPIController extends Controller
{
    /**
    * API Get number of Views
    * @Route("/api/views/count")
    */
    public function countAction() {
        $view = $this->getDoctrine()->getRepository(View::class)->find(1);
        $numViews = $view->getCount();

        $response = new JsonResponse();
        $response->setData(array(
            'numViews' => $numViews
        ));

        return $response;
    }
}
