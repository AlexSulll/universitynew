<?php

namespace app\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "oasu.students")]
class StudentEntity {
    #[ORM\Id]
    #[ORM\Column(name: "student_id", type: Types::INTEGER, nullable: true)]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[ORM\Column(name: "name_of_student", type: Types::STRING)]
    private string $studentName;

    #[ORM\ManyToOne(targetEntity: DepartmentEntity::class, inversedBy: "students")]
    #[ORM\JoinColumn(name: "id_of_group", referencedColumnName: "group_id")]
    private GroupEntity $group;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->studentName;
    }

    public function setName(?string $newStudentName): void
    {
        $this->studentName = $newStudentName;
    }

    public function getGroup(): GroupEntity
    {
        return $this->group;
    }

    public function setGroup(GroupEntity $newGroup): void
    {
        $newGroup->addStudents($this);
        $this->group = $newGroup;
    }

}