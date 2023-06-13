<?php

require '../includes/header.php';

// CHECK LOGIN STATUS
if (!isset($_SESSION['user-id'])) {
    header('Location: '.ROOT_URL.'signin.php');
    die();   
}

?>


