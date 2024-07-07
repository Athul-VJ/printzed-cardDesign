<?php
session_start();
$track = $_SESSION['trackid'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $targetDir = "users/$track/img/"; // Set the path to your images directory
    $imageName = basename($_POST['imageName']);
    $targetFile = $targetDir . $imageName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    if (isset($_FILES['imageFile']['tmp_name'])) {
        $check = getimagesize($_FILES['imageFile']['tmp_name']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        unlink($targetFile); // Remove the existing file
    }

    // Check file size (limit to 10MB)
    if ($_FILES['imageFile']['size'] > 10000000) { // 10MB in bytes
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedFileTypes)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES['imageFile']['tmp_name'], $targetFile)) {
            echo "The file ". htmlspecialchars($imageName) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
