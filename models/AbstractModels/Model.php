<?php

namespace Models\AbstractModels;

abstract class Model
{
    /**
     * Model constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * @param array $attributes
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $attributeName => $attributeValue) {
            $this->setAttribute($attributeName, $attributeValue);
        }
    }

    /**
     * @param string $attributeName
     * @param $value
     */
    public function setAttribute(string $attributeName, $value)
    {
        if (property_exists($this, $attributeName) && isset($value)) {
            $this->{$attributeName} = $value;
        }
    }

    /**
     * @param string $attributeName
     * @return mixed|null
     */
    public function getAttribute(string $attributeName)
    {
        if (property_exists($this, $attributeName) && isset($this->{$attributeName})) {
            return $this->{$attributeName};
        }

        return null;
    }

    abstract function save();

    abstract function delete();
}