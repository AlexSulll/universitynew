<?php

namespace app\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "oasu.group")]
class GroupEntity {

    #[ORM\Id]
    #[ORM\Column(name: "group_id", type: Types::INTEGER, nullable: true)]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[ORM\Column(name: "name_of_group", type: Types::STRING)]
    private string $groupName;

    #[ORM\ManyToOne(targetEntity: DepartmentEntity::class, inversedBy: "groups")]
    #[ORM\JoinColumn(name: "id_of_department", referencedColumnName: "department_id")]
    private DepartmentEntity $department;

    #[ORM\OneToMany(mappedBy: "group", targetEntity: StudentEntity::class)]
    private Collection $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->groupName;
    }

    public function setName(?string $newGroupName): void
    {
        $this->groupName = $newGroupName;
    }

    public function getDepartment(): DepartmentEntity
    {
        return $this->department;
    }

    public function setDepartment(DepartmentEntity $newDepartment): void
    {
        $newDepartment->addGroup($this);
        $this->department = $newDepartment;
    }

    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudents(StudentEntity $student): void
    {
        $this->students[] = $student;
    }
}