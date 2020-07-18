<?php

namespace App\Controller;

use SplFileObject;
use App\Utils\ImportFiles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    const USER_VISIT_FILE = "../data/user_visits.txt";
    const USER_ENVS_FILE = "../data/user_envs.txt";

    /**
     * @Route("/import", name="import")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $fileUserVisits = new SplFileObject(self::USER_VISIT_FILE);
        $numOfVisits = (new ImportFiles($entityManager))
            ->ImportFileVisits($fileUserVisits);

        $fileUserEnvs = new SplFileObject(self::USER_ENVS_FILE);
        $numOfEnvs = (new ImportFiles($entityManager))
            ->ImportFileEnvs($fileUserEnvs);

        return $this->render(
            'import/index.html.twig',
            [
                'controller_name' => 'ImportController',
                'UserVisits'      => $numOfVisits,
                'UserEnv'         => $numOfEnvs,
            ]
        );
    }
}
