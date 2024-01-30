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
                    <h3><span>BOOK CATEGORIES</span></h3>
                </div>
                <div class="category-list">
                    <?php
                    $catDataRow = fetchDataById("categories", "", "cat_id, cat_name");
                    foreach($catDataRow as $catData) {
                        echo '<a href="explorer.php?cat-id='.$catData['cat_name'].'"><span class="cat-card">';
                        echo '<b>'.$catData['cat_name'].'</b>';
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