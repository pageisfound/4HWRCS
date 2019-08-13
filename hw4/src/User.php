<?php

require_once 'Database.php';

class User
{
    /** @var Database $database */
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * @param string $name
     * @return array|bool
     */
    public function isUsernameTaken(string $name): bool
    {
        $query = 'SELECT username FROM ' . $this->database->getUserTable() . ' WHERE username = :name';

        $statement = $this->database->getConnection()->prepare($query);
        $statement->bindParam(':name', $name);
        $statement->execute();

        return $statement->rowCount() > 0;
    }

    /**
     * @param string $name
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public function create(string $name, string $password): bool
    {
        $password  = password_hash($password, PASSWORD_DEFAULT);
        $createdAt = date('Y-m-d H:i:s');

        $query = 'INSERT INTO ' . $this->database->getUserTable() .
            ' SET username=:name, password = :password, created_at = :createdAt';

        $statement = $this->database->getConnection()->prepare($query);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':password', $password);
        $statement->bindParam(':createdAt', $createdAt);

        return $statement->execute();
    }

    /**
     * @param string $name
     * @param string $password
     * @return bool
     * @throws Exception
     */
    public function validate(string $name, string $password): bool
    {
        $query = 'SELECT password FROM ' . $this->database->getUserTable() . ' WHERE username = :name';

        $statement = $this->database->getConnection()->prepare($query);
        $statement->bindParam(':name', $name);
        $statement->execute();

        if ($statement->rowCount() === 1) {
            $row = $statement->fetch();
            if ($row && password_verify($password, $row['password'])) {
                return true;
            }
        }

        return false;
    }
}
