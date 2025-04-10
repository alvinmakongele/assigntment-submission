<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Submission</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <style>
        .container { margin-top: 50px; }
        .error { color: red; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Student Assignment Submission</h2>
        <!-- Display submission status -->
        <?php if (isset($_GET['status'])): ?>
            <div class="alert <?php echo $_GET['status'] === 'success' ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $_GET['status'] === 'success' ? 'Assignment submitted successfully!' : 'Submission failed. Try again.'; ?>
            </div>
        <?php endif; ?>
        
        <!-- Submission Form -->
        <form id="submissionForm" action="submit.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="studentName" class="form-label">Student Name</label>
                <input type="text" class="form-control" id="studentName" name="student_name" required>
            </div>
            <div class="mb-3">
                <label for="course" class="form-label">Course</label>
                <input type="text" class="form-control" id="course" name="course" required>
            </div>
            <div class="mb-3">
                <label for="assignmentFile" class="form-label">Assignment File (PDF/DOC/DOCX, max 5MB)</label>
                <input type="file" class="form-control" id="assignmentFile" name="assignment_file" accept=".pdf,.doc,.docx" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit Assignment</button>
        </form>
        <a href="view.php" class="btn btn-secondary mt-3">View Submissions</a>
    </div>

    <!-- Bootstrap JS and Custom Validation -->
    <script src="assets/bootstrap.min.css"></script>
    <script>
        document.getElementById('submissionForm').addEventListener('submit', function(e) {
            const studentName = document.getElementById('studentName').value.trim();
            const course = document.getElementById('course').value.trim();
            const file = document.getElementById('assignmentFile').files[0];

            // Basic validation
            if (!studentName || !course || !file) {
                alert('Please fill all fields!');
                e.preventDefault();
            } else if (file.size > 5 * 1024 * 1024) { // 5MB limit
                alert('File size must be less than 5MB!');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>