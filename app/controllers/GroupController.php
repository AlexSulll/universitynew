<?php

namespace app\controllers;

use app\dto\DepartmentDto;
use app\dto\GroupDto;
use app\service\DepartmentService;
use app\service\GroupService;
use Exception;

class GroupController
{
    public GroupService $groupService;
    public DepartmentService $departmentService;

    public function __construct()
    {
        $this->groupService = new GroupService();
        $this->departmentService = new DepartmentService();
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
     * @return array|string
     */
    public function getGroupId(array $request): array | string
    {
        $groupDto = new GroupDto();

        if (isset($request["groupId"])) {
            $groupDto->groupId = $request["groupId"];
            $group = $this->groupService->getGroupId($groupDto);
            if ($group) {
                return $group;
            } else {
                return "Такой группы не существует";
            }
        } else {
            return "Ошибка данных";
        }
    }

    /**
     * @param array $request
     * @return array|string
     */
    public function getGroupByDepartmentId(array $request): array | string
    {
        $groupDto = new GroupDto();

        if (isset($request["departmentId"])) {
            $departmentDto = new DepartmentDto();
            $departmentDto->departmentId = $request["departmentId"];
            $department = $this->departmentService->getDepartmentId($departmentDto);
            if ($department) {
                $groupDto->departmentId = $request["departmentId"];
                return $this->groupService->getGroupByDepartmentId($groupDto);
            } else {
                return "Такой кафедры не существует";
            }
        } else {
            return "Ошибка данных";
        }
    }

    /**
     * @param array $request
     * @return string
     * @throws Exception
     */
    public function addGroup(array $request): string
    {

        $groupAll = $this->groupService->getGroupAll();

        $groupDto = new GroupDto();
        $departmentDto = new DepartmentDto();

        if (isset($request["groupName"], $request["departmentId"])) {
            if (preg_match("/^[А-яЁё0-9 -]*$/u", $request["groupName"]) && preg_match("/^[0-9]*$/", $request["departmentId"])) {
                $groupDto->groupName = $request["groupName"];
                $groupDto->departmentId = $request["departmentId"];
                $departmentDto->departmentId = $request["departmentId"];
                if (!array_search($groupDto->groupName, array_column($groupAll, "groupName"))) {
                    if ($this->departmentService->getDepartmentId($departmentDto)) {
                        $this->groupService->addGroup($groupDto);
                        return "Успешное добавление группы";
                    } else {
                        return "Такой кафедры не существует";
                    }
                } else {
                    return "Группа с таким названием уже существует";
                }
            } else {
                return "Ошибка при проверке данных";
            }
        } else {
            return "Ошибка данных";
        }
    }

    /**
     * @param array $request
     * @return string
     * @throws Exception
     */
    public function editGroup(array $request): string
    {
        $groupAll = $this->groupService->getGroupAll();

        $groupDto = new GroupDto();
        $departmentDto = new DepartmentDto();

        if (isset($request["groupId"], $request["newNameGroup"], $request["newDepartmentId"])) {
            if (preg_match("/^[А-яЁё0-9 -]*$/u", $request["newNameGroup"]) && preg_match("/^[0-9]*$/", $request["newDepartmentId"]) && preg_match("/^[0-9]*$/", $request["groupId"])) {
                $groupDto->groupId = $request["groupId"];
                $groupDto->groupName = $request["newNameGroup"];
                $groupDto->departmentId = $departmentDto->departmentId = $request["newDepartmentId"];
                if ($this->groupService->getGroupId($groupDto)) {
                    if ($this->departmentService->getDepartmentId($departmentDto)) {
                        if (!array_search($groupDto->groupName, array_column($groupAll, "groupName"))) {
                            $this->groupService->editGroup($groupDto);
                            return "Успешное изменение группы";
                        } else {
                            return "Группа с таким названием уже существует";
                        }
                    } else {
                        return "Такой кафедры не существует";
                    }
                } else {
                    return "Такой группы не существует";
                }
            } else {
                return "Ошибка при проверке данных";
            }
        } else {
            return "Ошибка данных";
        }
    }

    /**
     * @param array $request
     * @return string
     * @throws Exception
     */
    public function deleteGroup(array $request): string
    {
        $groupAll = $this->groupService->getGroupAll();

        $groupDto = new GroupDto();

        if (isset($request["groupId"])) {
            $groupDto->groupId = $request["groupId"];
            if (array_search($groupDto->groupId, array_column($groupAll, "id"))) {
                 $this->groupService->deleteGroup($groupDto);
                 return "Успешное удаление группы";
            } else {
                return "Такой группы не существует";
            }
        } else {
            return "Ошибка данных";
        }
    }
}