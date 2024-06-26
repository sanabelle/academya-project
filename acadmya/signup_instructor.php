<?php
// Database connection code here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "academya";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    $experience = $_POST["experience"];

    // Check if file was uploaded without errors
    if (isset($_FILES["profile_photo"]) && $_FILES["profile_photo"]["error"] == 0) {
        // Retrieve file details
        $profile_photo = $_FILES["profile_photo"];
        
        // Move the uploaded file to the desired directory
        $target_file = basename($profile_photo["name"]);
        if (move_uploaded_file($profile_photo["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename($profile_photo["name"])). " has been uploaded.";
            // Insert data into database
           $sql = "INSERT INTO instructor (instructor_email, instructor_username, instructor_password, `Phone Number`, `Experence`, profile_photo) 
        VALUES ('$email', '$username', '$password', '$phone', '$experience', '$target_file')";


            if ($conn->query($sql) === TRUE) {
                echo "New instructor record created successfully";
				    header('Location: index.php');

            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>
