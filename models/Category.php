<?php
class Category {
    private $conn;
    private $table = 'categories';

    public $id;
    public $category;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT 
                    c.id,
                    c.category
                  FROM
                    ' . $this->table . ' c';
        
        $stmt = $this->conn->prepare($query);                        
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT 
                    c.id,
                    c.category
                  FROM
                    ' . $this->table . ' c                  
                  WHERE
                    c.id = ?';

        $stmt = $this->conn->prepare($query);  
        $stmt->bindParam(1, $this->id);                      
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Make sure data is returned
        if($row != null) {
            $this->category = $row['category'];
        }

        // If data was returned but the author field is null
        if($row['category'] === null) {
            echo json_encode(
                array('message' => 'category_id Not Found'), JSON_FORCE_OBJECT
            );
            exit(1);
        }

        return $stmt;
    }

    public function create() {
        $query = 'INSERT INTO ' . 
                    $this->table . '
                  (
                  category
                  )
                  VALUES (
                    :category
                  );
                  ';

        $stmt = $this->conn->prepare($query);

        $this->category = htmlspecialchars(strip_tags($this->category));

        $stmt->bindParam(':category', $this->category);

        // Query succeeds
        if($stmt->execute()) {

            // Returns last inserted id from db
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        // Query fails
        printf("Error: %s. \n", $stmt->error);
        return false;
    }

    public function update() {
        $query = 'UPDATE ' . 
                    $this->table . '
                  SET
                    category = :category
                  WHERE 
                    id = :id
                  ';

        $stmt = $this->conn->prepare($query);

        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);

        // Query succeeds
        if($stmt->execute()) {
            return true;
        }

        // Query fails
        printf("Error: %s. \n", $stmt->error);
        return false;
    }

    public function delete() {
        $query = 'DELETE FROM ' . 
                    $this->table . '
                  WHERE 
                    id = :id';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);
        
        // Query succeeds
        if($stmt->execute()) {
            return true;
        }

        // Query fails
        printf("Error: %s. \n", $stmt->error);
        return false;
    }
}
?>