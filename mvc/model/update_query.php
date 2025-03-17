<?php
class Student {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateStudent($stud_id, $firstname, $lastname, $gender, $yr, $password) {
        $password = md5($password);
        $query = "UPDATE `student` SET `firstname`='$firstname', `lastname`='$lastname', `gender`='$gender', `yr`='$yr', `password`='$password' WHERE `stud_id`='$stud_id'";
        if (mysqli_query($this->conn, $query)) {
            header('Location: ../view/student_profile.php');
        } else {
            die(mysqli_error($this->conn));
        }
    }
}

require_once 'conn.php';

if (isset($_POST['update'])) {
    $stud_id = $_POST['stud_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $yr = $_POST['year'];
    $password = $_POST['password'];

    $student = new Student($conn);
    $student->updateStudent($stud_id, $firstname, $lastname, $gender, $yr, $password);
}
?>
