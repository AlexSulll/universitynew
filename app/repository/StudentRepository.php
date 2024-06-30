<?php

namespace app\repository;

use app\dto\StudentDto;
use app\Entities\StudentEntity;
use Doctrine\ORM\EntityManager;
use Exception;

class StudentRepository
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
    public function getStudentsAll(): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $students = $queryBuilder->select("s")
            ->from(StudentEntity::class, "s");
        return $students->getQuery()->getArrayResult();
    }

    /**
     * @param int $studentId
     * @return array|null
     */
    public function getStudentId(int $studentId): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $student = $queryBuilder->select("s")
            ->from(StudentEntity::class, "s")
            ->where("s.studentId = " . $studentId);
        return $student->getQuery()->getArrayResult();
    }

    /**
     * @param int $groupId
     * @return array|null
     */
    public function getStudentByGroupId(int $groupId): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $student = $queryBuilder->select("s")
            ->from(StudentEntity::class, "s")
            ->where("s.groupId = " . $groupId);
        return $student->getQuery()->getArrayResult();
    }

    /**
     * @param StudentDto $studentDto
     * @return void
     * @throws Exception
     */
    public function addStudent(StudentDto $studentDto): void
    {
        $newStudent = new StudentEntity;

        try {
            $newStudent->setName($studentDto->studentName);
            $newStudent->setGroupId($studentDto->groupId);
            $this->entityManager->persist($newStudent);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            throw new Exception("Ошибка при добавлении студента");
        }
    }

    /**
     * @param StudentDto $studentDto
     * @return void
     * @throws Exception
     */
    public function editStudent(StudentDto $studentDto): void
    {
        try {
            $student = $this->entityManager->find(StudentEntity::class, $studentDto->studentId);
            $student->setName($studentDto->studentName);
            $student->setGroupId($studentDto->groupId);

            $this->entityManager->persist($student);
            $this->entityManager->flush();

        } catch (Exception $exception) {
            throw new Exception("Ошибка при редактировании данных о студенте");
        }
    }

    /**
     * @param int $studentId
     * @return void
     * @throws Exception
     */
    public function deleteStudent(int $studentId): void
    {
        try {
            $student = $this->entityManager->find(StudentEntity::class, $studentId);

            $this->entityManager->remove($student);
            $this->entityManager->flush();

        } catch (Exception $exception) {
            throw new Exception("Ошибка при удалении студента");
        }
    }
}