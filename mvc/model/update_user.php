<?php
class User {
    private $conn;

    // Constructor để thiết lập kết nối cơ sở dữ liệu
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Hàm cập nhật thông tin người dùng
    public function update($user_id, $firstname, $lastname, $username, $password) {
        $password = md5($password);  // Mã hóa mật khẩu
        $query = "UPDATE `user` SET `firstname` = ?, `lastname` = ?, `username` = ?, `password` = ? WHERE `user_id` = ?";

        // Sử dụng prepared statement để tránh SQL injection
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param('sssss', $firstname, $lastname, $username, $password, $user_id);
            if ($stmt->execute()) {
                echo "<script>alert('Successfully updated!')</script>";
                echo "<script>window.location = '../view/user.php'</script>";
            } else {
                echo "<script>alert('Error updating record!')</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing query!')</script>";
        }
    }
}

// Kết nối cơ sở dữ liệu
require_once 'conn.php';

// Kiểm tra xem có gửi form với action 'edit' hay không
if (isset($_POST['edit'])) {
    $user = new User($conn);
    $user->update($_POST['user_id'], $_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['password']);
}
?>
