<?php
    session_start();
    require_once("dbconnect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Categories | Book Readers Forum</title>
</head>
<body>

    <?php
        if(isset($_SESSION['user_email'])) require_once("logged_header.php"); else require_once("header.php");
    ?>

    <div class="body">
        <div class="body-container">
            <div class="left-body">
                <?php include_once("left-body.php"); ?>
            </div>

            <div class="right-body">
                <div class="heading">
                    <h3><span>BOOK AUTHORS</span></h3>
                </div>
                <div class="author-list">
                    <?php
                    $authDataRow = fetchDataById("authors", "", "ID, name, details");
                    foreach($authDataRow as $authData) {
                        echo '<a href="explorer.php?author-id='.$authData['ID'].'"><span class="author-card">';
                        echo '<img src="avatar.jpg"><br>';
                        echo '<h2><b>'.$authData['name'].' [#'.$authData['ID'].']</b></h2><br><p>';
                        echo $authData['details'].'</p>';
                        echo '</span>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php require_once("footer.php") ?>

</body>
</html>