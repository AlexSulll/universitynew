<?php

namespace app\Entities;

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
}