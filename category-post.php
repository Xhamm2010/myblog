<?php
include 'includes/header.php';

if (isset($_GET['id'])) {

    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $post_query = "SELECT * FROM posts WHERE category_id = $id ORDER BY date_time DESC";
    $post_result = mysqli_query($conn, $post_query);
   
} else {
    header('Location: ' . ROOT_URL . 'blog.php');
    die();
}
?>
<!-- End of Nav -->

<!-- Category Title session -->
<section class="category">
    <header class="category__title">
        <h1>
            <?php
                $category_id = $id;
                $category_query = "SELECT * FROM categories WHERE id = $category_id ";
                $category_result = mysqli_query($conn, $category_query);
                $category_data = mysqli_fetch_assoc($category_result);
                echo $category_data['title'];
            ?>
        </h1>
    </header>
</section>
<!-- End of Category Title -->

<!-- Post Section -->
<?php if(mysqli_num_rows($post_result) > 0) : ?>
<section class="posts">
    <div class="container posts__container">
        <?php while ($post_data = mysqli_fetch_assoc($post_result)) : ?>
            <!-- Article -->
            <article>
                <div class="post__thumbnail">
                    <img src="uploadimg/<?= $post_data['thumbnail'] ?>">
                </div>

                <div class="post__info">
                    <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post_data['id'] ?>"><?= $post_data['title'] ?></a></h2>
                    <p class="post__body">
                        <?= substr($post_data['body'], 0, 200)  ?>...
                    </p>

                    <div class="post__author">

                        <!-- FETCH AUTHOR FROM USERS TABLE USING AUTHOR'S ID OF POST TABLE-->
                        <?php
                            $author_id = $post_data['author_id'];
                            $author_query = "SELECT * FROM users WHERE id = $author_id";
                            $author_result = mysqli_query($conn, $author_query);
                            $author_data = mysqli_fetch_assoc($author_result)
                        ?>

                        <div class="post__author-avatar">
                            <img src="uploadimg/<?= $author_data['avatar'] ?>">
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?= "{$author_data['firstname']} {$author_data['lastname']}" ?></h5>
                            <small><?= date("M d, Y - H:i:s", strtotime($post_data['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile ?>

    </div>
</section>
<?php else : ?>
    <div class="alert__message error" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem" >
    <?= "No Post Found For This Category" ?>
    </div>
<?php endif ?>
<!-- End of Post -->

<!-- Category Button -->
<section class="category__buttons">
<?php
    $category_query = "SELECT * FROM categories";
    $category_result = mysqli_query($conn, $category_query);
    ?>

    <div class="container category__buttons-container">
    <?php while ($category_data = mysqli_fetch_assoc($category_result)) : ?>
        <button class="category__button"><a href="<?= ROOT_URL ?>category-post.php?id=<?= $category_data ['id'] ?>"><?= $category_data['title'] ?></a></button>
    <?php endwhile ?>
    </div>
</section>
<!-- End of Category Buttons-->
<!-- Footer Starts -->
<?php
include 'includes/footer.php';
?>