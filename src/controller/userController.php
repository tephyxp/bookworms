<?php 

namespace Controller;

use Model\UserModel;

class UserController {
    private $userModel;

    public function __construct(){
        $this -> userModel =  new UserModel;
    }

    public function getUsers(){
       return $this -> userModel -> getUsers();
    }

    public function login(){
        if ($_SERVER[ 'REQUEST_METHOD' ] === 'POST') {
            if(isset ($_POST["user"]) && isset($_POST["password"])){
                $postedUser=$_POST["user"];
                $postedPassword=$_POST['password'];
            
                $users= $this -> getUsers();

                foreach ($users as $user){
                    if($user['user']==$postedUser && $user['password']==$postedPassword){
                        session_start();
                        $_SESSION['user']=$postedUser;
                        header('Location: src/view/booksAdministration.php');
                        exit();
                    }
                }
                echo "Username or password incorrect";
            }
        }
    }

    public function logout(){
        session_start();
        session_destroy();
        header("Location: ../../index.php");
        exit();
    }

    public function checkAuthentication() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: login.php');
            exit();
        }
    }
}
