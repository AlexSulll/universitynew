<?php

namespace app\repository;

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

    public function getFacultyId($facultyId): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $faculty = $queryBuilder->select("f")
            ->from(FacultyEntity::class, "f")
            ->where("f.facultyId = " . $facultyId);
        return $faculty->getQuery()->getArrayResult();
    }

    public function addFaculty($facultyName): void
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
//        $queryBuilder->add();
    }

    public function editFaculty($facultyDto): void
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->update(FacultyEntity::class, "f")
            ->set("f.facultyName", $facultyDto->facultyName)
            ->where($queryBuilder->expr()->eq("f.facultyId", $facultyDto->facultyId));
    }

}