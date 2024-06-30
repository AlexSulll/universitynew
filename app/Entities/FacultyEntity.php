<?php

namespace app\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: "FacultyEntity", targetEntity: DepartmentEntity::class)]
    #[ORM\JoinColumn(name: "departmentId")]
    private Collection $departments;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->facultyId;
    }

    public function getName(): ?string
    {
        return $this->facultyName;
    }

    public function setName(?string $newNameFaculty): void
    {
        $this->facultyName = $newNameFaculty;
    }

    public function getDepartment(): Collection
    {
        return $this->departments;
    }

    public function setDepartment(DepartmentEntity $department): void
    {
        $this->departments->add($department);
    }
}