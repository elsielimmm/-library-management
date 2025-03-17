<?php
require_once 'conn.php';

class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteUser($user_id) {
        $query = "DELETE FROM `user` WHERE `user_id` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $user_id); // 's' cho kiểu dữ liệu string
        $stmt->execute() or die($this->conn->error);
    }
}

if (isset($_POST['user_id'])) {
    $user = new User($conn);
    $user->deleteUser($_POST['user_id']);
}
?>
