<?php
session_start();

// Ensure $id is set from the GET parameter if provided, otherwise default to 0
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$_SESSION['check'] = $_SESSION['flag'] ?? 0;

if ($_SESSION['check'] == 1) {
    function copyFolder($src, $dst) {
        // Check if source folder exists
        if (!file_exists($src)) {
            echo "Source folder does not exist.";
            return;
        }

        // Create destination folder if it does not exist
        if (!file_exists($dst)) {
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
                $srcPath = $src . '/' . $file;
                $dstPath = $dst . '/' . $file;

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

    $track = $_SESSION['trackid']; // You need to set this variable somewhere in your code
    $sourceFolder = 'sheet-main';
    $destinationFolder = "users/$track"; // Use double quotes to parse the variable

    // Only copy if the destination folder is empty (i.e., initial setup)
    if (!file_exists($destinationFolder) || count(scandir($destinationFolder)) == 2) {
        copyFolder($sourceFolder, $destinationFolder);
    }

    // Set flag to prevent future copying
    $_SESSION['flag'] = 0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Editor</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Additional CSS styles can be added here */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-column">
            <!-- Image and text -->
            <nav class="navbar navbar-light bg-light">
                <div class="dropdown">
                    <button class="dropbtn"><p>Welcome <?= $_SESSION['name'] ?></p></button>
                    <div class="dropdown-content">
                        <a href="index.php">Logout</a>
                    </div>
                </div>
            </nav>
            <h2>Tools</h2>
            <table border="1">
                <tr>
                    <td>
                        <table border="2" cellpadding="5" cellspacing="0" style="text-align: center;">
                            <tr>
                                <td><img src="images/icons8-add-50.png" id="disable" data-name="icons8-add-50" alt="Image" class="img-fluid" width="30" height="30" style="cursor:pointer;display:<?php if ($_SESSION['check'] == 1) { echo "none"; } ?>"></td>
                                <td style="display:<?php if ($_SESSION['check'] == 0) { echo "none"; } ?>" class="di"><img src="images/text.png" class="myImage" data-name="text" alt="Image" class="img-fluid" width="30" height="30" style="cursor:pointer;"></td>
                            </tr>
                            <tr>
                                <td style="display:<?php if ($_SESSION['check'] == 0) { echo "none"; } ?>" class="di"><img src="images/image.png" class="uploadImage" data-name="image" alt="Image" class="img-fluid" width="30" height="30" style="cursor:pointer;"></td>
                                <td style="display:<?php if ($_SESSION['check'] == 0) { echo "none"; } ?>" class="di"><img src="images/logo.png" data-name="logo" alt="Image" class="img-fluid" width="30" height="30" style="cursor:pointer;"></td>
                            </tr>
                            <tr>
                                <td style="display:<?php if ($_SESSION['check'] == 0) { echo "none"; } ?>" class="di"><a href="reset.php"><img src="images/reset.png" data-name="reset" alt="Image" class="img-fluid" width="30" height="30" style="cursor:pointer;"></a></td>
                                <td style="display:<?php if ($_SESSION['check'] == 0) { echo "none"; } ?>" class="di"><img src="images/download.png" data-name="download" alt="Image" class="img-fluid" width="30" height="30" style="cursor:pointer;" onclick="placed()"></td>
                            </tr>
                        </table>
                    </td>
                    <td style="text-align: center; padding: 6px;">
                        <p id="msgs">Not everyone Can Design</p>
                    </td>
                </tr>
            </table>
            <div class="tools">
                <!-- Add your editing tools here -->
                <button class="title-button">Edit Title</button>
                <button>Edit Content</button>
                <button>Edit Images</button>
                <!-- Add more tools as needed -->
            </div>
        </div>
        <div class="right-column">
            <div class="iphone-mockup">
                <div class="iphone-header"></div>
                <iframe src="http://localhost/dashboard/assign-card/view/sheet-main/index.html" class="iphone-screen" id="lin"></iframe>
                <div class="iphone-footer"></div>
            </div>
        </div>
    </div>
    <!-- Modal for editing text -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Custom Modal</h2>
            <div class="modal-body">
                <form action="edit_text_file.php" method="post">
                    <label for="heading">Change Heading:</label>
                    <input type="text" id="heading" name="heading" required>
                    <br>
                    <label for="tagline">Change Tagline:</label>
                    <input type="text" id="tagline" name="tagline" required>
                    <br>
                    <label for="mobile">Change Mobile Number:</label>
                    <input type="text" id="mobile" name="mobile" required>
                    <br>
                    <label for="email">Change Email:</label>
                    <input type="email" id="email" name="email" required>
                    <br>
                    <label for="website">Change Website:</label>
                    <input type="text" id="website" name="website" required>
                    <br>
                    <label for="address">Change Address:</label>
                    <input type="text" id="address" name="address" required>
                    <br>
                    <button>Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="saveButton" style="display:none">Save Changes</button>
                <button id="cancelButton" style="display:none">Cancel</button>
            </div>
        </div>
    </div>
    <!-- Modal for uploading images -->
    <div id="uploadModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Upload Image</h2>
            <div class="modal-body">
            <form action="upload_image.php" method="post" enctype="multipart/form-data">
                <label for="imageFile">Select image to upload:</label>
                <input type="file" id="imageFile" name="imageFile" required>
                <br>
                <label for="imageName">Enter desired name (with extension, e.g., image.jpg):</label>
                <input type="text" id="imageName" name="imageName" value="IMG_7190.jpg" style="display:none;">
                <br>
                <button type="submit">Upload</button>
            </form>
            </div>
        </div>
    </div>
    <!-- Modal for setting social media URLs -->
    <div id="socialModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Set Social Media URLs</h2>
            <div class="modal-body">
                <form action="set_social_urls.php" method="post">
                    <label for="instagram">Instagram URL:</label>
                    <input type="url" id="instagram" name="instagram" required>
                    <br>
                    <label for="facebook">Facebook URL:</label>
                    <input type="url" id="facebook" name="facebook" required>
                    <br>
                    <label for="whatsapp">WhatsApp URL:</label>
                    <input type="url" id="whatsapp" name="whatsapp" required>
                    <br>
                    <label for="website">Website URL:</label>
                    <input type="url" id="website" name="website" required>
                    <br>
                    <button type="submit">Save URLs</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function placed(){
            alert("oder successfully placed");
        }
        var trac = <?= json_encode($_SESSION['trackid']) ?>;
        var lin = <?= json_encode($_SESSION['check']) ?>;
        if (lin == 1) {
            document.getElementById("lin").src = "http://localhost/dashboard/assign-card/view/users/" + trac + "/index.html";
        }
        var creat = <?= json_encode($id) ?>;
        if (creat == 1) {
            document.getElementById("msgs").innerHTML = "Successfully Created";
        }
        var flag = <?= json_encode($_SESSION['check']) ?>;
        var dis = document.getElementById("disable");
        dis.addEventListener("click", function() {
            if (flag == 0) {
                var elements = document.querySelectorAll(".di");
                elements.forEach(function(element) {
                    element.removeAttribute("style");
                    window.location.href = "update_session.php";
                });
            }
        });

        // Get the modals
        var textModal = document.getElementById("myModal");
        var uploadModal = document.getElementById("uploadModal");
        var socialModal = document.getElementById("socialModal");

        // Get the <span> element that closes the modal
        var textClose = textModal.querySelector(".close");
        var uploadClose = uploadModal.querySelector(".close");
        var socialClose = socialModal.querySelector(".close");

        // Function to show a modal
        function showModal(modal) {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        textClose.onclick = function() {
            textModal.style.display = "none";
        }
        uploadClose.onclick = function() {
            uploadModal.style.display = "none";
        }
        socialClose.onclick = function() {
            socialModal.style.display = "none";
        }

        // Get the cancel button and add click event to close the text modal
        var cancelButton = document.getElementById("cancelButton");
        cancelButton.onclick = function() {
            textModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == textModal) {
                textModal.style.display = "none";
            } else if (event.target == uploadModal) {
                uploadModal.style.display = "none";
            } else if (event.target == socialModal) {
                socialModal.style.display = "none";
            }
        }

        // Get all images and add click event to show the appropriate modal
        var images = document.querySelectorAll(".myImage");
        images.forEach(function(img) {
            img.onclick = function() {
                textModal.style.display = "block";
            }
        });

        var uploadImages = document.querySelectorAll(".uploadImage");
        uploadImages.forEach(function(img) {
            img.onclick = function() {
                uploadModal.style.display = "block";
            }
        });

        // Select the logo image and add click event to show social modal
        var logoImage = document.querySelector("img[data-name='logo']");
        logoImage.onclick = function() {
            socialModal.style.display = "block";
        };
    </script>
</body>
</html>
