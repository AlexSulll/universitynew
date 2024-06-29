<?php

namespace app\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "oasu.department")]
class DepartmentEntity {
    #[ORM\Id]
    #[ORM\Column(name: "department_id", type: Types::INTEGER, nullable: true)]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private int $departmentId;

    #[ORM\Column(name: "name_of_department", type: Types::STRING)]
    private string $departmentName;

    #[ORM\Column(name: "id_of_faculties", type: Types::INTEGER)]
    private int $facultyId;

    public function getId(): ?int
    {
        return $this->departmentId;
    }

    public function getName(): ?string
    {
        return $this->departmentName;
    }

    public function setName(?string $newDepartmentName): void
    {
        $this->departmentName = $newDepartmentName;
    }

    public function getFacultyId(): ?int
    {
        return $this->facultyId;
    }

    public function setFacultyId(?int $newFacultyId): void
    {
        $this->facultyId = $newFacultyId;
    }
}