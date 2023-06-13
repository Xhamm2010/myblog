<?php   
require 'config/database.php';

if (isset($_POST['submit'])) {
    // GET FORM DATA
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$title) {
        $_SESSION['add-category-error'] = 'Please Enter Title';
    } elseif (!$description) {
        $_SESSION['add-category-error'] = 'Please Enter Description';
    }

    // REDIRECT TO ADD-CATEGORY WITH DATA IF THERE IS AN INVALID INPUT
    if ($_SESSION['add-category-error']) {
        $_SESSION['add-category-data'] = $_POST;
        header('Location:'. ROOT_URL . 'admin/add-category.php');
        
    } else {
        // INSERT CATEGORY INTO DATABASE
        $query = "INSERT INTO  categories (title ,description) VALUE ('$title', '$description')";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_errno($conn)) {
            $_SESSION['add-category-error'] = 'Could not Add Category';
            header('location: ' . ROOT_URL . 'admin/add-category.php');
            die();
        } else {
            $_SESSION['add-category-success'] = 'Category Added Successfully';
            header('location: '. ROOT_URL . 'admin/manage-category.php');
            die();
        }
    }

}
