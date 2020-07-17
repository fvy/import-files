<?php

namespace App\Controller;

use App\Entity\UsersVisits;
use SplFileObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserVisitsController extends AbstractController
{
    /**
     * @Route("/user/visits", name="user_visits")
     */
    public function index()
    {

        $visitsArr = $this->getDoctrine()
            ->getRepository(UsersVisits::class)
            ->findAllVisits();
        print_r("visits:<pre style='background-color: black; color: limegreen;'>");
        print_r($visitsArr);
        print_r("</pre>");
        $visitsArr = $this->getDoctrine()
            ->getRepository(UsersVisits::class)
            ->findByExampleField();
        print_r("<pre style='background-color: black; color: limegreen;'>");
        print_r($visitsArr);
        print_r("</pre>");

        return $this->render('user_visits/index.html.twig', [
            'controller_name' => 'UserVisitsController',
            'visitsArr' => print_r($visitsArr, true),
        ]);
    }
}
