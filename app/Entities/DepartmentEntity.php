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
    private string $nameDepartment;

    #[ORM\JoinTable(name: "")]
    #[ORM\JoinColumn(name: "", referencedColumnName: "")]
    #[ORM\InverseJoinColumn(name: "", referencedColumnName: "")]
    #[ORM\ManyToMany(targetEntity: FacultyEntity::class)]
    private Collection $departments;
    public function __construct()
    {
        $this->departments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameDepartment(): ?string
    {
        return $this->nameDepartment;
    }

    public function setNameDepartment(?string $newNameDepartment): void
    {
        $this->nameDepartment = $newNameDepartment;
    }

    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function setDepartments(DepartmentEntity $departments): void
    {
        $this->departments->add($departments);
    }
}