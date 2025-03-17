<?php 
    
    require_once '../model/conn.php';

    // Xử lý tệp CSV khi form được submit
    if (isset($_POST['upload'])) {
        $file = $_FILES['csv_file']['tmp_name'];
        if ($_FILES['csv_file']['type'] == 'text/csv') {
            $handle = fopen($file, 'r');
            while (($data = fgetcsv($handle)) !== FALSE) {
                // Giả sử CSV có định dạng: ID, Firstname, Lastname, Gender, Year, Password
                $stud_no = $data[0];
                $firstname = $data[1];
                $lastname = $data[2];
                $gender = $data[3];
                $year = $data[4];
                $password = md5($data[5]);  // Mã hóa mật khẩu
                
                // Thêm sinh viên vào cơ sở dữ liệu
                $query = "INSERT INTO student (stud_no, firstname, lastname, gender, yr, password) VALUES ('$stud_no', '$firstname', '$lastname', '$gender', '$year', '$password')";
                mysqli_query($conn, $query);
            }
            fclose($handle);
            echo "<script>alert('Student list uploaded successfully.');</script>";
        } else {
            echo "<script>alert('Please upload a valid CSV file.');</script>";
        }
        echo "<script>window.location = '../view/student.php'</script>";
    }
?>