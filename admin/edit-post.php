<?php
include 'includes/header.php';

// FETCH CATEGORIES FROM DATABASE 
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);

// FETCH POST DATA FROM DATABASE IF ID IS SET
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = " SELECT * FROM posts WHERE `id` = '$id'";
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);
    
  
  } else{
    header('Location: '. ROOT_URL . 'admin/index.php');
    die();
  }
?>
<!--========================== End of Nav =================================================-->
<!-- =================== Form Section ==================================================== -->
<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $post['id'] ?>"/>
            <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>"/>
            <input type="text" name="title" value="<?= $post['title'] ?>" placeholder="Title" />
            <select name="category">
                <?php while($category_data = mysqli_fetch_assoc($category_result)) : ?>
                <option value="<?= $category_data['id'] ?>"><?= $category_data['title'] ?></option>
                <?php endwhile ?>
            </select>
            <textarea name="body" id="" rows="10" placeholder="Body"><?= $post['body'] ?></textarea>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                <label for="is_featured">Featured</label>
            </div>
            <div class="form__control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Update Post</button>
        </form>
    </div>
</section>
<!-- =================================End of Form =================================================== -->

<!--=============================== Footer Starts ====================================================-->
<?php
include '../includes/footer.php';
?>