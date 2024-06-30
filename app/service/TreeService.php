<?php

namespace app\service;

use app\repository\TreeRepository;

class TreeService
{
    public TreeRepository $treeRepository;

    public function __construct()
    {
        $this->treeRepository = new TreeRepository();
    }

    public function getTree()
    {
        $dataBase = $this->treeRepository->getTree();

        return $dataBase;
    }
}