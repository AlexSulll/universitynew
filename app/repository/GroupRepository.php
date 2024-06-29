<?php

namespace app\repository;

use app\dto\GroupDto;
use app\Entities\GroupEntity;
use Doctrine\ORM\EntityManager;
use Exception;

class GroupRepository
{
    public EntityManager $entityManager;

    public function __construct()
    {
        require_once dirname(__DIR__) . "/bootstrap.php";
        $this->entityManager = getEntityManager();
    }

    /**
     * @return array|null
     */
    public function getGroupAll(): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $groups = $queryBuilder->select("g")
            ->from(GroupEntity::class, "g");
        return $groups->getQuery()->getArrayResult();
    }

    /**
     * @param GroupDto $groupDto
     * @return array|null
     */
    public function getGroupId(GroupDto $groupDto): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $group = $queryBuilder->select("g")
            ->from(GroupEntity::class, "g")
            ->where("g.groupId = " . $groupDto->groupId);
        return $group->getQuery()->getArrayResult();
    }

    /**
     * @param GroupDto $groupDto
     * @return array|null
     */
    public function getGroupByDepartmentId(GroupDto $groupDto): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $department = $queryBuilder->select("g")
            ->from(GroupEntity::class, "g")
            ->where("g.departmentId = " . $groupDto->departmentId);
        return $department->getQuery()->getArrayResult();
    }

    /**
     * @throws Exception
     */
    public function addGroup(GroupDto $groupDto): void
    {
        $newGroup = new GroupEntity;

        try {
            $newGroup->setName($groupDto->groupName);
            $newGroup->setDepartmentId($groupDto->departmentId);
            $this->entityManager->persist($newGroup);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            throw new Exception("Ошибка при добавлении группы");
        }
    }

    /**
     * @throws Exception
     */
    public function editGroup(GroupDto $groupDto): void
    {
        try {
            $group = $this->entityManager->find(GroupEntity::class, $groupDto->groupId);
            $group->setName($groupDto->groupName);
            $group->setDepartmentId($groupDto->departmentId);

            $this->entityManager->persist($group);
            $this->entityManager->flush();

        } catch (Exception $exception) {
            throw new Exception("Ошибка при редактировании группы");
        }
    }
}