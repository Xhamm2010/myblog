<?php 
require 'config/database.php';
//  COLLECT ADD-USER SUBMIT DATA

if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_VALIDATE_INT);
    $avatar = $_FILES['avatar'];

    // VALIDATE INPUT VALUE
    if (!$firstname) {
        $_SESSION['add-user-error'] = 'Please Enter Your First Name';
    } elseif (!$lastname) {
        $_SESSION['add-user-error'] = 'Please Enter Your Last Name';
    } elseif (!$username) {
        $_SESSION['add-user-error'] = 'Please Enter Your UserName';
    } elseif (!$email) {
        $_SESSION['add-user-error'] = 'Please Enter  a Valid E-Mail';
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['add-user-error'] = 'Password should be more than 8 characters';
    } elseif (!$avatar['name']) {
        $_SESSION['add-user-error'] = 'Please Add Avatar';
    } else {
        //    Check if Password Matches
        if ($createpassword !== $confirmpassword) {
            $_SESSION['add-user-error'] = 'Password Do Not Match';
        } else {
            // HASHED PASSWORD
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // CHECK IF USER OR EMAIL EXIST
            $user_exist = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
            $user_exist_result = mysqli_query($conn, $user_exist);
            if (mysqli_num_rows($user_exist_result) > 0) {
                $_SESSION['add-user-error'] = 'Username OR Email Already Exist';
            } else {
                // AVATAR
                $time = time(); // to make each img name unique
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../uploadimg/' . $avatar_name;

                // VALIDATE THAT FILE IS AN IMAGE
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $tmpextention = explode('.', $avatar_name);
                $extention = strtolower(end($tmpextention));

                if (in_array($extention, $allowed_files)) {
                    // CHECK IF IMAGE IS TOO LARGE (1MB MAXIMUM)
                    if ($avatar['size'] < 1000000) {
                        // UPLOAD AVATAR
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['add-user-error'] = 'Image File Should Be Less Than 1mb';
                    }
                } else {
                    $_SESSION['add-user-error'] = 'Image File Should Be Png, Jpg OR Jpeg';
                }
            }
        }
    }

    //    REDIRECT TO SIGN-UP IF THERE WAS AN ERROR
    if (isset($_SESSION['add-user-error'])) {
        // PASS FORM DATA BACK TO SIGN-UP PAGE
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-user.php');
        die();
    } else {
        // INSERT NEW USER INTO DATABASE
        $insert_user = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', '$is_admin' )";
        $insert_user_result = mysqli_query($conn, $insert_user);

        if (!mysqli_errno($conn)) {
            // REDIRECT TO LOGIN WITH SUCCESS MESSAGE
            $_SESSION['add-user-success'] = " User $firstname $lastname Added SUCCESSFULLY";
            header('location: ' . ROOT_URL . 'admin/manage-user.php');
            die();
        }
    }
} else {
    header('location: ' . ROOT_URL . 'admin/add-user.php');
    die();
}
