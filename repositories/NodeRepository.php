<?php

namespace Repositories;

use Components\DatabaseConnection;
use Models\Node;

class NodeRepository
{
    /**
     * @return array
     */
    public static function getAllNodes(): array
    {
        $result = [];

        $pdo = DatabaseConnection::getInstance()->getPDO();
        $stmt = $pdo->query("SELECT * FROM nodes ORDER BY id ASC");

        $nodesData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($nodesData as $nodeData) {
            $result[] = new Node($nodeData);
        }

        return $result;
    }

    /**
     * @return Node|null
     */
    public static function getRootNodeTreeForHomepage()
    {
        $root = self::getRootNode();

        if (!isset($root)) {
            return null;
        }

        $allNodes = self::getAllNodes();

        $root->children = self::buildChildrenTree($allNodes, $root->getAttribute('id'));

        return $root;
    }

    /**
     * @param array $elements
     * @param int $parentId
     * @return array
     */
    public static function buildChildrenTree(array &$elements, int $parentId): array
    {
        $tree = [];

        foreach ($elements as &$element) {

            if ($element->getAttribute('parent_id') == $parentId) {
                $children = self::buildChildrenTree($elements, $element->getAttribute('id'));
                $element->children = $children;
                $tree[] = $element;
                unset($element);
            }
        }
        return $tree;
    }

    /**
     * @param Node $node
     */
    public static function createNode(Node $node): void
    {
        $pdo = DatabaseConnection::getInstance()->getPDO();

        $stmt = $pdo->prepare("INSERT INTO nodes (name, parent_id, is_root) VALUES (:name, :parent_id, :is_root)");
        $result = $stmt->execute([
            'name' => $node->getAttribute('name'),
            'parent_id' => $node->getAttribute('parent_id'),
            'is_root' => $node->getAttribute('is_root')
        ]);

        if ($result) {
            $node->setAttribute('id', $pdo->lastInsertId());
        }
    }

    /**
     * @param Node $node
     */
    public static function updateNode(Node $node): void
    {
        $pdo = DatabaseConnection::getInstance()->getPDO();

        $stmt = $pdo->prepare("UPDATE nodes SET name = :name, parent_id = :parent_id, is_root = :is_root WHERE id = :id");
        $stmt->execute([
            'id' => $node->getAttribute('id'),
            'name' => $node->getAttribute('name'),
            'parent_id' => $node->getAttribute('parent_id'),
            'is_root' => $node->getAttribute('is_root')
        ]);
    }

    /**
     * @param Node $node
     */
    public static function deleteNode(Node $node): void
    {
        $pdo = DatabaseConnection::getInstance()->getPDO();

        $stmt = $pdo->prepare("DELETE FROM nodes WHERE id = :id");
        $stmt->execute(['id' => $node->getAttribute('id')]);
    }

    /**
     * @param Node $node
     */
    public static function deleteNodeWithChildren(Node $node): void
    {
        foreach (self::getChildNodes($node) as $childNode) {
            self::deleteNodeWithChildren($childNode);
        }

        self::deleteNode($node);
    }

    /**
     * @param int $nodeId
     * @return Node|null
     */
    public static function getNodeById(int $nodeId)
    {
        $result = null;

        $pdo = DatabaseConnection::getInstance()->getPDO();
        $stmt = $pdo->prepare("SELECT * FROM nodes WHERE id = :id");
        $stmt->execute(['id' => $nodeId]);

        $nodeData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!empty($nodeData)) {
            $result = new Node($nodeData);
        }

        return $result;
    }

    /**
     * @return Node|null
     */
    public static function getRootNode()
    {
        $result = null;

        $pdo = DatabaseConnection::getInstance()->getPDO();
        $stmt = $pdo->query("SELECT * FROM nodes WHERE is_root = true");

        $nodeData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!empty($nodeData)) {
            $result = new Node($nodeData);
        }

        return $result;
    }

    /**
     * @param Node $node
     * @return array
     */
    public static function getChildNodes(Node $node): array
    {
        $result = [];

        $pdo = DatabaseConnection::getInstance()->getPDO();
        $stmt = $pdo->prepare("SELECT * FROM nodes WHERE parent_id = :id ORDER BY id ASC");
        $stmt->execute(['id' => $node->getAttribute('id')]);

        $nodesData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($nodesData as $nodeData) {
            $result[] = new Node($nodeData);
        }

        return $result;
    }
}