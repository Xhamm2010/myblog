<?php
require 'config/database.php';

if (isset($_POST['submit']) && isset($_POST['id'])) {
    // GET UPDATED CATEGORIES INPUT FROM THE EDIT CATEGORY
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   

    if (!$title || !$description) {
        $_SESSION['edit-category-error'] = " Invalid Inputs";
    } else {
        // UPDATE THE CATEGORY
        $query = "UPDATE `categories` SET `title`='$title', `description`='$description' WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if (mysqli_errno($conn)) {
            $_SESSION['edit-category-error'] = " Failed To Update Category";
        } else {
            $_SESSION['edit-category-success'] = " Category $title has been Updated Successfully";
        }
    }
}

header('Location: '. ROOT_URL .'admin/manage-category.php');
die();