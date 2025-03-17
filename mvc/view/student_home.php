<!DOCTYPE html>
<?php 
	session_start();
	if(!ISSET($_SESSION['student'])){
		header("location:../../index.php");
	}
	require_once '../model/conn.php'
?>
<html lang="en">
	<head>
		<title>Project File Management System</title>
		<meta charset = "utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="../../admin/css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../../admin/css/jquery.dataTables.css" />
		<link rel="stylesheet" type="text/css" href="../../admin/css/style.css" />
		<style>
    /* Cột Filename */
    td.filename {
        max-width: 150px;  /* Đặt chiều rộng tối đa cho cột */
        word-wrap: break-word; /* Cho phép xuống dòng */
        white-space: normal;  /* Không giữ nguyên khoảng trắng */
    }
		    /* Cột Filename */
			td.filename2 {
        max-width: 200px;  /* Đặt chiều rộng tối đa cho cột */
        word-wrap: break-word; /* Cho phép xuống dòng */
        white-space: normal;  /* Không giữ nguyên khoảng trắng */
    }
	/* Cột Filename */
	td.filename3 {
        max-width: 100px;  /* Đặt chiều rộng tối đa cho cột */
        word-wrap: break-word; /* Cho phép xuống dòng */
        white-space: normal;  /* Không giữ nguyên khoảng trắng */
    }
	td.filename4 {
        max-width: 40px;  /* Đặt chiều rộng tối đa cho cột */
        word-wrap: break-word; /* Cho phép xuống dòng */
        white-space: normal;  /* Không giữ nguyên khoảng trắng */
    }
	td.filename5 {
        max-width: 60px;  /* Đặt chiều rộng tối đa cho cột */
        word-wrap: break-word; /* Cho phép xuống dòng */
        white-space: normal;  /* Không giữ nguyên khoảng trắng */
    }
	#footer {
            text-align: center; /* Căn giữa nội dung theo chiều ngang */
        }
</style>
	</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
		<div class="container-fluid">
			<label class="navbar-brand">Project File Management System - Home Page</label>
            <a href="student_profile.php" class="btn btn-primary navbar-btn pull-right" style="margin-right: 10px;">Student Information</a>
		</div>
	</nav>
	<div class="">
		<div class="alert alert-info" style="margin-top:100px;">File List</div>
		<div class="panel panel-default">
			<div class="panel-body alert-success" >
				
				<table id="table" class="table table-bordered">
					<thead>
						<tr>
							<th>Title</th>
							<th>Description</th>
							<th>Faculty</th>
							<th>Date Uploaded</th>
                            <th>Name</th>
							<th>Action</th>
						</tr>
					</thead>
                    <tbody>
    <?php
        // Truy vấn lấy tất cả các file từ bảng storage và thông tin sinh viên từ bảng student
        $query = mysqli_query($conn, "SELECT storage.*, student.firstname, student.lastname FROM `storage` JOIN `student` ON storage.stud_no = student.stud_no WHERE storage.state = 1") or die(mysqli_error());
        
        // Duyệt qua từng kết quả và hiển thị thông tin
        while($fetch1 = mysqli_fetch_array($query)){
    ?>
    <tr class="del_file<?php echo $fetch1['store_id']?>">
	<td class="filename"><?php echo $fetch1['tit']?></td> <!-- Hiển thị đầy đủ filename -->
	<td class="filename2"><?php echo $fetch1['description']; ?></td>
	<td class="filename3"><?php echo $fetch1['faculty']; ?></td>
        <td><?php echo $fetch1['date_uploaded']?></td>
        <td><?php echo $fetch1['firstname'] . ' ' . $fetch1['lastname']?></td>
        <td><a href="preview_file.php?store_id=<?php echo $fetch1['store_id']?>" class="btn btn-success"><span class="glyphicon glyphicon-eye-open"></span> View</a> 
    </tr>
    <?php
        }
    ?>
</tbody>

				</table>
			</div>
		</div>
	</div>
	
	<div id = "footer">
		<label class = "footer-title"> An Nguyen & Phuong Pham </label>
	</div>
	<div class="modal fade" id="modal_confirm" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">System</h3>
				</div>
				<div class="modal-body">
					<center><h4 class="text-danger">Are you sure you want to logout?</h4></center>
				</div>
				<div class="modal-footer">
					<a type="button" class="btn btn-success" data-dismiss="modal">Cancel</a>
					<a href="../controller/logout.php" class="btn btn-danger">Logout</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_remove" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">System</h3>
				</div>
				<div class="modal-body">
					<center><h4 class="text-danger">Are you sure you want to remove this file?</h4></center>
				</div>
				<div class="modal-footer">
					<a type="button" class="btn btn-success" data-dismiss="modal">No</a>
					<button type="button" class="btn btn-danger" id="btn_yes">Yes</button>
				</div>
			</div>
		</div>
	</div>
<?php include '../controller/student_home_event.php'?>

</body>
</html>