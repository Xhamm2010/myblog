<?php

require 'includes/header.php';

if (isset($_GET['search']) && isset($_GET['submit'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $search_post_query = " SELECT * FROM posts WHERE title LIKE '%$search%' ORDER BY date_time DESC ";
    $search_post_result = mysqli_query($conn, $search_post_query);
  } else {
    header('Location: ' . ROOT_URL . 'blog.php');
    die();
  }

  ?>

  <!-- Post Section -->
  <?php if(mysqli_num_rows($search_post_result) > 0) : ?>
<section class="posts">
    <div class="container posts__container">
        <?php while ($search_post_data = mysqli_fetch_assoc($search_post_result)) : ?>
            <!-- Article -->
            <article>
                <div class="post__thumbnail">
                    <img src="uploadimg/<?= $search_post_data['thumbnail'] ?>">
                </div>
                
                <div class="post__info">
                    <?php
                    $category_id = $search_post_data['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id = $category_id ";
                    $category_result = mysqli_query($conn, $category_query);
                    $category_data = mysqli_fetch_assoc($category_result)
                    ?>

                    <a href="<?= ROOT_URL ?>category-post.php?id=<?= $category_data['id'] ?>" class="category__button"><?= $category_data['title'] ?></a>
                    
                    <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $search_post_data['id'] ?>"><?= $search_post_data['title'] ?></a></h2>
                    <p class="post__body">
                        <?= substr($search_post_data['body'], 0, 200)  ?>...
                    </p>
                    <div class="post__author">
                        <!-- FETCH AUTHOR FROM USERS TABLE USING AUTHOR'S ID OF POST TABLE-->
                        <?php
                        $author_id = $search_post_data['author_id'];
                        $author_query = "SELECT * FROM users WHERE id = $author_id ";
                        $author_result = mysqli_query($conn, $author_query);
                        $author_data = mysqli_fetch_assoc($author_result)
                        ?>

                        <div class="post__author-avatar">
                            <img src="uploadimg/<?= $author_data['avatar'] ?>">
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?= "{$author_data['firstname']} {$author_data['lastname']}" ?></h5>
                            <small><?= date("M d, Y - H:i:s", strtotime($search_post_data['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>
       <?php endwhile ?>
    </div>
</section>
<?php else : ?>
    <div class="alert__message error" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem" >
    <?= "Search Not Found" ?>
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
        <button class="category__button"><a href="<?= ROOT_URL ?>category-post.php?id=<?= $category_data['id'] ?>"><?= $category_data['title'] ?></a></button>
    <?php endwhile ?>
    </div>
</section>
<!-- End of Category Buttons-->

<!-- Footer Starts -->
<?php
require 'includes/footer.php';
?>






