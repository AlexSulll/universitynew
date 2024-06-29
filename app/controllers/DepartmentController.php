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

    public function getDepartmentByFacultyId(array $request): array | string
    {
        $departmentDto = new DepartmentDto();

        if (isset($request["facultyId"])) {
            $facultyDto = new FacultyDto();
            $facultyDto->facultyId = $request["facultyId"];
            $faculty = $this->facultyService->getFacultyId($facultyDto);
            if ($faculty) {
                $departmentDto->facultyId = $request["facultyId"];
                return $this->departmentService->getDepartmentByFacultyId($departmentDto);
            } else {
                return "Такого факультета не существует";
            }
        } else {
            return "Кафедр с таким факультетом не существует";
        }
    }

    /**
     * @param array $request
     * @return string|null
     * @throws Exception
     */
    public function addDepartment(array $request): ?string
    {

        $departmentAll = $this->departmentService->getDepartmentAll();

        $departmentDto = new DepartmentDto();
        $facultyDto = new FacultyDto();

        if (isset($request["departmentName"], $request["facultyId"])) {
            $departmentDto->departmentName = $request["departmentName"];
            $departmentDto->facultyId = $request["facultyId"];
            $facultyDto->facultyId = $request["facultyId"];
            if (preg_match("/^[А-яЁё -]*$/u", $departmentDto->departmentName) && preg_match("/^[0-9]*$/", $departmentDto->facultyId)) {
                if (!array_search($departmentDto->departmentName, array_column($departmentAll, "departmentName"))) {
                    if ($this->facultyService->getFacultyId($facultyDto)) {
                        return $this->departmentService->addDepartment($departmentDto);
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

    public function editDepartment(array $request)
    {

//        $faculties = $this->facultyService->getFacultyAll();
//
//        $facultyDto = new FacultyDto();
//
//        if (isset($request["facultyId"], $request["newNameFaculty"])) {
//            $facultyDto->facultyName = $request["newNameFaculty"];
//            $facultyDto->facultyId = $request["facultyId"];
//            $getFaculty = $this->facultyService->getFacultyId($facultyDto);
//            if ($getFaculty) {
//                if (!array_search($request["newNameFaculty"], array_column($faculties, "facultyName"))) {
//
//                    return $this->facultyService->editFaculty($facultyDto);
//
//                } else {
//                    return "Факультет с таким названием уже существует";
//                }
//            } else {
//                return "Такого факультета не существует";
//            }
//        } else {
//            return "Ошибка данных";
//        }
    }

    public function deleteDepartment(array $request) {

    }
}