<?php
require 'config/database.php';

if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

//   FETCH USER FROM DATABASE
$query = "SELECT * FROM users WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (mysqli_num_rows($result) == 1) {
  $avatar_name = $user['avatar'];
  $avatar_path = "../uploadimg/".$avatar_name;
  // DELETE AVATAR IF AVAILABLE
  if ($avatar_path) {
      unlink($avatar_path);
  }
}

//************************** */ FETCH ALL THUMBNAILS OF USER POST AND DELETE*************************************
$thumbnail_query = "SELECT thumbnail FROM posts WHERE author_id = $id";
$thumbnail_result = mysqli_query($conn, $thumbnail_query);

if (mysqli_num_rows($thumbnail_result) > 0) {
    while ($thumbnail_data = mysqli_fetch_assoc($thumbnail_result)) {
      $thumbnail_path = '../uploadimg/'. $thumbnail_data['thumbnail'];

      if ($thumbnail_path) {
          unlink($thumbnail_path);
      }
    }
}


// DELETE USER FROM DATABASE
$delete_query = "DELETE FROM users
                WHERE id = '$id' LIMIT 1";
$delete_result = mysqli_query($conn, $delete_query);
// CHECKING FOR ERROR AFTER DELETING
if (mysqli_errno($conn)) {
  $_SESSION['delete-user-error'] = " Failed To Delete User";
} else {
  $_SESSION['delete-user-success'] = " User $firstname $lastname has been Deleted Successfully";
}


}

header('Location: '. ROOT_URL .'admin/manage-user.php');
die();
