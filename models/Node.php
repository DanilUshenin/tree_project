<?php

namespace Models;

use Models\AbstractModels\Model;
use Repositories\NodeRepository;

class Node extends Model
{
    protected int $id;

    protected string $name;

    protected int $parent_id;

    protected bool $is_root;

    private $data = [];

    public function save(): void
    {
        if (isset($this->id)) {
            NodeRepository::updateNode($this);
        } else {
            NodeRepository::createNode($this);
        }
    }
    
    public function delete(): void
    {
        NodeRepository::deleteNodeWithChildren($this);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value): void
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        return null;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * @param $name
     */
    public function __unset($name): void
    {
        unset($this->data[$name]);
    }
}