<?php

namespace app\Entities;

use Couchbase\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: "oasu.faculties")]
class FacultyEntity {
    #[ORM\Id]
    #[ORM\Column(name: "faculty_id", type: Types::INTEGER, nullable: true)]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private int $facultyId;

    #[ORM\Column(name: "name_faculty", type: Types::STRING)]
    private string $facultyName;

    #[ORM\JoinTable(name: "oasu.department")]
    #[ORM\JoinColumn(name: "department_id", referencedColumnName: "departmentId")]
    #[ORM\ManyToMany(targetEntity: DepartmentEntity::class)]
    private $department;

    public function __construct()
    {
        $this->department = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->facultyId;
    }

    public function getName(): ?string
    {
        return $this->facultyName;
    }

    public function setName(?string $newNameFaculty)
    {
        $this->facultyName = $newNameFaculty;
    }

    public function addDepartment()
    {

    }
}