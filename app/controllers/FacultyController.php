<?php

namespace app\controllers;

use app\dto\FacultyDto;
use app\repository\FacultyRepository;
use app\service\FacultyService;
use Doctrine\ORM\EntityManager;

class FacultyController {
    public FacultyService $facultyService;

    public function __construct()
    {
        $this->facultyService = new FacultyService();
    }

//    /**
//     * @return array
//     */
    public function getFacultyAll()
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
        }

        $faculty = $this->facultyService->getFacultyId($facultyDto);

        if ($faculty) {
            return $faculty;
        } else {
            return "Такого факультета не существует";
        }
    }

    /**
     * @param array $request
     * @return string|void
     */
    public function addFaculty(array $request) {

        $facultiesAll = $this->getFacultyAll();

        $facultyDto = new FacultyDto();

        if (isset($request["facultyName"])) {
            $facultyDto->facultyName = $request["facultyName"];
            if (!array_search($facultyDto->facultyName, array_column($facultiesAll, "name_faculty"))) {
                if (preg_match("/^[А-яЁё -]*$/u", $facultyDto->facultyName)) {
                    return $this->facultyService->addFaculty($facultyDto);
                } else {
                    return "Ошибка при проверке данных";
                }
            } else {
                return "Факультет с таким названием уже существует";
            }
        }
    }

    /**
     * @param array $request
     * @return string
     */
    public function editFaculty (array $request): string
    {

        $facultyDto = new FacultyDto();

        if (isset($request["facultyId"], $request["newNameFaculty"])) {
            $facultyDto->facultyId = $request["facultyId"];
            $facultyDto->facultyName = $request["newNameFaculty"];

            return $this->facultyService->editFaculty($facultyDto);
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