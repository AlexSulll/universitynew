<?php

namespace app\service;

use app\dto\FacultyDto;
use Exception;
use PDO;
use app\repository\FacultyRepository;

class FacultyService {

    public PDO $connect;
    public FacultyRepository $facultyRepository;

    public function __construct()
    {
        $this->facultyRepository = new FacultyRepository();
    }

    /**
     * @return array
     */
    public function getFacultyAll(): array
    {
        return $this->facultyRepository->getFacultyAll();
    }

    /**
     * @param FacultyDto $facultyDto
     * @return array|null
     */
    public function getFacultyId(FacultyDto $facultyDto): ?array
    {
        $faculty = $this->facultyRepository->getFacultyId($facultyDto);

        if ($faculty) {
            return $faculty;
        } else {
            return null;
        }
    }

    /**
     * @param FacultyDto $facultyDto
     * @return void
     * @throws Exception
     */
    public function addFaculty(FacultyDto $facultyDto): void
    {
        $this->facultyRepository->addFaculty($facultyDto);
    }

    /**
     * @param FacultyDto $facultyDto
     * @return void
     * @throws Exception
     */
    public function editFaculty(FacultyDto $facultyDto): void
    {
        $this->facultyRepository->editFaculty($facultyDto);
    }

    public function deleteFaculty (FacultyDto $facultyDto) {

    }

}