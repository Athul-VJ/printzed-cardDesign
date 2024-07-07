<?php
session_start();
$track = $_SESSION['trackid'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $heading = $_POST['heading'];
    $tagline = $_POST['tagline'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $website = $_POST['website'];
    $address = $_POST['address'];

    // Define the path to your text file
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
        $prevHeading = $_SESSION['prev_heading'] ?? 'PrintZed';
        $prevTagline = $_SESSION['prev_tagline'] ?? 'Design and printing solutions';
        $prevMobile = $_SESSION['prev_mobile'] ?? '+97 52 538 6869';
        $prevEmail = $_SESSION['prev_email'] ?? 'sales@printzed.ae';
        $prevWebsite = $_SESSION['prev_website'] ?? 'printzed.ae';
        $prevAddress = $_SESSION['prev_address'] ?? 'Near Canadian Hospital Abu Hail,Dubai-UAE';

        // Replace the old content with the new content
        $updatedContent = str_replace([
            $prevHeading,
            $prevTagline,
            $prevMobile,
            $prevEmail,
            $prevWebsite,
            $prevAddress
        ], [
            $heading,
            $tagline,
            $mobile,
            $email,
            $website,
            $address
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
            $_SESSION['prev_heading'] = $heading;
            $_SESSION['prev_tagline'] = $tagline;
            $_SESSION['prev_mobile'] = $mobile;
            $_SESSION['prev_email'] = $email;
            $_SESSION['prev_website'] = $website;
            $_SESSION['prev_address'] = $address;

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
