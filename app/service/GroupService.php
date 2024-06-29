<?php

namespace app\service;

use app\dto\GroupDto;
use app\repository\GroupRepository;
use Exception;

class GroupService
{
    public GroupRepository $groupRepository;

    public function __construct()
    {
        $this->groupRepository = new GroupRepository();
    }

    /**
     * @return array|null
     */
    public function getGroupAll(): ?array
    {
        return $this->groupRepository->getGroupAll();
    }

    /**
     * @param GroupDto $groupDto
     * @return array|null
     */
    public function getGroupId(GroupDto $groupDto): ?array
    {
        return $this->groupRepository->getGroupId($groupDto);
    }

    /**
     * @param GroupDto $groupDto
     * @return array|null
     */
    public function getGroupByDepartmentId(GroupDto $groupDto): ?array
    {
        return $this->groupRepository->getGroupByDepartmentId($groupDto);
    }

    /**
     * @param GroupDto $groupDto
     * @return void
     * @throws Exception
     */
    public function addGroup(GroupDto $groupDto): void
    {
        $this->groupRepository->addGroup($groupDto);
    }

    /**
     * @param GroupDto $groupDto
     * @return void
     * @throws Exception
     */
    public function editGroup(GroupDto $groupDto): void
    {
        $this->groupRepository->editGroup($groupDto);
    }
}