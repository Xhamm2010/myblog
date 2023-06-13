<?php
include 'includes/header.php';

// FETCH CURRENT USER FROM DATABASE
$current_user_id = $_SESSION['user-id'];
$query = "SELECT posts.id, posts.title, posts.category_id FROM posts JOIN users ON posts.author_id = users.id
          WHERE posts.author_id = $current_user_id ORDER BY posts.id DESC ";
$post_result = mysqli_query($conn, $query);
?>
<!--======================================= End of Nav =================================================-->
<!--================================= Dashboard Section ===================================================-->
<section class="dashboard">
    <!-- ADD POST SUCCESS MESSAGE -->
    <?php if (isset($_SESSION['add-post-success'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['add-post-success'];
                unset($_SESSION['add-post-success']);
                ?>
            </p>
        </div>

        <!-- EDIT POST SUCCESS AND ERROR MESSAGE -->
    <?php elseif (isset($_SESSION['edit-post-success'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['edit-post-success'];
                unset($_SESSION['edit-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post-error'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['edit-post-error'];
                unset($_SESSION['edit-post-error']);
                ?>
            </p>
        </div>
        <!-- DELETE POST SUCCESS AND ERROR MESSAGE -->
    <?php elseif (isset($_SESSION['delete-post-success'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['delete-post-success'];
                unset($_SESSION['delete-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-post-error'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['delete-post-error'];
                unset($_SESSION['delete-post-error']);
                ?>
            </p>
        </div>
    <?php endif; ?>



    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle">
            <i class="fa fa-arrow-right"></i>
        </button>
        <button id="hide__sidebar-btn" class="sidebar__toggle">
            <i class="fa fa-arrow-left"></i>
        </button>
        <aside>
            <ul>
                <li>
                    <a href="add-post.php">
                        <i class="fa fa-pencil"></i>
                        <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php" class="active">
                        <i class="fa fa-desktop"></i>
                        <h5>Manage Post</h5>
                    </a>
                </li>
                <?php if (isset($_SESSION['user-is-admin'])) : ?>
                    <li>
                        <a href="add-user.php">
                            <i class="fa fa-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-user.php">
                            <i class="fa fa-users"></i>
                            <h5>Manage User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php">
                            <i class="fa fa-edit (alias)"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-category.php">
                            <i class="fa fa-tags"></i>
                            <h5>Manage Category</h5>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </aside>

        <main>
            <h2>MANAGE POST</h2>
            <?php if (mysqli_num_rows($post_result) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = mysqli_fetch_assoc($post_result)) : ?>
                            <!-- GET CATEGORY TITLE OF EACH POST FROM CATEGORY TABLE -->
                            <?php
                            $category_id = $post['category_id'];
                            $category_query = "SELECT title FROM categories WHERE id = $category_id ";
                            $category_result = mysqli_query($conn, $category_query);
                            $category_data = mysqli_fetch_assoc($category_result)



                            ?>
                            <tr>
                                <td><?= $post['title'] ?></td>
                                <td><?= $category_data['title'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $post['id']  ?>" class="btn sm">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/delete-post.php?id=<?= $post['id']  ?>" class="btn sm danger">Delete</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error"><?= "No Post Found" ?></div>
            <?php endif ?>


        </main>
    </div>
</section>
<!--=================================== Footer Starts =========================================-->
<?php
include '../includes/footer.php';
?>