<?php
session_start();
require '../mvc/model/conn.php'; // Kết nối database
require '../mvc/model/admin_login.php'; // Import model

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Tạo instance của UserModel
    $userModel = new UserModel($conn);

    // Lấy thông tin người dùng từ database
    $fetch = $userModel->getUser($username, $password);

    if ($fetch) { // Nếu có user trong database
        $_SESSION['user'] = $fetch['user_id'];
        $_SESSION['status'] = $fetch['status'];
        header("location:../mvc/view/admin_home.php");
    } else { // Nếu thông tin không hợp lệ
        $error = "Invalid username or password";
    }
}
?>
