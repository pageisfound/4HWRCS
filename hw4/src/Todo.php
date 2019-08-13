<?php

require_once 'Database.php';

class Todo
{
    /** @var Database $database */
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * @return array
     */
    public function readAll(): array
    {
        $query     = 'SELECT id, name, created_at FROM ' . $this->database->getMainTable();
        $statement = $this->database->getConnection()->query($query);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     * @return array|bool
     */
    public function readSingle(int $id)
    {
        $query = 'SELECT name, description, created_at FROM ' . $this->database->getMainTable() .
            ' WHERE id = ' . $id;
        $statement = $this->database->getConnection()->query($query);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $createdAt
     * @return array
     */
    public function readByDate(string $createdAt): array
    {
        $query = 'SELECT id, name, created_at FROM ' . $this->database->getMainTable() .
            ' WHERE created_at = :date';

        $statement = $this->database->getConnection()->prepare($query);
        $statement->bindParam(':date', $createdAt);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $name
     * @param string $description
     * @return bool
     * @throws Exception
     */
    public function create(string $name, string $description): bool
    {
        $createdAt = date('Y-m-d');

        $query = 'INSERT INTO ' . $this->database->getMainTable() .
            ' SET name=:name, description = :description, created_at = :createdAt';

        $statement = $this->database->getConnection()->prepare($query);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':createdAt', $createdAt);

        return $statement->execute();
    }

    /**
     * @param int    $id
     * @param string $name
     * @param string $description
     * @return bool
     */
    public function update(int $id, string $name, string $description): bool
    {
        $query = 'UPDATE ' . $this->database->getMainTable() .
            ' SET name = :name, description = :description
            WHERE id = ' . $id;

        $statement = $this->database->getConnection()->prepare($query);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':description', $description);

        return $statement->execute();
    }

    /**
     * @param int    $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $query     = 'DELETE FROM ' . $this->database->getMainTable() . ' WHERE id = ' . $id;
        $statement = $this->database->getConnection()->prepare($query);

        return $statement->execute();
    }
}
