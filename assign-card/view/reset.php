<?php
session_start();
$track = $_SESSION['trackid'];
function copyFolder($src, $dst) {
    // Normalize paths
    $src = rtrim($src, '/') . '/';
    $dst = rtrim($dst, '/') . '/';

    // Check if source folder exists
    if (!file_exists($src)) {
        echo "Source folder does not exist.";
        return;
    }

    // Check if destination folder exists
    if (file_exists($dst)) {
        // If destination folder exists and is a file, remove it
        if (!is_dir($dst)) {
            unlink($dst);
        } else {
            // If destination folder exists and is a directory, delete its contents
            $files = glob($dst . '*'); // Get all files in destination folder
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
    } else {
        // Create destination folder if it does not exist
        mkdir($dst, 0755, true);
    }

    // Open the source directory to read in files
    $dir = opendir($src);

    if (!$dir) {
        echo "Failed to open source folder.";
        return;
    }

    // Loop through the files in source directory
    while (($file = readdir($dir)) !== false) {
        // Skip the special folders '.' and '..'
        if ($file != '.' && $file != '..') {
            // Construct full paths for source and destination
            $srcPath = $src . $file;
            $dstPath = $dst . $file;

            // Recursively copy if it's a folder
            if (is_dir($srcPath)) {
                copyFolder($srcPath, $dstPath);
            } else {
                // Copy file
                if (!copy($srcPath, $dstPath)) {
                    echo "Failed to copy $srcPath to $dstPath.";
                }
            }
        }
    }

    closedir($dir);
}

// Example usage:
$sourceFolder = 'sheet-main'; // Replace with your source folder path
$destinationFolder = "users/$track"; // Replace with your destination folder path

copyFolder($sourceFolder, $destinationFolder);
echo "Folder copied successfully.";
?>
