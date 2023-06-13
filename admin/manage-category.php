<?php
include 'includes/header.php';

// FETCH CATEGORIES FROM DATABASE 
$query = "SELECT * FROM categories ORDER BY title";
$result = mysqli_query($conn, $query);
?>
<!--======================================= End of Nav =================================================-->
<!--================================= Dashboard Section ===================================================-->
<section class="dashboard">
    <!-- ADD CATEGORY SUCCESS MESSAGE -->
    <?php if (isset($_SESSION['add-category-success'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['add-category-success'];
                unset($_SESSION['add-category-success']);
                ?>
            </p>
        </div>

        <!-- EDIT CATEGORY SUCCESS AND ERROR MESSAGE -->
    <?php elseif (isset($_SESSION['edit-category-success'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['edit-category-success'];
                unset($_SESSION['edit-category-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-category-error'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['edit-category-error'];
                unset($_SESSION['edit-category-error']);
                ?>
            </p>
        </div>
        <!-- DELETE category SUCCESS AND ERROR MESSAGE -->
    <?php elseif (isset($_SESSION['delete-category-success'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['delete-category-success'];
                unset($_SESSION['delete-category-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-category-error'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['delete-category-error'];
                unset($_SESSION['delete-category-error']);
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
                    <a href="index.php">
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
                        <a href="manage-category.php" class="active">
                            <i class="fa fa-tags"></i>
                            <h5>Manage Category</h5>
                        </a>
                    </li>
                <?php endif;   ?>
            </ul>
        </aside>

        <main>
            <h2>MANAGE CATEGORY</h2>
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($category_data = mysqli_fetch_assoc($result)) : ?> 
                        <tr>
                            <td><?= $category_data['title'] ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $category_data['id']  ?>" class="btn sm">Edit</a></td>
                            <td><a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?= $category_data['id'] ?>" class="btn sm danger">Delete</a></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error"><?= "No Category Found" ?></div>
            <?php endif ?>
            



        </main>
    </div>
</section>
<!--=================================== Footer Starts =========================================-->
<?php
include '../includes/footer.php';
?>