<?php 
require 'config/constants.php';

// DESTROY ALL SESSION AND REDIRECT TO HOME PAGE
session_destroy();
header('Location: '.ROOT_URL);
die();
