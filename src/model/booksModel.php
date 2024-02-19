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
        $stmt -> bindParam(':limit',$limit, PDO::PARAM_INT);
        $stmt -> bindParam( ':from' , $startFrom, PDO::PARAM_INT ); 

        //ejecutamos
        return ($stmt->execute()) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    public function getTotalBooks()
    {
        $query = "SELECT COUNT(id) as total FROM books";
        $stmt = $this->PDO->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        }
        return false;
    }


    public function getBookDetails($id)
    {
        $query = "SELECT * FROM books WHERE id = :id LIMIT 1";
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(":id", $id);
        return ($stmt->execute()) ? $stmt->fetch() : false;
    }

    public function searchBooks($keyword)
    {
        $query = "SELECT * FROM books WHERE title LIKE :keyword OR author LIKE :keyword";
        $stmt = $this->PDO->prepare($query);
        $keyword = "%$keyword%";
        $stmt->bindParam(":keyword", $keyword);
        return ($stmt->execute()) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    public function addBook($isbn, $title, $author, $image, $description)
    {
        $query = "INSERT INTO books(id, isbn, title, author, image, description) VALUES (null, :isbn, :title, :author, :image, :description)";

        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_LOB);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $this->PDO->lastInsertId();
        } else {
            return false;
        }
    }

    public function deleteBook($id)
    {
        $query = 'DELETE FROM books WHERE id = :id';
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            die('error' . $stmt->errorInfo()[2]);
        }
    }
}
