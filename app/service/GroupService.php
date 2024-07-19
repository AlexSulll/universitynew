<?php

namespace app\service;

use app\dto\GroupDto;
use app\dto\StudentDto;
use app\Entities\DepartmentEntity;
use app\Entities\GroupEntity;
use app\Entities\StudentEntity;
use Doctrine\ORM\EntityManager;
use Exception;

class GroupService
{
    public StudentService $studentService;
    public EntityManager $entityManager;

    public function __construct()
    {
        $this->studentService = new StudentService();
        require_once dirname(__DIR__) . "/bootstrap.php";
        $this->entityManager = getEntityManager();
    }

    /**
     * @return array|null
     */
    public function getGroupAll(): ?array
    {
        $groups = $this->entityManager->getRepository(GroupEntity::class)->findAll();
        return $this->extracted($groups);
    }

    /**
     * @param GroupDto $groupDto
     * @return GroupDto
     */
    public function getGroupById(GroupDto $groupDto): GroupDto
    {
        $group = $this->entityManager->getRepository(GroupEntity::class)->find($groupDto->id) ?? sendFail("Такой группы не существует");

        $groupDto->id = $group->getId();
        $groupDto->name = $group->getName();
        $groupDto->departmentId = $group->getDepartment()->getId();

        return $groupDto;
    }

    /**
     * @param GroupDto $groupDto
     * @return array|null
     */
    public function getGroupByDepartmentId(GroupDto $groupDto): ?array
    {
        $this->entityManager->getRepository(DepartmentEntity::class)->find($groupDto->departmentId) ?? sendFail("Такого кафедры не существует");
        $groups = $this->entityManager->getRepository(GroupEntity::class)->findBy(['department' => $groupDto->departmentId]);
        return $this->extracted($groups);
    }

    /**
     * @param GroupDto $groupDto
     * @return void
     * @throws Exception
     */
    public function addGroup(GroupDto $groupDto): void
    {
        $group = $this->entityManager->getRepository(GroupEntity::class)->findOneBy(['name' => $groupDto->name]);

        $department = $this->entityManager->getRepository(DepartmentEntity::class)->find($groupDto->departmentId) ?? sendFail("Такого кафедры не существует");

        if ($group !== null) {
            sendFail("Такая группа уже существует");
        }

        try {
            $newGroup = new GroupEntity;
            $newGroup->setName($groupDto->name);
            $newGroup->setDepartment($department);
            $this->entityManager->persist($newGroup);
            $this->entityManager->flush();
            sendFail("Успешное добавление группы");
        } catch (Exception $exception) {
            sendFail("Ошибка при добавлении группы");
        }
    }

    /**
     * @param GroupDto $groupDto
     * @return void
     * @throws Exception
     */
    public function editGroup(GroupDto $groupDto): void
    {
        $group = $this->entityManager->find(GroupEntity::class, $groupDto->id) ?? sendFail('Такой группы нет');

        $department = $this->entityManager->find(DepartmentEntity::class, $groupDto->departmentId) ?? sendFail("Кафедра не найдена");

        $groupExist = $this->entityManager->getRepository(GroupEntity::class)->findOneBy([
            'name' => $groupDto->name,
            'department' => $groupDto->departmentId
        ]);

        if ($groupExist !== null) {
            sendFail("Такое название уже сущесвтвует");
        }

        try {
            $group->setName($groupDto->name);
            $group->setDepartment($department);

            $this->entityManager->persist($group);
            $this->entityManager->flush();
            sendFail("Успешное изменение группы");
        } catch (Exception $exception) {
            sendFail("Ошибка при редактировании группы");
        }
    }

    /**
     * @param GroupDto $groupDto
     * @return void
     * @throws Exception
     */
    public function deleteGroup(GroupDto $groupDto): void
    {
        $studentsToDelete = $this->entityManager->getRepository(StudentEntity::class)->findBy(['group' => $groupDto->id]);
        foreach ($studentsToDelete as $student) {
            $studentDto = new StudentDto();
            $studentDto->id = $student->getId();
            $this->studentService->deleteStudent($studentDto);
        }
        $group = $this->entityManager->find(GroupEntity::class, $groupDto->id) ?? sendFail("Такой группы не существует");
        try {
            $this->entityManager->remove($group);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            sendFail("Ошибка при удалении группы");
        }
    }

    /**
     * @param array $groups
     * @return array
     */
    public function extracted(array $groups): array
    {
        $groupDtos = [];
        foreach ($groups as $group) {
            $groupDto = new GroupDto();
            $groupDto->id = $group->getId();
            $groupDto->name = $group->getName();
            $groupDto->departmentId = $group->getDepartment()->getId();
            $groupDtos[] = $groupDto;
        }
        return $groupDtos;
    }
}