<!DOCTYPE html>
<?php 
	require '../controller/validator.php';
	require_once '../model/conn.php'
?>
<html lang = "en">
	<head>
		<title>Project File Management System</title>
		<meta charset = "utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel = "stylesheet" type = "text/css" href = "../../admin/css/bootstrap.css" />
		<link rel = "stylesheet" type = "text/css" href = "../../admin/css/jquery.dataTables.css" />
		<link rel = "stylesheet" type = "text/css" href = "../../admin/css/style.css" />
		<style>
            #footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                text-align: center;
                background-color: #f8f9fa;
                padding: 10px 0;
                border-top: 1px solid #ddd;
            }
            .footer-title {
                font-weight: bold;
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
			<ul class = "nav navbar-right">	
				<li class = "dropdown">
					<a class = "user dropdown-toggle" data-toggle = "dropdown" href = "#">
						<span class = "glyphicon glyphicon-user"></span>
						<?php 
							echo $fetch['firstname']." ".$fetch['lastname'];
						?>
						<b class = "caret"></b>
					</a>
				<ul class = "dropdown-menu">
					<li>
					<a href="admin_home_view_file.php"><i class="glyphicon glyphicon-home"></i> Home</a>
						<a href = "../controller/admin_logout.php"><i class = "glyphicon glyphicon-log-out"></i> Logout</a>
					</li>
				</ul>
				</li>
			</ul>
		</div>
	</nav>
	<?php include 'sidebar.php'?>
	<div id = "content">
		<br /><br /><br />
		<div class="alert alert-info"><h3>Accounts / Students</h3></div> 
		<button class="btn btn-success" data-toggle="modal" data-target="#form_modal"><span class="glyphicon glyphicon-plus"></span> Add Student</button>
		<button class="btn btn-primary" data-toggle="modal" data-target="#upload_csv_modal"><span class="glyphicon glyphicon-upload"></span> Upload CSV</button>
		<br /><br />
		<table id = "table" class="table table-bordered">
			<thead>
				<tr>
					<th>Student no</th>
					<th>Firstname</th>
					<th>Lastname</th>
					<th>Gender</th>
					<th>Year</th>
					<th>Password</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = mysqli_query($conn, "SELECT * FROM `student`") or die(mysqli_error());
					while($fetch = mysqli_fetch_array($query)){
				?>
					<tr class="del_student<?php echo $fetch['stud_id']?>">
						<td><?php echo $fetch['stud_no']?></td>
						<td><?php echo $fetch['firstname']?></td>
						<td><?php echo $fetch['lastname']?></td>
						<td><?php echo $fetch['gender']?></td>
						<td><?php echo $fetch['yr']?></td>
						<td>********</td>
						<td><center><button class="btn btn-warning" data-toggle="modal" data-target="#edit_modal<?php echo $fetch['stud_id']?>"><span class="glyphicon glyphicon-edit"></span> Edit</button> 
						<button class="btn btn-danger btn-delete" id="<?php echo $fetch['stud_id']?>" type="button"><span class="glyphicon glyphicon-trash"></span> Delete</button></center></td>
					</tr>
	<div class="modal fade" id="edit_modal<?php echo $fetch['stud_id']?>" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form method="POST" action="../model/update_student.php">	
					<div class="modal-header">
						<h4 class="modal-title">Update Student</h4>
					</div>
					<div class="modal-body">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Student no</label>
								<input type="hidden" name="stud_id" value="<?php echo $fetch['stud_id']?>" class="form-control"/>
								<input type="number" name="stud_no" value="<?php echo $fetch['stud_no']?>" class="form-control" readonly="readonly"/>
							</div>
							<div class="form-group">
								<label>Firstname</label>
								<input type="text" name="firstname" value="<?php echo $fetch['firstname']?>" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Lastname</label>
								<input type="text" name="lastname" value="<?php echo $fetch['lastname']?>" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Gender</label>
								<select name="gender" class="form-control" required="required">
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
								<label>Password</label>
								<input type="password" name="password" class="form-control" required="required"/>
							</div>
						</div>
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
						<button name="update" class="btn btn-warning" ><span class="glyphicon glyphicon-save"></span> Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>

	<div class="modal fade" id="upload_csv_modal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form method="POST" action="../model/upload_csv.php" enctype="multipart/form-data"> 
					<div class="modal-header">
						<h4 class="modal-title">Upload CSV</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Choose CSV File</label>
							<input type="file" name="csv_file" class="form-control" accept=".csv" required="required"/>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
						<button type="submit" name="upload" class="btn btn-primary"><span class="glyphicon glyphicon-upload"></span> Upload</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_confirm" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">System</h3>
				</div>
				<div class="modal-body">
					<center><h4 class="text-danger">All files of the student will also be deleted.</h4></center>
					<center><h3 class="text-danger">Are you sure you want to delete this data?</h3></center>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" id="btn_yes">Yes</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="form_modal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form method="POST" action="../model/save_student.php">	
					<div class="modal-header">
						<h4 class="modal-title">Add Student</h4>
					</div>
					<div class="modal-body">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Student no</label>
								<input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="5" name="stud_no" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Firstname</label>
								<input type="text" name="firstname" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Lastname</label>
								<input type="text" name="lastname" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Gender</label>
								<select name="gender" class="form-control" required="required">
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
								<label>Password</label>
								<input type="password" name="password" class="form-control" required="required"/>
							</div>
						</div>
					</div>
					<div style="clear:both;"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
						<button name="save" class="btn btn-success" ><span class="glyphicon glyphicon-save"></span> Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="footer">
        <label class="footer-title">An Nguyen & Phuong Pham</label>
    </div>
	<?php 
	include '../controller/student_event.php';
	
?>
</body>
</html>