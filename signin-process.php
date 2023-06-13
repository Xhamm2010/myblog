<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username_email) {
        $_SESSION['signin-error'] = 'username or email required';
    } elseif (!$password) {
        $_SESSION['signin-error'] = 'password required';
    } else {
        // FETCH USER FROM DATABASE
        $fetch_user = "SELECT * FROM users WHERE username = '$username_email' OR email = '$username_email'";
        $fetch_user_result = mysqli_query($conn, $fetch_user);

        if (mysqli_num_rows($fetch_user_result) > 0) {
            //  FETCH THE DATA
            $user_data = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_data['password'];

            // COMPARE DB PASSWORD WITH USER SUPPLIED PASSWORD
            if (password_verify($password, $db_password)) {
                // SET SESSION FOR ACCESS CONTROL
                $_SESSION['user-id'] = $user_data['id'];

                // SESSION IF USER IS AN ADMIN
                if ($user_data['is_admin'] == 1) {
                    $_SESSION['user-is-admin'] = true;
                   
                } 

                // LOG USER IN
                header('Location:' . ROOT_URL . 'admin/');
                die();

            } else {
                $_SESSION['signin-error'] = 'CHECK YOUR INPUT';
            }
        } else {
            $_SESSION['signin-error'] = 'USER NOT FOUND';
        }
    }

    // IF ANY ERROR OCCURS
    if (isset($_SESSION['signin-error'])) {
        $_SESSION['signin-data'] = $_POST;
        header('Location: ' . ROOT_URL . 'signin.php');
        die();
    }
} else {
    header('Location: ' . ROOT_URL . 'signin.php');
    die();
}
