<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }
        .certificate {
            width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            text-align: center;
        }
        h2 {
            color: #4CAF50;
        }
        p {
            font-size: 1.2em;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <h2>Certificate of Completion</h2>
        <p>This certifies that</p>
        <p><strong><?= htmlspecialchars($student_name) ?></strong></p>
        <p>has successfully completed the quiz for</p>
        <p><strong><?= htmlspecialchars($course_name) ?></strong></p>
        <p>on <?= date('F j, Y') ?></p>
    </div>
</body>
</html>
