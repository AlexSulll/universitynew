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

    /**
     * @return array
     */
    public function getTree(): array
    {
        return $this->treeRepository->getTree();
    }
}