<?php

namespace app\repository;

use app\Entities\FacultyEntity;
use Doctrine\ORM\EntityManager;

class TreeRepository
{
    public EntityManager $entityManager;

    public function __construct()
    {
        require_once dirname(__DIR__) . "/bootstrap.php";
        $this->entityManager = getEntityManager();
    }

    /**
     * @return array
     */
    public function getTree(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $tree = $queryBuilder->select("f", "d", "g", "s")
            ->from(FacultyEntity::class, "f")
            ->leftJoin("f.departments", "d")
            ->leftJoin("d.groups", "g")
            ->leftJoin("g.students", "s");

        return $tree->getQuery()->getArrayResult();
    }
}