<?php
include 'includes/header.php';
// FETCH POST FROM DATABASE IF ID IS SET
if (isset($_GET['id'])) {

    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $post_query = "SELECT * FROM posts WHERE id = $id";
    $post_result = mysqli_query($conn, $post_query);
    $post_data = mysqli_fetch_assoc($post_result);
} else {
    header('Location: ' . ROOT_URL . 'blog.php');
    die();
}
?>
<!-- End of Nav -->

<!-- Single Post session -->
<section class="singlepost">
    <div class="container singlepost__container">
        <h2><?= $post_data['title'] ?></h2>
        <div class="post__author">
            <?php
            $author_id = $post_data['author_id'];
            $author_query = "SELECT * FROM users WHERE id = $author_id ";
            $author_result = mysqli_query($conn, $author_query);
            $author_data = mysqli_fetch_assoc($author_result)
            ?>

            <div class="post__author-avatar">
                <img src="uploadimg/<?= $author_data['avatar'] ?>">
            </div>
            <div class="post__author-info">
                <h5>By: <?= "{$author_data['firstname']} {$author_data['lastname']}"  ?></h5>
                <small>
                    <?= date("M d, Y - H:i:s", strtotime($post_data['date_time'])) ?>
                </small>
            </div>
        </div>
        <div class="singlepost__thumbnail">
            <img src="uploadimg/<?= $post_data['thumbnail'] ?>" alt="Image">
        </div>
        <p>
            <?= $post_data['body'] ?>
        </p>
    </div>

</section>
<!-- End of Single Post -->

<!-- Footer Starts -->
<?php
include 'includes/footer.php';
?>