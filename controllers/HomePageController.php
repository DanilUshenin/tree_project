<?php

namespace Controllers;

use Models\Node;
use Repositories\NodeRepository;

class HomePageController
{
    public function view()
    {
        $title = 'Main page';
        $node = NodeRepository::getRootNodeTreeForHomepage();

        require_once(ROOT . '/views/home_page/home_page.php');
    }

    public function createNode()
    {
        $node = new Node([
            'name' => $_POST['name'],
            'parent_id' => $_POST['parent_id'],
            'is_root' => $_POST['is_root'] ?? false
        ]);

        $node->save();

        include(ROOT . '/views/home_page/node.php');
    }

    public function renameNode()
    {
        $nodeId = $_POST['node_id'];
        $nodeName = $_POST['name'];

        $node = NodeRepository::getNodeById($nodeId);

        if (isset($node)) {
            $node->setAttribute('name', $nodeName);
            $node->save();
        }
    }

    public function deleteNode()
    {
        $nodeId = $_POST['node_id'];

        $node = NodeRepository::getNodeById($nodeId);

        if (isset($node)) {
            $node->delete();
        }
    }
}