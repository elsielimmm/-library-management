<?php
session_start();
require_once 'mvc/model/student_login.php'; // Chạy model Auth

if (isset($_POST['login'])) {
    $stud_no = $_POST['stud_no'];
    $password = $_POST['password'];

    $auth = new Auth($conn); // Tạo đối tượng Auth
    $stud_id = $auth->login($stud_no, $password); // Gọi phương thức login

    if ($stud_id) {
        $_SESSION['student'] = $stud_id;
        header("location: mvc/view/student_profile.php");
    } else {
        $_SESSION['error'] = 'Invalid username or password'; // Lưu thông báo lỗi vào session
        header("location: index.php"); // Chuyển hướng lại trang đăng nhập
    }
}
?>
