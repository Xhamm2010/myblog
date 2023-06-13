<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // FETCH POST FROM DATABASE IN OTHER TO DELETE THUMBNAIL
    $query = "SELECT * FROM posts WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_assoc($result);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = '../uploadimg/' . $thumbnail_name;

        if ($thumbnail_path) {
            unlink($thumbnail_path);

            // DELETE POST FROM DATABASE
            $delete_query = "DELETE FROM posts WHERE id = $id LIMIT 1";
            $delete_result = mysqli_query($conn, $delete_query);

            if (!mysqli_errno($conn)) {
                // REDIRECT TO MANAGE POST WITH SUCCESS MESSAGE
                $_SESSION['edit-post-success'] = " Post Has Been SUCCESSFULLY DELETED";
            }
        }
    }
}
header('Location: ' . ROOT_URL . 'admin/index.php');
die();
