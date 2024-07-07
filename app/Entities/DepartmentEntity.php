<?php

namespace app\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "oasu.department")]
class DepartmentEntity {

    #[ORM\Id]
    #[ORM\Column(name: "department_id", type: Types::INTEGER, nullable: true)]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[ORM\Column(name: "name_of_department", type: Types::STRING)]
    private string $departmentName;

    #[ORM\ManyToOne(targetEntity: FacultyEntity::class, inversedBy: "departments")]
    #[ORM\JoinColumn(name: "id_of_faculties", referencedColumnName: "faculty_id")]
    private FacultyEntity $faculty;

    #[ORM\OneToMany(mappedBy: "department", targetEntity: GroupEntity::class)]
    private Collection $groups;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->departmentName;
    }

    public function setName(?string $newDepartmentName): void
    {
        $this->departmentName = $newDepartmentName;
    }

    public function getFaculty(): FacultyEntity
    {
        return $this->faculty;
    }

    public function setFaculty(FacultyEntity $newFaculty): void
    {
        $newFaculty->addDepartment($this);
        $this->faculty = $newFaculty;
    }

    public function getGroup(): Collection
    {
        return $this->groups;
    }

    public function addGroup(GroupEntity $group): void
    {
        $this->groups[] = $group;
    }
}