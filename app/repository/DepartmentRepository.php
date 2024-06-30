<?php

namespace app\repository;

use app\dto\DepartmentDto;
use app\Entities\DepartmentEntity;
use Doctrine\ORM\EntityManager;
use Exception;

class DepartmentRepository
{
    public EntityManager $entityManager;

    public function __construct()
    {
        require_once dirname(__DIR__) . "/bootstrap.php";
        $this->entityManager = getEntityManager();
    }

    /**
     * @return array|null
     */
    public function getDepartmentAll(): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $departments = $queryBuilder->select("d")
            ->from(DepartmentEntity::class, "d");
        return $departments->getQuery()->getArrayResult();
    }

    /**
     * @param int $departmentId
     * @return array|null
     */
    public function getDepartmentId(int $departmentId): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $department = $queryBuilder->select("d")
            ->from(DepartmentEntity::class, "d")
            ->where("d.departmentId = " . $departmentId);
        return $department->getQuery()->getArrayResult();
    }

    /**
     * @param int $facultyId
     * @return array|null
     */
    public function getDepartmentByFacultyId(int $facultyId): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $department = $queryBuilder->select("d")
            ->from(DepartmentEntity::class, "d")
            ->where("d.facultyId = " . $facultyId);
        return $department->getQuery()->getArrayResult();
    }

    /**
     * @param DepartmentDto $departmentDto
     * @return void
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
        } catch (Exception $exception) {
            throw new Exception("Ошибка при добавлении кафедры");
        }
    }

    /**
     * @param DepartmentDto $departmentDto
     * @return void
     * @throws Exception
     */
    public function editDepartment(DepartmentDto $departmentDto): void
    {
        try {
            $department = $this->entityManager->find(DepartmentEntity::class, $departmentDto->departmentId);
            $department->setName($departmentDto->departmentName);
            $department->setFacultyId($departmentDto->facultyId);

            $this->entityManager->persist($department);
            $this->entityManager->flush();

        } catch (Exception $exception) {
            throw new Exception("Ошибка при редактировании кафедры");
        }
    }

    /**
     * @param int|array $departmentId
     * @return void
     * @throws Exception
     */
    public function deleteDepartment(int | array $departmentId): void
    {
        if (!is_array($departmentId)) {
            try {
                $department = $this->entityManager->find(DepartmentEntity::class, $departmentId);

                $this->entityManager->remove($department);
                $this->entityManager->flush();

            } catch (Exception $exception) {
                throw new Exception("Ошибка при удалении кафедры");
            }
        } else {
            try {
                foreach ($departmentId as $id) {
                    $department = $this->entityManager->find(DepartmentEntity::class, $id["departmentId"]);

                    $this->entityManager->remove($department);
                }
                $this->entityManager->flush();
            } catch (Exception $exception) {
                throw new Exception("Ошибка при удалении кафедр");
            }
        }
    }
}