<?php
include 'includes/header.php';

if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = " SELECT * FROM categories WHERE id = $id ";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $category = mysqli_fetch_assoc($result);
  }
} else {
  header('Location: ' . ROOT_URL . 'admin/manage-category.php');
  die();
}
?>
<!--========================== End of Nav =================================================-->
<!-- =================== Form Section ==================================================== -->
<section class="form__section">
  <div class="container form__section-container">
    <h2>Edit Category</h2>
    <form action="<?= ROOT_URL ?>admin/edit-category-process.php" method="post">
      <input type="hidden" name="id" value="<?= $category['id'] ?>" />
      <input type="text" name="title" value="<?= $category['title'] ?>" placeholder="Title" />
      <textarea name="description" id="" rows="10" placeholder="Description"><?= $category['description'] ?></textarea>
      <button type="submit" name="submit" class="btn">Update Category</button>
    </form>
  </div>
</section>
<!-- =================================End of Form =================================================== -->

<!--=============================== Footer Starts ====================================================-->
<?php
include '../includes/footer.php';
?>