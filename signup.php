<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<link rel="stylesheet" href="styles.css">
 
<?php require_once("header.php") ?>

<div class="body">
    <div class="center-heading">
        <h2><span>Registration form</span></h2>
    </div>

    <?php require_once("regprocess.php") ?>

    <form action="" method="post" class="reg-form">
        <div class="form-group">
            <label for="name">Username</label>
            <input type="text" id="name" name="name" placeholder="Enter full name..." required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email..." required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter a password..." required>
        </div>
        <div class="form-group">
            <label for="repassword">Retype Password</label>
            <input type="password" id="repassword" name="repassword" placeholder="Enter password again..." required>
        </div>
        <div class="form-group">
            <label for="interests">Interests</label>
            <input type="text" id="interests" name="interests" placeholder="Your interests...">
        </div>
        <button type="submit" name="submit" class="submit-button">Register Now</button>
    </form>
</div>

<?php require_once("footer.php") ?>
 
</body>
</html>