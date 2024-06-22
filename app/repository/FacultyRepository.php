<?php

namespace app\repository;

use app\Entities\FacultyEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class FacultyRepository extends EntityRepository
{

//    public EntityManager $entityManager;
//    public function __construct(EntityManagerInterface $em, $class)
//    {
//        parent::__construct($em, $class);
//    }

//    public function getFacultyAll(): array
//    {
//        $connection = $this->_em->createQueryBuilder();
//        $connection->select("f")
//            ->from(FacultyEntity::class, "f");
//        return $connection->getQuery()->getArrayResult();
//    }
    public function findByFacultyAll(): array
    {
        $connection = $this->_em->createQueryBuilder();
        $faculties = $connection->select("name_faculty")
            ->from(FacultyEntity::class, "f");
        return $faculties->getQuery()->getArrayResult();
    }
}