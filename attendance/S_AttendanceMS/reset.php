<?php 
  include('connect.php');
 ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Attendance Management System</title>
  <meta charset="UTF-8">
  <!-- <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/main.css"> -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="styles.css">

</head>

<body>
<header class="bg-dark text-white py-3 mb-4 border-bottom border-secondary">
    <div class="container d-flex justify-content-between align-items-center">
      <h1 class="h4">Attendance Management System</h1>
      <a href="index.php" class="btn btn-outline-light">Login</a>
    </div>
  </header>

  <main class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h3 class="text-center mb-4">Recover Your Password</h3>
            <form method="post">
              <div class="mb-3">
                <label for="inputEmail" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter your email" required>
              </div>
              <div class="text-end">
                <button type="submit" class="btn btn-dark" name="reset">Recover Password</button>
              </div>
            </form>

            <div class="mt-4">
              <?php
              if (isset($_POST['reset'])) {
                  $test = $_POST['email'];
                  $row = 0;

                  $query = $conn->prepare("SELECT password FROM admininfo WHERE email = ?");
                  $query->bind_param("s", $test);
                  $query->execute();
                  $result = $query->get_result();
                  $row = $result->num_rows;

                  if ($row == 0) {
                      echo "<div class='alert alert-danger'>No matching email found.</div>";
                  } else {
                      while ($dat = $result->fetch_assoc()) {
                          echo "<div class='alert alert-success'>
                                  <strong>Hi there!</strong><br>
                                  You requested a password recovery. You may <a href='index.php'>Login here</a> and enter this key as your password to login.<br>
                                  <strong>Recovery key:</strong> <mark>" . $dat['password'] . "</mark><br>
                                  Regards,<br>Attendance Management System
                                </div>";
                      }
                  }
              } else {
                  echo "<div class='alert alert-info'>Email is not associated with any account. Contact Dipesh 1.0.</div>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="bg-dark text-white text-center py-3 mt-5 border-top border-secondary">
    <p class="mb-0">&copy; 2025 Attendance Management System</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>