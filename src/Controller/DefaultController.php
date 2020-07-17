<?php

namespace App\Controller;

use SplFileObject;
use App\Entity\UsersVisits;
use App\Entity\UsersEnvironments;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $usersVisits = new UsersVisits();
        $usersEnvs = new UsersEnvironments();

        $fileUserVisits = new SplFileObject("../data/user_visits.txt");
        while (!$fileUserVisits->eof()) {
            [$date, $time, $ip, $from, $to] = $fileUserVisits->fgetcsv("|");
            $usersVisits->setVisitDate($date);
            $usersVisits->setVisitTime($time);
            $usersVisits->setVisitIp($ip);
            $usersVisits->setVisitFrom($from);
            $usersVisits->setVisitTo($to);
        }

        $entityManager->persist($usersVisits);
        $entityManager->flush();

        $fileUserEnv = new SplFileObject("../data/user_envs.txt");
        while (!$fileUserEnv->eof()) {
            [$date, $time, $ip, $from, $to] = $fileUserEnv->fgetcsv("|");
            $usersEnvs->setUserIp($date);
            $usersEnvs->setUserBrowser($date);
            $usersEnvs->setUserOs($date);
        }

        $entityManager->persist($usersVisits);
        $entityManager->flush();

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
