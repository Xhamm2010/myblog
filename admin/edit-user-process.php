<?php
require 'config/database.php';

if (isset($_POST['id'])) {
    // GET UPDATED USERS INPUT FROM THE EDIT PAGE
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$firstname || !$lastname) {
        $_SESSION['edit-user-error'] = " Invalid Inputs";
    } else {
        // UPDATE THE USER
        $query = "UPDATE users
                  SET firstname = '$firstname',
                  lastname = '$lastname',
                  is_admin = $is_admin
                  WHERE id = $id LIMIT 1 ";
        $result = mysqli_query($conn, $query);
        if (mysqli_errno($conn)) {
            $_SESSION['edit-user-error'] = " Failed To Update User";
        } else {
            $_SESSION['edit-user-success'] = " User $firstname $lastname has been Updated Successfully";
        }
    }
}

header('Location: '. ROOT_URL .'admin/manage-user.php');
die();
