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
    private int $id;

    #[ORM\Column(name: "name_faculty", type: Types::STRING)]
    private string $name;

    #[ORM\OneToMany(mappedBy: "faculty", targetEntity: DepartmentEntity::class)]
    private Collection $departments;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $newName): void
    {
        $this->name = $newName;
    }

    public function getDepartment(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(DepartmentEntity $department): void
    {
        $this->departments[] = $department;
    }
}