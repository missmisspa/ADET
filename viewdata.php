<?php
require 'conn.php';

if (!isset($_GET['id'])) {
    die("<div class='alert alert-danger text-center'>Student ID is required.</div>");
}

$student_id = intval($_GET['id']);

$student_result = mysqli_query($conn, "SELECT * FROM results WHERE id = $student_id");

if (!$student_result || mysqli_num_rows($student_result) == 0) {
    die("<div class='alert alert-warning text-center'>Student not found.</div>");
}

$student = mysqli_fetch_assoc($student_result);

$activity_query = "SELECT * FROM activity WHERE student_id = $student_id";
$activity_result = mysqli_query($conn, $activity_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Student Activities</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h3 class="text-center mb-4">
            View Post for <?= htmlspecialchars($student['fname']) ?> <?= htmlspecialchars($student['lname']) ?>
        </h3>

        <?php if (mysqli_num_rows($activity_result) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Activity Name</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $counter = 1;
                    while ($activity = mysqli_fetch_assoc($activity_result)): ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= htmlspecialchars($activity['activity_name']) ?></td>
                        <td><?= $activity['activity_marks'] ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="alert alert-info text-center">No activity records found for this student.</div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>