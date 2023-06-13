<?php

require 'config/constants.php';

// GET USER SIGNIN DATA
$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;
unset($_SESSION['signin-data']);

?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog Websit</title>
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/styles.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/all.min.css" />
</head>

<body>
  <!-- =================== Form Section ==================================================== -->
  <section class="form__section">
    <div class="container form__section-container">
      <h2>Sign In</h2>
      <?php if (isset($_SESSION['signup-success'])) : ?>
        <div class="alert__message success">
          <p><?= $_SESSION['signup-success'];
              unset($_SESSION['signup-success']); ?></p>
        </div>
      <?php elseif (isset($_SESSION['signin-error'])) : ?>
        <div class="alert__message error">
          <p><?= $_SESSION['signin-error'];
              unset($_SESSION['signin-error']); ?></p>
        </div>
      <?php endif; ?>
      

      <form action="<?= ROOT_URL ?>signin-process.php" method="post">
        <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or Email" />
        <input type="password" name="password" value="<?= $password ?>" placeholder="Password" />
        <button type="submit" name="submit" class="btn">Sign In</button>
        <small>Don't have an Account?<a href="signup.php">Sign Up</a></small>
      </form>
    </div>
  </section>

  <script src="./main.js"></script>
</body>

</html>