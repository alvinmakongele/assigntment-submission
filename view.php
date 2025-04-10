<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'assignment_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $student_name = htmlspecialchars($_POST['student_name']);
    $course = htmlspecialchars($_POST['course']);
    $file = $_FILES['assignment_file'];

    // File upload configuration
    $upload_dir = 'uploads/';
    $file_name = uniqid() . '-' . basename($file['name']);
    $file_path = $upload_dir . $file_name;
    $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

    // Validate file
    if (!in_array($file['type'], $allowed_types) || $file['size'] > 5 * 1024 * 1024) {
        header('Location: index.php?status=error');
        exit;
    }

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO submissions (student_name, course, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $student_name, $course, $file_path);
        
        if ($stmt->execute()) {
            header('Location: index.php?status=success');
        } else {
            header('Location: index.php?status=error');
        }
        $stmt->close();
    } else {
        header('Location: index.php?status=error');
    }
} else {
    header('Location: index.php'); // Redirect if not POST
}

$conn->close();
?>