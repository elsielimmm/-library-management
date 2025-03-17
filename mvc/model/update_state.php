<?php
require_once 'conn.php'; // Kết nối cơ sở dữ liệu

class FileManager {
    private $conn;

    // Khởi tạo kết nối cơ sở dữ liệu
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Hàm cập nhật thông tin của file
    public function updateFileState($store_id, $message, $state) {
        $store_id = mysqli_real_escape_string($this->conn, $store_id);
        $message = mysqli_real_escape_string($this->conn, $message);
        $state = mysqli_real_escape_string($this->conn, $state);

        // Cập nhật thông tin vào cơ sở dữ liệu
        $query = "UPDATE storage SET state = '$state', mess = '$message' WHERE store_id = '$store_id'";

        if (mysqli_query($this->conn, $query)) {
            return 'success'; // Trả về success nếu cập nhật thành công
        } else {
            return 'error'; // Nếu có lỗi trong quá trình cập nhật
        }
    }
}

// Kiểm tra nếu có dữ liệu từ form gửi đến
if (isset($_POST['store_id']) && isset($_POST['message']) && isset($_POST['state'])) {
    $fileManager = new FileManager($conn); // Tạo đối tượng FileManager
    $store_id = $_POST['store_id'];
    $message = $_POST['message'];
    $state = $_POST['state'];

    // Cập nhật trạng thái file
    $result = $fileManager->updateFileState($store_id, $message, $state);

    echo $result; // Trả về kết quả thành công hoặc lỗi
} else {
    echo 'error'; // Trường hợp thiếu thông tin
}
?>
