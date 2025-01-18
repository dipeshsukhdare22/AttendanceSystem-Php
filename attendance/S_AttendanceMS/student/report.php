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

<!-- head started -->
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
<!-- head ended -->

<!-- body started -->
<body>

<!-- Menus started-->
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
<!-- Menus ended -->

<center>

<div class="row">

  <div class="content">
    <h3>Student Report</h3>
    <br>
    <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">

  <div class="form-group">

    <label  for="input1" class="col-sm-3 control-label">Select Subject</label>
      <div class="col-sm-4">
      <select name="whichcourse" id="input1">
         <option  value="algo">Analysis of Algorithms</option>
         <option  value="algolab">Analysis of Algorithms Lab</option>
        <option  value="dbms">Database Management System</option>
        <option  value="dbmslab">Database Management System Lab</option>
        <option  value="weblab">Web Programming Lab</option>
        <option  value="os">Operating System</option>
        <option  value="oslab">Operating System Lab</option>
        <option  value="obm">Object Based Modeling</option>
        <option  value="softcomp">Soft Computing</option>

      </select>
      </div>

  </div>

        <div class="form-group">
           <label for="input1" class="col-sm-3 control-label">Your Reg. No.</label>
              <div class="col-sm-7">
                  <input type="text" name="sr_id"  class="form-control" id="input1" placeholder="enter your reg. no." />
              </div>
        </div>
        <input type="submit" class="btn btn-danger col-md-3 col-md-offset-7" style="border-radius:0%" value="Find" name="sr_btn" />
    </form>

    <div class="content"><br></div>

    <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
    <table class="table table-striped">
    <?php
if (isset($_POST['sr_btn'])) {
    $sr_id = $_POST['sr_id'];
    $course = $_POST['whichcourse'];

    $i = 0;
    $count_pre = 0;
    $all_query = $conn->prepare("SELECT stat_id, COUNT(*) AS countP FROM attendance WHERE stat_id = ? AND course = ? AND st_status = 'Present'");
    $all_query->bind_param("ss", $sr_id, $course);
    $all_query->execute();
    $result_all = $all_query->get_result();

    $singleT = $conn->prepare("SELECT COUNT(*) AS countT FROM attendance WHERE stat_id = ? AND course = ?");
    $singleT->bind_param("ss", $sr_id, $course);
    $singleT->execute();
    $result_single = $singleT->get_result();

    $count_tot = 0;
    if ($row = $result_single->fetch_assoc()) {
        $count_tot = $row['countT'];
    }

    $attendance_data = $result_all->fetch_assoc(); 

    if ($attendance_data) { 
        $i++;
        if ($i <= 1) {
            ?>
            <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Registration No.:</td>
                            <td><?php echo $attendance_data['stat_id']; ?></td>
                        </tr>
                        <tr>
                            <td>Total Class (Days):</td>
                            <td><?php echo $count_tot; ?></td>
                        </tr>
                        <tr>
                            <td>Present (Days):</td>
                            <td><?php echo $attendance_data['countP']; ?></td>
                        </tr>
                        <tr>
                            <td>Absent (Days):</td>
                            <td><?php echo $count_tot - $attendance_data['countP']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <?php
        }
    } else {
        echo "No attendance data found for the provided details.";
    }
}
?>
    </table>
  </form>
  </div>

</div>
</center>
</body>
</html>
