<?php
require_once 'conn.php';

class FilePreview {
    private $conn;
    private $storeId;
    public $pdfFile;

    public function __construct($dbConnection, $storeId) {
        $this->conn = $dbConnection;
        $this->storeId = $storeId;
        $this->pdfFile = null;
    }

    public function fetchFile() {
        $query = mysqli_query($this->conn, "SELECT * FROM `storage` WHERE `store_id` = '{$this->storeId}'") or die(mysqli_error($this->conn));
        $fetch = mysqli_fetch_array($query);
        $filename = $fetch['filename'];
        $studNo = $fetch['stud_no'];
        $this->pdfFile = "../../files/" . $studNo . "/" . $filename;
    }

    public function checkFileExists() {
        if (!file_exists($this->pdfFile)) {
            die("File không tồn tại!");
        }
    }
}

// Kiểm tra và khởi tạo đối tượng
if (isset($_REQUEST['store_id'])) {
    $storeId = $_REQUEST['store_id'];
    $filePreview = new FilePreview($conn, $storeId);
    $filePreview->fetchFile();
    $filePreview->checkFileExists();
    $pdfFile = $filePreview->pdfFile;

    header('Content-Type: text/html; charset=utf-8');
} else {
    die("ID không hợp lệ!");
}
?>
