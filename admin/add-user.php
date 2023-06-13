<?php
include 'includes/header.php';

// GET ALL ADD-USER DATA
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;
$is_admin = $_SESSION['add-user-data']['userrole'] ?? null;

unset($_SESSION['add-user-data']);
?>

<!--========================== End of Nav =================================================-->
<!-- =================== Form Section ==================================================== -->
<section class="form__section">
  <div class="container form__section-container">
    <h2>Add User</h2>
    <?php if (isset($_SESSION['add-user-error'])) : ?>
      <div class="alert__message error">
        <p>
        <?= $_SESSION['add-user-error'];
                unset($_SESSION['add-user-error']);
            ?>
        </p>
      </div>
    <?php endif; ?>
    <form action="<?= ROOT_URL ?>admin/add-user-process.php" method="post" enctype="multipart/form-data">
      <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name" />
      <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name" />
      <input type="text" name="username" value="<?= $username ?>" placeholder="Username" />
      <input type="email" name="email" value="<?= $email ?>" placeholder="Enter Email" />
      <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Create Password" />
      <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password" />
      <select name="userrole">
        <option value="0">Author</option>
        <option value="1">Admin</option>
      </select>
      <div class="form__control">
        <label for="avatar">Add Avatar</label>
        <input type="file" name="avatar" id="avatar" />
      </div>
      <button type="submit" name="submit" class="btn">Add User</button>
    </form>
  </div>
</section>
<!-- =================================End of Form =================================================== -->

<!--=============================== Footer Starts ====================================================-->
<?php
include '../includes/footer.php';
?>