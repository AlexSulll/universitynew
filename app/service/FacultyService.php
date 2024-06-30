<?php

namespace app\service;

use app\dto\DepartmentDto;
use app\dto\FacultyDto;
use app\repository\DepartmentRepository;
use Exception;
use app\repository\FacultyRepository;

class FacultyService {

    public FacultyRepository $facultyRepository;
    public DepartmentRepository $departmentRepository;
    public DepartmentService $departmentService;

    public function __construct()
    {
        $this->facultyRepository = new FacultyRepository();
        $this->departmentRepository = new DepartmentRepository();
        $this->departmentService = new DepartmentService();
    }

    /**
     * @return array
     */
    public function getFacultyAll(): array
    {
        return $this->facultyRepository->getFacultyAll();
    }

    /**
     * @param FacultyDto $facultyDto
     * @return array|null
     */
    public function getFacultyId(FacultyDto $facultyDto): ?array
    {
        $faculty = $this->facultyRepository->getFacultyId($facultyDto);

        if ($faculty) {
            return $faculty;
        } else {
            return null;
        }
    }

    /**
     * @param FacultyDto $facultyDto
     * @return void
     * @throws Exception
     */
    public function addFaculty(FacultyDto $facultyDto): void
    {
        $this->facultyRepository->addFaculty($facultyDto);
    }

    /**
     * @param FacultyDto $facultyDto
     * @return void
     * @throws Exception
     */
    public function editFaculty(FacultyDto $facultyDto): void
    {
        $this->facultyRepository->editFaculty($facultyDto);
    }

    /**
     * @param FacultyDto $facultyDto
     * @return void
     * @throws Exception
     */
    public function deleteFaculty(FacultyDto $facultyDto): void
    {
        $departmentsToDelete = $this->departmentRepository->getDepartmentByFacultyId($facultyDto->facultyId);
        foreach ($departmentsToDelete as $department) {
            $departmentDto = new DepartmentDto();
            $departmentDto->departmentId = $department["departmentId"];
            $this->departmentService->deleteDepartment($departmentDto);
        }

        $this->facultyRepository->deleteFaculty($facultyDto->facultyId);

    }
}