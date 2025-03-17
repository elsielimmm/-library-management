<?php
require_once 'conn.php';

class Student {
    private $conn;

    // Constructor để khởi tạo kết nối
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Hàm để thêm sinh viên
    public function save($stud_no, $firstname, $lastname, $gender, $year, $section, $password) {
        $yrsec = $year . $section;
        $password = md5($password);

        $query = "INSERT INTO `student` VALUES('', '$stud_no', '$firstname', '$lastname', '$gender', '$yrsec', '$password')";
        mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
    }
}

// Kiểm tra nếu form được submit
if (isset($_POST['save'])) {
    $stud_no = $_POST['stud_no'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $year = $_POST['year'];
    $section = $_POST['section'];
    $password = $_POST['password'];

    // Tạo đối tượng Student và lưu dữ liệu
    $student = new Student($conn);
    $student->save($stud_no, $firstname, $lastname, $gender, $year, $section, $password);

    // Chuyển hướng đến trang khác
    header('location: ../view/student.php');
}
?>
