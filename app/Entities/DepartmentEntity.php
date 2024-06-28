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
    private int $departmentId;

    #[ORM\Column(name: "name_of_department", type: Types::STRING)]
    private string $nameDepartment;
    #[ORM\ManyToOne(targetEntity: FacultyEntity::class)]
    private $faculty;
    public function getId(): ?int
    {
        return $this->departmentId;
    }

    public function getNameDepartment(): ?string
    {
        return $this->nameDepartment;
    }

    public function setNameDepartment(?string $newNameDepartment): void
    {
        $this->nameDepartment = $newNameDepartment;
    }

}