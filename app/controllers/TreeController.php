<?php

namespace app\controllers;

use app\service\TreeService;

class TreeController
{
    public TreeService $treeService;

    public function __construct()
    {
        $this->treeService = new TreeService();
    }

    public function getTree()
    {
        return $this->treeService->getTree();
    }
}