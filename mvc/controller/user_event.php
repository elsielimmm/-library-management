<?php include 'admin_script.php'?>
<script type="text/javascript">
$(document).ready(function(){
	$('.btn-delete').on('click', function(){
		var user_id = $(this).attr('id');
		$("#modal_confirm").modal('show');
		$('#btn_yes').attr('name', user_id);
	});
	$('#btn_yes').on('click', function(){
		var id = $(this).attr('name');
		$.ajax({
			type: "POST",
			url: "../model/delete_user.php",
			data:{
				user_id: id
			},
			success: function(){
				$("#modal_confirm").modal('hide');
				$(".del_user" + id).empty();
				$(".del_user" + id).html("<td colspan='10'><center class='text-danger'>Deleting...</center></td>");
				setTimeout(function(){
					$(".del_user" + id).fadeOut('slow');
				}, 1000);
			}
		});
	});
});
</script>