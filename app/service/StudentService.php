<?php

namespace app\service;

use app\dto\StudentDto;
use app\repository\StudentRepository;
use Exception;

class StudentService
{
    public StudentRepository $studentRepository;

    public function __construct()
    {
        $this->studentRepository = new StudentRepository();
    }

    /**
     * @return array|null
     */
    public function getStudentsAll(): ?array
    {
        return $this->studentRepository->getStudentsAll();
    }

    /**
     * @param StudentDto $studentDto
     * @return array|null
     */
    public function getStudentId(StudentDto $studentDto): ?array
    {
        return $this->studentRepository->getStudentId($studentDto->studentId);
    }

    /**
     * @param StudentDto $studentDto
     * @return array|null
     */
    public function getStudentByGroupId(StudentDto $studentDto): ?array
    {
        return $this->studentRepository->getStudentByGroupId($studentDto->groupId);
    }

    /**
     * @param StudentDto $studentDto
     * @return void
     * @throws Exception
     */
    public function addStudent(StudentDto $studentDto): void
    {
        $this->studentRepository->addStudent($studentDto);
    }

    /**
     * @param StudentDto $studentDto
     * @return void
     * @throws Exception
     */
    public function editStudent(StudentDto $studentDto): void
    {
        $this->studentRepository->editStudent($studentDto);
    }

    /**
     * @param StudentDto $studentDto
     * @return void
     * @throws Exception
     */
    public function deleteStudent(StudentDto $studentDto): void
    {
        $this->studentRepository->deleteStudent($studentDto->studentId);
    }
}