<?php

namespace app\service;

use app\dto\FacultyDto;
use PDO;
use app\repository\FacultyRepository;

class FacultyService {

    public PDO $connect;
    public FacultyRepository $facultyRepository;

    public function __construct()
    {
        $this->facultyRepository = new FacultyRepository();
    }

    public function getFacultyAll(): array
    {
        return $this->facultyRepository->getFacultyAll();
    }

    public function getFacultyId(FacultyDto $facultyDto): ?array
    {
        $faculty = $this->facultyRepository->getFacultyId($facultyDto->facultyId);

        if ($faculty) {
            return $faculty;
        } else {
            return null;
        }
    }

    public function addFaculty(FacultyDto $facultyDto): string
    {
        $this->facultyRepository->addFaculty($facultyDto->facultyName);
        return "Успешное добавление факультета";
    }

    public function editFaculty(FacultyDto $facultyDto)
    {
        $this->facultyRepository->editFaculty($facultyDto);
    }

    public function deleteFaculty (FacultyDto $facultyDto) {

    }

}