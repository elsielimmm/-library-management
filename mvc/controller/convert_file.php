<?php
// Function to convert Word to PDF
function convertWordToPdf($file)
{
    if (isset($file['word_file'])) {
        $fileName = $file['word_file']['name'];
        $fileTmpPath = $file['word_file']['tmp_name'];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        // Check file type (only accept .doc and .docx)
        if (strtolower($fileExt) == 'docx' || strtolower($fileExt) == 'doc') {
            // Directory to store the Word file
            $uploadDir = '../../uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create uploads directory if it doesn't exist
            }

            $uploadFilePath = $uploadDir . $fileName;

            // Move file from temporary location to uploads directory
            if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
                // Directory to store the PDF output
                $outputDir = '../../uploads/pdf/';
                if (!file_exists($outputDir)) {
                    mkdir($outputDir, 0777, true); // Create PDF directory if it doesn't exist
                }

                // Get the file name without extension
                $fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);
                $outputFilePath = $outputDir . $fileNameWithoutExtension . '.pdf';

                // Full path to soffice.exe (update according to the path on your machine)
                $libreOfficePath = 'C:\\Program Files\\LibreOffice\\program\\soffice.exe'; 

                // Command to convert Word to PDF
                $command = '"' . $libreOfficePath . '" --headless --convert-to pdf --outdir ' . escapeshellarg($outputDir) . ' ' . escapeshellarg($uploadFilePath);

                // Execute the command
                exec($command, $output, $resultCode);

                // Check result
                if ($resultCode == 0) {
                    return ['success' => true, 'pdfLink' => $outputFilePath];
                } else {
                    return ['success' => false, 'error' => 'An error occurred during the file conversion process!'];
                }
            } else {
                return ['success' => false, 'error' => 'An error occurred when storing the Word file!'];
            }
        } else {
            return ['success' => false, 'error' => 'Please select a Word file (.doc or .docx)!'];
        }
    }
    return ['success' => false, 'error' => 'No file was uploaded!'];
}

// Variable to hold the result message
$message = '';
$result = [];

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Call the function to handle the upload and conversion
    $result = convertWordToPdf($_FILES);

    // Check the result and create a message
    if ($result['success']) {
        $message = 'The file has been successfully converted!';
    } else {
        $message = $result['error'];
    }
}
?>