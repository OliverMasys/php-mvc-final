<?php

namespace App\Models;

use PDO;

class Product
{
    // connect to the database
    public function getConnection()
    {
        $dsn = "mysql:
                host=localhost;
                dbname=sherd_JimBelushi;
                charset=utf8;
                port=3306";

        return new PDO($dsn,"sherd_JimBelushi","adpujdB734kf3", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    // method to gat all rows of data from the products table
    public function getData(): array
    {
        // establish db connection
        $conn = $this->getConnection();

        // create db query
        $sql = "SELECT * FROM `products`";

        // send query to db
        $stmt = $conn->prepare($sql);

        // execute query
        $stmt->execute();

        // return db result set to Products controller as associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // method to get a row(s) from db based on a specific ID 
    // passed from the index.php page in the site root directory
    public function find(string $id): array|bool
    {

        if ($id === null) {
            return false;  // or throw a PageNotFoundException, your call
        }

        $conn = $this->getConnection();

        $sql = "SELECT * FROM `products` WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // create an empty array to store errors
    protected array $errors = [];

    // method to add errors when validation fails
    protected function addError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }

    // method to test form data against validation requirements
    protected function validate(array $data): bool
    {
        if (empty($data["name"])) {
            
            $this->addError("name", "Required");

        }

        return empty($this->errors);
    }

    // method for returning errors on validation
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function insert(array $data): int|bool
    {
        // validate form data
        if ( ! $this->validate($data) ) {
            return false;
        }

        $sql = "INSERT INTO `products` (name, description) VALUES (?, ?)";

        $conn = $this->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(1, $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(2, $data["description"], PDO::PARAM_STR);

        $stmt->execute();

        return $conn->lastInsertId();
    }

    public function update(string $id, array $data): bool
    {
        if ( ! $this->validate($data) ) {
            return false;
        }

        unset($data["id"]);

        $fields = array_keys($data);

        array_walk($fields, function (&$value) {
            $value = "$value = ?";
        });

        $sql = "UPDATE `products` SET " . implode(", ", $fields) . " WHERE id = ?";

        $conn = $this->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(1, $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(2, $data["description"], PDO::PARAM_STR);
        $stmt->bindValue(3, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete(string $id): bool
    {
        $sql = "DELETE FROM `products` WHERE id = :id";

        $conn = $this->getConnection();

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }


}