<?php

namespace app\repository;

use app\Entities\DepartmentEntity;
use app\Entities\FacultyEntity;
use app\Entities\GroupEntity;
use app\Entities\StudentEntity;
use Doctrine\ORM\EntityManager;

class TreeRepository
{
    public EntityManager $entityManager;

    public function __construct()
    {
        require_once dirname(__DIR__) . "/bootstrap.php";
        $this->entityManager = getEntityManager();
    }
    public function getTree()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $tree = $queryBuilder->select("f", "d", "g", "s")
            ->from(FacultyEntity::class, "f")
            ->join(DepartmentEntity::class, "d")
            ->join(GroupEntity::class, "g")
            ->join(StudentEntity::class, "s");

        return $tree->getQuery()->getArrayResult();
    }
}