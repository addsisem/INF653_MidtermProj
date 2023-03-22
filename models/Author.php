<?php
class Author {
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT 
                    a.id,
                    a.author
                  FROM
                    ' . $this->table . ' a';
        
        $stmt = $this->conn->prepare($query);                        
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT 
                    a.id,
                    a.author
                  FROM
                    ' . $this->table . ' a                  
                  WHERE
                    a.id = ?';

        $stmt = $this->conn->prepare($query);  
        $stmt->bindParam(1, $this->id);                      
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Error Handling
        if($row != null) {
            $this->author = $row['author'];
        }

        if($row['author'] ??= null) {
            echo json_encode(
                array('message' => 'author_id Not Found'), JSON_FORCE_OBJECT
            );
            exit(1);
        }

        return $stmt;
    }

    public function create() {
        $query = 'INSERT INTO ' . 
                    $this->table . '
                  (
                  author
                  )
                  VALUES (
                    :author
                  );
                  ';

        $stmt = $this->conn->prepare($query);

        $this->author = htmlspecialchars(strip_tags($this->author));

        $stmt->bindParam(':author', $this->author);

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
                    author = :author
                  WHERE 
                    id = :id
                  ';

        $stmt = $this->conn->prepare($query);

        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':author', $this->author);
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