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
     * @param StudentDto $studentDto
     * @return array|null
     */
    public function getStudentId(StudentDto $studentDto): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $student = $queryBuilder->select("s")
            ->from(StudentEntity::class, "s")
            ->where("s.studentId = " . $studentDto->studentId);
        return $student->getQuery()->getArrayResult();
    }

    /**
     * @param $studentDto
     * @return array|null
     */
    public function getStudentByGroupId($studentDto): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $student = $queryBuilder->select("s")
            ->from(StudentEntity::class, "s")
            ->where("s.groupId = " . $studentDto->groupId);
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

    public function deleteStudent(StudentDto $studentDto) {
//        $student = $this->entityManager->find(StudentEntity::class, $studentDto->studentId);
//        $student->removeStudent();
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $student = $queryBuilder->delete("s")
            ->from(StudentEntity::class, "s")
            ->where("s.studentId = " . $studentDto->studentId);
        $student->getQuery();
    }
}