<?php

namespace app\repository;

use app\dto\FacultyDto;
use app\Entities\FacultyEntity;
use Doctrine\ORM\EntityManager;

class FacultyRepository {

    public EntityManager $entityManager;

    public function __construct()
    {
        require_once dirname(__DIR__) . "/bootstrap.php";
        $this->entityManager = getEntityManager();
    }
    public function getFacultyAll(): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $faculty = $queryBuilder->select("f")
            ->from(FacultyEntity::class, "f");
        return $faculty->getQuery()->getArrayResult();
    }

    public function getFacultyId(FacultyDto $facultyDto): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $faculty = $queryBuilder->select("f")
            ->from(FacultyEntity::class, "f")
            ->where("f.facultyId = " . $facultyDto->facultyId);
        return $faculty->getQuery()->getArrayResult();
    }

    public function addFaculty($facultyDto): void
    {
        $newFaculty = new FacultyEntity;
        $newFaculty->setName($facultyDto->facultyName);
        $this->entityManager->persist($newFaculty);
        $this->entityManager->flush();
    }

    public function editFaculty(FacultyDto $facultyDto)
    {
        $faculty = $this->entityManager->find(FacultyEntity::class, $facultyDto->facultyId);
        $faculty->setName($facultyDto->facultyName);

        $this->entityManager->persist($faculty);
        $this->entityManager->flush();

        return $faculty->getName();
    }

}