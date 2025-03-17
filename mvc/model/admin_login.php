<?php
class UserModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUser($username, $password) {
        $password = md5($password);
        $query = mysqli_query($this->conn, "SELECT * FROM `user` WHERE `username` = '$username' AND `password` = '$password'") or die(mysqli_error($this->conn));
        return mysqli_fetch_array($query);
    }
}
?>
