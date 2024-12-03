<?php
session_start();
include 'includes/conn.php';

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hash and salt the password
    $hashedPassword = hash('sha256', '2123293dsj2hu2nikhiljdsd' . hash('sha256', $password));

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists
        echo "<div class='popup popup--icon -error js_error-popup popup--visible' onclick='closePopup()'>
                <div class='popup__background'></div>
                <div class='popup__content'>
                    <h3 class='popup__content__title'>Error</h3>
                    <p>This account already exists. Please use a different email address.</p>
                </div>
            </div>";
    } else {
        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO admin (name, username, password, is_verified) VALUES (?, ?, ?, 1)");
        $stmt->bind_param("sss", $name, $username, $hashedPassword);

        if ($stmt->execute()) {
            // Redirect to the login page with a success message
            header("Location: login.php?success=1");
            exit();
        } else {
            // Show error popup on failure
            echo "<div class='popup popup--icon -error js_error-popup popup--visible' onclick='closePopup()'>
                    <div class='popup__background'></div>
                    <div class='popup__content'>
                        <h3 class='popup__content__title'>Error</h3>
                        <p>Registration Failed. Please try again.</p>
                    </div>
                </div>";
        }
    }

    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <link rel="stylesheet" href="css/pop.css">
   <link rel="stylesheet" href="css/style.css">
   <title>Register</title>
</head>
<body>
   <form action="" method="POST">
      <div class="container d-flex justify-content-center align-items-center min-vh-100">
         <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
               <div class="featured-image mb-3">
                  <img src="img/444.png" class="img-fluid" style="width: 400px; border-radius: 10px;">
               </div>
            </div>
            <div class="col-md-6 right-box">
               <div class="row align-items-center">
                  <div class="header-text mb-4">
                     <h2>REGISTER</h2>
                     <p>Create your account to access our services.</p>
                  </div>
                  <div class="input-group mb-3">
                     <input type="text" name="name" class="form-control form-control-lg bg-light fs-6" required placeholder="Name">
                  </div>
                  <div class="input-group mb-3">
                     <input type="email" name="username" class="form-control form-control-lg bg-light fs-6" required placeholder="Email">
                  </div>
                  <div class="input-group mb-3">
                     <input type="password" name="password" class="form-control form-control-lg bg-light fs-6" required placeholder="Password">
                  </div>
                  <div class="input-group mb-3">
                     <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Register</button>
                  </div>
                  <p class="text-center">Already have an account? <a href="login.php">Sign In</a></p>
               </div>
            </div>
         </div>
      </div>
   </form>
   
</body>
</html>
