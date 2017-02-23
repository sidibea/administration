<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/23/17
 * Time: 12:26 PM
 */

namespace NB\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AxesController  extends Controller{

    public function listAction(){

        $user = $this->getUser();


        $em = $this->getDoctrine()->getManager();

        $list = $em->getRepository('NBMainBundle:Axes')->findAll();



        return$this->render('NBMainBundle:Axes:list.html.twig', [
            'list' => $list
        ]);
    }

}