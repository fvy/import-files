<?php

namespace App\Controller;

use SplFileObject;
use App\Utils\ImportFilesIntoDB;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImportController extends AbstractController
{
    const USER_VISIT_FILE = "../data/user_visits.txt";
    const USER_ENVS_FILE = "../data/user_envs.txt";

    /**
     * @Route("/import", name="import")
     * @param ValidatorInterface $validator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $importFilesIntoDB = new ImportFilesIntoDB($entityManager, $validator);

        $fileUserVisits = new SplFileObject(self::USER_VISIT_FILE);
        $numOfVisits = $importFilesIntoDB->ImportFileVisits($fileUserVisits);
        $errorVisits = $importFilesIntoDB->errorsString;

        $fileUserEnvs = new SplFileObject(self::USER_ENVS_FILE);
        $numOfEnvs = $importFilesIntoDB->ImportFileEnvs($fileUserEnvs);
        $errorEnvs = $importFilesIntoDB->errorsString;

        return $this->render(
            'import/index.html.twig',
            [
                'controller_name'  => 'ImportController',
                'UserVisits'       => $numOfVisits,
                'UserVisitsErrors' => $errorVisits,
                'UserEnv'          => $numOfEnvs,
                'UserEnvErrors'    => $errorEnvs,
            ]
        );
    }
}
