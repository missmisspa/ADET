<?php
require 'conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM results WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $marks = $_POST['marks'];
    $grade = $_POST['grade'];

    $sql = "UPDATE results SET fname='$fname', lname='$lname', marks='$marks', grade='$grade' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Student</h1>
    <form method="post">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">

        <label>First Name:</label>
        <input type="text" name="fname" value="<?= $row['fname'] ?>" required><br>

        <label>Last Name:</label>
        <input type="text" name="lname" value="<?= $row['lname'] ?>" required><br>

        <label>Marks:</label>
        <input type="number" name="marks" min="0" max="100" value="<?= $row['marks'] ?>" required><br>

        <label>Grade Level:</label>
        <select name="grade" required>
            <option value="">Select Grade</option>
            <?php for ($i = 1; $i <= 12; $i++) { ?>
                <option value="<?= $i; ?>" <?= ($row['grade'] == $i) ? 'selected' : ''; ?>>Grade <?= $i; ?></option>
            <?php } ?>
        </select><br>

        <button type="submit">Update</button>
    </form>
    <a href="index.php"><button>Back</button></a>
</body>
</html>
