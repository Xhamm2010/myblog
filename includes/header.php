<?php

require 'config/database.php';

// FETCH CURRENT USER FROM DATABASE
if (isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $avatar = mysqli_fetch_assoc($result);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Websit</title>
    <!-- Custom CSS --> 
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/styles.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/all.min.css">
</head>
<body>
    <!-- <i class="fab fa-facebook-"></i> -->
    <nav>
        <div class="container nav__container">
            <a href="<?= ROOT_URL ?>" class="nav__logo">Ezekiel</a>
            <ul class="nav__items">
                <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li> 
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>

               <?php if(isset($_SESSION['user-id'])) : ?>
                    <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= ROOT_URL. 'uploadimg/'. $avatar['avatar']?>" alt="">
                    </div>
                    <ul>
                        <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                        <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                    </ul>
                   </li>
                <?php else : ?>
                <li><a href="<?= ROOT_URL ?>signin.php">Sign-In</a></li>
                <?php endif; ?>
                
            </ul>
           <button id="open__nav-btn"><i class="fa fa-list-ul"></i></button>
           <button id="close__nav-btn"><i class="fa fa-close"></i></button>
        </div>
    </nav>
    <!-- End of Nav -->