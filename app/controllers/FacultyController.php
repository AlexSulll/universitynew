<?php

namespace app\controllers;

use app\dto\FacultyDto;
use app\service\FacultyService;

class FacultyController {
    public FacultyService $facultyService;

    public function __construct()
    {
        $this->facultyService = new FacultyService();
    }

    public function getFacultyAll(): array
    {
        return $this->facultyService->getFacultyAll();
    }

    public function getFacultyId(array $request): array | string
    {

        $facultyDto = new FacultyDto();

        if (isset($request["facultyId"])) {
            $facultyDto->facultyId = $request["facultyId"];
        }

        $faculty = $this->facultyService->getFacultyId($facultyDto);

        if ($faculty) {
            return $faculty;
        } else {
            return "Такого факультета не существует";
        }
    }

    public function addFaculty(array $request) {

        $facultiesAll = $this->facultyService->getFacultyAll();

        $facultyDto = new FacultyDto();

        if (isset($request["facultyName"])) {
            $facultyDto->facultyName = $request["facultyName"];
            if (!array_search($facultyDto->facultyName, array_column($facultiesAll, "facultyName"))) {
                if (preg_match("/^[А-яЁё -]*$/u", $facultyDto->facultyName)) {
                    return $this->facultyService->addFaculty($facultyDto);
                } else {
                    return "Ошибка при проверке данных";
                }
            } else {
                return "Факультет с таким названием уже существует";
            }
        } else {
            return null;
        }
    }

    public function editFaculty(array $request): string
    {

        $faculties = $this->facultyService->getFacultyAll();

        $facultyDto = new FacultyDto();

        if (isset($request["facultyId"], $request["newNameFaculty"])) {
            $facultyDto->facultyName = $request["newNameFaculty"];
            $facultyDto->facultyId = $request["facultyId"];
            $getFaculty = $this->facultyService->getFacultyId($facultyDto);
            if ($getFaculty) {
                if (!array_search($request["newNameFaculty"], array_column($faculties, "facultyName"))) {

                    $this->facultyService->editFaculty($facultyDto);

                    return "Успешное изменение факультета";
                } else {
                    return "Факультет с таким названием уже существует";
                }
            } else {
                return "Такого факультета не существует";
            }
        } else {
            return "Ошибка данных";
        }
    }

//    public function deleteFaculty (array $request) {
//        $facultyDto = new FacultyDto();
//        $facultyDto->facultyId = $request["facultyId"];
//
//        return $this->facultyService->deleteFaculty($facultyDto);
//    }
}