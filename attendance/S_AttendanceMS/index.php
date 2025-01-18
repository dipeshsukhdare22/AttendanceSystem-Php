<?php
  include('./connect.php'); 
if(isset($_POST['login'])) {
    // Start of try block
    try {

        // Checking empty fields
        if(empty($_POST['username'])) {
            throw new Exception("Username is required!");
        }
        if(empty($_POST['password'])) {
            throw new Exception("Password is required!");
        }
        
        // Prepare and execute query using mysqli and prepared statements
        $stmt = $conn->prepare("SELECT * FROM admininfo WHERE username = ? AND password = ? AND type = ?");
        $stmt->bind_param("sss", $_POST['username'], $_POST['password'], $_POST['type']);
        $stmt->execute();
        
        // Check if any row is returned
        $result = $stmt->get_result();
        $row = $result->num_rows;

        // Redirect based on role
        if($row > 0) {
            session_start();
            $_SESSION['name'] = "oasis";
            if($_POST["type"] == 'teacher') {
                header('location: teacher/index.php');
            } else if($_POST["type"] == 'student') {
                header('location: student/index.php');
            } else if($_POST["type"] == 'admin') {
                header('location: admin/index.php');
            }
        } else {
            throw new Exception("Username, Password or Role is wrong, try again!");
            header('location: login.php');
        }

    } catch(Exception $e) {
        $error_msg = $e->getMessage();
    }

    // End of try-catch
}
?>

<?php
// Display error message if available
if(isset($error_msg)) {
    echo "<div class='alert alert-danger'>$error_msg</div>";
}
?>


<!DOCTYPE html>
<html>
<head>

	<title>Attendance Management System</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="styles.css" >x
	 
</head>
<body>
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1>Attendance Management System</h1>
            <h3 class="mt-3">Login Panel</h3>
        </div>

        <?php
        if (isset($error_msg)) {
            echo '<div class="alert alert-danger text-center">' . $error_msg . '</div>';
        }
        ?>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter Your Username">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Your Password">
                            </div>

                            <div class="form-group">
                                <label>Login As:</label>
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

                            <button type="submit" class="btn btn-success btn-block" name="login">Login</button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <p><a href="reset.php" class="text-primary">Reset Password</a></p>
                    <p><a href="signup.php" class="text-primary">Create New Account</a></p>
                </div>
            </div>
        </div>
    </div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>