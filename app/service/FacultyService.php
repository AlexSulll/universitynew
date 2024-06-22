<?php

namespace app\service;

use app\dto\FacultyDto;
use app\Entities\FacultyEntity;
use app\thesaurus\DataBase;
use Doctrine\ORM\EntityManager;
use PDO;
use app\repository\FacultyRepository;
use Doctrine\ORM\EntityRepository;

class FacultyService {

    public PDO $connect;
    public EntityManager $entityManager;
    public EntityRepository $facultyRepository;

    public function __construct()
    {
        require_once __DIR__ . "/../bootstrap.php";
        $this->entityManager = getEntityManager();
        $this->facultyRepository = $this->entityManager->getRepository(FacultyEntity::class);
    }
//    public function __construct()
//    {
//        $conn = new DataBase();
//        $this->connect = $conn->pdo;
//    }

//    /**
//     * @return array
//     */
//    public function getFacultyAll(): array
//    {
//
//        $sql = file_get_contents(dirname(__DIR__) . "/sql/faculty/getFaculty.sql");
//
//        $getFaculties = $this->connect->query($sql);
//        return $getFaculties->fetchAll(PDO::FETCH_ASSOC);
//
//    }

    public function getFacultyAll()
    {
        return $this->facultyRepository->findByFacultyAll();
//        $repository = $this->entityManager->getRepository(FacultyEntity::class)->findAll();
//        $result = [];
//        foreach ($repository as $faculty) {
//            $facultyDto = new FacultyDto();
//            $facultyDto->facultyId = $faculty->getId();
//            $facultyDto->facultyName = $faculty->getName();
//            $result[] = $facultyDto;
//        }
//
//        return $result;
    }

    /**
     * @param FacultyDto $facultyDto
     * @return array|null
     */
    public function getFacultyId(FacultyDto $facultyDto): ?array
    {
        $sql = file_get_contents(dirname(__DIR__) . "/sql/faculty/getFacultyId.sql");

        $getFaculty = $this->connect->prepare($sql);
        $getFaculty->execute([$facultyDto->facultyId]);
        $faculties = $getFaculty->fetch(PDO::FETCH_ASSOC);

        if ($faculties) {
            return $faculties;
        } else {
            return null;
        }
    }

    /**
     * @param FacultyDto $facultyDto
     * @return string
     */
    public function addFaculty (FacultyDto $facultyDto): string
    {
        $sql = file_get_contents(dirname(__DIR__) . "/sql/faculty/addFaculty.sql");

        $addFaculty = $this->connect->prepare($sql);
        $addFaculty->execute([
           "facultyName" => $facultyDto->facultyName
        ]);
        return "Успешное добавление факультета";
    }

    /**
     * @param FacultyDto $facultyDto
     * @return string
     */
    public function editFaculty (FacultyDto $facultyDto): string
    {
        $getFaculty = $this->getFacultyId($facultyDto);
        $faculties = $this->getFacultyAll();

        if ($getFaculty) {
            if (!array_search($facultyDto->facultyName, array_column($faculties, "name_faculty"))) {
                $sql = file_get_contents(dirname(__DIR__) . "/sql/faculty/editFaculty.sql");
                $editFaculty = $this->connect->prepare($sql);
                $editFaculty->execute([
                   "newNameFaculty" => $facultyDto->facultyName,
                   "facultyId" => $facultyDto->facultyId
                ]);

                return "Успешное изменение факультета";
            } else {
                return "Факультет с таким названием уже существует";
            }
        } else {
            return "Такого факультета не существует";
        }
    }

    public function deleteFaculty (FacultyDto $facultyDto) {

    }

}