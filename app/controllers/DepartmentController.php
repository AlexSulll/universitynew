<?php

namespace app\controllers;

use app\dto\DepartmentDto;
use app\service\DepartmentService;
use Exception;

class DepartmentController
{
    public DepartmentService $departmentService;

    public function __construct()
    {
        $this->departmentService = new DepartmentService();
    }

    /**
     * @return array
     */
    public function getDepartmentAll(): array
    {
        return $this->departmentService->getDepartmentAll();
    }

    /**
     * @param array $request
     * @return DepartmentDto
     */
    public function getDepartmentById(array $request): DepartmentDto
    {
        $departmentDto = new DepartmentDto();
        $departmentDto->id = $request["departmentId"];
        return $this->departmentService->getDepartmentById($departmentDto);
    }

    /**
     * @param array $request
     * @return array|null
     */
    public function getDepartmentByFacultyId(array $request): ?array
    {
        $departmentDto = new DepartmentDto();
        $departmentDto->facultyId = $request["facultyId"];
        return $this->departmentService->getDepartmentByFacultyId($departmentDto);
    }

    /**
     * @param array $request
     * @return void
     * @throws Exception
     */
    public function addDepartment(array $request): void
    {
        $departmentDto = new DepartmentDto();
        $departmentDto->name = $request["departmentName"];
        $departmentDto->facultyId = $request["facultyId"];
        $this->departmentService->addDepartment($departmentDto);
    }

    /**
     * @param array $request
     * @return void
     * @throws Exception
     */
    public function editDepartment(array $request): void
    {
        $departmentDto = new DepartmentDto();
        $departmentDto->id = $request["departmentId"];
        $departmentDto->name = $request["newNameDepartment"];
        $departmentDto->facultyId = $request["newFacultyId"];
        $this->departmentService->editDepartment($departmentDto);
    }

    /**
     * @param array $request
     * @return void
     * @throws Exception
     */
    public function deleteDepartment(array $request): void
    {
        $departmentDto = new DepartmentDto();
        $departmentDto->id = $request["departmentId"];
        $this->departmentService->deleteDepartment($departmentDto);
    }
}