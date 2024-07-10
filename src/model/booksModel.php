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

        $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    
    public function getBooks()
    {
        $query = "SELECT * FROM books";
        $stmt = $this->PDO->prepare($query);

        return ($stmt->execute()) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    public function getBooksPagination($page, $limit)
    {
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM books LIMIT :limit OFFSET :offset";
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    
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

    public function addBook($publish_date, $title, $author, $image, $review)
    {
        $query = "INSERT INTO books(id, publish_date, title, author, image, review) VALUES (null, :publish_date, :title, :author, :image, :review)";

        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':publish_date', $publish_date, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_LOB);
        $stmt->bindParam(':review', $review, PDO::PARAM_STR);

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
        $errorInfo = $stmt->errorInfo();
        error_log("Delete failed for ID $id: " . print_r($errorInfo, true));
        return false;
    }

    }
    
    public function editBook($id, $publish_date, $title, $author, $image, $review)
    {
        $query = "UPDATE books SET publish_date = :publish_date, title = :title, author = :author, image = :image, review = :review WHERE id = :id";

        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':publish_date', $publish_date);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':review', $review);

        if ($stmt->execute()) {
            return true;
        } else {
            die('error' . $stmt->errorInfo()[2]);
        };
    }
}
