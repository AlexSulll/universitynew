<?php

namespace app\controllers;

use app\dto\StudentDto;
use app\service\StudentService;
use Exception;

class StudentController
{
    public StudentService $studentService;

    public function __construct()
    {
        $this->studentService = new StudentService();
    }

    /**
     * @return array|null
     */
    public function getStudentsAll(): ?array
    {
        return $this->studentService->getStudentsAll();
    }

    /**
     * @param array $request
     * @return StudentDto
     */
    public function getStudentById(array $request): StudentDto
    {
        $studentDto = new StudentDto();
        $studentDto->id = $request["studentId"];
        return $this->studentService->getStudentById($studentDto);
    }

    /**
     * @param array $request
     * @return array|string
     */
    public function getStudentByGroupId(array $request): array | string
    {
        $studentDto = new StudentDto();
        $studentDto->groupId = $request["groupId"];
        return $this->studentService->getStudentByGroupId($studentDto);
    }

    /**
     * @param array $request
     * @return void
     * @throws Exception
     */
    public function addStudent(array $request): void
    {
        $studentDto = new StudentDto();
        $studentDto->name = $request["studentName"];
        $studentDto->groupId = $request["groupId"];
        $this->studentService->addStudent($studentDto);
    }

    /**
     * @param array $request
     * @return void
     * @throws Exception
     */
    public function editStudent(array $request): void
    {
        $studentDto = new StudentDto();
        $studentDto->id = $request["studentId"];
        $studentDto->name = $request["newNameStudent"];
        $studentDto->groupId = $request["newGroupId"];
        $this->studentService->editStudent($studentDto);
    }

    /**
     * @param array $request
     * @return void
     * @throws Exception
     */
    public function deleteStudent(array $request): void
    {
        $studentDto = new StudentDto();
        $studentDto->id = $request["studentId"];
        $this->studentService->deleteStudent($studentDto);
    }
}