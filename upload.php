 
<?php
// Database connection
include "config.php";

if (isset($_POST["submit"])) {
    // Set image placement folder
    $target_dir = "Uploads/";
    // Get file path
    $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);
    // Get file extension
    $imageExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Allowed file types
    $allowd_file_ext = array("jpg", "jpeg", "png");

    if (!file_exists($_FILES["fileUpload"]["tmp_name"])) {
        $resMessage = array(
            "message" => "Select image to upload.",
        );
    } else if (!in_array($imageExt, $allowd_file_ext)) {
        $resMessage = array(
            "message" => "Allowed file formats .jpg, .jpeg and .png.",
        );
    } else if ($_FILES["fileUpload"]["size"] > 2097152) {
        $resMessage = array(
            "message" => "File is too large. File size should be less than 2 megabytes.",
        );
    } else if (file_exists($target_file)) {
        $resMessage = array(
            "message" => "File already exists.",
        );
    } else {
        if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO files (file_path) VALUES (?)";
            $stmt = mysqli_prepare($link, $sql);
			mysqli_stmt_bind_param($stmt, "s", $param_path);
			$param_path = $target_file;
            if (mysqli_stmt_execute($stmt)) {
                $resMessage = array(
                    "message" => "Image uploaded successfully.",
                );
            }
        } else {
            $resMessage = array(
                "message" => "Image coudn't be uploaded.",
            );
        }
    }
}
?>
 