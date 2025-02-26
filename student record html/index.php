<?php
require 'conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Records</title>
    <style>
        table {
            border-collapse: collapse;
        }
        table, th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Student Records</h1>
    <a href="create.php"><button>Add Student</button></a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Marks</th>
                <th>Grade</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM results";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['fname']}</td>
                        <td>{$row['lname']}</td>
                        <td>{$row['marks']}</td>
                        <td>Grade {$row['grade']}</td>
                        <td><a href='update.php?id={$row['id']}'>Edit</a></td>
                        <td><a href='delete.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
