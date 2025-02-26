<?php
require 'conn.php';

$sql = "SELECT * FROM results";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            margin-bottom: 20px;
        }
        th {
            background-color: #f8f9fa;
            color: black;
            text-align: center;
        }
        td, th {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center fw-bold mb-4">Student Records</h2>

    <!-- Create Student Form (One Row) -->
    <div class="card">
        <div class="card-header text-black text-center">Add Student</div>
        <div class="card-body">
            <form method="post" action="create.php">
                <div class="row g-2">
                    <div class="col-md-3">
                        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="marks" class="form-control" placeholder="Marks" required>
                    </div>
                    <div class="col-md-2">
                        <select name="grade" class="form-select" required>
                            <option value="" selected disabled>Grade Level</option>
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                echo "<option value='$i'>Grade $i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-secondary">
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Marks</th>
                    <th>Grade Level</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['fname']}</td>
                        <td>{$row['lname']}</td>
                        <td>{$row['marks']}</td>
                        <td>Grade {$row['grade']}</td>
                        <td><button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal' 
                        data-id='{$row['id']}' data-fname='{$row['fname']}' data-lname='{$row['lname']}' 
                        data-marks='{$row['marks']}' data-grade='{$row['grade']}'>Edit</button></td>
                        <td><a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="update.php">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-2">
                        <label>First Name:</label>
                        <input type="text" name="fname" id="edit-fname" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Last Name:</label>
                        <input type="text" name="lname" id="edit-lname" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Marks:</label>
                        <input type="number" name="marks" id="edit-marks" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Grade Level:</label>
                        <select name="grade" id="edit-grade" class="form-select" required>
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                echo "<option value='$i'>Grade $i</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('edit-id').value = button.getAttribute('data-id');
        document.getElementById('edit-fname').value = button.getAttribute('data-fname');
        document.getElementById('edit-lname').value = button.getAttribute('data-lname');
        document.getElementById('edit-marks').value = button.getAttribute('data-marks');
        document.getElementById('edit-grade').value = button.getAttribute('data-grade');
    });
</script>

</body>
</html>
