<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Musicien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GlobalController extends Controller
{
    /**
     * @Route("/global/view", name="globalview")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('projet/globalview.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
