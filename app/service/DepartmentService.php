<?php

namespace app\service;

use app\dto\DepartmentDto;
use app\dto\GroupDto;
use app\Entities\DepartmentEntity;
use app\Entities\FacultyEntity;
use app\Entities\GroupEntity;
use Doctrine\ORM\EntityManager;
use Exception;

class DepartmentService
{
    public GroupService $groupService;
    public EntityManager $entityManager;

    public function __construct()
    {
        $this->groupService = new GroupService();
        require_once dirname(__DIR__) . "/bootstrap.php";
        $this->entityManager = getEntityManager();
    }

    /**
     * @return array|null
     */
    public function getDepartmentAll(): ?array
    {
        $departments = $this->entityManager->getRepository(DepartmentEntity::class)->findAll();
        return $this->toDepartmentDto($departments);
    }

    /**
     * @param DepartmentDto $departmentDto
     * @return DepartmentDto
     */
    public function getDepartmentById(DepartmentDto $departmentDto): DepartmentDto
    {
        $department = $this->entityManager->getRepository(DepartmentEntity::class)->find($departmentDto->id) ?? sendFail("Такой кафедры не существует");

        $departmentDto->id = $department->getId();
        $departmentDto->name = $department->getName();
        $departmentDto->facultyId = $department->getFaculty()->getId();

        return $departmentDto;
    }

    /**
     * @param DepartmentDto $departmentDto
     * @return array
     */
    public function getDepartmentByFacultyId(DepartmentDto $departmentDto): array
    {
        $this->entityManager->getRepository(FacultyEntity::class)->find($departmentDto->facultyId) ?? sendFail("Такого факультета не существует");
        $departments = $this->entityManager->getRepository(DepartmentEntity::class)->findBy(['faculty' => $departmentDto->facultyId]);
        return $this->toDepartmentDto($departments);
    }

    /**
     * @param DepartmentDto $departmentDto
     * @return void
     * @throws Exception
     */
    public function addDepartment(DepartmentDto $departmentDto): void
    {
        $department = $this->entityManager->getRepository(DepartmentEntity::class)->findOneBy(['name' => $departmentDto->name]);

        $faculty = $this->entityManager->getRepository(FacultyEntity::class)->find($departmentDto->facultyId) ?? sendFail("Такого факультета не существует");

        if ($department !== null) {
            sendFail("Такая кафедра уже существует");
        }

        try {
            $newDepartment = new DepartmentEntity;
            $newDepartment->setName($departmentDto->name);
            $newDepartment->setFaculty($faculty);
            $this->entityManager->persist($newDepartment);
            $this->entityManager->flush();
            sendFail("Успешное добавление кафедры");
        } catch (Exception $exception) {
            sendFail("Ошибка при добавлении кафедры");
        }
    }

    /**
     * @param DepartmentDto $departmentDto
     * @return void
     * @throws Exception
     */
    public function editDepartment(DepartmentDto $departmentDto): void
    {
        $department = $this->entityManager->find(DepartmentEntity::class, $departmentDto->id) ?? sendFail('Такой кафедры нет');

        $faculty = $this->entityManager->find(FacultyEntity::class, $departmentDto->facultyId) ?? sendFail("Факультет не найден");

        $departmentExist = $this->entityManager->getRepository(DepartmentEntity::class)->findOneBy([
            'name' => $departmentDto->name,
            'faculty' => $departmentDto->facultyId
        ]);

        if ($departmentExist !== null) {
            sendFail("Такое название уже сущесвтвует");
        }

        try {
            $department->setName($departmentDto->name);
            $department->setFaculty($faculty);

            $this->entityManager->persist($department);
            $this->entityManager->flush();

        } catch (Exception $exception) {
            sendFail("Ошибка при редактировании кафедры");
        }
    }

    /**
     * @param DepartmentDto $departmentDto
     * @return void
     * @throws Exception
     */
    public function deleteDepartment(DepartmentDto $departmentDto): void
    {
        $groupsToDelete = $this->entityManager->getRepository(GroupEntity::class)->findBy(['department' => $departmentDto->id]);
        foreach ($groupsToDelete as $group) {
            $groupDto = new GroupDto();
            $groupDto->id = $group->getId();
            $this->groupService->deleteGroup($groupDto);
        }
        $department = $this->entityManager->find(DepartmentEntity::class, $departmentDto->id);
        try {
            $this->entityManager->remove($department);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            sendFail("Ошибка при удалении кафедры");
        }
    }

    /**
     * @param array $departments
     * @return DepartmentDto[]
     */
    public function toDepartmentDto(array $departments): array
    {
        $departmentDtos = [];
        foreach ($departments as $department) {
            $departmentDto = new DepartmentDto();
            $departmentDto->id = $department->getId();
            $departmentDto->name = $department->getName();
            $departmentDto->facultyId = $department->getFaculty()->getId();
            $departmentDtos[] = $departmentDto;
        }
        return $departmentDtos;
    }
}