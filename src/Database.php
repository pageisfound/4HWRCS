<?php

class Database
{
    /** @var PDO $connection */
    private $connection;
    /** @var string $tableName */
    private $mainTable = 'todos';
    /** @var string $users */
    private $userTable = 'users';

    public function __construct()
    {
        $host = 'localhost:3306';
        $name = 'hw4';
        $dsn  = 'mysql:host=' . $host . ';dbname=' . $name;

        $user = 'qwerty';
        $pass = 'qwerty';

        try {
            $this->connection = new PDO($dsn, $user, $pass);
        } catch (PDOException $exception) {
            echo 'Connection failed: ' . $exception->getMessage();
        }
    }

    /**
     * @return PDO
     */
    public function getConnection(): \PDO
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getMainTable(): string
    {
        return $this->mainTable;
    }

    /**
     * @return string
     */
    public function getUserTable(): string
    {
        return $this->userTable;
    }
}
