<!DOCTYPE html>
<?php 
    session_start();
    if(!ISSET($_SESSION['student'])){
        header("location:../../index.php");
    }
    require_once '../model/conn.php';
?>
<html lang="en">
<head>
    <title>Project File Management System</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../admin/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../../admin/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="../../admin/css/style.css" />
    <style>
        /* CSS cho body để sử dụng Flexbox */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            flex: 1;
            width: 35%;  /* Đặt chiều rộng tùy chỉnh */
            margin: 0 auto;  /* Căn giữa */
            margin-top: -20px;  /* Điều chỉnh vị trí của container */
        }

        /* CSS cho panel */
        .panel {
            background-color: #dce2f7; /* Màu nền của panel */
            border-color: #959fc4;
        }

        .panel-heading {
            background-color: #004085; /* Màu nền của phần tiêu đề (xanh đậm) */
            text-align: center;  /* Căn giữa tiêu đề */
            font-weight: bold;
            color: white;  /* Màu chữ đậm và sáng hơn */
            padding: 15px;
        }

        .panel-body {
            padding: 20px;
        }

        h1.panel-title {
            text-align: center;  /* Căn giữa tiêu đề */
            font-weight: bold;  /* In đậm */
        }

        /* Căn giữa nút */
        .btn {
            width: 150px;  /* Cố định chiều rộng cho các nút */
            margin: 10px;  /* Khoảng cách giữa các nút */
            display: inline-block;
            text-align: center;
        }

        /* CSS cho footer */
        #footer {
            text-align: center; /* Căn giữa nội dung trong footer */
            padding: 10px; /* Giảm khoảng cách xung quanh nội dung */
            background-color: #f4f7fa; /* Màu nền cho footer */
            width: 100%; /* Đảm bảo chiều rộng footer đầy đủ */
            margin-top: auto; /* Đảm bảo footer luôn nằm dưới cùng */
        }

        .footer-title {
            font-size: 13px; /* Giảm kích thước chữ */
            color: #333; /* Màu chữ */
        }

        /* CSS cho form */
        form {
            text-align: center;  /* Căn giữa form */
        }

        .form-group label {
            text-align: left;
        }

        .form-group {
            margin-bottom: 15px;  /* Khoảng cách giữa các form-group */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
        <div class="container-fluid">
            <label class="navbar-brand">Project File Management System</label>
        </div>
    </nav>
    
    <div class="col-md-6 container"> <!-- Đổi từ col-md-3 thành col-md-6 -->
        <div class="panel panel-warning" style="margin-top:20%;">
            <div class="panel-heading">
                <h1 class="panel-title">Update Student Information</h1>
            </div>
            <?php
                $query = mysqli_query($conn, "SELECT * FROM `student` WHERE `stud_id` = '$_SESSION[student]'") or die(mysqli_error());
                $fetch = mysqli_fetch_array($query);
            ?>
            <div class="panel-body">
                <form method="POST" action="../model/update_query.php">
                    <div class="form-group">
                        <label>Student no:</label> 
                        <input type="text" class="form-control" value="<?php echo $fetch['stud_no']?>" name="stud_no" readonly="readonly"/>
                        <input type="hidden" value="<?php echo $fetch['stud_id']?>" name="stud_id"/>
                    </div>
                    <div class="form-group">
                        <label>Firstname:</label> 
                        <input type="text" class="form-control" value="<?php echo $fetch['firstname']?>" name="firstname" required="required"/>
                    </div>
                    <div class="form-group">
                        <label>Lastname:</label> 
                        <input type="text" class="form-control" value="<?php echo $fetch['lastname']?>" name="lastname" required="required"/>
                    </div>
                    <div class="form-group" name="gender" required="required">
                        <label>Gender:</label> 
                        <select class="form-control" name="gender">
                            <option value=""></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-inline">
                        <label>Year</label>
                        <select name="year" class="form-control" required="required">
                            <option value=""></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <br />
                    <div class="form-group">
                        <label>Password:</label> 
                        <input type="password" class="form-control" value="" name="password" required="required"/>
                    </div>
                    <a class="btn btn-default" href="student_profile.php">Cancel</a> 
                    <button class="btn btn-warning" name="update"><span class="glyphicon glyphicon-edit"></span> Update</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <div id="footer">
        <label class="footer-title">An Nguyen & Phuong Pham</label>
    </div>

    <?php include '../controller/script.php'?>
</body>
</html>
