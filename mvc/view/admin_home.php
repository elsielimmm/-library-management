<!DOCTYPE html> 
<?php 
    require '../controller/validator.php';
    require_once '../model/conn.php';
?>
<html lang="en">
<head>
    <title>Project File Management System</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../admin/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../../admin/css/style.css" />
    <style>
        /* Khóa cuộn trang */
        body, html {
            overflow: hidden;
            height: 100%;
            font-family: Arial, sans-serif; /* Thêm font dễ nhìn */
            background: linear-gradient(to right, #ffffff, #bac6d1); /* Gradient nền đẹp */
        }

        /* Thêm màu nền và căn chỉnh cho Mission và Vision */
        .alert {
            background-color: #f0f8ff; /* Nền xanh nhạt cho các alert */
            border-color: #007bff; /* Viền xanh đậm */
            color: #004085; /* Màu chữ xanh đậm */
        }

        .alert h3 {
            font-weight: bold;
        }

        /* Thẻ thông tin về Mission và Vision */
        .info-card {
            background-color: #ffffff; /* Nền trắng cho các thẻ thông tin */
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease; /* Hiệu ứng khi hover */
        }

        .info-card:hover {
            background-color: #f8f9fa; /* Nền sáng khi hover */
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2); /* Tăng độ đổ bóng khi hover */
        }

        .info-card h4 {
            font-weight: bold;
            color: #004085;
        }

        .info-card .glyphicon {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 10px;
        }

        /* Đảm bảo các phần content có khoảng cách đẹp */
        #content {
            margin-top: 80px;
        }

        /* CSS cho footer */
        #footer {
            display: flex; /* Sử dụng flexbox */
            justify-content: center; /* Căn giữa nội dung theo chiều ngang */
            align-items: center; /* Căn giữa nội dung theo chiều dọc */
            padding: 15px; /* Thêm khoảng cách bên trong footer */
            background-color: #007bff; /* Màu nền xanh đậm cho footer */
            margin-top: 30px; /* Khoảng cách giữa content và footer */
            color: white; /* Chữ màu trắng */
        }

        /* Chỉnh sửa màu chữ trong footer thành đen */
        .footer-title {
            font-size: 14px;
            color: black; /* Thay đổi màu chữ thành đen */
        }

        /* Chỉnh sửa cho lời chào Welcome */
        .welcome-message {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            color: #007bff; /* Màu chữ của lời chào */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
        <div class="container-fluid">
            <label class="navbar-brand">Project File Management System</label>
            <?php 
                $query = mysqli_query($conn, "SELECT * FROM `user` WHERE `user_id` = '$_SESSION[user]'") or die(mysqli_error());
                $fetch = mysqli_fetch_array($query);
            ?>
            <ul class="nav navbar-right">  
                <li class="dropdown">
                    <a class="user dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-user"></span>
                        <?php 
                            echo $fetch['firstname']." ".$fetch['lastname'];
                        ?>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_home_view_file.php"><i class="glyphicon glyphicon-home"></i> Home</a></li>
                        <li><a href="../controller/admin_logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <?php include 'sidebar.php'?>

    <div id="content" class="container">
        <!-- Thẻ Mission -->
        <div class="row">
            <div class="col-md-6">
                <div class="info-card">
                    <span class="glyphicon glyphicon-flag"></span>
                    <h4>Mission</h4>
                    <p>Our mission is to provide an easy-to-use platform for students to upload their projects and receive feedback from instructors.</p>
                </div>
            </div>
            <!-- Thẻ Vision -->
            <div class="col-md-6">
                <div class="info-card">
                    <span class="glyphicon glyphicon-eye-open"></span>
                    <h4>Vision</h4>
                    <p>Our vision is to become the leading platform for student project submissions, enhancing the learning experience.</p>
                </div>
            </div>
        </div>

        <!-- Thẻ Welcome to Admin Page! -->
        <div class="row">
            <div class="col-md-12">
                <div class="info-card">
                    <span class="glyphicon glyphicon-globe"></span> <!-- Icon -->
                    <h4>Welcome to Admin Page!</h4> <!-- Tiêu đề -->
                    <p>We are glad to have you here. Manage the files and oversee the platform's functionality with ease.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Căn giữa footer -->
    <div id="footer">
        <label class="footer-title">An Nguyen & Phuong Pham</label>
    </div>

    <?php include '../controller/admin_script.php'?>  
</body>
</html>
