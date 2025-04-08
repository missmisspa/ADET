<?php
require 'conn.php';

if (!isset($_GET['id'])) {
    die("<div class='alert alert-danger text-center'>Student ID is required.</div>");
}

$student_id = intval($_GET['id']);

$query = "SELECT * FROM results WHERE id = $student_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("<div class='alert alert-warning text-center'>Student not found.</div>");
}

$student = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $activity_name = mysqli_real_escape_string($conn, $_POST['activity_name']);
    $activity_marks = intval($_POST['activity_marks']);

    if (!empty($activity_name) && $activity_marks >= 0 && $activity_marks <= 100) {
        $insert = "INSERT INTO activity (student_id, activity_name, activity_marks)
                VALUES ($student_id, '$activity_name', $activity_marks)";
        if (mysqli_query($conn, $insert)) {
            $message = "<div class='alert alert-success text-center'>Activity posted successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger text-center'>Failed to post activity.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning text-center'>Please provide valid activity details.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Post Activity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h3 class="text-center mb-4">Post Activity for <?= htmlspecialchars($student['fname']) ?>
            <?= htmlspecialchars($student['lname']) ?></h3>

        <?php if (isset($message)) echo $message; ?>

        <form method="post">
            <div class="mb-3">
                <label>First Name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($student['fname']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($student['lname']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label>Grade</label>
                <input type="text" class="form-control" value="Grade <?= $student['grade'] ?>" readonly>
            </div>

            <div class="mb-3">
                <label>Marks</label>
                <input type="text" class="form-control" value="<?= $student['marks'] ?>" readonly>
            </div>

            <hr>

            <h5>Add Activity</h5>

            <div class="mb-3">
                <label>Activity Name</label>
                <input type="text" name="activity_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Activity Marks</label>
                <input type="number" name="activity_marks" class="form-control" min="0" max="100" required>
            </div>

            <div class="container-fluid">
                <div class="row g-2">
                    <div class="col-md-6 text-center">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Back
                            to Student List</button>
                    </div>
                    <div class="col-md-6 text-center">
                        <button type="submit" class="btn btn-primary"
                            onclick="window.location.href='postdata.php'">Post</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>