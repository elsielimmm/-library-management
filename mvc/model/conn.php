<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "test7";
    public $conn;

    public function __construct() {
        $this->connect();
        $this->initializeDefaultUser();
    }

    // Phương thức kết nối cơ sở dữ liệu
    private function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        if ($this->conn->connect_error) {
            die("Error: Failed to connect to database! " . $this->conn->connect_error);
        }
    }

    // Phương thức kiểm tra và tạo tài khoản mặc định
    private function initializeDefaultUser() {
        $defaultQuery = $this->conn->query("SELECT * FROM `user`");
        
        if ($defaultQuery === false) {
            die("Error: " . $this->conn->error);
        }
        
        if ($defaultQuery->num_rows === 0) {
            $encryptedPassword = md5('admin');
            $insertDefault = $this->conn->query("INSERT INTO `user` VALUES('', 'Administrator', '', 'admin', '$encryptedPassword', 'administrator')");
            
            if ($insertDefault === false) {
                die("Error: " . $this->conn->error);
            }
        }
    }
}

// Khởi tạo đối tượng Database
$db = new Database();
$conn = $db->conn; // Biến $conn để tương thích với các đoạn mã hiện tại
?>
