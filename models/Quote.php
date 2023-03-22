<?php
    class Quote {
        //DB
        private $conn;
        private $table = 'quotes';

        //Quote properties
        public $id;
        public $quote;
        public $category_id;
        public $category;
        public $author_id;
        public $author;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        // Get Quotes
        public function read() {
            $query = 'SELECT 
                        c.category as category,
                        a.author as author,
                        q.id,
                        q.quote,
                        q.category_id,
                        q.author_id
                      FROM
                        ' . $this->table . ' q
                      LEFT JOIN
                        categories c ON q.category_id = c.id
                      LEFT JOIN
                        authors a ON q.author_id = a.id';
            
            $stmt = $this->conn->prepare($query);                        
            $stmt->execute();
            return $stmt;
        }

        public function readCategoryAuthors() {
            $query = 'SELECT 
                        c.category as category,
                        a.author as author,
                        q.id,
                        q.quote,
                        q.category_id,
                        q.author_id
                      FROM
                        ' . $this->table . ' q
                      LEFT JOIN
                        categories c ON q.category_id = c.id
                      LEFT JOIN
                        authors a ON q.author_id = a.id
                      WHERE
                        q.author_id = :author_id AND q.category_id = :category_id';
            
            $stmt = $this->conn->prepare($query); 
            $stmt->bindParam(':author_id', $this->author_id); 
            $stmt->bindParam(':category_id', $this->category_id);                         
            $stmt->execute();
            return $stmt;
        }

        public function readAuthor() {
            $query = 'SELECT 
                        c.category as category,
                        a.author as author,
                        q.id,
                        q.quote,
                        q.category_id,
                        q.author_id
                      FROM
                        ' . $this->table . ' q
                      LEFT JOIN
                        categories c ON q.category_id = c.id
                      LEFT JOIN
                        authors a ON q.author_id = a.id
                      WHERE
                        q.author_id = ?';
            
            $stmt = $this->conn->prepare($query); 
            $stmt->bindParam(1, $this->author_id);                       
            $stmt->execute();
            return $stmt;
        }

        public function readCategory() {
            $query = 'SELECT 
                        c.category as category,
                        a.author as author,
                        q.id,
                        q.quote,
                        q.category_id,
                        q.author_id
                      FROM
                        ' . $this->table . ' q
                      LEFT JOIN
                        categories c ON q.category_id = c.id
                      LEFT JOIN
                        authors a ON q.author_id = a.id
                      WHERE
                        q.category_id = ?';
            
            $stmt = $this->conn->prepare($query);   
            $stmt->bindParam(1, $this->category_id);                     
            $stmt->execute();
            return $stmt;
        }

        public function read_single() {
            $query = 'SELECT 
                        c.category as category,
                        a.author as author,
                        q.id,
                        q.quote,
                        q.category_id,
                        q.author_id
                      FROM
                        ' . $this->table . ' q
                      LEFT JOIN
                        categories c ON q.category_id = c.id
                      LEFT JOIN
                        authors a ON q.author_id = a.id
                      WHERE
                        q.id = ?';

            $stmt = $this->conn->prepare($query);  
            $stmt->bindParam(1, $this->id);                      
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Error Handling
            if($row != null) {
                $this->id = $row['id'];
                $this->quote = $row['quote'];
                $this->category = $row['category'];
                $this->author = $row['author'];
            }

            if($row['quote'] == null) {
                echo json_encode(
                    array('message' => 'No Quotes Found')
                );
                exit(1);
            }

            return $stmt;
        }

        public function create() {
            $query = 'INSERT INTO ' . 
                        $this->table . '
                      (
                        quote, 
                        category_id, 
                        author_id
                      )
                      VALUES (
                        :quote,
                        :category_id,
                        :author_id
                      );';

            $stmt = $this->conn->prepare($query);

            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));

            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':author_id', $this->author_id);

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
                      quote = :quote,
                      category_id = :category_id,
                      author_id = :author_id
                      WHERE 
                        id = :id
                      ';
    
            $stmt = $this->conn->prepare($query);
    
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->id = htmlspecialchars(strip_tags($this->id));
    
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':author_id', $this->author_id);
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