<?php

namespace app\controllers;

use app\dto\GroupDto;
use app\service\GroupService;
use Exception;

class GroupController
{
    public GroupService $groupService;

    public function __construct()
    {
        $this->groupService = new GroupService();
    }

    /**
     * @return array|null
     */
    public function getGroupAll(): ?array
    {
        return $this->groupService->getGroupAll();
    }

    /**
     * @param array $request
     * @return GroupDto
     */
    public function getGroupById(array $request): GroupDto
    {
        $groupDto = new GroupDto();
        $groupDto->id = $request["groupId"];
        return $this->groupService->getGroupById($groupDto);
    }

    /**
     * @param array $request
     * @return array|string
     */
    public function getGroupByDepartmentId(array $request): array | string
    {
        $groupDto = new GroupDto();
        $groupDto->departmentId = $request["departmentId"];
        return $this->groupService->getGroupByDepartmentId($groupDto);
    }

    /**
     * @param array $request
     * @return void
     * @throws Exception
     */
    public function addGroup(array $request): void
    {
        $groupDto = new GroupDto();
        $groupDto->name = $request["groupName"];
        $groupDto->departmentId = $request["departmentId"];
        $this->groupService->addGroup($groupDto);
    }

    /**
     * @param array $request
     * @return void
     * @throws Exception
     */
    public function editGroup(array $request): void
    {
        $groupDto = new GroupDto();
        $groupDto->id = $request["groupId"];
        $groupDto->name = $request["newNameGroup"];
        $groupDto->departmentId = $request["newDepartmentId"];
        $this->groupService->editGroup($groupDto);
    }

    /**
     * @param array $request
     * @return void
     * @throws Exception
     */
    public function deleteGroup(array $request): void
    {
        $groupDto = new GroupDto();
        $groupDto->id = $request["groupId"];
        $this->groupService->deleteGroup($groupDto);
    }
}