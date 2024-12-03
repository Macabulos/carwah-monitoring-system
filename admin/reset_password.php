<?php
include 'includes/conn.php';
$message = "";

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    
    // Verify token and check if it's not expired
    $sql = "SELECT * FROM admin WHERE reset_token = ? AND token_expiry > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        $message = "<div class='feedback-message feedback-error'>Invalid or expired reset link.</div>";
    }
} elseif (isset($_POST['password']) && isset($_POST['token'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    
    // Update password and clear reset token
    $sql = "UPDATE admin SET password = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ? AND token_expiry > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $password, $token);
    
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $message = "<div class='feedback-message feedback-success'>Password has been successfully reset. <a href='login.php'>Login here</a></div>";
    } else {
        $message = "<div class='feedback-message feedback-error'>Failed to reset password. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/forgot_password.css">
</head>
<body>
    <div class="forgot-password-container">
        <h2>Reset Password</h2>
        <?php if (!isset($_GET['token']) || (isset($_GET['token']) && $result->num_rows > 0)): ?>
            <form action="reset_password.php" method="POST">
                <div class="input-field email">
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="input-field password">
                    <input type="password" name="password" placeholder="Enter new password" required>
                </div>
                
                <div class="input-field password">
                    <input type="password" name="confirm_password" placeholder="Confirm new password" required>
                </div>
                
                <button type="submit">Reset Password</button>
            </form>
        <?php endif; ?>
        <?php echo $message; ?>
        <button onclick="window.location.href='login.php'" class="go-back-btn">Go Back</button>
    </div>
</body>
</html>

