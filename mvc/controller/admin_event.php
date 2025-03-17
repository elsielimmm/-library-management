<?php include 'script.php'?>
<script type="text/javascript">
$(document).ready(function(){
	$('.btn_remove').on('click', function(){
		var store_id = $(this).attr('id');
		$("#modal_remove").modal('show');
		$('#btn_yes').attr('name', store_id);
	});
	$('.btn-state').on('click', function() {
            // Lấy giá trị từ thuộc tính data-mess
            var message = $(this).data('mess');
            // Hiển thị thông báo
            alert(message);
        });
	 // Khi nhấn nút xác nhận (màu xanh)
	 $('.btn-confirm').on('click', function() {
        var store_id = $(this).data('id'); // Lấy store_id từ thuộc tính data-id
        var state = 1; // Trạng thái xác nhận (1)
        
        // Chữ thông báo yêu cầu nhập
        var message = prompt("Please enter the confirmation message for this file:", "Successful authentication, the file will be posted publicly on the homepage.");

        if (message !== null && message !== "") {
            $.ajax({
                type: "POST",
                url: "../model/update_state.php", // Đường dẫn tới file PHP xử lý
                data: {
                    store_id: store_id,
                    message: message,
                    state: state
                },
                success: function(response) {
                    if (response === 'success') {
                        alert("Verify successful.");
                        location.reload(); // Làm mới trang sau khi cập nhật
                    } else {
                        alert("Error: Could not update the file state.");
                    }
                }
            });
        } else {
            alert("Request canceled.");
        }
    });

    // Khi nhấn nút hủy bỏ (màu đỏ)
    $('.btn-reject').on('click', function() {
        var store_id = $(this).data('id'); // Lấy store_id từ thuộc tính data-id
        var state = 0; // Trạng thái hủy bỏ (0)
        
        // Chữ thông báo yêu cầu nhập
        var message = prompt("Please enter the rejection message for this file:", "Fail authentication, the file will not be posted publicly on the homepage.");

        if (message !== null && message !== "") {
            $.ajax({
                type: "POST",
                url: "../model/update_state.php", // Đường dẫn tới file PHP xử lý
                data: {
                    store_id: store_id,
                    message: message,
                    state: state
                },
                success: function(response) {
                    if (response === 'success') {
                        alert("Verify successful.");
                        location.reload(); // Làm mới trang sau khi cập nhật
                    } else {
                        alert("Error: Could not update the file state.");
                    }
                }
            });
        } else {
            alert("Request canceled.");
        }
    });
	$('#btn_yes').on('click', function(){
		var id = $(this).attr('name');
		$.ajax({
			type: "POST",
			url: "../model/remove_file.php",
			data:{
				store_id: id
			},
			success: function(data){
				$("#modal_remove").modal('hide');
				$(".del_file" + id).empty();
				$(".del_file" + id).html("<td colspan='8'><center class='text-danger'>Deleting...</center></td>");
				setTimeout(function(){
					$(".del_file" + id).fadeOut('slow');
				}, 1000);
				
			}
		});
	});
});
</script>	