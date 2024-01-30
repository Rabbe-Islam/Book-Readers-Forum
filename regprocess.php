<?php
session_start();
require_once("dbconnect.php");

if (isset($_POST['submit'])) {
    // Check if required fields are set
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repassword'])) {
        // Data from POST request
        $fullname = $_POST['name'];
        $email = $_POST['email'];
        $interests = $_POST['interests'];
        $pass = $_POST['password'];
        $repass = $_POST['repassword'];

        if ($pass !== $repass) {
            echo '<p class="notify-red">Password and Confirm Password do not match!</p>';
        } else {
            // Hash the password (use a secure hashing method)
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

            // Use prepared statement to insert data safely
            $sql = "INSERT INTO users (name, email, interests, password) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $fullname, $email, $interests, $hashedPassword);
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['user_email'] = $email;
                    header("Location: index.php");
                    exit();
                } else {
                    echo '<p class="notify-red">Registration failed due to SERVER ERROR!</p>';
                }
                mysqli_stmt_close($stmt);
            } else {
                echo '<p>Database error: ' . mysqli_error($conn) . '</p>';
            }
        }
    } else {
        echo '<p class="notify-red">Registration unsuccessful! Please fill up the form again...</p>';
    }
}
?>