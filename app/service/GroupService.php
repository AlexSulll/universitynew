<?php

namespace app\service;

use app\dto\GroupDto;
use app\dto\StudentDto;
use app\repository\GroupRepository;
use app\repository\StudentRepository;
use Exception;

class GroupService
{
    public GroupRepository $groupRepository;
    public StudentRepository $studentRepository;
    public StudentService $studentService;

    public function __construct()
    {
        $this->groupRepository = new GroupRepository();
        $this->studentRepository = new StudentRepository();
        $this->studentService = new StudentService();
    }

    /**
     * @return array|null
     */
    public function getGroupAll(): ?array
    {
        return $this->groupRepository->getGroupAll();
    }

    /**
     * @param GroupDto $groupDto
     * @return array|null
     */
    public function getGroupId(GroupDto $groupDto): ?array
    {
        return $this->groupRepository->getGroupId($groupDto->groupId);
    }

    /**
     * @param GroupDto $groupDto
     * @return array|null
     */
    public function getGroupByDepartmentId(GroupDto $groupDto): ?array
    {
        return $this->groupRepository->getGroupByDepartmentId($groupDto->departmentId);
    }

    /**
     * @param GroupDto $groupDto
     * @return void
     * @throws Exception
     */
    public function addGroup(GroupDto $groupDto): void
    {
        $this->groupRepository->addGroup($groupDto);
    }

    /**
     * @param GroupDto $groupDto
     * @return void
     * @throws Exception
     */
    public function editGroup(GroupDto $groupDto): void
    {
        $this->groupRepository->editGroup($groupDto);
    }

    /**
     * @param GroupDto $groupDto
     * @return void
     * @throws Exception
     */
    public function deleteGroup(GroupDto $groupDto): void
    {
        $studentsToDelete = $this->studentRepository->getStudentByGroupId($groupDto->groupId);
        foreach ($studentsToDelete as $student) {
            $studentDto = new StudentDto();
            $studentDto->studentId = $student["id"];
            $this->studentService->deleteStudent($studentDto);
        }
        $this->groupRepository->deleteGroup($groupDto->groupId);
    }
}