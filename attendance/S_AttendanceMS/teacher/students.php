<?php

ob_start();
session_start();

if($_SESSION['name']!='oasis')
{
  header('location: login.php');
}
?>
<?php include('connect.php');?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Attendance Management System</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="../css/main.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

  <link rel="stylesheet" href="styles.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  </style>

</head>

<body>

  <header>

    <h1>Attendance Management System</h1>
    <div class="navbar">
      <a href="index.php" style="text-decoration:none;">Home</a>
      <a href="students.php" style="text-decoration:none;">Students</a>
      <a href="teachers.php" style="text-decoration:none;">Faculties</a>
      <a href="attendance.php" style="text-decoration:none;">Attendance</a>
      <a href="report.php" style="text-decoration:none;">Report</a>
      <a href="../logout.php" style="text-decoration:none;">Logout</a>


    </div>

  </header>

  <center>
    <div class="row">
        <div class="content">
            <h3>Student List</h3>
            <br>
            <form method="post" action="">
                <label>Batch</label>
                <input type="text" name="sr_batch">
                <input type="submit" name="sr_btn" class="btn btn-danger" style="border-radius:0%" value="Search">
            </form>
            <br>
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Registration No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Department</th>
                        <th scope="col">Batch</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    if (isset($_POST['sr_btn'])) {
                        $srbatch = $_POST['sr_batch'];
                        $stmt = $conn->prepare("SELECT * FROM students WHERE st_batch = ? ORDER BY st_id ASC");
                        $stmt->bind_param("s", $srbatch);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($data = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $data['st_id']; ?></td>
                                <td><?php echo $data['st_name']; ?></td>
                                <td><?php echo $data['st_dept']; ?></td>
                                <td><?php echo $data['st_batch']; ?></td>
                                <td><?php echo $data['st_sem']; ?></td>
                                <td><?php echo $data['st_email']; ?></td>
                            </tr>
                            <?php
                        }
                        $stmt->close();
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</center>


</body>

</html>