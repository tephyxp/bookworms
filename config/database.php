<?php
namespace Config;
use PDO;
use PDOException;

    class Database{
        //parametros db
        private $host;
        private $db_name;
        private $username;
        private $password;
        private $conn;

    // Constructor
    public function __construct(){

        $env = parse_ini_file(__DIR__ . '/../.env');
        
        $this->host = $env['DDBB_HOST']; 
        $this->db_name = $env['DDBB_NAME'];
        $this->username = $env['DDBB_USER'];
        $this->password = $env['DDBB_PASSWORD'];
    }

        //Conexion db
        public function connect(){
            $this->conn = null;

            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname='  . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            } catch (PDOException $e) {
                echo "error al conectar con DB: " . $e->getMessage(); 
            }
            return $this->conn;
        }
    }