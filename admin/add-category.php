<?php
include 'includes/header.php';

// GET CATEGORY DATA
$title = $_SESSION['add-category-data']['title'] ?? null;
$description = $_SESSION['add-category-data']['description'] ?? null;
unset($_SESSION['add-category-data']);
?>
<!--========================== End of Nav =================================================-->
<!-- =================== Form Section ==================================================== -->
<section class="form__section">
  <div class="container form__section-container">
    <h2>Add Category</h2>
    <?php if (isset($_SESSION['add-category-error'])): ?>
      <div class="alert__message error">
      <p>
        <?= $_SESSION['add-category-error']; 
            unset($_SESSION['add-category-error']);
        ?>
    </p>
    </div>
    <?php endif ?> 
    <form action="<?= ROOT_URL ?>admin/add-category-process.php" method="post">
      <input type="text" name="title" value="<?= $title ?>" placeholder="Title" />
      <textarea name="description" value="<?= $description ?>" id="" rows="10" placeholder="Description"></textarea>
      <button type="submit" name="submit" class="btn">Add Category</button>
    </form>
  </div>
</section>
<!-- =================================End of Form =================================================== -->

<!--=============================== Footer Starts ====================================================-->
<?php
include '../includes/footer.php';
?>