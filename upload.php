
<?php
$uploadDir = 'content/'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"];
    if ($file["error"] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code " . $file["error"]);
    }
    $uploadPath = $uploadDir . basename($file["name"]);
    if (move_uploaded_file($file["tmp_name"], $uploadPath)) {
        echo "File uploaded successfully.";
    } else {
        echo "Error uploading file.";
    }
}
?>
