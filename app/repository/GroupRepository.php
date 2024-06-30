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
     * @param int $groupId
     * @return array|null
     */
    public function getGroupId(int $groupId): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $group = $queryBuilder->select("g")
            ->from(GroupEntity::class, "g")
            ->where("g.groupId = " . $groupId);
        return $group->getQuery()->getArrayResult();
    }

    /**
     * @param int $departmentId
     * @return array|null
     */
    public function getGroupByDepartmentId(int $departmentId): ?array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $department = $queryBuilder->select("g")
            ->from(GroupEntity::class, "g")
            ->where("g.departmentId = " . $departmentId);
        return $department->getQuery()->getArrayResult();
    }

    /**
     * @param GroupDto $groupDto
     * @return void
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
     * @param GroupDto $groupDto
     * @return void
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

    /**
     * @param int|array $groupId
     * @return void
     * @throws Exception
     */
    public function deleteGroup(int | array $groupId): void
    {
        if (!is_array($groupId)) {
            try {
                $group = $this->entityManager->find(GroupEntity::class, $groupId);

                $this->entityManager->remove($group);
                $this->entityManager->flush();

            } catch (Exception $exception) {
                throw new Exception("Ошибка при удалении группы");
            }
        } else {
            try {
                foreach ($groupId as $id) {
                    $group = $this->entityManager->find(GroupEntity::class, $id["groupId"]);

                    $this->entityManager->remove($group);
                }
                $this->entityManager->flush();
            } catch (Exception $exception) {
                throw new Exception("Ошибка при удалении групп");
            }
        }
    }
}