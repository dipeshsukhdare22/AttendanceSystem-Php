<?php
ob_start();
session_start();

if($_SESSION['name'] != 'oasis') {
  header('location: login.php');
}
?>
<?php include('connect.php'); ?>

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
        <h3>Individual Report</h3>
        <form method="post" action="">
          <label>Select Subject</label>
          <select name="whichcourse">
            <option value="algo">Analysis of Algorithms</option>
            <option value="algolab">Analysis of Algorithms Lab</option>
            <option value="dbms">Database Management System</option>
            <option value="dbmslab">Database Management System Lab</option>
            <option value="weblab">Web Programming Lab</option>
            <option value="os">Operating System</option>
            <option value="oslab">Operating System Lab</option>
            <option value="obm">Object Based Modeling</option>
            <option value="softcomp">Soft Computing</option>
          </select>
          <p> </p>
          <label>Student Reg. No.</label>
          <input type="text" name="sr_id">
          <input type="submit" name="sr_btn" value="Go!">
        </form>

        <h3>Mass Report</h3>
        <form method="post" action="">
          <label>Select Subject</label>
          <select name="course">
            <option value="algo">Analysis of Algorithms</option>
            <option value="algolab">Analysis of Algorithms Lab</option>
            <option value="dbms">Database Management System</option>
            <option value="dbmslab">Database Management System Lab</option>
            <option value="weblab">Web Programming Lab</option>
            <option value="os">Operating System</option>
            <option value="oslab">Operating System Lab</option>
            <option value="obm">Object Based Modeling</option>
            <option value="softcomp">Soft Computing</option>
          </select>
          <p> </p>
          <label>Date (yyyy-mm-dd)</label>
          <input type="text" name="date">
          <input type="submit" name="sr_date" value="Go!">
        </form>

        <br>

        <?php
        if (isset($_POST['sr_btn'])) {
          $sr_id = $_POST['sr_id'];
          $course = $_POST['whichcourse'];

          // Prepared statement for fetching individual report
          $single_stmt = $conn->prepare("SELECT stat_id, COUNT(*) AS countP FROM attendance WHERE stat_id = ? AND course = ? AND st_status = 'Present'");
          $single_stmt->bind_param("ss", $sr_id, $course);
          $single_stmt->execute();
          $single_result = $single_stmt->get_result();

          // Prepared statement for fetching total attendance count
          $singleT_stmt = $conn->prepare("SELECT COUNT(*) AS countT FROM attendance WHERE stat_id = ? AND course = ?");
          $singleT_stmt->bind_param("ss", $sr_id, $course);
          $singleT_stmt->execute();
          $singleT_result = $singleT_stmt->get_result();
        }

        if (isset($_POST['sr_date'])) {
          $sdate = $_POST['date'];
          $course = $_POST['course'];

          // Prepared statement for mass report based on date
          $all_stmt = $conn->prepare("SELECT * FROM attendance WHERE stat_date = ? AND course = ?");
          $all_stmt->bind_param("ss", $sdate, $course);
          $all_stmt->execute();
          $all_result = $all_stmt->get_result();
        }
        ?>

        <table class="table table-stripped">
          <thead>
            <tr>
              <th scope="col">Reg. No.</th>
              <th scope="col">Name</th>
              <th scope="col">Department</th>
              <th scope="col">Batch</th>
              <th scope="col">Date</th>
              <th scope="col">Attendance Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Ensure all_result is set and has data
            if (isset($all_result) && $all_result->num_rows > 0) {
              while ($data = mysqli_fetch_array($all_result)) {
                echo "<tr>
                        <td>{$data['st_id']}</td>
                        <td>{$data['st_name']}</td>
                        <td>{$data['st_dept']}</td>
                        <td>{$data['st_batch']}</td>
                        <td>{$data['stat_date']}</td>
                        <td>{$data['st_status']}</td>
                      </tr>";
              }
            } else {
              echo "<tr><td colspan='6'>No records found.</td></tr>";
            }
            ?>
          </tbody>
        </table>

        <?php
        // Display individual report if available
        if (isset($_POST['sr_btn']) && $single_result->num_rows > 0) {
          $single_data = mysqli_fetch_array($single_result);
          $total_classes = mysqli_fetch_array($singleT_result)[0];  // Get total count

          echo "<table class='table table-striped'>
                  <tbody>
                    <tr>
                      <td>Student Reg. No: </td><td>{$single_data['stat_id']}</td>
                    </tr>
                    <tr>
                      <td>Total Class (Days): </td><td>{$total_classes}</td>
                    </tr>
                    <tr>
                      <td>Present (Days): </td><td>{$single_data['countP']}</td>
                    </tr>
                    <tr>
                      <td>Absent (Days): </td><td>" . ($total_classes - $single_data['countP']) . "</td>
                    </tr>
                  </tbody>
                </table>";
        }
        ?>
      </div>
    </div>
  </center>
</body>
</html>
