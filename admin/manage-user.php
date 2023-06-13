<?php
include 'includes/header.php';

// FETCH USERS FROM DATABASE EXCEPT CURRENT USER
$current_admin_id = $_SESSION['user-id'];

$query = "SELECT * FROM users WHERE NOT `id` = '$current_admin_id'";
$result = mysqli_query($conn, $query);
?>
<!--======================================= End of Nav =================================================-->
<!--================================= Dashboard Section ===================================================-->
<section class="dashboard">
    <!-- ADD USER SUCCESS MESSAGE -->
    <?php if (isset($_SESSION['add-user-success'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['add-user-success'];
                unset($_SESSION['add-user-success']);
                ?>
            </p>
        </div>

        <!-- EDIT USER SUCCESS AND ERROR MESSAGE -->
    <?php elseif (isset($_SESSION['edit-user-success'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['edit-user-success'];
                unset($_SESSION['edit-user-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-user-error'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['edit-user-error'];
                unset($_SESSION['edit-user-error']);
                ?>
            </p>
        </div>
        <!-- DELETE USER SUCCESS AND ERROR MESSAGE -->
    <?php elseif (isset($_SESSION['delete-user-success'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['delete-user-success'];
                unset($_SESSION['delete-user-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-user-error'])) : ?>
        <div class="alert__message success" style="width: 50%; margin: auto; text-align:center; margin-bottom: 0.5rem">
            <p>
                <?= $_SESSION['delete-user-error'];
                unset($_SESSION['delete-user-error']);
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
                        <a href="manage-user.php" class="active">
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
            <h2>MANAGE USER</h2>
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>User name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= "{$user['firstname']} {$user['lastname']}" ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/delete-user.php?id=<?= $user['id'] ?>" class="btn sm danger">Delete</a></td>
                                <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error"><?= "No User Found" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>
<!--=================================== Footer Starts =========================================-->
<?php
include '../includes/footer.php';
?>