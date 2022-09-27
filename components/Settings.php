<?php

namespace Components;

class Settings extends Singleton
{
    /**
     * @var array $envVariables
     */
    private array $envVariables;

    protected function __construct()
    {
        $this->envVariables = include(ROOT . '/env.php');
    }

    /**
     * @return array
     */
    public function getEnvVariables(): array
    {
        return $this->envVariables;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function getEnvVariable($key)
    {
        if (array_key_exists($key, $this->envVariables)) {
            return $this->envVariables[$key];
        }

        return null;
    }
}