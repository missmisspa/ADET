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

