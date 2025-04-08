<?php
require 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $marks = $_POST['marks'];
    $grade = $_POST['grade'];

    $sql = "INSERT INTO results (fname, lname, marks, grade) VALUES ('$fname', '$lname', '$marks', '$grade')";
    
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
    <title>Add Student</title>
</head>
<body>
    <h1>Add Student</h1>
    <form method="post">
        <label>First Name:</label>
        <input type="text" name="fname" required><br>

        <label>Last Name:</label>
        <input type="text" name="lname" required><br>

        <label>Marks:</label>
        <input type="number" name="marks" min="0" max="100" required><br>

        <label>Grade Level:</label>
        <select name="grade" required>
            <option value="">Select Grade</option>
            <?php for ($i = 1; $i <= 12; $i++) { ?>
                <option value="<?= $i; ?>"><?= "Grade $i"; ?></option>
            <?php } ?>
        </select><br>

        <button type="submit">Add</button>
    </form>
    <a href="index.php"><button>Back</button></a>
</body>
</html>
