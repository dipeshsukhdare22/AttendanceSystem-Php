<?php
ob_start();
session_start();

if ($_SESSION['name'] != 'oasis') {
    header('location: ../index.php');
}
?>

<?php

include('connect.php');

try {
    if (isset($_POST['std'])) {
        $stmt = $conn->prepare("INSERT INTO students (st_id, st_name, st_dept, st_batch, st_sem, st_email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $_POST['st_id'], $_POST['st_name'], $_POST['st_dept'], $_POST['st_batch'], $_POST['st_sem'], $_POST['st_email']);
        
        // Execute the query
        $stmt->execute();
        $success_msg = "Student added successfully.";
    }

    if (isset($_POST['tcr'])) {
        $stmt = $conn->prepare("INSERT INTO teachers (tc_id, tc_name, tc_dept, tc_email, tc_course) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $_POST['tc_id'], $_POST['tc_name'], $_POST['tc_dept'], $_POST['tc_email'], $_POST['tc_course']);
        
        // Execute the query
        $stmt->execute();
        $success_msg = "Teacher added successfully.";
    }
} catch (Exception $e) {
    $error_msg = $e->getMessage();
}
?>

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
<style type="text/css">

  .message{
    padding: 10px;
    font-size: 15px;
    font-style: bold;
    color: black;
  }
</style>
</head>

<body>
    <header>
      <h1>Attendance Management System</h1>
      <div class="navbar">
      <a href="signup.php" style="text-decoration:none;">Create Users</a>
      <a href="index.php" style="text-decoration:none;">Add Student/Teacher</a>
      <a href="v-students.php" style="text-decoration:none;">View Students</a>
      <a href="v-teachers.php" style="text-decoration:none;">View Teachers</a>
      <a href="../logout.php" style="text-decoration:none;">Logout</a>

    </div>
    </header>
<center>
<!-- Error or Success Message printint started -->
<div class="message">
        <?php if(isset($success_msg)) echo $success_msg; if(isset($error_msg)) echo $error_msg; ?>
</div>

<div class="content">

  <center> Select: <a href="#teacher">Teacher</a> | <a href="">Student</a> <br></center>

  <div class="row" id="student">



      <form method="post" class="form-horizontal col-md-6 col-md-offset-3">
      <h4>Add Student's Information</h4>
      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Reg. No.</label>
          <div class="col-sm-7">
            <input type="text" name="st_id"  class="form-control" id="input1" placeholder="student reg. no." />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Name</label>
          <div class="col-sm-7">
            <input type="text" name="st_name"  class="form-control" id="input1" placeholder="student full name" />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Department</label>
          <div class="col-sm-7">
            <input type="text" name="st_dept"  class="form-control" id="input1" placeholder="department ex. CSE" />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Batch</label>
          <div class="col-sm-7">
            <input type="text" name="st_batch"  class="form-control" id="input1" placeholder="batch e.x 2020" />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Semester</label>
          <div class="col-sm-7">
            <input type="text" name="st_sem"  class="form-control" id="input1" placeholder="semester ex. Fall-15" />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Email</label>
          <div class="col-sm-7">
            <input type="email" name="st_email"  class="form-control" id="input1" placeholder="valid email" />
          </div>
      </div>


      <input type="submit" class="btn btn-primary col-md-2 col-md-offset-8" value="Add Student" name="std" />
    </form>

  </div>
<br><br><br>
  <div class="rowtwo" id="teacher">
  

       <form method="post" class="form-horizontal col-md-6 col-md-offset-3">
        <h4>Add Teacher's Information</h4>
      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Teacher ID</label>
          <div class="col-sm-7">
            <input type="text" name="tc_id"  class="form-control" id="input1" placeholder="teacher's id" />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Name</label>
          <div class="col-sm-7">
            <input type="text" name="tc_name"  class="form-control" id="input1" placeholder="teacher full name" />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Department</label>
          <div class="col-sm-7">
            <input type="text" name="tc_dept"  class="form-control" id="input1" placeholder="department ex. CSE" />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Email</label>
          <div class="col-sm-7">
            <input type="email" name="tc_email"  class="form-control" id="input1" placeholder="valid email" />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Subject Name</label>
          <div class="col-sm-7">
            <input type="text" name="tc_course"  class="form-control" id="input1" placeholder="subject ex. Software Engineering" />
          </div>
      </div>

      <input type="submit" class="btn btn-primary col-md-2 col-md-offset-8" value="Add Teacher" name="tcr" />
    </form>
    
  </div>
</div><br>
</center>
</body>
</html>
