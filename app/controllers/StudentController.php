<?php

namespace app\controllers;

use app\dto\DepartmentDto;
use app\dto\GroupDto;
use app\dto\StudentDto;
use app\service\GroupService;
use app\service\StudentService;
use Exception;

class StudentController
{
    public StudentService $studentService;
    public GroupService $groupService;

    public function __construct()
    {
        $this->studentService = new StudentService();
        $this->groupService = new GroupService();
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
     * @return array|string
     */
    public function getStudentId(array $request): array | string
    {
        $studentDto = new StudentDto();

        if (isset($request["studentId"])) {
            $studentDto->studentId = $request["studentId"];
            $student = $this->studentService->getStudentId($studentDto);
            if ($student) {
                return $student;
            } else {
                return "Такого студента не существует";
            }
        } else {
            return "Ошибка данных";
        }
    }

    /**
     * @param array $request
     * @return array|string
     */
    public function getStudentByGroupId(array $request): array | string
    {
        $studentDto = new StudentDto();

        if (isset($request["groupId"])) {
            $groupDto = new GroupDto();
            $groupDto->groupId = $request["groupId"];
            $group = $this->groupService->getGroupId($groupDto);
            if ($group) {
                $studentDto->groupId = $request["groupId"];
                return $this->studentService->getStudentByGroupId($studentDto);
            } else {
                return "Такой группы не существует";
            }
        } else {
            return "Ошибка данных";
        }
    }

    /**
     * @param array $request
     * @return string
     * @throws Exception
     */
    public function addStudent(array $request): string
    {
        $studentAll = $this->studentService->getStudentsAll();

        $studentDto = new StudentDto();
        $groupDto = new GroupDto();

        if (isset($request["studentName"], $request["groupId"])) {
            if (preg_match("/^[А-яЁё -]*$/u", $request["studentName"]) && preg_match("/^[0-9]*$/", $request["groupId"])) {
                $studentDto->studentName = $request["studentName"];
                $studentDto->groupId = $request["groupId"];
                $groupDto->groupId = $request["groupId"];
                if (!array_search($studentDto->studentName, array_column($studentAll, "studentName"))) {
                    if ($this->groupService->getGroupId($groupDto)) {
                        $this->studentService->addStudent($studentDto);
                        return "Успешное добавление студента";
                    } else {
                        return "Такой группы не существует";
                    }
                } else {
                    return "Студент с таким ФИО уже существует";
                }
            } else {
                return "Ошибка при проверке данных";
            }
        } else {
            return "Ошибка данных";
        }
    }

    /**
     * @param array $request
     * @return string
     * @throws Exception
     */
    public function editStudent(array $request): string
    {
        $studentAll = $this->studentService->getStudentsAll();

        $studentDto = new StudentDto();
        $groupDto = new GroupDto();

        if (isset($request["studentId"], $request["newNameStudent"], $request["newGroupId"])) {
            if (preg_match("/^[А-яЁё0-9 -]*$/u", $request["newNameStudent"]) && preg_match("/^[0-9]*$/", $request["studentId"]) && preg_match("/^[0-9]*$/", $request["newGroupId"])) {
                $studentDto->studentId = $request["studentId"];
                $studentDto->studentName = $request["newNameStudent"];
                $studentDto->groupId = $groupDto->groupId = $request["newGroupId"];
                if ($this->studentService->getStudentId($studentDto)) {
                    if ($this->groupService->getGroupId($groupDto)) {
                        if (!array_search($studentDto->studentName, array_column($studentAll, "studentName"))) {
                            $this->studentService->editStudent($studentDto);
                            return "Успешное изменение данных студента";
                        } else {
                            return "Студент с таким ФИО уже существует";
                        }
                    } else {
                        return "Такой группы не существует";
                    }
                } else {
                    return "Такого студента не существует";
                }
            } else {
                return "Ошибка при проверке данных";
            }
        } else {
            return "Ошибка данных";
        }
    }

    /**
     * @param array $request
     * @return string
     * @throws Exception
     */
    public function deleteStudent(array $request): string
    {
        $studentAll = $this->studentService->getStudentsAll();

        $studentDto = new StudentDto();

        if (isset($request["studentId"])) {
            $studentDto->studentId = $request["studentId"];
            if (array_search($studentDto->studentId, array_column($studentAll, "studentId"))) {
                $this->studentService->deleteStudent($studentDto);
                return "Успешное удаление студента";
            } else {
                return "Такого студента не существует";
            }
        } else {
            return "Ошибка данных";
        }
    }
}