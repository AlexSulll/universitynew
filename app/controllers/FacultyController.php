<?php

namespace app\controllers;

use app\dto\IdNameDto;
use app\service\FacultyService;
use Exception;

class FacultyController
{
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
     * @return IdNameDto
     */
    public function getFacultyById(array $request): IdNameDto
    {
        $facultyDto = new IdNameDto();
        $facultyDto->id = $request["facultyId"];
        return $this->facultyService->getFacultyById($facultyDto);
    }

    /**
     * @param array $request
     * @return void
     */
    public function addFaculty(array $request): void
    {
        $facultyDto = new IdNameDto();
        $facultyDto->name = $request["facultyName"];
        $this->facultyService->addFaculty($facultyDto);
    }

    /**
     * @param array $request
     * @return void
     * @throws Exception
     */
    public function editFaculty(array $request): void
    {
        $facultyDto = new IdNameDto();
        $facultyDto->id = $request["facultyId"];
        $facultyDto->name = $request["newNameFaculty"];
        $this->facultyService->editFaculty($facultyDto);
    }

    /**
     * @param array $request
     * @return void
     * @throws Exception
     */
    public function deleteFaculty(array $request): void
    {
        $facultyDto = new IdNameDto();
        $facultyDto->id = $request["facultyId"];
        $this->facultyService->deleteFaculty($facultyDto);
    }
}