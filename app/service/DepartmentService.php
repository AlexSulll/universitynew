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

    public function getDepartmentAll(): ?array
    {
        return $this->departmentRepository->getDepartmentAll();
    }

    public function getDepartmentId(DepartmentDto $departmentDto): ?array
    {
        return $this->departmentRepository->getDepartmentId($departmentDto);
    }

    public function getDepartmentByFacultyId(DepartmentDto $departmentDto): ?array
    {
        return $this->departmentRepository->getDepartmentByFacultyId($departmentDto);
    }

    /**
     * @throws Exception
     */
    public function addDepartment($departmentDto): ?string
    {
        $this->departmentRepository->addDepartment($departmentDto);
        return "Успешное добавление кафедры";
    }


}