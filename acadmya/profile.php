<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "academya";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data for all instructors
$sql = "SELECT * FROM instructor";
$result = $conn->query($sql);

$instructors = array(); // Initialize an array to store all instructors' data

if ($result->num_rows > 0) {
    // Loop through each row of the result set and store data in the $instructors array
    while ($row = $result->fetch_assoc()) {
        $instructors[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
/* Reset Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }

        /* Container Styles */
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Title Styles */
        .title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Profile Card Styles */
        .profile-card {
            position: relative;
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 20px;
            transition: transform 0.3s ease;
        }

        .profile-img:hover {
            transform: scale(1.1);
        }

        .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .profile-description {
            margin-bottom: 10px;
        }

        .star-rating {
            color: #f39c12;
            margin-bottom: 10px;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .action-buttons a {
            margin-left: 10px;
            padding: 8px 16px;
            border-radius: 5px;
            background-color: #ff7708;
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .action-buttons a:hover {
            background-color:#ff770880;
        }

        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .profile-card {
                flex-direction: column;
                text-align: center;
            }

            .profile-img {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .action-buttons {
                justify-content: center;
            }

            .action-buttons a {
                margin-left: 0;
            }
        }    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Profile Details</h1>
        <?php foreach ($instructors as $instructor): ?>
            <div class="profile-card">
                <div class="profile-img">
                    <img src="<?php echo $instructor['profile_photo']; ?>" alt="Profile Picture">
                </div>
                <div class="profile-info">
                    <h1 class="profile-name"><?php echo $instructor['instructor_username']; ?></h1>
                    <p class="profile-description"><?php echo $instructor['Experence']; ?></p>
                    <div class="star-rating">
                        <!-- Display stars dynamically based on some rating logic if available -->
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="action-buttons">
                        <!-- Link to the View Courses page with instructor_id parameter -->
                        <a href="view_courses.php?instructor_id=<?php echo $instructor['id']; ?>">View Courses</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
