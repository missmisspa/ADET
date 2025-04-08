<?php
require 'conn.php';

// Fetch data with error handling
$sql = "SELECT * FROM results";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("<div class='alert alert-danger text-center'>Error fetching data: " . mysqli_error($conn) . "</div>");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
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

    th,
    td {
        text-align: center;
        vertical-align: middle;
    }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="text-center fw-bold mb-4">Student Records</h2>

        <div class="card">
            <div class="card-header text-black text-center">Add Student</div>
            <div class="card-body">
                <form method="post" action="create.php" onsubmit="return validateForm()">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="text" name="fname" class="form-control" placeholder="First Name">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="lname" class="form-control" placeholder="Last Name">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="marks" id="marks" class="form-control" placeholder="Marks">
                        </div>
                        <div class="col-md-2">
                            <select name="grade" class="form-select">
                                <option value="" selected disabled>Grade Level</option>
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                <option value="<?= $i ?>">Grade <?= $i ?></option>
                                <?php } ?>
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
                        <th>Post</th>
                        <th>View Post</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['fname']) ?></td>
                        <td><?= htmlspecialchars($row['lname']) ?></td>
                        <td><?= $row['marks'] ?></td>
                        <td>Grade <?= $row['grade'] ?></td>
                        <td>
                            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal'
                                data-id='<?= $row['id'] ?>' data-fname='<?= htmlspecialchars($row['fname']) ?>'
                                data-lname='<?= htmlspecialchars($row['lname']) ?>' data-marks='<?= $row['marks'] ?>'
                                data-grade='<?= $row['grade'] ?>'>
                                Edit
                            </button>
                        </td>
                        <td>
                            <a href='delete.php?id=<?= $row['id'] ?>' class='btn btn-danger btn-sm'
                                onclick='return confirm("Are you sure?")'>Delete</a>
                        </td>
                        <td>
                            <a href='postdata.php?id=<?= $row['id'] ?>' class='btn btn-primary btn-sm'>Post</a>
                        </td>
                        <td>
                            <a href='viewdata.php?id=<?= $row['id'] ?>' class='btn btn-info btn-sm'>View Post</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No student records found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
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
                            <input type="text" name="fname" id="edit-fname" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Last Name:</label>
                            <input type="text" name="lname" id="edit-lname" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Marks:</label>
                            <input type="number" name="marks" id="edit-marks" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Grade Level:</label>
                            <select name="grade" id="edit-grade" class="form-select">
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                <option value="<?= $i ?>">Grade <?= $i ?></option>
                                <?php } ?>
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

    <script>
    function validateForm() {
        let marks = document.getElementById('marks').value;
        if (marks === "" || isNaN(marks) || marks < 65 || marks > 100) {
            alert("Marks must be a number between 65 and 100.");
            return false;
        }
        return true;
    }

    function validateEditForm() {
        let fname = document.getElementById('edit-fname').value.trim();
        let lname = document.getElementById('edit-lname').value.trim();
        let marks = document.getElementById('edit-marks').value;
        let grade = document.getElementById('edit-grade').value;

        if (fname === "" || lname === "") {
            alert("First Name and Last Name cannot be empty.");
            return false;
        }

        if (marks === "" || isNaN(marks) || marks < 65 || marks > 100) {
            alert("Marks must be a number between 65 and 100.");
            return false;
        }

        if (grade === "") {
            alert("Please select a Grade Level.");
            return false;
        }

        return true;
    }

    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        document.getElementById('edit-id').value = button.getAttribute('data-id');
        document.getElementById('edit-fname').value = button.getAttribute('data-fname');
        document.getElementById('edit-lname').value = button.getAttribute('data-lname');
        document.getElementById('edit-marks').value = button.getAttribute('data-marks');
        document.getElementById('edit-grade').value = button.getAttribute('data-grade');
    });

    document.querySelector("#editModal form").onsubmit = validateEditForm;
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>