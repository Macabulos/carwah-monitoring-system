
<?php
   session_start();
   include 'includes/conn.php';
   
   if(isset($_POST['username']) && isset($_POST['password'])) {
   
      $username = $_POST['username'];
      $password = $_POST['password'];
      
      // Hashing the password
      $passw = hash('sha256', $password);
      function createSalt() {
         return '2123293dsj2hu2nikhiljdsd';
      }
      $salt = createSalt();
      $pass = hash('sha256', $salt.$passw);

      // SQL query to select admin
      $sql_query = "SELECT id, username, password FROM admin WHERE username= '$username' AND password = '$pass' LIMIT 1";
      
      $result = $conn->query($sql_query);
      
      if ($result->num_rows > 0) {
         
         // Fetch user data from database
         $row = $result->fetch_assoc();
         
         if ($row['username'] == $username && $row['password'] == $pass) {
            // Start the session and store user info
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $row['id'];
            $_SESSION['password'] = $password;
?>
            <!-- Success Popup -->
            <div class="popup popup--icon -success js_success-popup popup--visible">
               <div class="popup__background"></div>
               <div class="popup__content">
                  <h3 class="popup__content__title">Success</h3>
                  <p>Login Successfully</p>
                  <p>
                     <?php echo "<script>setTimeout(\"location.href = 'dashboard.php';\",1500);</script>"; ?>
                  </p>
               </div>
            </div>
<?php
         } 
      } else {
?>
         <!-- Error Popup (Only shown if login fails) -->
         <div class="popup popup--icon -error js_error-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
               <h3 class="popup__content__title">Error</h3>
               <p>Invalid Email or Password</p>
               <p>
                  <a href="login.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
               </p>
            </div>
         </div>
<?php
      }
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
    <title>Login</title>
</head>
<body>
    <form action="" method="POST"> <!-- Form action set to empty to submit to the same page -->
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
                            <h2>SIGN IN</h2>
                            <p>We are happy to have you back.</p>
                           
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" name="username"  id="userEmail" class="form-control form-control-lg bg-light fs-6" required placeholder="Email">
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" name="password" id="password" class="form-control form-control-lg bg-light fs-6" required placeholder="Password">
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="chk">
                                <label for="chk" class="form-check-label text-secondary"><small>Show Password</small></label>
                                <p class="text-right">Forgot your password? <a href="reset_password.php">Reset here</a></p>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" name="admin_login" class="btn btn-lg btn-primary w-100 fs-6">Sign In</button>
                           <!-- Inside the login form -->
                        <p class="text-center">Don’t have an account? <a href="register.php">Register</a></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        const userassword = document.getElementById("password");
        const chk = document.getElementById("chk");
        chk.onchange = function() {
            password.type = chk.checked ? "text" : "password";

        };

        // Function to display the popup
       function showPopup(type, title, message) {
           const popup = document.getElementById('popup');
           const popupTitle = document.getElementById('popup-title');
           const popupMessage = document.getElementById('popup-message');

           popup.className = 'popup popup--visible popup--icon ' + type;
           popupTitle.textContent = title;
           popupMessage.textContent = message;
       }

       // Function to close the popup
       function closePopup() {
           const popup = document.getElementById('popup');
           popup.classList.remove('popup--visible');
       }

       // Optional: Automatically close the popup after 5 seconds
       setTimeout(() => {
           closePopup();
       }, 5000);
    </script>
</body>
</html>