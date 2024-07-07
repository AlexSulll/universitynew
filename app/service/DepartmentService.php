<?php

namespace app\service;

use app\dto\DepartmentDto;
use app\dto\GroupDto;
use app\repository\DepartmentRepository;
use app\repository\GroupRepository;
use Exception;

class DepartmentService
{
    public DepartmentRepository $departmentRepository;
    public GroupRepository $groupRepository;
    public GroupService $groupService;

    public function __construct()
    {
        $this->departmentRepository = new DepartmentRepository();
        $this->groupRepository = new GroupRepository();
        $this->groupService = new GroupService();
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
        foreach ($groupsToDelete as $group) {
            $groupDto = new GroupDto();
            $groupDto->groupId = $group["id"];
            $this->groupService->deleteGroup($groupDto);
        }

        $this->departmentRepository->deleteDepartment($departmentDto->departmentId);
    }
}