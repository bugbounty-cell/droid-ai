<?php

$uploadDir = "uploads/";

// Create directory if it doesn't exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

    $tmpName = $_FILES['image']['tmp_name'];
    $fileName = basename($_FILES['image']['name']);
    $fileSize = $_FILES['image']['size'];

    // Allowed image types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedTypes)) {
        die("Only image files are allowed.");
    }

    // Verify it's actually an image
    if (getimagesize($tmpName) === false) {
        die("Invalid image file.");
    }

    // Generate unique filename
    $newFileName = uniqid('img_', true) . '.' . $extension;
    $destination = $uploadDir . $newFileName;

    if (move_uploaded_file($tmpName, $destination)) {
        echo "Image uploaded successfully.<br>";
        echo "<img src='$destination' style='max-width:300px'>";
    } else {
        echo "Upload failed.";
    }

} else {
    echo "No file uploaded.";
}
?>
