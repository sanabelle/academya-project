<?php
session_start();

// Database connection setup
$dsn = 'mysql:host=localhost;dbname=academya';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

if (!isset($_SESSION['user']) || !isset($_SESSION['user_type'])) {
    header('Location: index.html');
    exit;
}

$user = $_SESSION['user'];
$user_type = $_SESSION['user_type'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_profile'])) {
        if ($user_type == 'student') {
            $stmt = $pdo->prepare('DELETE FROM students WHERE student_id = ?');
            $stmt->execute([$user['student_id']]);
        } elseif ($user_type == 'instructor') {
            $stmt = $pdo->prepare('DELETE FROM instructor WHERE id = ?');
            $stmt->execute([$user['id']]);
        }
        session_destroy();
        header('Location: index.html');
        exit;
    } elseif (isset($_POST['update_profile'])) {
        if ($user_type == 'student') {
            $stmt = $pdo->prepare('UPDATE students SET email = ?, username = ? WHERE student_id = ?');
            $stmt->execute([$_POST['email'], $_POST['username'], $user['student_id']]);
        } elseif ($user_type == 'instructor') {
            $stmt = $pdo->prepare('UPDATE instructor SET instructor_email = ?, instructor_username = ? WHERE id = ?');
            $stmt->execute([$_POST['email'], $_POST['username'], $user['id']]);
        }
        $_SESSION['user'] = ($user_type == 'student') ? 
            ['student_id' => $user['student_id'], 'email' => $_POST['email'], 'username' => $_POST['username']] : 
            ['id' => $user['id'], 'instructor_email' => $_POST['email'], 'instructor_username' => $_POST['username']];
    }
}

// Function to get unread message count for a course
function getUnreadMessageCount($pdo, $course_id) {
    $stmt = $pdo->prepare('SELECT COUNT(*) AS unread_count FROM messages WHERE course_id = ? AND read_status = 0');
    $stmt->execute([$course_id]);
    $result = $stmt->fetch();
    return $result['unread_count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
        }
        .dashboard-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .user-info {
            display: flex;
            align-items: center;
        }
        .user-info p {
            margin: 0;
            margin-right: 10px;
            color: #666;
        }
        .user-info a {
            color: #333;
            text-decoration: none;
            padding: 8px 12px;
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            border-radius: 3px;
            transition: background-color 0.3s;
        }
        .user-info a:hover {
            background-color: #e1e1e1;
        }
        .profile-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .profile-section h2 {
            font-size: 20px;
            color: #333;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .profile-section form {
            max-width: 400px;
        }
        .profile-section label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }
        .profile-section input[type="email"],
        .profile-section input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }
        .profile-section button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 10px;
        }
		.profile-section button.btn-success {
            background-color: #ff7708; /* Orange color */
            border-color: #ff7708; /* Orange color */
        }

        /* Change primary button hover color */
        .profile-section button.btn-success:hover {
            background-color: #ff9933; /* Lighter shade of orange */
            border-color: #ff9933; /* Lighter shade of orange */
        }

        /* Leave delete button (Delete Profile) as red */
        .profile-section button.btn-danger {
            background-color: #f44336; /* Red color */
            border-color: #f44336; /* Red color */
        }

        /* Hover effect for delete button (Delete Profile) */
        .profile-section button.btn-danger:hover {
            background-color: #e53935; /* Lighter shade of red */
            border-color: #e53935; /* Lighter shade of red */
        }
        .profile-section button:hover {
            background-color: #45a049;
        }
        .profile-section button[name="delete_profile"] {
            background-color: #f44336;
        }
        .profile-section button[name="delete_profile"]:hover {
            background-color: #e53935;
        }
        .dashboard-section {
            margin-top: 20px;
        }
        .dashboard-section h2 {
            font-size: 20px;
            color: #333;
            margin-top: 8px;
            margin-bottom: 10px;
        }
        .courses {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .course {
            padding: 15px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .course h3 {
            font-size: 18px;
            color: #333;
            margin-top: 0;
            margin-bottom: 5px;
        }
        .course p {
            color: #666;
            margin: 5px 0;
        }
        .course a {
            display: inline-block;
            padding: 8px 12px;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            transition: background-color 0.3s;
            margin-top: 10px;
			background-color: #ff7708; 
            border-color: #ff7708;
        }
        .course a:hover {
			            background-color: #ff9933; 
            border-color: #ff9933;
        }
        .notification-badge {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 50%;
            position: relative;
            top: -10px;
            left: 10px;
        }
        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #ff7708; /* Orange background */
            padding-top: 20px;
        }
        .sidebar h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .sidebar li {
            margin-bottom: 10px;
        }
        .sidebar a {
            display: block;
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #ff9933; /* Lighter shade of orange on hover */
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard Menu</h2>
        <ul>
            <?php if ($user_type == 'student'): ?>
                <li><a href="#student-dashboard"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="#my-courses"><i class="fas fa-book"></i> My Courses</a></li>
                <!-- Add more links as needed for students -->
            <?php elseif ($user_type == 'instructor'): ?>
                <li><a href="#instructor-dashboard"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="#my-courses"><i class="fas fa-book"></i> My Courses</a></li>
                <!-- Add more links as needed for instructors -->
            <?php endif; ?>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Page Content -->
    <div class="content">
        <div class="dashboard-container">
            <header>
                <h1>Dashboard</h1>
                <div class="user-info">
                    <?php if ($user_type == 'student'): ?>
                        <p>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</p>
                    <?php elseif ($user_type == 'instructor'): ?>
                        <p>Welcome, <?php echo htmlspecialchars($user['instructor_username']); ?>!</p>
                    <?php endif; ?>
                    <!-- Sidebar toggle button -->
                    <button class="btn btn-dark d-block d-md-none" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </header>

            <section id="student-dashboard" class="profile-section">
                <h2>Profile Information</h2>
                <form method="POST">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_type == 'student' ? $user['email'] : $user['instructor_email']); ?>" required>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user_type == 'student' ? $user['username'] : $user['instructor_username']); ?>" required>
                    <button type="submit" name="update_profile" class="btn btn-success">Update Profile</button>
                    <button type="submit" name="delete_profile" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your profile?');">Delete Profile</button>
                </form>
            </section>

            <?php if ($user_type == 'student'): ?>
                <section id="my-courses" class="dashboard-section">
                    <a href="fullstack.html" class="btn btn-primary mb-3">Enroll Courses</a>
                    <h2>My Courses</h2>
                    <div class="courses">
                        <?php
                        $student_id = $user['student_id'];
                        $stmt = $pdo->prepare('SELECT * FROM courses INNER JOIN enrolment ON courses.course_id = enrolment.course_id WHERE enrolment.student_id = ?');
                        $stmt->execute([$student_id]);
                        $courses = $stmt->fetchAll();	

                        foreach ($courses as $course) {
                            echo '<div class="course">';
                            echo '<h3>' . htmlspecialchars($course['Course Title']) . '</h3>';
                            echo '<p>Duration: ' . htmlspecialchars($course['Course Duration']) . ' hours</p>';
                            echo '<p>Price: $' . htmlspecialchars($course['Course Price']) . '</p>';
                            echo '<a href="viewcourse.php?course_id=' . $course['course_id'] . '" class="btn btn-success">View Course</a>';
                            echo '<a href="complete.php?course_id=' . $course['course_id'] . '" class="btn btn-info">complete</a>';
							echo '<a href="chat.php?course_id=' . $course['course_id'] . '" class="btn btn-info">Chat with Instructor</a>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </section>
            <?php elseif ($user_type == 'instructor'): ?>
                <section id="my-courses" class="dashboard-section">
                    <a href="courseform.php" class="btn btn-primary mb-3">Add Course</a>
                    <h2>My Courses</h2>
                    <div class="courses">
                        <?php
                        $instructor_id = $user['id'];
                        $stmt = $pdo->prepare('SELECT * FROM courses WHERE instructor_id = ?');
                        $stmt->execute([$instructor_id]);
                        $courses = $stmt->fetchAll();

                        foreach ($courses as $course) {
                            $course_id = $course['course_id'];
                            $unread_count = getUnreadMessageCount($pdo, $course_id); // Function to fetch unread message count
                            echo '<div class="course">';
                            echo '<h3>' . htmlspecialchars($course['Course Title']) . '</h3>';
                            echo '<p>Duration: ' . htmlspecialchars($course['Course Duration']) . ' hours</p>';
                            echo '<p>Number of Lessons: ' . htmlspecialchars($course['Number of lessons']) . '</p>';
                            echo '<a href="viewcourse.php?course_id=' . $course['course_id'] . '" class="btn btn-success">View Course</a>';
                            echo '<a href="lessonform.php?course_id=' . $course['course_id'] . '" class="btn btn-primary">Add Lessons</a>';
                            echo '<a href="chat.php?course_id=' . $course['course_id'] . '" class="btn btn-info">Open Chat</a>';
                            if ($unread_count > 0) {
                                echo '<span class="notification-badge">' . $unread_count . '</span>';
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
