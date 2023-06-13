<?php
include 'includes/header.php';

// FETCH CATEGORIES FROM DATABASE 
$query = "SELECT * FROM categories";
$result = mysqli_query($conn, $query);

// GET FORM DATA IF FORM WAS INVALID
$title = $_SESSION['add-post-data']['title'] ?? NULL;
$body = $_SESSION['add-post-data']['body'] ?? NULL;
// UNSET FORM DATE 
unset($_SESSION['add-post-data']);
?>
<!--========================== End of Nav =================================================-->
<!-- =================== Form Section ==================================================== -->
<section class="form__section">
    <div class="container form__section-container">
        <h2>Add Post</h2>
        <?php if (isset($_SESSION['add-post-error'])) : ?>
      <div class="alert__message error">
        <p>
        <?= $_SESSION['add-post-error'];
                unset($_SESSION['add-post-error']);
            ?>
        </p>
      </div>
    <?php endif; ?>
        <form action="<?= ROOT_URL ?>admin/add-post-process.php" method="post" enctype="multipart/form-data">
            <input type="text" name="title" value="<?= $title ?>" placeholder="Title" />
            <select name="category">
            <?php while($category_data = mysqli_fetch_assoc($result)) : ?>
                <option value="<?= $category_data['id'] ?> "><?= $category_data['title'] ?></option>
            <?php endwhile ?>
            </select>
            <textarea name="body" id="" rows="10" placeholder="Body"><?= $body ?></textarea>

            <?php if(isset($_SESSION['user-is-admin']) == true) : ?>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                <label for="is_featured">Featured</label>
            </div>
            <?php endif ?>
            

            <div class="form__control">
                <label for="thumbnail">Add Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Add Post</button>
        </form>
    </div>
</section>
<!-- =================================End of Form =================================================== -->

<!--=============================== Footer Starts ====================================================-->
<?php
include '../includes/footer.php';
?>