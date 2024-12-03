<?php
include 'includes/conn.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];




    // under construction please be aware okay !!!!!!!!!!!!












    // Verify the token and set the user as verified
    $stmt = $conn->prepare("UPDATE admin SET is_verified = 1, verification_token = NULL WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<div class='popup popup--icon -success js_success-popup popup--visible'>
            <div class='popup__background'></div>
            <div class='popup__content'>
                <h3 class='popup__content__title'>Success</h3>
                <p>Your email has been verified. You may now <a href='login.php'>log in</a>.</p>
            </div>
        </div>";
    } else {
        echo "<div class='popup popup--icon -error js_error-popup popup--visible'>
            <div class='popup__background'></div>
            <div class='popup__content'>
                <h3 class='popup__content__title'>Error</h3>
                <p>Invalid or expired token.</p>
            </div>
        </div>";
    }
    $stmt->close();
}
?>
