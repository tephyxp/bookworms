<?php

    namespace Model;
    
    use PDO;
    use Config\Database;

    class booksModel
    {
        private $PDO;

        public function __construct()
        {
            $connectDB = new Database;
            $this->PDO = $connectDB->connect();
        }

        //traer todos los books
        public function getBooks()
        {
            $query = "SELECT * FROM books";
             //preparar sentencia
            $stmt = $this->PDO->prepare($query);
             //ejecutamos
            return ($stmt->execute()) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false;
        }
        
        public function getBookDetails($id)
        {
            $query = "SELECT * FROM books WHERE id = :id LIMIT 1";
            $stmt = $this->PDO->prepare($query);
            $stmt->bindParam(":id",$id);
            return ($stmt->execute()) ? $stmt->fetch() : false;
        }
    }