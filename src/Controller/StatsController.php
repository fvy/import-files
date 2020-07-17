<?php

namespace App\Controller;

use App\Entity\UsersVisits;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    /**
     * @Route("/stats", name="stats")
     */
    public function index()
    {
        $visitsArr = $this->getDoctrine()
            ->getRepository(UsersVisits::class)
            ->findAllVisits();

//        $visitsArr = $this->getDoctrine()
//            ->getRepository(UsersVisits::class)
//            ->findByExampleField();

        return $this->render('stats/index.html.twig', [
            'controller_name' => 'StatsController',
            'visitsArr' => print_r($visitsArr, true),
        ]);
    }
}
