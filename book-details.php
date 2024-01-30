<?php
    session_start();
    require_once("dbconnect.php");

    $bookId = (isset($_GET['bookid'])? $_GET['bookid'] : '');
    $userId = (isset($_SESSION['user_id'])? $_SESSION['user_id'] : '');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Book Readers Forum</title>
</head>
<body>

    <?php
        if(isset($_SESSION['user_email'])) {require_once("logged_header.php");} 
        else {require_once("header.php");}
    ?>

    <div class="body">
        <div class="body-container">
            <div class="left-body">
                <?php include_once("left-body.php"); ?>
            </div>

            <div class="right-body">
                <?php
                if(isset($_GET['delreviewid'])){
                    $delreview = $_GET['delreviewid'];
                    $bookid = $_GET['bookid'];
                
                    echo '<br><p><h2>Are you sure you want to delete the review? <a href="?delreview='.$delreview.'&bookid='.$bookId.'"><b> Yes </b></a> | <a href="?bookid='.$bookId.'"><b> No </b></a></h2></p><br>';
                } else if(isset($_GET['delreview'])){
                    $reviewid = $_GET['delreview'];
                
                    if(deleteDataById("reviews", "ID = $reviewid")){
                        echo '<p class="notify-green">Review Deleted Successfully</p>';
                    }
                }

                if(isset($_POST['commentsubmit'])){
                    $commenttext = $_POST['commenttext'];
                    $review_date = date("Y-m-d");
                    $bookId = $_POST['bookid'];
                    
                    $sql = "INSERT INTO reviews (user_id, review_text, review_date, book_id) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $sql);
                    
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "issi", $userId, $commenttext, $review_date, $bookId);
                
                        if (mysqli_stmt_execute($stmt)) {
                            echo '<p class="notify-green">Your review on this post has been published.</p>';
                        } else {
                            echo '<p class="notify-red">Error! Review publish unsuccessful.<br><b>Your review:</b> '.$commenttext.'</p>';
                        }
                        
                        mysqli_stmt_close($stmt);
                    } else {
                        echo '<p class="notify-red">Error preparing the statement.</p>';
                    }
                }                
                ?>
                <form action="?review=done" method="post">
                <div class="heading">
                    <h3><span>BOOK DETAILS</span></h3>
                </div>
                <?php 
                $bookResult = fetchDataById("books", "ID = $bookId");
                $authorResult = fetchDataById("authors", "ID = " . $bookResult['author_id']);
                $bookCatResult = fetchDataById("categories", "cat_id = " . $bookResult['category_id']);
                ?>
                <div class="book-i-cover">
                    <div class="book-i-img">
                        <img src="<?php echo $bookResult['image_path']; ?>" alt="<?php echo $bookResult['name']; ?>"><br>
                        <span class="book-i-rating">Rating: <?php echo $bookResult['rating']; ?></span>
                    </div>
                    <div class="book-i-details">
                        <span class="book-i-name"><h2><?php echo $bookResult['name']; ?></h2></span>
                        <span class="book-i-author"><h4>by <b><?php echo $authorResult['name']; ?></b></h4></span>
                        <span class="book-i-genre"><h5><b>Genre :</b> <?php echo $bookCatResult['cat_name']; ?></h5></span>
                        <span class="book-i-publish"><h5><b>Date Published :</b> Publishing date here</h5></span>
                        <span class="book-i-postedby"><h5><b>Posted by :</b> Administrator</h5></span>
                        <span class="book-i-synopsis"><h5><b>Synopsis :</b> Summary of the book is described here.</h5></span>
                    </div>
                </div>


                <?php
                if(isset($_SESSION['user_email'])) {
                    echo '<div class="heading">
                        <h3><span>WRITE A REVIEW ON THIS</span></h3>
                    </div>
                    <div class="review-box">
                        <div class="review-box-form">
                            <input type="hidden" name="bookid" value="'.$bookId.'">
                            <textarea name="commenttext" id="commenttext" cols="80" rows="10">Write something...</textarea>
                            <input type="submit" name="commentsubmit" id="submit" value="Make Review">
                        </div>
                    </div>
                    </form>';
                    }
                ?>


                <div class="heading">
                    <h3><span>USER REVIEWS</span></h3>
                </div>
                <?php
                $reviewRows = fetchDataById("reviews", "book_id = $bookId", "ID, user_id, review_text, review_date, book_id");
                if(!($reviewRows)) {
                    echo '<p class="notify-red">No reviews yet. Be the first to review this book.</p>';
                } else {
                    foreach($reviewRows as $reviewData){
                    $revauthId = $reviewData['user_id'];
                    $revauthData = fetchDataById("users", "ID = $revauthId");
                    echo '<div class="cmnt-body">
                            <div class="cmnt-auth">
                                <img src="avatar.jpg" alt="user">
                            </div>
                            <div class="cmnt-block">
                                <span class="cmnt-auth-name"><h3>'.$revauthData['name'].'</h3> <font color="orange"> | </font> <font color="grey"><small>'.$reviewData['review_date'].'</small></font></span>
                                <span class="cmnt-text" style="white-space: pre-line;">'.$reviewData['review_text'].'</span>
                                <span class="edel"><a href="?delreviewid='.$reviewData['ID'].'&bookid='.$bookId.'">Delete</a>
                            </div>
                        </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <?php require_once("footer.php") ?>

</body>
</html>