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
      $sql_query = "SELECT id, username FROM admin WHERE username = ? AND password = ? AND is_verified = 1 LIMIT 1";
      $stmt = $conn->prepare($sql_query);
      $stmt->bind_param("ss", $username, $hashedPassword);
      $stmt->execute();
      $result = $stmt->get_result();
      
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
                     <?php echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>"; ?>
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
