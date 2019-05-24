<?php

namespace AppBundle\Controller;

use AppBundle\Form\MusicienType;
use AppBundle\Entity\Musicien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;



class MusicienController extends Controller
{
    /**
     * @Route("/global/view", name="musicienview")
     */
    public function viewAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $musiciens = $em->getRepository('AppBundle:Musicien')->findAll();
        $em = $this->getDoctrine()->getManager();
        if ($musiciens == null) {
            throw new NotFoundHttpException('erreur de récupération des données');
        }
        $response = $this->render('projet/globalview.html.twig', [
            'musiciens' => $musiciens]);
        return $response;
    }

    /**
     * @Route("musicien/view/{id}", name="musicien_view_url")
     */
    public function viewUrlAction($id)
    {
        // récupérer un seul article depuis la base de données
        $em = $this->getDoctrine()->getManager();
        $musicien = $em->getRepository("AppBundle:Musicien")->find($id);
        // générer une page d'erreur 404 si l'article n'existe pas
        if ($musicien == null) {
            // le code s'arrêtera ici si on rentre dans le if
            throw new NotFoundHttpException("L'ID N'EXISTE PAS");
        }
        $response = $this->render('projet/musicienviewid.html.twig', [
            'musicien' => $musicien
        ]);
        return $response;
    }


    /**
     * @Route("musicien/insert", name="musicien_insert")
     */
    public function insertAction(Request $request)
    {
        // 1- créer une instance de Article
        $musicien = new Musicien();
        // 2- à partir du service "form.factory", créer un "formBuilder" qui va nous servir à créer
        // un objet formulaire.
        // On appelle la méthode createBuilder du form.factory en lui passant deux paramètres :
        //    1- la classe formulaire créée auparavant : MusicienType::class
        //    2- puis l'objet à lier à ce formulaire : $musicien
        $formBuilder = $this->get('form.factory')->createBuilder(MusicienType::class, $musicien);
        // 3- à partir du formBuilder, on génère l'objet formulaire
        $form = $formBuilder->getForm();
        // 4- récupérer les données envoyées pour hydrater l'objet
        $form->handleRequest($request);
        // 5-
        // si le formulaire a été soumis, alors enregistrer l'objet article
        // dont les propriétés ont été automatiquement settées
        // par le composant formulaire lros du "handleRequest"
        if ($form->isSubmitted()) {


            // vérifier si le formulaire est valide
            // isValid() va aller chercher dans la configuration de l'entité les contraintes
            // et automatiquement faire les vérifcations PHP adéquates$

            // toutes les contraintes ici :
            // https://symfony.com/doc/3.4/reference/constraints.html
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($musicien);
                $em->flush();
                return $this->redirectToRoute('globalview');
            }
        }

        // 6- générer le template twig en lui passant la vue de l'objet formulaire
        // dans le template twig "article/insert.html.twig", on aura ainsi accès à la variable formArticle
        return $this->render('projet/musicieninsert.html.twig', [
            'formMusicien' => $form->createView()
        ]);
    }

    /**
     * @Route("/musicien/remove", name="musicien_remove")
     */
    public function removeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $musiciens = $em->getRepository('AppBundle:Musicien')->findAll();
        $em = $this->getDoctrine()->getManager();
        $response = $this->render('projet/musicienremoveview.html.twig', [
            'musiciens' => $musiciens]);
        return $response;
    }

    /**
     * @Route("/musicien/remove/{id}", name="musicien_remove_id")
     */
    public function removeIdAction($id)
    {
        // récupérer un seul article depuis la base de données
        $em = $this->getDoctrine()->getManager();
        $musicien = $em->getRepository("AppBundle:Musicien")->find($id);

        // supprimer une entité
        if ($musicien != null) {
            $em->remove($musicien);
            $em->flush();
        }
        return $this->redirectToRoute('globalview');
    }

    /**
     * @Route("/musicien/list", name="musicien_list")
     * @return Response
     */
    public function musicienListAction(Request $request)
    {
        $repository = $this -> getDoctrine()->getRepository(Musicien::class);
        $musiciens =$repository->findAll();
        return $this -> render('/projet/MusicienListview.html.twig',
            array('musiciens'=>$musiciens));
    }


    /**
     * @Route ("/edit/{id}", name="musicien_edit")
     * @return Response
     */
    public function edit(Request $request ,Musicien $musicien)
    {

        // 2- à partir du service "form.factory", créer un "formBuilder" qui va nous servir à créer
        // un objet formulaire.
        // On appelle la méthode createBuilder du form.factory en lui passant deux paramètres :
        //    1- la classe formulaire créée auparavant : MusicienType::class
        //    2- puis l'objet à lier à ce formulaire : $musicien
        $formBuilder = $this->get('form.factory')->createBuilder(MusicienType::class, $musicien);
        // 3- à partir du formBuilder, on génère l'objet formulaire
        $form = $formBuilder->getForm();
        // 4- récupérer les données envoyées pour hydrater l'objet
        $form->handleRequest($request);
        // 5-
        // si le formulaire a été soumis, alors enregistrer l'objet article
        // dont les propriétés ont été automatiquement settées
        // par le composant formulaire lros du "handleRequest"
        if ($form->isSubmitted()) {
        // vérifier si le formulaire est valide
            // isValid() va aller chercher dans la configuration de l'entité les contraintes
            // et automatiquement faire les vérifcations PHP adéquates$

            // toutes les contraintes ici :
            // https://symfony.com/doc/3.4/reference/constraints.html
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($musicien);
                $em->flush();
                return $this->redirectToRoute('globalview');
            }
        }

        // 6- générer le template twig en lui passant la vue de l'objet formulaire
        // dans le template twig "article/insert.html.twig", on aura ainsi accès à la variable formArticle
        return $this->render('projet/musicieninsert.html.twig', [
            'formMusicien' => $form->createView()
        ]);
    }
}

