<?php

namespace app\Entities;

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

    #[ORM\Column(name: "id_of_department", type: Types::INTEGER)]
    private int $departmentId;

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
}