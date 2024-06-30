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
    private int $groupId;

    #[ORM\Column(name: "name_of_group", type: Types::STRING)]
    private string $groupName;

    #[ORM\ManyToOne(targetEntity: DepartmentEntity::class, inversedBy: "groups")]
    #[ORM\JoinColumn(name: "department_id")]
    #[ORM\Column(name: "id_of_department", type: Types::INTEGER)]
    private int $departmentId;

    #[ORM\OneToMany(mappedBy: "groupId", targetEntity: StudentEntity::class)]
    #[ORM\JoinColumn(name: "student_id")]
    private Collection $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->groupId;
    }

    public function getName(): ?string
    {
        return $this->groupName;
    }

    public function setName(?string $newGroupName): void
    {
        $this->groupName = $newGroupName;
    }

    public function getDepartmentId(): ?int
    {
        return $this->departmentId;
    }

    public function setDepartmentId(?int $newDepartmentId): void
    {
        $this->departmentId = $newDepartmentId;
    }

    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function setStudents(StudentEntity $student): void
    {
        $this->students->add($student);
    }
}