<?php
require_once '../model/conn.php';
require_once '../model/download.php';

if (isset($_REQUEST['store_id'])) {
    $store_id = $_REQUEST['store_id'];

    // Tạo đối tượng StorageModel
    $storageModel = new StorageModel($conn);

    // Lấy thông tin file
    $fetch = $storageModel->getFileInfo($store_id);
    if ($fetch) {
        $filename = $fetch['filename'];
        $stud_no = $fetch['stud_no'];
        $pdfFile = "../../files/" . $stud_no . "/" . $filename;

        if (file_exists($pdfFile)) {
            // Thiết lập các header để tải file
            header("Content-Disposition: attachment; filename=" . $filename);
            header("Content-Type: application/octet-stream");
            readfile($pdfFile);
        } else {
            die("File does not exist!");
        }
    } else {
        die("File information not found!");
    }
}
?>
