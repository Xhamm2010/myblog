<?php
include 'includes/header.php';

// GETTING USER ID
if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = " SELECT * FROM users WHERE `id` = '$id'";
  $result = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($result);
  $firstname = $user['firstname'];
  $lastname = $user['lastname'];

} else{
  header('Location: '. ROOT_URL . 'admin/manage-user.php');
  die();
}
?>
    <!--========================== End of Nav =================================================-->
    <!-- =================== Form Section ==================================================== -->
    <section class="form__section">
      <div class="container form__section-container">
        <h2>Edit User</h2>
        <form action="<?= ROOT_URL ?>admin/edit-user-process.php" method="post">
        <input type="hidden" value="<?= $id ?>" name="id">
          <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name" />
          <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name" />
          <select name="userrole">
            <option value="0">Author</option>
            <option value="1">Admin</option>
          </select>
          <button type="submit" name="submit" class="btn">Update User</button>
        </form>
      </div>
    </section>
    <!-- =================================End of Form =================================================== -->

    <!--=============================== Footer Starts ====================================================-->
    <?php
include '../includes/footer.php';
?>