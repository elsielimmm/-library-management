<?php
require_once 'conn.php'; // Kết nối cơ sở dữ liệu

class FileManager {
    private $conn;

    // Khởi tạo kết nối cơ sở dữ liệu
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Hàm xóa file và dữ liệu trong cơ sở dữ liệu
    public function deleteFile($store_id) {
        // Lấy thông tin của file từ cơ sở dữ liệu
        $store_id = mysqli_real_escape_string($this->conn, $store_id);
        $query = mysqli_query($this->conn, "SELECT * FROM `storage` WHERE `store_id` = '$store_id'") or die(mysqli_error($this->conn));
        $fetch = mysqli_fetch_array($query);
        
        // Kiểm tra nếu tìm thấy file
        if ($fetch) {
            $filename = $fetch['filename'];
            $stud_no = $fetch['stud_no'];

            // Xóa file từ thư mục
            if (unlink("../../files/" . $stud_no . "/" . $filename)) {
                // Xóa dữ liệu trong cơ sở dữ liệu
                mysqli_query($this->conn, "DELETE FROM `storage` WHERE `store_id` = '$store_id'") or die(mysqli_error($this->conn));
                return 'success'; // Trả về success nếu xóa thành công
            } else {
                return 'error'; // Trả về error nếu không thể xóa file
            }
        } else {
            return 'file_not_found'; // Nếu không tìm thấy file
        }
    }
}

// Kiểm tra nếu có dữ liệu từ form gửi đến
if (isset($_POST['store_id'])) {
    $fileManager = new FileManager($conn); // Tạo đối tượng FileManager
    $store_id = $_POST['store_id'];

    // Xóa file và dữ liệu
    $result = $fileManager->deleteFile($store_id);
    echo $result; // Trả về kết quả thành công, lỗi hoặc không tìm thấy file
} else {
    echo 'error'; // Trường hợp thiếu thông tin
}
?>
