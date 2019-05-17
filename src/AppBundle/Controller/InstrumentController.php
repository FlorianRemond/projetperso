<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Musicien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InstrumentController extends Controller
{
    /**
     * @Route("/instrument/view", name="instrumentview")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('projet/instrumentview.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
