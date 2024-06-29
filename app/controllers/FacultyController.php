<?php

namespace app\controllers;

use app\dto\FacultyDto;
use app\service\FacultyService;
use Exception;

class FacultyController {
    public FacultyService $facultyService;

    public function __construct()
    {
        $this->facultyService = new FacultyService();
    }

    /**
     * @return array
     */
    public function getFacultyAll(): array
    {
        return $this->facultyService->getFacultyAll();
    }

    /**
     * @param array $request
     * @return array|string
     */
    public function getFacultyId(array $request): array | string
    {

        $facultyDto = new FacultyDto();

        if (isset($request["facultyId"])) {
            $facultyDto->facultyId = $request["facultyId"];
            $faculty = $this->facultyService->getFacultyId($facultyDto);
            if ($faculty) {
                return $faculty;
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
    public function addFaculty(array $request): string
    {

        $facultiesAll = $this->facultyService->getFacultyAll();

        $facultyDto = new FacultyDto();

        if (isset($request["facultyName"])) {
            if (preg_match("/^[А-яЁё -]*$/u", $request["facultyName"])) {
                $facultyDto->facultyName = $request["facultyName"];
                if (!array_search($facultyDto->facultyName, array_column($facultiesAll, "facultyName"))) {
                    $this->facultyService->addFaculty($facultyDto);
                    return "Успешное добавление факультета";
                } else {
                    return "Факультет с таким названием уже существует";
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
    public function editFaculty(array $request): string
    {

        $faculties = $this->facultyService->getFacultyAll();

        $facultyDto = new FacultyDto();

        if (isset($request["facultyId"], $request["newNameFaculty"])) {
            if (preg_match("/^[А-яЁё -]*$/u", $request["newNameFaculty"]) && preg_match("/^[0-9]*$/", $request["facultyId"])) {
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
                return "Ошибка при проверке данных";
            }
        } else {
            return "Ошибка данных";
        }
    }

    public function deleteFaculty(array $request) {

    }
}