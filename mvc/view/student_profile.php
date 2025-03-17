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
				max-width: 150px;
				word-wrap: break-word;
				white-space: normal;
			}
			td.filename2 {
				max-width: 200px;
				word-wrap: break-word;
				white-space: normal;
			}
			td.filename3 {
				max-width: 100px;
				word-wrap: break-word;
				white-space: normal;
			}
			td.filename4 {
				max-width: 40px;
				word-wrap: break-word;
				white-space: normal;
			}
			#footer {
				text-align: center;
			}

			td > a.btn, td > button.btn {
            display: inline-block;
            margin: 0 5px;
            vertical-align: middle;
            white-space: nowrap;
        	}
        	td {
            white-space: nowrap;
        }
		body {
				font-family: Arial, sans-serif;
				font-size: 13px;
				line-height: 1.6;
			}
			
		</style>
	</head>
<body>
	<!-- Navbar (Header) giữ nguyên kích thước ban đầu -->
	<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
		<div class="container-fluid">
			<label class="navbar-brand">Project File Management System - Student Information</label>
			<a href="#" data-toggle="modal" data-target="#modal_confirm" class="btn btn-danger navbar-btn pull-right" style="margin-right: 10px;">Logout</a>
			<a href="word_to_pdf.php" class="btn btn-success navbar-btn pull-right" style="margin-right: 10px;">Convert word to pdf</a>
			<a href="student_update.php" class="btn btn-warning navbar-btn pull-right" style="margin-right: 10px;">Update Student</a>
			<a href="student_home.php" class="btn btn-primary navbar-btn pull-right" style="margin-right: 10px;">Home</a>
		</div>
	</nav>

	<!-- Main Content -->
	<div class="col-md-8">
		<div class="alert alert-info" style="margin-top:100px;">File List</div>
		<div class="panel panel-default">
			<div class="panel-body alert-success">
				<table id="table" class="table table-bordered">
					<thead>
						<tr>
							<th>Title</th>
							<th>Description</th>
							<th>Faculty</th>
							<th>Date Uploaded</th>
							<th>Action</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$query = mysqli_query($conn, "SELECT * FROM `student` WHERE `stud_id` = '$_SESSION[student]'") or die(mysqli_error());
							$fetch = mysqli_fetch_array($query);
							$stud_no = $fetch['stud_no'];
							$query1 = mysqli_query($conn, "SELECT * FROM `storage` WHERE `stud_no` = '$stud_no'") or die(mysqli_error());
while($fetch1 = mysqli_fetch_array($query1)){
						?>
						<tr class="del_file<?php echo $fetch1['store_id']?>">
							<td class="filename"><?php echo $fetch1['tit']?></td>
							<td class="filename2"><?php echo $fetch1['description']; ?></td>
							<td class="filename3"><?php echo $fetch1['faculty']; ?></td>
							<td><?php echo $fetch1['date_uploaded']?></td>
							<td>
								<a href="preview_file.php?store_id=<?php echo $fetch1['store_id']?>" class="btn btn-success btn-sm" style="margin-right: 10px;">
									<span class="glyphicon glyphicon-eye-open"></span> View
								</a>
								<button class="btn btn-danger btn-sm btn_remove" type="button" id="<?php echo $fetch1['store_id']?>">
									<span class="glyphicon glyphicon-trash"></span> Remove
								</button>
							</td>
							<td class="filename4">
								<?php 
									if ($fetch1['state'] == 2) {
										echo '<button class="btn btn-warning btn-sm btn-state" data-mess="' . htmlspecialchars($fetch1['mess']) . '"><span class="glyphicon glyphicon-option-horizontal"></span></button>';
									} else if ($fetch1['state'] == 0) {
										echo '<button class="btn btn-danger btn-sm btn-state" data-mess="' . htmlspecialchars($fetch1['mess']) . '"><span class="glyphicon glyphicon-remove"></span></button>';
									} else {
										echo '<button class="btn btn-success btn-sm btn-state" data-mess="' . htmlspecialchars($fetch1['mess']) . '"><span class="glyphicon glyphicon-ok"></span></button>';
									}
								?>
							</td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Sidebar with Student Information -->
	<div class="col-md-4">
		<div class="panel panel-primary" style="margin-top:20%;">
			<div class="panel-heading">
				<h1 class="panel-title">Student Information</h1>
			</div>
			<div class="panel-body">
				<h4>Student no: <label class="pull-right"><?php echo $fetch['stud_no']?></label></h4>
				<hr style="border-top:1px dotted #ccc;"/>
				<h4>Name: <label class="pull-right"><?php echo $fetch['firstname']." ".$fetch['lastname']?></label></h4>
				<hr style="border-top:1px dotted #ccc;"/>
				<h4>Gender: <label class="pull-right"><?php echo $fetch['gender']?></label></h4>
				<hr style="border-top:1px dotted #ccc;"/>
				<h4>Year: <label class="pull-right"><?php echo $fetch['yr']?></label></h4>
				<hr style="border-top:1px dotted #ccc;"/>
				<h3>File</h3>
				<form method="POST" enctype="multipart/form-data" action="../model/save_file.php">
					<input type="file" name="file" size="4" style="background-color:#fff;" required="required" accept=".pdf"/>
					<br />
					<label for="tit">Title</label>
					<textarea name="tit" id="tit" class="form-control" rows="4" placeholder="Enter file title"></textarea>
					<br />
					<br />
					<label for="description">Description</label>
<textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter file description"></textarea>
					<br />
					<br />
					<label for="faculty">Faculty</label>
					<select name="faculty" id="faculty" class="form-control">
						<option value="Mechanical Engineering">Mechanical Engineering</option>
						<option value="Information Technology">Information Technology</option>
						<option value="Transportation Mechanical Engineering">Transportation Mechanical Engineering</option>
						<option value="Thermal And Refrigeration Engineering">Thermal And Refrigeration Engineering</option>
						<option value="Electrical Engineering">Electrical Engineering</option>
						<option value="Electronics And Communication Engineering">Electronics And Communication Engineering</option>
						<option value="Chemical Engineering">Chemical Engineering</option>
						<option value="Road And Bridge Engineering">Road And Bridge Engineering</option>
						<option value="Civil Engineering">Civil Engineering</option>
						<option value="Water Resourses Engineering">Water Resourses Engineering</option>
						<option value="Environment">Environment</option>
						<option value="Project Management">Project Management</option>
						<option value="Architecture">Architecture</option>
						<option value="Advanced Science and Technology">Advanced Science and Technology</option>
					</select>
					<br />
					<input type="hidden" name="stud_no" value="<?php echo $fetch['stud_no']?>"/>
					<button class="btn btn-success btn-sm" name="save"><span class="glyphicon glyphicon-plus"></span> Add File</button>
				</form>
				<br style="clear:both;"/>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<div id="footer">
		<label class="footer-title">An Nguyen & Phuong Pham</label>
	</div>
	<style>
    /* Đảm bảo nút View và Remove nằm cạnh nhau */
    td > a.btn, td > button.btn {
        display: inline-block;
        margin: 0 5px;
        white-space: nowrap; /* Không xuống dòng */
    }
</style>

	<!-- Modal Confirm Logout -->
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

	<!-- Modal Remove File -->
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

	<?php include '../controller/student_profile_event.php'?>
</body>
</html>