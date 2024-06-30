<?php

namespace app\repository;

use app\dto\FacultyDto;
use app\Entities\FacultyEntity;
use Doctrine\ORM\EntityManager;
use Exception;

class FacultyRepository {

    public EntityManager $entityManager;

    public function __construct()
    {
        require_once dirname(__DIR__) . "/bootstrap.php";
        $this->entityManager = getEntityManager();
    }

    /**
     * @return array|null
     */
    public function getFacultyAll(): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $faculty = $queryBuilder->select("f")
            ->from(FacultyEntity::class, "f");
        return $faculty->getQuery()->getArrayResult();
    }

    /**
     * @param FacultyDto $facultyDto
     * @return array|null
     */
    public function getFacultyId(FacultyDto $facultyDto): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $faculty = $queryBuilder->select("f")
            ->from(FacultyEntity::class, "f")
            ->where("f.facultyId = " . $facultyDto->facultyId);
        return $faculty->getQuery()->getArrayResult();
    }

    /**
     * @param FacultyDto $facultyDto
     * @return void
     * @throws Exception
     */
    public function addFaculty(FacultyDto $facultyDto): void
    {
        $newFaculty = new FacultyEntity;

        try {
            $newFaculty->setName($facultyDto->facultyName);
            $this->entityManager->persist($newFaculty);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            throw new Exception("Ошибка при добавлении факультета");
        }

    }

    /**
     * @param FacultyDto $facultyDto
     * @return void
     * @throws Exception
     */
    public function editFaculty(FacultyDto $facultyDto): void
    {
        try {
            $faculty = $this->entityManager->find(FacultyEntity::class, $facultyDto->facultyId);
            $faculty->setName($facultyDto->facultyName);

            $this->entityManager->persist($faculty);
            $this->entityManager->flush();

        } catch (Exception $exception) {
            throw new Exception("Ошибка при редактировании факультета");
        }
    }

    /**
     * @param int $facultyId
     * @return void
     * @throws Exception
     */
    public function deleteFaculty(int $facultyId): void
    {
        try {
            $faculty = $this->entityManager->find(FacultyEntity::class, $facultyId);

            $this->entityManager->remove($faculty);
            $this->entityManager->flush();

        } catch (Exception $exception) {
            throw new Exception("Ошибка при удалении факультета");
        }
    }
}