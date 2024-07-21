<?php

namespace app\service;

use app\dto\DepartmentDto;
use app\dto\IdNameDto;
use app\Entities\DepartmentEntity;
use app\Entities\FacultyEntity;
use Doctrine\ORM\EntityManager;
use Exception;

class FacultyService
{
    public DepartmentService $departmentService;
    public EntityManager $entityManager;

    public function __construct()
    {
        $this->departmentService = new DepartmentService();
        require_once dirname(__DIR__) . "/bootstrap.php";
        $this->entityManager = getEntityManager();
    }

    /**
     * @return array
     */
    public function getFacultyAll(): array
    {
        $faculties = $this->entityManager->getRepository(FacultyEntity::class)->findAll();
        $facultyDtos = [];
        foreach ($faculties as $faculty) {
            $facultyDto = new IdNameDto();
            $facultyDto->id = $faculty->getId();
            $facultyDto->name = $faculty->getName();
            $facultyDtos[] = $facultyDto;
        }
        return $facultyDtos;
    }

    /**
     * @param IdNameDto $facultyDto
     * @return IdNameDto
     */
    public function getFacultyById(IdNameDto $facultyDto): IdNameDto
    {
        $faculty = $this->entityManager->getRepository(FacultyEntity::class)->find($facultyDto->id) ?? sendFail("Такого факультета не существует");

        $facultyDto->id = $faculty->getId();
        $facultyDto->name = $faculty->getName();

        return $facultyDto;
    }

    /**
     * @param IdNameDto $facultyDto
     * @return void
     */
    public function addFaculty(IdNameDto $facultyDto): void
    {
        $faculty = $this->entityManager->getRepository(FacultyEntity::class)->findOneBy(['name' => $facultyDto->name]);

        if ($faculty !== null) {
            sendFail("Такой факультет уже существует");
        }

        try {
            $newFaculty = new FacultyEntity;
            $newFaculty->setName($facultyDto->name);
            $this->entityManager->persist($newFaculty);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            sendFail("Ошибка при добавлении факультета");
        }
    }

    /**
     * @param IdNameDto $facultyDto
     * @return void
     * @throws Exception
     */
    public function editFaculty(IdNameDto $facultyDto): void
    {
        $faculty = $this->entityManager->find(FacultyEntity::class, $facultyDto->id) ?? sendFail("Такого факультета не существует");
        $facultyExist = $this->entityManager->getRepository(FacultyEntity::class)->findOneBy(['name' => $facultyDto->name]);

        if ($facultyExist !== null) {
            sendFail("Факультет с таким названием уже существует");
        }

        try {
            $faculty->setName($facultyDto->name);

            $this->entityManager->persist($faculty);
            $this->entityManager->flush();
            sendFail("Успешное изменение факультета");
        } catch (Exception $exception) {
            sendFail("Ошибка при редактировании факультета");
        }
    }

    /**
     * @param IdNameDto $facultyDto
     * @return void
     * @throws Exception
     */
    public function deleteFaculty(IdNameDto $facultyDto): void
    {
        $departmentsToDelete = $this->entityManager->getRepository(DepartmentEntity::class)->findBy(['faculty' => $facultyDto->id]);
        foreach ($departmentsToDelete as $department) {
            $departmentDto = new DepartmentDto();
            $departmentDto->id = $department->getId();
            $this->departmentService->deleteDepartment($departmentDto);
        }
        $faculty = $this->entityManager->find(FacultyEntity::class, $facultyDto->id);
        try {
            $this->entityManager->remove($faculty);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            sendFail("Ошибка при удалении факультета");
        }
    }
}