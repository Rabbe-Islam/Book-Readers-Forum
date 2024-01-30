<?php
    session_start();
    require_once("dbconnect.php");
    require_once("loginvalidate.php");
    require_once("adminvalidate.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Book Readers Forum</title>
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
                    <h3><span>ADMINISTRATOR PANEL</span></h3>
                </div>

                <div class="admin-panel-blk">

                    <!-- Section for Adding or Deleting Books -->
                    <div class="panel-heading"> Add A New Book </div>
                    <?php
                    if (isset($_POST['submit-book']) && isset($_POST['name']) && isset($_POST['authorid']) && isset($_POST['catid']) && isset($_POST['rating'])) {
                        // Retrieve form data
                        $name = isset($_POST['name']) ? $_POST['name'] : '';
                        $authorId = isset($_POST['authorid']) ? $_POST['authorid'] : '';
                        $catId = isset($_POST['catid']) ? $_POST['catid'] : '';
                        $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
                    
                        // File upload handling
                        $uploadDir = 'uploads/';
                        $uploadFile = $uploadDir . md5(uniqid()) . '_' . basename($_FILES['bookimg']['name']);
                    
                        if (move_uploaded_file($_FILES['bookimg']['tmp_name'], $uploadFile)) {
                            $inserted = insertDataRow('books', 'name, author_id, rating, category_id, image_path', 
                                "'" . $name . "', $authorId, $rating, $catId, '" . $uploadFile . "'");
                    
                            if ($inserted) {
                                echo '<p class="notify-green">Book added successfully.</p>';
                            } else {
                                echo '<p class="notify-red">Failed to add book to the database.</p>';
                            }
                        } else {
                            echo '<p class="notify-red">Plese fill up all informations to add a new book</p>';
                        }
                    }                    
                    ?>
                    <form action="" method="post" class="addx-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Book Name : </label>
                            <input type="text" id="name" name="name" placeholder="Enter Book name" required>
                        </div>
                        <div class="form-group">
                            <label for="bookimg">Book Cover Image : </label><br>
                            <input type="file" id="bookimg" name="bookimg" required>
                        </div>
                        <div class="form-group">
                            <label for="authorid">Author ID : </label>
                            <select id="authorid" name="authorid">
                                <option value="" selected>-- Select Author --</option>
                                <?php
                                $authorDataRows = fetchDataById('authors', '', 'ID, name');
                                foreach ($authorDataRows as $authorData) {
                                    echo '<option value="'.$authorData['ID'].'">'.$authorData['name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="catid">Category ID : </label>
                            <select id="catid" name="catid">
                                <option value="" selected>-- Select Category --</option>
                                <?php
                                $categoryDataRows = fetchDataById('categories', '', 'cat_id, cat_name');
                                foreach ($categoryDataRows as $categoryData) {
                                    echo '<option value="'.$categoryData['cat_id'].'">'.$categoryData['cat_name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating : </label>
                            <input type="number" id="rating" name="rating" step="0.5" min="0.0" max="10.0" value="8.5" required>
                        </div>
                        <button type="submit" name="submit-book" class="submit-button">SUBMIT NEW BOOK</button>
                    </form>


                    <!-- Section for Adding or Removing Author -->
                    <div class="panel-heading" id="authedit"> Add New Author </div>
                    <?php
                    if (isset($_POST['submit-author'])) {
                        // Retrieve form data
                        $authorName = isset($_POST['auth-name']) ? $_POST['auth-name'] : '';
                        $authorDetails = isset($_POST['auth-details']) ? $_POST['auth-details'] : '';

                        if (isset($_POST['auth-name'])) {
                            $inserted = insertDataRow('authors', 'name, details', "'$authorName', '$authorDetails'");
                    
                            if ($inserted) {
                                echo '<p class="notify-green">Author added successfully.</p>';
                            } else {
                                echo '<p class="notify-red">Failed to add author to the database.</p>';
                            }
                        } else {
                            echo '<p class="notify-red">Please enter author name.</p>';
                        }
                    }
                    ?>
                    <form action="#authedit" method="post" class="addx-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="auth-name">Author Name : </label>
                            <input type="text" id="auth-name" name="auth-name" placeholder="Enter author name" required>
                        </div>
                        <div class="form-group">
                            <label for="auth-details">Author Details (brief) : </label>
                            <textarea id="auth-details" name="auth-details" placeholder="Write brief about details..."></textarea>
                        </div>
                        <button type="submit" name="submit-author" class="submit-button">ADD NEW AUTHOR</button>
                    </form>


                    <!-- Section for Adding or Removing Book Category -->
                    <div class="panel-heading" id="catedit"> Add New Category </div>
                    <?php
                    if (isset($_POST['submit-category'])) {
                        // Retrieve form data
                        $categoryName = isset($_POST['cat-name']) ? $_POST['cat-name'] : '';

                        if (isset($_POST['cat-name'])) {
                            $inserted = insertDataRow('categories', 'cat_name', "'$categoryName'");
                    
                            if ($inserted) {
                                echo '<p class="notify-green">New category added successfully.</p>';
                            } else {
                                echo '<p class="notify-red">Failed to add new category to the database.</p>';
                            }
                        } else {
                            echo '<p class="notify-red">Please enter a category name.</p>';
                        }
                    }
                    ?>
                    <form action="#catedit" method="post" class="addx-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="cat-name">Category Name : </label>
                            <input type="text" id="cat-name" name="cat-name" placeholder="Enter category name...">
                        </div>
                        <button type="submit" name="submit-category" class="submit-button">ADD NEW CATEGORY</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <?php require_once("footer.php") ?>

</body>
</html>