<?php
session_start();
require_once("dbconnect.php");

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use a prepared statement to prevent SQL injection
    $query = "SELECT ID, name, email, password, interests FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];

        if (password_verify($password, $stored_password)) {
            // Password is correct. User is authenticated.
            $adminData = fetchDataById("admins", "user_id = ".$row['ID']);
            // Set the user ID for further use in the application.
            $_SESSION['user_id'] = $row['ID'];
            if(isset($adminData['ID'])) {
                $_SESSION['admin_id'] = $adminData['ID'];
            }
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_name'] = $row['name'];
            
            // Redirect the user to a logged-in area or dashboard.
            header("Location: index.php");
            exit();
        } else {
            // Password is incorrect. Show an error message.
            echo '<p class="notify-red">Password is incorrect! Try again...</p>';
        }
    } else {
        // User not found. Show an error message.
        echo '<p class="notify-red">Account not found! Please check your Email or Username again</p>';
    }
}
?>