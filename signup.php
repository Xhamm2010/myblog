
<?php

require 'config/constants.php';

  // GET ALL SIGN-UP DATA
   $firstname = $_SESSION['signup-data']['firstname'] ?? null;
   $lastname = $_SESSION['signup-data']['lastname'] ?? null;
   $username = $_SESSION['signup-data']['username'] ?? null;
   $email = $_SESSION['signup-data']['email'] ?? null;
   $createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
   $confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;

   unset($_SESSION['signup-data']);
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
        <h2>Sign Up</h2>
        <?php if (isset($_SESSION['signup-error'])) :?>
        <div class="alert__message error">
          <p>
            <?= $_SESSION['signup-error'];
                unset($_SESSION['signup-error']);
            ?>
          </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>signup-process.php" method="post" enctype="multipart/form-data">
          <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name" />
          <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name" />
          <input type="text" name="username" value="<?= $username ?>" placeholder="Username" />
          <input type="email" name="email" value="<?= $email ?>" placeholder="Enter Email" />
          <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Create Password" />
          <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password" />
          <div class="form__control">
            <label for="avatar">Use Avatar</label>
            <input type="file" name="avatar" id="avatar" />
          </div>
          <button type="submit" name="submit" class="btn">Sign Up</button>
          <small
            >Already have an Account?<a href="signin.php">Sign In</a></small
          >
        </form>
      </div>
    </section>

    <script src="./main.js"></script>
  </body>
</html>
