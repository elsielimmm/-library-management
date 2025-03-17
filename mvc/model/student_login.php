<?php
require_once 'conn.php'; // Kết nối cơ sở dữ liệu

class Auth {
    private $conn;

    // Khởi tạo kết nối cơ sở dữ liệu
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Hàm xác thực người dùng
    public function login($stud_no, $password) {
        $stud_no = mysqli_real_escape_string($this->conn, $stud_no);
        $password = md5(mysqli_real_escape_string($this->conn, $password));

        $query = mysqli_query($this->conn, "SELECT * FROM `student` WHERE `stud_no` = '$stud_no' && `password` = '$password'") or die(mysqli_error($this->conn));
        $row = mysqli_num_rows($query);

        if ($row > 0) {
            $fetch = mysqli_fetch_array($query);
            return $fetch['stud_id']; // Trả về ID của sinh viên nếu đăng nhập thành công
        } else {
            return false; // Trả về false nếu đăng nhập không thành công
        }
    }
}
?>
