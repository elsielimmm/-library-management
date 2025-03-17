<?php
require_once 'conn.php';

class FileUploader {
    private $conn;
    private $stud_no;
    private $file;
    private $tit;
    private $description;
    private $faculty;
    private $date;
    private $state = 2;
    private $mess = 'This file is waiting for authentication to post to the public homepage from the administrator.';

    public function __construct($conn, $stud_no, $file, $tit, $description, $faculty) {
        $this->conn = $conn;
        $this->stud_no = $stud_no;
        $this->file = $file;
        $this->tit = $tit;
        $this->description = $description;
        $this->faculty = $faculty;
        $this->date = date("Y-m-d, h:i A", strtotime("+6 HOURS"));
    }

    // Kiểm tra và tạo folder nếu chưa tồn tại
    public function createFolder() {
        if (!file_exists("../../files/" . $this->stud_no)) {
            mkdir("../../files/" . $this->stud_no, 0777, true);
        }
    }

    // Kiểm tra và xử lý upload file
    public function uploadFile() {
        $file_name = $this->file['name'];
        $file_type = $this->file['type'];
        $file_temp = $this->file['tmp_name'];
        $location = "../../files/" . $this->stud_no . "/" . $file_name;

        // Kiểm tra định dạng file
        if ($file_type == 'application/pdf') {
            if (move_uploaded_file($file_temp, $location)) {
                $this->saveToDatabase($file_name, $file_type);
            } else {
                echo "<script>alert('File upload failed. Please try again.')</script>";
                echo "<script>window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Only PDF files are allowed.')</script>";
            echo "<script>window.history.back();</script>";
        }
    }

    // Lưu thông tin file vào cơ sở dữ liệu
    private function saveToDatabase($file_name, $file_type) {
        $query = "INSERT INTO `storage` (`filename`, `file_type`, `date_uploaded`, `stud_no`, `tit`, `description`, `faculty`, `state`, `mess`) 
                  VALUES ('$file_name', '$file_type', '$this->date', '$this->stud_no', '$this->tit', '$this->description', '$this->faculty', '$this->state', '$this->mess')";

        mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
        header('location: ../view/student_profile.php');
    }
}

// Kiểm tra và thực thi
if (isset($_POST['save'])) {
    $fileUploader = new FileUploader($conn, $_POST['stud_no'], $_FILES['file'], $_POST['tit'], $_POST['description'], $_POST['faculty']);
    $fileUploader->createFolder();
    $fileUploader->uploadFile();
}
?>
