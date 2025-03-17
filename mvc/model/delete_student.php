<?php
require_once 'conn.php';

class Student {
    private $conn;
    private $stud_id;
    private $stud_no;

    public function __construct($conn, $stud_id) {
        $this->conn = $conn;
        $this->stud_id = $stud_id;
        $this->fetchStudentData();
    }

    // Lấy thông tin sinh viên từ cơ sở dữ liệu
    private function fetchStudentData() {
        $query = mysqli_query($this->conn, "SELECT * FROM `student` WHERE `stud_id` = '$this->stud_id'") or die(mysqli_error($this->conn));
        $fetch = mysqli_fetch_array($query);
        $this->stud_no = $fetch['stud_no'];
    }

    // Hàm xóa thư mục
    private function removeDir($dir) {
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $path = $dir . '/' . $item;
            if (is_dir($path)) {
                $this->removeDir($path); // Gọi đệ quy để xóa thư mục con
            } else {
                unlink($path); // Xóa file
            }
        }
        rmdir($dir); // Xóa thư mục gốc
    }

    // Xóa dữ liệu sinh viên và các file liên quan
    public function deleteStudentData() {
        // Kiểm tra xem thư mục có tồn tại không, nếu có thì xóa
        if (file_exists("../../files/" . $this->stud_no)) {
            $this->removeDir("../../files/" . $this->stud_no);
        }

        // Xóa dữ liệu sinh viên khỏi cơ sở dữ liệu
        $deleteStudent = mysqli_query($this->conn, "DELETE FROM `student` WHERE `stud_id` = '$this->stud_id'");
        if (!$deleteStudent) {
            die('Error deleting student: ' . mysqli_error($this->conn));
        }

        // Xóa dữ liệu trong bảng storage liên quan đến sinh viên
        $deleteStorage = mysqli_query($this->conn, "DELETE FROM `storage` WHERE `stud_no` = '$this->stud_no'");
        if (!$deleteStorage) {
            die('Error deleting storage: ' . mysqli_error($this->conn));
        }
    }
}

// Kiểm tra và xử lý yêu cầu từ phía client
if (isset($_POST['stud_id'])) {
    $stud_id = $_POST['stud_id'];
    $student = new Student($conn, $stud_id);
    $student->deleteStudentData();
}
?>
