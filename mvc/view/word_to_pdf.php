<?php
include '../controller/convert_file.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convert Word to PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            text-align: center;
            position: relative;
        }
        .message.success {
            background-color: #28a745;
            color: white;
        }
        .message.error {
            background-color: #dc3545;
            color: white;
        }
        .message .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
            font-size: 18px;
            color: white;
        }
        iframe {
            margin-top: 2px;  /* Adjusted margin-top to move the iframe up */
            width: 100%;
            height: 600px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-file-upload"></i> Choose a Word file to convert to PDF</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="word_file" accept=".docx,.doc" required>
            </div>
            <button type="submit" name="submit" class="btn">Convert</button>
        </form>

        <?php if (isset($message) && $message != ''): ?>
            <div class="message <?php echo isset($result['success']) && $result['success'] ? 'success' : 'error'; ?>">
                <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($result['success']) && $result['success']): ?>
            <h4>Preview the PDF file:</h4>
            <iframe src="<?php echo $result['pdfLink']; ?>" frameborder="0"></iframe>
        <?php endif; ?>
    </div>
</body>
</html>
