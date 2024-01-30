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
    <div class="login-container">
        <div class="login-left">
            <img src="login-image.jpg" title="bookshelf">
        </div>
        <div class="login-right">
            <div class="center-heading">
                <h2><span>Login form</span></h2>
            </div>
            <div class="login-form">
                <?php require_once("loginprocess.php") ?>

                <form action="" method="post">
                    <label for="email">Email : </label><br>
                    <input type="email" name="email" id="email" placeholder="Your email" required>
                    <br><label for="password">Password : </label><br>
                    <input type="password" name="password" id="password" placeholder="Your Password" required><br>
                    <div class="alignright"><input type="submit" name="submit" id="submit" value="Submit"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once("footer.php") ?>
 
</body>
</html>