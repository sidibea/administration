<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/23/17
 * Time: 3:20 PM
 */

namespace NB\MainBundle\Controller;
use NB\MainBundle\Form\VilleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class VillesController extends Controller
{
    public function listAction(){

        $em = $this->getDoctrine()->getManager();

        $list = $em->getRepository('NBMainBundle:Axes')->findAll();



        return$this->render('NBMainBundle:Villes:list.html.twig', [
            'list' => $list
        ]);
    }

    public function addAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $ville = new Ville();
        $form = $this->get('form.factory')->create(new VilleType(), $ville);

        if ($form->handleRequest($request)->isValid()) {

            $photo = $form->get('photo')->getData();

            if($photo != null){
                // Genere un nom unique du fichier avant le stocker
                $photoName = md5(uniqid()).'.'.$photo->guessExtension();

                //Transfer le fichier dans le repertoire ou le logo doit etre stocker
                $photo->move(
                    $this->getParameter('logo_directory'),
                    $photoName
                );

                $ville->setPhoto($photoName);
            }else{
                $ville->setPhoto(null);
            }

            $ville->setCreatedAt(new \datetime);
            $ville->setUpdatedAt(new \datetime);
            $em->persist($ville);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Le bus bien ete enregistrée.');
            return $this->redirect($this->generateUrl('nb_main_city'));

        }

        return$this->render('NBMainBundle:Villes:add.html.twig', [
            'form' => $form->createView()
        ]);

    }



}