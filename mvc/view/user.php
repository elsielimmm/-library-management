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
			<ul class="nav navbar-right">	
				<li class="dropdown">
					<a class="user dropdown-toggle" data-toggle = "dropdown" href = "#">
						<span class="glyphicon glyphicon-user"></span>
						<?php 
							echo $fetch['firstname']." ".$fetch['lastname'];
						?>
						<b class="caret"></b>
					</a>
				<ul class="dropdown-menu">
					<li>
					<a href="admin_home_view_file.php"><i class="glyphicon glyphicon-home"></i> Home</a>
						<a href="../controller/admin_logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
					</li>
				</ul>
				</li>
			</ul>
		</div>
	</nav>
	<?php include 'sidebar.php'?>
	<div id = "content">
		<br /><br /><br />
		<div class="alert alert-info"><h3>Accounts / Users</h3></div> 
		<button class="btn btn-success" data-toggle="modal" data-target="#form_modal"><span class="glyphicon glyphicon-plus"></span> Add User</button>
		<br /><br />
		<table id = "table" class="table table-bordered">
			<thead>
				<tr>
					<th>Firstname</th>
					<th>Lastname</th>
					<th>Username</th>
					<th>Password</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = mysqli_query($conn, "SELECT * FROM `user`") or die(mysqli_error());
					while($fetch = mysqli_fetch_array($query)){
				?>
				<?php 
					if($fetch['status'] != "administrator" || $_SESSION['status'] == $fetch['status']){
				?>	
					<tr class="del_user<?php echo $fetch['user_id']?>">
						<td><?php echo $fetch['firstname']?></td>
						<td><?php echo $fetch['lastname']?></td>
						<td><?php echo $fetch['username']?></td>
						<td>********</td>
						<td><?php echo $fetch['status']?></td>
						<td><center><button class="btn btn-warning" data-toggle="modal" data-target="#edit_modal<?php echo $fetch['user_id']?>"><span class="glyphicon glyphicon-edit"></span> Edit</button> 
						<?php
							if($fetch['status'] != "administrator"){
						?>
							| <button class="btn btn-danger btn-delete" id="<?php echo $fetch['user_id']?>" type="button"><span class="glyphicon glyphicon-trash"></span> Delete</button></center></td>
						<?php
							}
						?>
					</tr>
					
					<div class="modal fade" id="edit_modal<?php echo $fetch['user_id']?>" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<form method="POST" action="../model/update_user.php">	
									<div class="modal-header">
										<h4 class="modal-title">Update User</h4>
									</div>
									<div class="modal-body">
										<div class="col-md-3"></div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Firstname</label>
												<input type="hidden" name="user_id" value="<?php echo $fetch['user_id']?>"/>
												<input type="text" name="firstname" value="<?php echo $fetch['firstname']?>" class="form-control" required="required"/>
											</div>
											<div class="form-group">
												<label>Lastname</label>
												<input type="text" name="lastname" value="<?php echo $fetch['lastname']?>" class="form-control" required="required"/>
											</div>
											<div class="form-group">
												<label>Username</label>
												<input type="text" name="username" value="<?php echo $fetch['username']?>" class="form-control" required="required"/>
											</div>
											<div class="form-group">
												<label>Password</label>
												<input type="password" name="password" class="form-control" required="required"/>
											</div>
											<div class="form-group">
												<label>Status</label>
												<?php
													if($fetch['status'] != "administrator"){
												?>
													<input type="text" name="status" value="Regular" class="form-control" readonly="readonly" required="required"/>
												<?php
													}else{
												?>
													<input type="text" name="status" value="administrator" class="form-control" readonly="readonly" required="required"/>
												<?php
													}
												?>
											</div>
										</div>
									</div>
									<div style="clear:both;"></div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
										<button name="edit" class="btn btn-warning" ><span class="glyphicon glyphicon-save"></span> Update</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					
					
				<?php
					}
				?>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="modal fade" id="modal_confirm" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">System</h3>
				</div>
				<div class="modal-body">
					<center><h4 class="text-danger">Are you sure you want to delete this data?</h4></center>
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
				<form method="POST" action="../model/save_user.php">	
					<div class="modal-header">
						<h4 class="modal-title">Add User</h4>
					</div>
					<div class="modal-body">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Firstname</label>
								<input type="text" name="firstname" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Lastname</label>
								<input type="text" name="lastname" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Username</label>
								<input type="text" name="username" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" name="password" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Status</label>
								<input type="text" name="status" value="Regular" class="form-control" readonly="readonly" required="required"/>
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
	

<?php include '../controller/user_event.php'?>
</body>
</html>