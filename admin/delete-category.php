<?php
require 'config/database.php';

if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);


  //   UPDATE CATEGORY ID OF POST THAT BELONG TO THIS CATEGORY TO ID OF UNCATEGORIZED CATEGORY  
  $update_category_id_query = "UPDATE posts SET category_id = 9 WHERE category_id = $id ";
  $update_category_id_query_result = mysqli_query($conn, $update_category_id_query);

  if (!mysqli_errno($conn)) {
    // DELETE CATEGORY FROM DATABASE
    $delete_query = "DELETE FROM categories
    WHERE id = '$id' LIMIT 1";
    $delete_result = mysqli_query($conn, $delete_query);
  }

  // CHECKING FOR ERROR AFTER DELETING
  if (mysqli_errno($conn)) {
    $_SESSION['delete-category-error'] = " Failed To Delete Category";
  } else {
    $_SESSION['delete-category-success'] = "Category has been Deleted Successfully";
  }
}
header('Location: ' . ROOT_URL . 'admin/manage-category.php');
die();
