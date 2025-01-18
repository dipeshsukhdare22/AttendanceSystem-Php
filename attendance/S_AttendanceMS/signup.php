<?php

include('connect.php');

try {
    if (isset($_POST['signup'])) {

        // Checking if required fields are empty
        if (empty($_POST['email'])) {
            throw new Exception("Email can't be empty.");
        }

        if (empty($_POST['uname'])) {
            throw new Exception("Username can't be empty.");
        }

        if (empty($_POST['pass'])) {
            throw new Exception("Password can't be empty.");
        }

        if (empty($_POST['fname'])) {
            throw new Exception("Full Name can't be empty.");
        }

        if (empty($_POST['phone'])) {
            throw new Exception("Phone can't be empty.");
        }

        if (empty($_POST['type'])) {
            throw new Exception("User Type can't be empty.");
        }

        $stmt = $conn->prepare("INSERT INTO admininfo (username, password, email, fname, phone, type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $_POST['uname'], $_POST['pass'], $_POST['email'], $_POST['fname'], $_POST['phone'], $_POST['type']);

        if ($stmt->execute()) {
            $success_msg = "Signup Successfully!";
        } else {
            throw new Exception("Error occurred during signup. Please try again.");
        }
        $stmt->close(); 
    }
} catch (Exception $e) {
    $error_msg = $e->getMessage();
}

?>

<?php
// Print success or error message
if (isset($success_msg)) {
    echo "<div class='alert alert-success'>$success_msg</div>";
}
if (isset($error_msg)) {
    echo "<div class='alert alert-danger'>$error_msg</div>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance Management System</title>
<meta charset="UTF-8">
  
  <link rel="stylesheet" type="text/css" href="css/main.css">   
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css" >
</head>

<body>
    <div class="container mt-2">
        <header class="text-center mb-2">
            <h1>Attendance Management System</h1>
            <h3>Signup</h3>
        </header>
        
        <?php
        if (isset($success_msg)) echo '<div class="alert alert-success text-center">' . $success_msg . '</div>';
        if (isset($error_msg)) echo '<div class="alert alert-danger text-center">' . $error_msg . '</div>';
        ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="fname">Full Name</label>
                                <input type="text" name="fname" class="form-control" id="fname" placeholder="Full Name" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="number" name="phone" class="form-control" id="phone" placeholder="Phone Number" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Your Email" required>
                            </div>

                            <div class="form-group">
                                <label for="uname">Username</label>
                                <input type="text" name="uname" class="form-control" id="uname" placeholder="Choose Username" required>
                            </div>

                            <div class="form-group">
                                <label for="pass">Password</label>
                                <input type="password" name="pass" class="form-control" id="pass" placeholder="Enter Password" required>
                            </div>

                            <div class="form-group">
                                <label>User Role:</label>
                                <div class="d-flex justify-content-between">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="type" id="student" value="student" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="student">Student</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="type" id="teacher" value="teacher" class="custom-control-input">
                                        <label class="custom-control-label" for="teacher">Teacher</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="type" id="admin" value="admin" class="custom-control-input">
                                        <label class="custom-control-label" for="admin">Admin</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block" name="signup">Signup</button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p><strong>Already have an account? <a href="index.php" class="text-primary">Login</a> here.</strong></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
