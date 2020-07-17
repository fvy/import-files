<?php

namespace App\Controller;

use App\Entity\UsersVisits;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        $visitsArr = $this->getDoctrine()
            ->getRepository(UsersVisits::class)
            ->findAllVisits();

//        $visitsArr = $this->getDoctrine()
//            ->getRepository(UsersVisits::class)
//            ->findByExampleField();

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'visitsArr' => print_r($visitsArr, true),
        ]);
    }
}
