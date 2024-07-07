<?php

namespace app\controllers;

use app\dto\DepartmentDto;
use app\dto\FacultyDto;
use app\service\DepartmentService;
use app\service\FacultyService;
use Exception;

class DepartmentController
{
    public DepartmentService $departmentService;
    public FacultyService $facultyService;

    public function __construct()
    {
        $this->departmentService = new DepartmentService();
        $this->facultyService = new FacultyService();
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
     * @return array|string
     */
    public function getDepartmentId(array $request): array | string
    {
        $departmentDto = new DepartmentDto();

        if (isset($request["departmentId"])) {
            $departmentDto->departmentId = $request["departmentId"];
            $department = $this->departmentService->getDepartmentId($departmentDto);
            if ($department) {
                return $department;
            } else {
                return "Такой кафедры не существует";
            }
        } else {
            return "Ошибка данных";
        }
    }

    /**
     * @param array $request
     * @return array|string
     */
    public function getDepartmentByFacultyId(array $request): array | string
    {
        $departmentDto = new DepartmentDto();

        if (isset($request["facultyId"])) {
            $facultyDto = new FacultyDto();
            $facultyDto->facultyId = $request["facultyId"];
            if ($this->facultyService->getFacultyId($facultyDto)) {
                $departmentDto->facultyId = $request["facultyId"];
                return $this->departmentService->getDepartmentByFacultyId($departmentDto);
            } else {
                return "Такого факультета не существует";
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
    public function addDepartment(array $request): string
    {

        $departmentAll = $this->departmentService->getDepartmentAll();

        $departmentDto = new DepartmentDto();
        $facultyDto = new FacultyDto();

        if (isset($request["departmentName"], $request["facultyId"])) {
            if (preg_match("/^[А-яЁё -]*$/u", $request["departmentName"]) && preg_match("/^[0-9]*$/", $request["facultyId"])) {
                $departmentDto->departmentName = $request["departmentName"];
                $departmentDto->facultyId = $request["facultyId"];
                $facultyDto->facultyId = $request["facultyId"];
                if (!array_search($departmentDto->departmentName, array_column($departmentAll, "departmentName"))) {
                    if ($this->facultyService->getFacultyId($facultyDto)) {
                        $this->departmentService->addDepartment($departmentDto);
                        return "Успешное добавление кафедры";
                    } else {
                        return "Такой факультет не существует";
                    }
                } else {
                    return "Кафедра с таким названием уже существует";
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
    public function editDepartment(array $request): string
    {

        $departmentAll = $this->departmentService->getDepartmentAll();

        $departmentDto = new DepartmentDto();
        $facultyDto = new FacultyDto();

        if (isset($request["departmentId"], $request["newNameDepartment"], $request["newFacultyId"])) {
            if (preg_match("/^[А-яЁё -]*$/u", $request["newNameDepartment"]) && preg_match("/^[0-9]*$/", $request["departmentId"]) && preg_match("/^[0-9]*$/", $request["newFacultyId"])) {
                $departmentDto->departmentId = $request["departmentId"];
                $departmentDto->departmentName = $request["newNameDepartment"];
                $facultyDto->facultyId = $departmentDto->facultyId = $request["newFacultyId"];
                if ($this->departmentService->getDepartmentId($departmentDto)) {
                    if ($this->facultyService->getFacultyId($facultyDto)) {
                        if (!array_search($departmentDto->departmentName, array_column($departmentAll, "departmentName"))) {
                            $this->departmentService->editDepartment($departmentDto);
                            return "Успешное изменение кафедры";
                        } else {
                            return "Кафедра с таким названием уже существует";
                        }
                    } else {
                        return "Такого факультета не существует";
                    }
                } else {
                    return "Такой кафедры не существует";
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
    public function deleteDepartment(array $request): string
    {
        $departmentAll = $this->departmentService->getDepartmentAll();

        $departmentDto = new DepartmentDto();

        if (isset($request["departmentId"])) {
            $departmentDto->departmentId = $request["departmentId"];
            if (array_search($departmentDto->departmentId, array_column($departmentAll, "id"))) {
                $this->departmentService->deleteDepartment($departmentDto);
                return "Успешное удаление кафедры";
            } else {
                return "Такой кафедры не существует";
            }
        } else {
            return "Ошибка данных";
        }
    }
}