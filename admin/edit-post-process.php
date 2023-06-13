<?php 

require 'config/database.php';
//  COLLECT ADD-USER SUBMIT DATA

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    // var_dump($thumbnail);

    // SET IS_FEATURED TO 0 IF IT IS UNCHECKED
    $is_featured = $is_featured == 1? : 0;

    // VALIDATE INPUT VALUE
    if (!$title || !$category_id || !$body) {
        $_SESSION['edit-post-error'] = 'Could not Update Post. Invalid Form Data';
    }  else {

        // DELETE EXISTING THUMBNAIL IF A NEW THUMBNAIL IS SELECTED 
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../uploadimg/'.$previous_thumbnail_name;
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }
        }

        // WORK ON THE NEW THUMBNAIL SELECED BY THE USER
        // thumbnail
        $time = time(); // to make each img name unique
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../uploadimg/' . $thumbnail_name;

        // VALIDATE THAT FILE IS AN IMAGE
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $tmpextention = explode('.', $thumbnail_name);
        $extention = strtolower(end($tmpextention));

        if (in_array($extention, $allowed_files)) {
            // CHECK IF IMAGE IS TOO LARGE (1MB MAXIMUM)
            if ($thumbnail['size'] < 2000000) {
                // UPLOAD thumbnail
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['edit-post-error'] = 'Image File Should Be Less Than 1mb';
            }
        } else {
            $_SESSION['edit-post-error'] = 'Image File Should Be Png, Jpg OR Jpeg';
        }
    }

    //    REDIRECT TO MANAGE-POST IF THERE WAS AN ERROR
    if (isset($_SESSION['edit-post-error'])) {
        header('location: ' . ROOT_URL . 'admin/index.php');
        die();
    } else {
        // SET IS_FEATURED OF ALL POST TO 0 IF THIS POST IS_FEATURED IS 1
            if ($is_featured == 1) {
                $zero_is_featured_query = "UPDATE posts SET is_featured = 0"; 
                $zero_is_featured_result = mysqli_query($conn, $zero_is_featured_query);
            }

        // SET THUMBNAIL NAME IF IT WAS UPDATED 
        $updated_thumbnail = $thumbnail_name ?? $previous_thumbnail_name;

        $query = "UPDATE posts
                  SET title = '$title', body = '$body', thumbnail = '$updated_thumbnail', category_id = $category_id,
                  is_featured = $is_featured
                  WHERE id = $id LIMIT 1";
        $result = mysqli_query($conn, $query);
       

        if (!mysqli_errno($conn)) {
            // REDIRECT TO LOGIN WITH SUCCESS MESSAGE
            $_SESSION['edit-post-success'] = " Post Has Been SUCCESSFULLY UPDATED";
            header('location: ' . ROOT_URL . 'admin/index.php');
            die();
        }
    }
} else {
    header('location: ' . ROOT_URL . 'admin/index.php');
    die();
}