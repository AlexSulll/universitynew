<?php

namespace app\service;

use app\dto\DepartmentDto;
use app\repository\DepartmentRepository;
use Exception;

class DepartmentService
{
    public DepartmentRepository $departmentRepository;

    public function __construct()
    {
        $this->departmentRepository = new DepartmentRepository();
    }

    /**
     * @return array|null
     */
    public function getDepartmentAll(): ?array
    {
        return $this->departmentRepository->getDepartmentAll();
    }

    /**
     * @param DepartmentDto $departmentDto
     * @return array|null
     */
    public function getDepartmentId(DepartmentDto $departmentDto): ?array
    {
        return $this->departmentRepository->getDepartmentId($departmentDto);
    }

    /**
     * @param DepartmentDto $departmentDto
     * @return array|null
     */
    public function getDepartmentByFacultyId(DepartmentDto $departmentDto): ?array
    {
        return $this->departmentRepository->getDepartmentByFacultyId($departmentDto);
    }

    /**
     * @param DepartmentDto $departmentDto
     * @return void
     * @throws Exception
     */
    public function addDepartment(DepartmentDto $departmentDto): void
    {
        $this->departmentRepository->addDepartment($departmentDto);
    }

    /**
     * @param DepartmentDto $departmentDto
     * @return void
     * @throws Exception
     */
    public function editDepartment(DepartmentDto $departmentDto): void
    {
        $this->departmentRepository->editDepartment($departmentDto);
    }
}