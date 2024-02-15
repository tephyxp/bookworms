<?php

namespace Model;

use Config\Database;
use PDO;

class UserModel {
    private $conn;

    public function __construct()
    {
        $connection = new  Database();
        $this ->conn = $connection->connect();
    }

    public function getUsers(){
        $users= $this -> conn ->prepare("SELECT * FROM bookworms_library.users");

        return ($users -> execute()) ? $users -> fetchAll(PDO::FETCH_ASSOC) : false ;
    }

}