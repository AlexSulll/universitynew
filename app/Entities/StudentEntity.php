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
    private int $studentId;

    #[ORM\Column(name: "name_of_student", type: Types::STRING)]
    private string $studentName;

    #[ORM\ManyToOne(targetEntity: GroupEntity::class, inversedBy: "students")]
    #[ORM\JoinColumn(name: "group_id")]
    #[ORM\Column(name: "id_of_group", type: Types::INTEGER)]
    private int $groupId;

    public function getId(): ?int
    {
        return $this->studentId;
    }

    public function getName(): ?string
    {
        return $this->studentName;
    }

    public function setName(?string $newStudentName): void
    {
        $this->studentName = $newStudentName;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function setGroupId(?int $newGroupId): void
    {
        $this->groupId = $newGroupId;
    }

}