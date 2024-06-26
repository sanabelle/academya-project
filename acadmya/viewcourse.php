<?php
session_start();

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

if (!isset($_GET['course_id'])) {
    die('Course ID not provided.');
}

$course_id = filter_var($_GET['course_id'], FILTER_VALIDATE_INT);

$stmt = $pdo->prepare('SELECT * FROM lessons WHERE course_id = ? ORDER BY `The Order of lesson` ASC');
$stmt->execute([$course_id]);
$lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

$user = $_SESSION['user'];
$user_type = $_SESSION['user_type'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Lessons</title>
    <link rel="stylesheet" href="css/course.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
            color: #333;
        }
        .course-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background: #ff7708;
            color: #fff;
            padding: 15px 0;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .user-info a {
            color: #fff;
            text-decoration: none;
            margin-left: 10px;
            font-weight: bold;
        }
        .lessons-section {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .lesson {
            border-bottom: 1px solid #e0e0e0;
            padding: 15px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .lesson:last-child {
            border-bottom: none;
        }
        .lesson-info h3 {
            margin: 0;
            font-size: 1.5em;
            color: #4CAF50;
        }
        .lesson-info p {
            margin: 5px 0;
            font-size: 1em;
        }
        .lesson-actions {
            display: flex;
            gap: 10px;
        }
        .lesson-actions a {
            text-decoration: none;
            color: #000;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .lesson-actions a:hover {
            opacity: 0.8;
        }
        .lesson-actions .fas {
            margin-right: 5px;
        }
        .edit-btn, .delete-btn {
            cursor: pointer;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            transition: background 0.3s;
            color: #fff;
        }
        .edit-btn {
            background: #2196F3;
        }
        .edit-btn:hover {
            background: #1E88E5;
        }
        .delete-btn {
            background: #f44336;
        }
        .delete-btn:hover {
            background: #e53935;
        }
        #editModal, #deleteModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        #editModal > div, #deleteModal > div {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            width: 400px;
            max-width: 90%;
        }
        #editLessonForm label, #deleteLessonForm label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        #editLessonForm input, #editLessonForm textarea, #editLessonForm button, #deleteLessonForm button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1em;
        }
        #editLessonForm button, #deleteLessonForm button {
            background: #4CAF50;
            color: #fff;
            border: none;
            margin-top: 15px;
        }
        #editLessonForm button:hover, #deleteLessonForm button:hover {
            background: #45A049;
        }
        #editLessonForm button[type="button"], #deleteLessonForm button[type="button"] {
            background: #f44336;
        }
        #editLessonForm button[type="button"]:hover, #deleteLessonForm button[type="button"]:hover {
            background: #e53935;
        }
    </style>
</head>
<body>
    <div class="course-container">
        <header>
            <h1>Course Lessons</h1>
            <div class="user-info">
                <a href="dashboard.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </header>

        <section class="lessons-section">
            <h2>Lessons</h2>
            <div class="lessons">
                <?php
                if ($lessons) {
                    foreach ($lessons as $lesson) {
                        echo '<div class="lesson">';
                        echo '<div class="lesson-info">';
                        echo '<h3>' . htmlspecialchars($lesson['Lesson Title']) . '</h3>';
                        echo '<p>Duration: ' . htmlspecialchars($lesson['Lesson Duration']) . ' minutes</p>';
                        echo '<p>Description: ' . htmlspecialchars($lesson['Lesson Description']) . '</p>';
                        echo '</div>';
                        echo '<div class="lesson-actions">';
                        // echo '<a href="' . htmlspecialchars($lesson['video_url']) . '" target="_blank"><i class="fas fa-video"></i> Watch Video</a>';
                        echo '<a href="' . htmlspecialchars($lesson['file_url']) . '" download><i class="fas fa-file-download"></i> Download File</a>';
          

                        if ($user_type == 'instructor') {
                            echo '<span class="edit-btn" data-id="' . $lesson['lesson_id'] . '"><i class="fas fa-edit"></i> Edit</span>';
                            echo '<span class="delete-btn" data-id="' . $lesson['lesson_id'] . '"><i class="fas fa-trash-alt"></i> Delete</span>';
                        					 	   echo '<a href="create_quiz.php?lesson_id=' . $lesson['lesson_id']  . '"><i class="fas fa-plus"ٍٍٍ></i>Create Quiz</a>';							

						} elseif ($user_type == 'student') {
                            echo '<a href="mark_lesson.php?lesson_id=' . $lesson['lesson_id']  . '" class="btn btn-info">mark</a>';							
                            echo '<a href="taking-quiz.php?lesson_id=' . $lesson['lesson_id'] . '"><i class="fas fa-clipboard-check"></i> Take Quiz</a>';
                        }
                        echo '</div>';
                        echo '</div>';

                        echo '<div> <video style="width:100%" height="240" controls>
                        <source src="'.$lesson['video_url'].'" type="video/mp4">
                        <source src="'.$lesson['video_url'].'" type="video/ogg">
                        Your browser does not support the video tag.
                      </video></div>';
                     
                    }
                } else {
                    echo '<p>No lessons found for this course.</p>';
                }
                ?>
            </div>
        </section>
    </div>

    <div id="editModal">
        <div>
            <h2>Edit Lesson</h2>
            <form id="editLessonForm">
                <label for="lessonTitle">Lesson Title</label>
                <input type="text" id="lessonTitle" name="lessonTitle" required>
                <label for="lessonDuration">Lesson Duration</label>
                <input type="number" id="lessonDuration" name="lessonDuration" required>
                <label for="lessonDescription">Lesson Description</label>
                <textarea id="lessonDescription" name="lessonDescription" required></textarea>
                <input type="hidden" id="lessonId" name="lessonId">
                <button type="submit">Save Changes</button>
                <button type="button" id="cancelEdit">Cancel</button>
            </form>
        </div>
    </div>

    <div id="deleteModal">
        <div>
            <h2>Delete Lesson</h2>
            <form id="deleteLessonForm">
                <p>Are you sure you want to delete this lesson?</p>
                <input type="hidden" id="deleteLessonId" name="lessonId">
                <button type="submit">Yes, Delete</button>
                <button type="button" id="cancelDelete">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-btn');
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const editModal = document.getElementById('editModal');
            const deleteModal = document.getElementById('deleteModal');
            const editLessonForm = document.getElementById('editLessonForm');
            const deleteLessonForm = document.getElementById('deleteLessonForm');
            const cancelEdit = document.getElementById('cancelEdit');
            const cancelDelete = document.getElementById('cancelDelete');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const lessonId = this.getAttribute('data-id');
                    fetch(`get_lesson.php?lesson_id=${lessonId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('lessonTitle').value = data.lesson_title;
                            document.getElementById('lessonDuration').value = data.lesson_duration;
                            document.getElementById('lessonDescription').value = data.lesson_description;
                            document.getElementById('lessonId').value = data.lesson_id;
                            editModal.style.display = 'flex';
                        })
                        .catch(error => console.error('Error fetching lesson data:', error));
                });
            });

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const lessonId = this.getAttribute('data-id');
                    document.getElementById('deleteLessonId').value = lessonId;
                    deleteModal.style.display = 'flex';
                });
            });

            cancelEdit.addEventListener('click', function() {
                editModal.style.display = 'none';
            });

            cancelDelete.addEventListener('click', function() {
                deleteModal.style.display = 'none';
            });

            editLessonForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(editLessonForm);
                fetch('edit_lesson.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error updating lesson');
                        }
                    })
                    .catch(error => console.error('Error updating lesson:', error));
            });

            deleteLessonForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(deleteLessonForm);
                fetch('delete_lesson.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error deleting lesson');
                        }
                    })
                    .catch(error => console.error('Error deleting lesson:', error));
            });
        });
    </script>
</body>
</html>
