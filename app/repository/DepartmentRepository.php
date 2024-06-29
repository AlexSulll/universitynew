<?php

namespace app\repository;

use app\dto\DepartmentDto;
use app\Entities\DepartmentEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Exception;

class DepartmentRepository
{
    public EntityManager $entityManager;

    public function __construct()
    {
        require_once dirname(__DIR__) . "/bootstrap.php";
        $this->entityManager = getEntityManager();
    }

    public function getDepartmentAll(): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $departments = $queryBuilder->select("d")
            ->from(DepartmentEntity::class, "d");
        return $departments->getQuery()->getArrayResult();
    }

    public function getDepartmentId(DepartmentDto $departmentDto): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $department = $queryBuilder->select("d")
            ->from(DepartmentEntity::class, "d")
            ->where("d.departmentId = " . $departmentDto->departmentId);
        return $department->getQuery()->getArrayResult();
    }

    public function getDepartmentByFacultyId(DepartmentDto $departmentDto): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $department = $queryBuilder->select("d")
            ->from(DepartmentEntity::class, "d")
            ->where("d.facultyId = " . $departmentDto->facultyId);
        return $department->getQuery()->getArrayResult();
    }

    /**
     * @throws Exception
     */
    public function addDepartment(DepartmentDto $departmentDto): void
    {
        $newDepartment = new DepartmentEntity;

        try {
            $newDepartment->setName($departmentDto->departmentName);
            $newDepartment->setFacultyId($departmentDto->facultyId);
            $this->entityManager->persist($newDepartment);
            $this->entityManager->flush();
        } catch (ORMException $exception) {
            throw new Exception("Ошибка при добавлении факультета");
        }
    }
}