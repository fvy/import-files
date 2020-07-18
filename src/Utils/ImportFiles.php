<?php


namespace App\Utils;

use App\Entity\UsersVisits;
use App\Entity\UsersEnvironments;

class ImportFiles
{
    private $entityManager;

    const BATCH_SIZE = 100;

    function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function ImportFileVisits(\SplFileObject $fileUserVisits)
    {
        $i = 1;
        while (!$fileUserVisits->eof()) {
            [$date, $time, $ip, $from, $to] = $fileUserVisits->fgetcsv("|");

            $date = str_replace('.', '-', $date);

            $usersVisits = new UsersVisits();
            $usersVisits->setVisitDate(new \DateTime($date));
            $usersVisits->setVisitTime(new \DateTime($time));
            $usersVisits->setVisitIp($ip);
            $usersVisits->setVisitFrom($from);
            $usersVisits->setVisitTo($to);

            $this->entityManager->persist($usersVisits);

            if (($i % self::BATCH_SIZE) === 0) {
                $this->flushAndClear();
            }
            $i++;
        }
        $this->flushAndClear();

        return $i;
    }

    public function ImportFileEnvs(\SplFileObject $fileUserEnv)
    {

        $i= 1;
        while (!$fileUserEnv->eof()) {
            [$ip, $browser, $os] = $fileUserEnv->fgetcsv("|");

            $usersEnvs = new UsersEnvironments();
            $usersEnvs->setUserIp($ip);
            $usersEnvs->setUserBrowser($browser);
            $usersEnvs->setUserOs($os);

            $this->entityManager->persist($usersEnvs);

            if (($i % self::BATCH_SIZE) === 0) {
                $this->flushAndClear();
            }
            $i++;
        }
        $this->flushAndClear();

        return $i;
    }

    private function flushAndClear()
    {
        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}