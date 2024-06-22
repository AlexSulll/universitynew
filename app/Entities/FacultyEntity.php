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
    private int $id;

    #[ORM\Column(name: "name_faculty", type: Types::STRING)]
    private string $nameFaculty;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->nameFaculty;
    }

    public function setName(?string $newNameFaculty): void
    {
        $this->nameFaculty = $newNameFaculty;
    }
}