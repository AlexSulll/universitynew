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

    /**
     * @return array
     */
    public function getTree(): array
    {
        return $this->treeService->getTree();
    }
}