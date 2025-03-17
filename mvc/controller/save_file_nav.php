<?php
require_once '../model/save_file.php';
require_once '../model/conn.php';

class FileController {
    private $fileModel;

    public function __construct($db_connection) {
        $this->fileModel = new File($db_connection);
    }

    public function handleFileUpload() {
        if (isset($_POST['save'])) {
            $stud_no = $_POST['stud_no'];
            $file = $_FILES['file'];
            $tit = $_POST['tit'];
            $description = $_POST['description'];
            $faculty = $_POST['faculty'];

            if ($this->fileModel->uploadFile($stud_no, $file, $tit, $description, $faculty)) {
                header('location: ../view/student_profile.php');
            } else {
                echo "<script>alert('File upload failed. Please try again.')</script>";
                echo "<script>window.history.back();</script>";
            }
        }
    }
}
?>
