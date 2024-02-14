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
    }