
<?php
	include '../model/download.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project File Management System</title>
	<style>
        h1 {
            text-align: center; /* Căn giữa theo chiều ngang */
            margin-top: 20px;  /* Thêm khoảng cách phía trên */
            font-family: Arial, sans-serif; /* Đặt font chữ dễ đọc */
            color: #333; /* Màu chữ */
        }
    </style>
</head>
<body>
    <h1>Preview file PDF</h1>
    <iframe src="<?php echo htmlspecialchars($pdfFile); ?>" style="width:100%; height:90vh;" frameborder="0"></iframe>
</body>
</html>
