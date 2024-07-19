<?php

namespace app\service;

use app\dto\DepartmentDto;
use app\dto\FacultyDto;
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
            $facultyDto = new FacultyDto();
            $facultyDto->id = $faculty->getId();
            $facultyDto->name = $faculty->getName();
            $facultyDtos[] = $facultyDto;
        }
        return $facultyDtos;
    }

    /**
     * @param FacultyDto $facultyDto
     * @return FacultyDto
     */
    public function getFacultyById(FacultyDto $facultyDto): FacultyDto
    {
        $faculty = $this->entityManager->getRepository(FacultyEntity::class)->find($facultyDto->id) ?? sendFail("Такого факультета не существует");

        $facultyDto->id = $faculty->getId();
        $facultyDto->name = $faculty->getName();

        return $facultyDto;
    }

    /**
     * @param FacultyDto $facultyDto
     * @return void
     */
    public function addFaculty(FacultyDto $facultyDto): void
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
            sendFail("Успешное добавление факультета");
        } catch (Exception $exception) {
            sendFail("Ошибка при добавлении факультета");
        }
    }

    /**
     * @param FacultyDto $facultyDto
     * @return void
     * @throws Exception
     */
    public function editFaculty(FacultyDto $facultyDto): void
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
     * @param FacultyDto $facultyDto
     * @return void
     * @throws Exception
     */
    public function deleteFaculty(FacultyDto $facultyDto): void
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