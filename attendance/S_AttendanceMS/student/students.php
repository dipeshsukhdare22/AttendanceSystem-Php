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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
   
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
   
  <link rel="stylesheet" href="styles.css" >
   
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</head>
<body>

<header>

  <h1>Attendance Management System</h1>
  <div class="navbar">
  <a href="index.php" style="text-decoration:none;">Home</a>
  <a href="students.php" style="text-decoration:none;">Students</a>
  <a href="report.php" style="text-decoration:none;">Report Section</a>
  <a href="account.php" style="text-decoration:none;">My Account</a>
  <a href="../logout.php" style="text-decoration:none;">Logout</a>

</div>

</header>

<center>

<?php
// Establish the connection with the database
include('connect.php');  // Assuming this includes your MySQL connection setup

if (isset($_POST['sr_btn'])) {
    // Retrieve the form input
    $srbatch = $_POST['sr_batch'];
    $i = 0;

    // Prepare and execute the query to prevent SQL injection
    $query = $conn->prepare("SELECT * FROM students WHERE st_batch = ? ORDER BY st_id ASC");
    $query->bind_param("s", $srbatch);
    $query->execute();

    // Store the result
    $result = $query->get_result();
}
?>

<div class="row">
  <div class="content">
    <h3>Student List</h3>
    <br>

    <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
      <div class="form-group">
        <label for="input1" class="col-sm-3 control-label">Batch</label>
        <div class="col-sm-7">
          <input type="text" name="sr_batch" class="form-control" id="input1" placeholder="Only 2020" />
        </div>
      </div>
      <input type="submit" class="btn btn-danger col-md-3 col-md-offset-7" style="border-radius:0%" value="Search" name="sr_btn" />
    </form>

    <div class="content"></div>
    <table class="table table-striped">
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

      <?php
      // Check if query returned results
      if (isset($result) && $result->num_rows > 0) {
          while ($data = $result->fetch_assoc()) {
              $i++;
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
      } else {
          echo "<tr><td colspan='6'>No students found for this batch</td></tr>";
      }
      ?>

    </table>
  </div>
</div>

</center>
</body>
</html>
