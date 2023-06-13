<?php 
require 'config/database.php';


if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured= filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // IF IS_FEATURED IS UNCHECK, SET IT TO 0
    $is_featured = $is_featured == 1 ?  : 0;

    // VALIDATE FORM DATA
    if (!$title) {
        $_SESSION['add-post-error'] = 'Please Add Post Title';
    } elseif (!$body) {
        $_SESSION['add-post-error'] = 'Please Add Post Body';
    } elseif (!$category_id) {
        $_SESSION['add-post-error'] = 'Please Choose a Category';
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post-error'] = 'Choose Add post thumbnail';
    }  else {
        // WORK ON THUMBNAIL
        $time = time();
        $thumbnail_name = $time.$thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../uploadimg/' . $thumbnail_name;

        // VALIDATE THAT FILE IS AN IMAGE
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $tmpextention = explode('.', $thumbnail_name);
        $extention = strtolower(end($tmpextention));

        if (in_array($extention, $allowed_files)) {
            // CHECK IF IMAGE IS TOO LARGE (1MB MAXIMUM)
            if ($thumbnail['size'] < 2_000_000) {
                // UPLOAD AVATAR
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post-error'] = 'Thumbnail File Should Be Less Than 2mb';
            }
        } else {
            $_SESSION['add-post-error'] = 'Thumbnail File Should Be Png, Jpg OR Jpeg';
        }

    }

    //    REDIRECT TO ADD-POST IF THERE WAS AN ERROR
    if (isset($_SESSION['add-post-error'])) {
        // PASS FORM DATA BACK TO ADD-POST PAGE
        $_SESSION['add-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    } else {
        // SET IS_FEATURED OF ALL POST TO 0 IF IS_FEATURED OF THIS POST IS 1
        if ($is_featured == 1) {
            $is_featured_zero = "UPDATE posts SET is_featured = 0";
            $result = mysqli_query($conn, $is_featured_zero);
        }
        // INSERT POST INTO DATABASE
        $insert_post = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";
        $result = mysqli_query($conn, $insert_post);

        if (!mysqli_errno($conn)) {
            // REDIRECT TO MANAGE POST WITH SUCCESS MESSAGE
            $_SESSION['add-post-success'] = "New Post SUCCESSFULLY Added";
            header('location: ' . ROOT_URL . 'admin/');
            die();
        }
    }

}
header('location: ' . ROOT_URL . 'admin/add-post.php');
die();
