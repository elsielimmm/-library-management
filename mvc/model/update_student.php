<?php
require_once 'conn.php';

class Student {
    private $conn;

    // Constructor to initialize the connection
    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    // Method to update student information
    public function updateStudent($stud_id, $stud_no, $firstname, $lastname, $gender, $yr, $password) {
        $passwordHash = md5($password);

        $query = "UPDATE `student` SET `stud_no` = ?, `firstname` = ?, `lastname` = ?, `gender` = ?, `yr` = ?, `password` = ? WHERE `stud_id` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssi", $stud_no, $firstname, $lastname, $gender, $yr, $passwordHash, $stud_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Successfully updated!')</script>";
            echo "<script>window.location = '../view/student.php'</script>";
        } else {
            echo "<script>alert('Update failed!')</script>";
        }

        $stmt->close();
    }
}

if (isset($_POST['update'])) {
    $stud_id = $_POST['stud_id'];
    $stud_no = $_POST['stud_no'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $yr = $_POST['year'];
    $password = $_POST['password'];

    $student = new Student($conn);
    $student->updateStudent($stud_id, $stud_no, $firstname, $lastname, $gender, $yr, $password);
}
?>
