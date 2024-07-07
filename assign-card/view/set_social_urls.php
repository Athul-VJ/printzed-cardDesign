<?php
session_start();
$track = $_SESSION['trackid'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instagram = $_POST['instagram'];
    $facebook = $_POST['facebook'];
    $whatsapp = $_POST['whatsapp'];
    $website = $_POST['website'];

    // Define the path to your HTML file
    $filePath = "users/$track/index.html";

    // Check if the file exists
    if (file_exists($filePath)) {
        // Read the file content
        $fileContent = file_get_contents($filePath);

        if ($fileContent === false) {
            echo "Failed to read file content.";
            exit;
        }

        // Retrieve previous values from session or set defaults if not present
        $prevInstagram = $_SESSION['prev_instagram'] ?? 'https://www.instagram.com/url';
        $prevFacebook = $_SESSION['prev_facebook'] ?? 'https://www.facebook.com/url';
        $prevWhatsapp = $_SESSION['prev_whatsapp'] ?? 'https://api.whatsapp.com/url';
        $prevWebsite = $_SESSION['prev_website'] ?? 'https://website/url';

        // Replace the old content with the new content
        $updatedContent = str_replace([
            $prevInstagram,
            $prevFacebook,
            $prevWhatsapp,
            $prevWebsite
        ], [
            $instagram,
            $facebook,
            $whatsapp,
            $website
        ], $fileContent);

        // Write the updated content back to the file
        $writeResult = file_put_contents($filePath, $updatedContent);

        if ($writeResult === false) {
            echo "Failed to write updated content to file.";
            exit;
        }

        // Read the file again to confirm changes
        $finalContent = file_get_contents($filePath);

        // Verify the changes
        if ($finalContent === $updatedContent) {
            // Store the new values in the session for future use
            $_SESSION['prev_instagram'] = $instagram;
            $_SESSION['prev_facebook'] = $facebook;
            $_SESSION['prev_whatsapp'] = $whatsapp;
            $_SESSION['prev_website'] = $website;

            // Redirect to main.php after successful update
            header("Location: main.php");
            exit;
        } else {
            echo "File update failed. Changes did not persist.";
        }

    } else {
        echo "File does not exist.";
    }
} else {
    echo "Invalid request method.";
}
?>
