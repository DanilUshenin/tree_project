<?php

namespace Components;

class DatabaseConnection extends Singleton
{
    /**
     * @var \PDO $pdo
     */
    private \PDO $pdo;

    protected function __construct()
    {
        $envVariables = Settings::getInstance()->getEnvVariables();

        $host = Helper::arrayGet($envVariables, 'DATABASE_HOST', '');
        $dbname = Helper::arrayGet($envVariables, 'DATABASE_NAME', '');
        $userName = Helper::arrayGet($envVariables, 'DATABASE_USERNAME', '');
        $password = Helper::arrayGet($envVariables, 'DATABASE_PASSWORD', '');

        try {
            $dsn = "mysql:host=$host;dbname=$dbname";
            $pdo = new \PDO($dsn, $userName, $password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            exit("Connection failed: " . $e->getMessage());
        }

        $this->pdo = $pdo;
    }

    /**
     * @return \PDO
     */
    public function getPDO(): \PDO
    {
        return $this->pdo;
    }
}