<?php

namespace app\service;

use app\dto\StudentDto;
use app\Entities\GroupEntity;
use app\Entities\StudentEntity;
use Doctrine\ORM\EntityManager;
use Exception;

class StudentService
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
        $students = $this->entityManager->getRepository(StudentEntity::class)->findAll();
        return $this->extracted($students);
    }

    /**
     * @param StudentDto $studentDto
     * @return StudentDto
     */
    public function getStudentById(StudentDto $studentDto): StudentDto
    {
        $student = $this->entityManager->getRepository(StudentEntity::class)->find($studentDto->id) ?? sendFail("Такого студента не существует");

        $studentDto->id = $student->getId();
        $studentDto->name = $student->getName();
        $studentDto->groupId = $student->getGroup()->getId();

        return $studentDto;
    }

    /**
     * @param StudentDto $studentDto
     * @return array|null
     */
    public function getStudentByGroupId(StudentDto $studentDto): ?array
    {
        $this->entityManager->getRepository(GroupEntity::class)->find($studentDto->groupId) ?? sendFail("Такой группы не существует");
        $students = $this->entityManager->getRepository(StudentEntity::class)->findBy(['group' => $studentDto->groupId]);
        return $this->extracted($students);
    }

    /**
     * @param StudentDto $studentDto
     * @return void
     * @throws Exception
     */
    public function addStudent(StudentDto $studentDto): void
    {
        $student = $this->entityManager->getRepository(StudentEntity::class)->findOneBy(['name' => $studentDto->name]);

        $group = $this->entityManager->getRepository(GroupEntity::class)->find($studentDto->groupId) ?? sendFail("Такого группы не существует");

        if ($student !== null) {
            sendFail("Студент с таким ФИО уже существует");
        }

        try {
            $newStudent = new StudentEntity;
            $newStudent->setName($studentDto->name);
            $newStudent->setGroup($group);
            $this->entityManager->persist($newStudent);
            $this->entityManager->flush();
            sendFail("Успешное добавление студента");
        } catch (Exception $exception) {
            sendFail("Ошибка при добавлении студента");
        }
    }

    /**
     * @param StudentDto $studentDto
     * @return void
     * @throws Exception
     */
    public function editStudent(StudentDto $studentDto): void
    {
        $student = $this->entityManager->find(StudentEntity::class, $studentDto->id) ?? sendFail('Такой студент не существует');

        $group = $this->entityManager->find(GroupEntity::class, $studentDto->groupId) ?? sendFail("Группа не найдена");

        $studentExist = $this->entityManager->getRepository(StudentEntity::class)->findOneBy([
            'name' => $studentDto->name,
            'group' => $studentDto->groupId
        ]);

        if ($studentExist !== null) {
            sendFail("Такое название уже сущесвтвует");
        }

        try {
            $student->setName($studentDto->name);
            $student->setGroup($group);

            $this->entityManager->persist($student);
            $this->entityManager->flush();
            sendFail("Успешное изменение студента");
        } catch (Exception $exception) {
            sendFail("Ошибка при редактировании студента");
        }
    }

    /**
     * @param StudentDto $studentDto
     * @return void
     * @throws Exception
     */
    public function deleteStudent(StudentDto $studentDto): void
    {
        $student = $this->entityManager->find(StudentEntity::class, $studentDto->id) ?? sendFail("Такого студента не существует");
        try {
            $this->entityManager->remove($student);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            sendFail("Ошибка при удалении студента");
        }
    }

    /**
     * @param array $students
     * @return array
     */
    public function extracted(array $students): array
    {
        $studentDtos = [];
        foreach ($students as $student) {
            $studentDto = new StudentDto();
            $studentDto->id = $student->getId();
            $studentDto->name = $student->getName();
            $studentDto->groupId = $student->getGroup()->getId();
            $studentDtos[] = $studentDto;
        }
        return $studentDtos;
    }
}