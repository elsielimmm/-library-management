<?php
require_once 'conn.php';

class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function save($firstname, $lastname, $username, $password, $status) {
        $password = md5($password);
        $query = "INSERT INTO `user` VALUES('', ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $firstname, $lastname, $username, $password, $status);
        if ($stmt->execute()) {
            header('location: ../view/user.php');
        } else {
            die($this->conn->error);
        }
    }
}

if (isset($_POST['save'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = $_POST['status'];
    
    $user = new User($conn);
    $user->save($firstname, $lastname, $username, $password, $status);
}
?>
