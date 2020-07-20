<?php


namespace App\Utils;

use App\Entity\UsersVisits;
use App\Entity\UsersEnvironments;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImportFilesIntoDB
{
    private $entityManager;

    const BATCH_SIZE = 100;

    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var string
     */
    public $errorsString;
    /**
     * @var string
     */
    public $errors;

    function __construct($entityManager, $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function ImportFileVisits(\SplFileObject $fileUserVisits): ?int
    {
        $i = 0;
        $this->errorsString = [];
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

            // validate Object & keep Errors
            $this->validateObject($usersVisits, $i);

            if (($i % self::BATCH_SIZE) === 0) {
                $this->flushAndClear();
            }
            $i++;
        }
        $this->flushAndClear();

        return $i;
    }

    public function ImportFileEnvs(\SplFileObject $fileUserEnv): ?int
    {
        $i = 0;
        $this->errorsString = [];
        while (!$fileUserEnv->eof()) {
            [$ip, $browser, $os] = $fileUserEnv->fgetcsv("|");

            $usersEnvs = new UsersEnvironments();
            $usersEnvs->setUserIp($ip);
            $usersEnvs->setUserBrowser($browser);
            $usersEnvs->setUserOs($os);

            $this->entityManager->persist($usersEnvs, $i);

            $this->validateObject($usersEnvs, $i);

            if (($i % self::BATCH_SIZE) === 0) {
                $this->flushAndClear();
            }
            $i++;
        }
        $this->flushAndClear();

        return $i;
    }

    private function flushAndClear(): void
    {
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    private function validateObject($usersVisits, $step): void
    {
        $this->errors = $this->validator->validate($usersVisits);

        if (count($this->errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            static $i;
            foreach ($this->errors as $error) {
                $this->errorsString[$i] = [
                    'stringNumber'    => $step,
                    'message'         => $error->getMessage(),
                    'invalidValue'    => $error->getInvalidValue(),
                    'invalidProperty' => $error->getPropertyPath(),
                ];
                $i++;
            }
            //return new Response($errorsString);
        }
    }
}