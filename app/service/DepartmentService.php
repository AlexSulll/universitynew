<?php

namespace app\service;

use app\dto\DepartmentDto;
use app\repository\DepartmentRepository;
use app\repository\GroupRepository;
use Exception;

class DepartmentService
{
    public DepartmentRepository $departmentRepository;
    public GroupRepository $groupRepository;

    public function __construct()
    {
        $this->departmentRepository = new DepartmentRepository();
        $this->groupRepository = new GroupRepository();
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
        return $this->departmentRepository->getDepartmentId($departmentDto->departmentId);
    }

    /**
     * @param DepartmentDto $departmentDto
     * @return array|null
     */
    public function getDepartmentByFacultyId(DepartmentDto $departmentDto): ?array
    {
        return $this->departmentRepository->getDepartmentByFacultyId($departmentDto->facultyId);
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

    /**
     * @param DepartmentDto $departmentDto
     * @return void
     * @throws Exception
     */
    public function deleteDepartment(DepartmentDto $departmentDto): void
    {
        $groupsToDelete = $this->groupRepository->getGroupByDepartmentId($departmentDto->departmentId);
        $this->groupRepository->deleteGroup($groupsToDelete);

        $this->departmentRepository->deleteDepartment($departmentDto->departmentId);
    }
}