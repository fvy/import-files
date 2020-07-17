<?php

namespace App\Controller;

use App\Entity\UsersEnvironments;
use App\Entity\UsersVisits;
use SplFileObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    /**
     * @Route("/import", name="import")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $i = 1;
        $batchSize = 100;

        $fileUserVisits = new SplFileObject("../data/user_visits.txt");
        while (!$fileUserVisits->eof()) {
            [$date, $time, $ip, $from, $to] = $fileUserVisits->fgetcsv("|");

            $usersVisits = new UsersVisits();
            $usersVisits->setVisitDate(new \DateTime(str_replace('.', '-', $date)));
            $usersVisits->setVisitTime(new \DateTime($time));
            $usersVisits->setVisitIp($ip);
            $usersVisits->setVisitFrom($from);
            $usersVisits->setVisitTo($to);

            $entityManager->persist($usersVisits);

            if (($i % $batchSize) === 0) {
                $entityManager->flush();
                $entityManager->clear();
            }
            $i++;
        }
        $entityManager->flush();
        $entityManager->clear();

        $k = 1;
        $fileUserEnv = new SplFileObject("../data/user_envs.txt");
        while (!$fileUserEnv->eof()) {
            [$ip, $browser, $os] = $fileUserEnv->fgetcsv("|");

            $usersEnvs = new UsersEnvironments();
            $usersEnvs->setUserIp($ip);
            $usersEnvs->setUserBrowser($browser);
            $usersEnvs->setUserOs($os);

            $entityManager->persist($usersEnvs);

            if (($k % $batchSize) === 0) {
                $entityManager->flush();
                $entityManager->clear();
            }
            $k++;
        }
        $entityManager->flush();
        $entityManager->clear();

        return $this->render(
            'import/index.html.twig',
            [
                'controller_name' => 'ImportController',
                'UserVisits'      => $i,
                'UserEnv'         => $k,
            ]
        );
    }
}
