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
    <title>Home | Book Readers Forum</title>
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
                    <h3><span>RECENT BOOKS</span></h3>
                </div>
                <div class="book-list">
    	        <?php
                $bookDataRows = fetchDataById('books', '', 'ID, name, author_id, category_id, rating, image_path');

                foreach ($bookDataRows as $bookData) {
                    $authorId = $bookData['author_id'];
                    $authorData = fetchDataById("authors", "ID=$authorId");
                    
                    // Check if authorData is found
                    if ($authorData) {
                        $authorName = $authorData['name'];
                    } else {
                        $authorName = "Unknown Author";
                    }

                    echo '<a href="book-details.php?bookid=' . $bookData['ID'] . '">
                            <div class="book-card">
                                <img src="' . $bookData['image_path'] . '" alt="Book ' . $bookData['ID'] . '">
                                <div class="book-card-details">
                                    <span class="ratings">' . $bookData['rating'] . ' stars</span>
                                    <h3>' . $bookData['name'] . '</h3>
                                    <p><b>By</b> ' . $authorName . '</p>
                                </div>
                            </div>
                        </a>';
                }
                ?>
                </div>
            </div>
        </div>
    </div>

    <?php require_once("footer.php") ?>

</body>
</html>