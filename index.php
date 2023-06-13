<!-- Page Header starts here -->
<?php
include 'includes/header.php';

// FETCH IS_featured POST FROM POST TABLE
$post_featured_query = "SELECT * FROM posts WHERE is_featured = 1 LIMIT 1";
$post_featured_result = mysqli_query($conn, $post_featured_query);
$post_featured_data = mysqli_fetch_assoc($post_featured_result);

// FETCH 9 POST FROM POST TABLE
$post_query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$post_result = mysqli_query($conn, $post_query);

?>
<!-- Page Header ends here -->

<!-- Featured session -->
<!-- SHOW FEATURED POST IF THERE IS ANY -->
<?php if (mysqli_num_rows($post_featured_result) > 0) : ?>

    <section class="featured">
        <div class="container featured__container">
            <div class="post__thumbnail">
                <img src="uploadimg/<?= $post_featured_data['thumbnail'] ?>">
            </div>
            <div class="post__info">

                <!-- GET CATEGORY FROM CATEGORIES TABLE USING CATEGORY_ID OF POST -->
                <?php
                $category_id = $post_featured_data['category_id'];
                $category_query = "SELECT * FROM categories WHERE id = $category_id ";
                $category_result = mysqli_query($conn, $category_query);
                $category_data = mysqli_fetch_assoc($category_result)
                ?>

                <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category_data['id'] ?>" class="category__button"><?= $category_data['title'] ?></a>
                <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post_featured_data['id'] ?>"><?= $post_featured_data['title'] ?></a></h2>
                <p class="post__body">
                    <?= substr($post_featured_data['body'], 0, 200)  ?>...
                </p>
                <div class="post__author">
                    <!-- FETCH AUTHOR FROM USERS TABLE USING AUTHOR'S ID OF POST-->
                    <?php
                    $author_id = $post_featured_data['author_id'];
                    $author_query = "SELECT * FROM users WHERE id = $author_id ";
                    $author_result = mysqli_query($conn, $author_query);
                    $author_data = mysqli_fetch_assoc($author_result)
                    ?>

                    <div class="post__author-avatar">
                        <img src="uploadimg/<?= $author_data['avatar'] ?> ?>">
                    </div>
                    <div class="post__author-info">
                        <h5>By: <?= "{$author_data['firstname']} {$author_data['lastname']}"  ?></h5>
                        <small>
                            <?= date("M d, Y - H:i:s", strtotime($post_featured_data['date_time'])) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>
<!-- End of Featured -->

<!-- Post Section -->
<section class="posts <?= $post_featured_data? '' : 'section__extra-margin' ?>">
    <div class="container posts__container">
        <?php while ($post_data = mysqli_fetch_assoc($post_result)) : ?>
            <!-- Article -->
            <article>
                <div class="post__thumbnail">
                    <img src="uploadimg/<?= $post_data['thumbnail'] ?>">
                </div>
                
                <div class="post__info">
                    <?php
                    $category_id2 = $post_data['category_id'];
                    $category_query2 = "SELECT * FROM categories WHERE id = $category_id2 ";
                    $category_result2 = mysqli_query($conn, $category_query2);
                    $category_data2 = mysqli_fetch_assoc($category_result2)
                    ?>

                    <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category_data2['id'] ?>" class="category__button"><?= $category_data2['title'] ?></a>
                    
                    <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post_data['id'] ?>"><?= $post_data['title'] ?></a></h2>
                    <p class="post__body">
                        <?= substr($post_data['body'], 0, 200)  ?>...
                    </p>
                    <div class="post__author">
                        <!-- FETCH AUTHOR FROM USERS TABLE USING AUTHOR'S ID OF POST TABLE-->
                        <?php
                        $author_id2 = $post_data['author_id'];
                        $author_query2 = "SELECT * FROM users WHERE id = $author_id2 ";
                        $author_result2 = mysqli_query($conn, $author_query2);
                        $author_data2 = mysqli_fetch_assoc($author_result2)
                        ?>

                        <div class="post__author-avatar">
                            <img src="uploadimg/<?= $author_data2['avatar'] ?>">
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?= "{$author_data2['firstname']} {$author_data2['lastname']}" ?></h5>
                            <small><?= date("M d, Y - H:i:s", strtotime($post_data['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile ?>

    </div>
</section>
<!-- End of Post -->

<!-- Category Button -->
<section class="category__buttons">
    <?php
    $category_query3 = "SELECT * FROM categories";
    $category_result3 = mysqli_query($conn, $category_query3);
    ?>

    <div class="container category__buttons-container">
    <?php while ($category_data3 = mysqli_fetch_assoc($category_result3)) : ?>
        <button class="category__button"><a href="<?= ROOT_URL ?>category-post.php?id=<?= $category_data3['id'] ?>"><?= $category_data3['title'] ?></a></button>
    <?php endwhile ?>
    </div>
</section>
<!-- End of Category Buttons-->

<!-- Footer Starts -->
<?php
include 'includes/footer.php';
?>