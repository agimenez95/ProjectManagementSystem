<?php
include_once "../logic/prereq.php";
foreach ($_POST as $key => $value) {
  if ($value == 'Delete User') {
    $id = $key;
    $userman = new UserManager(getDB());
    // disable a user
    $userman->disableUserById($id);
  }
}
header('Location: '.$_SERVER['HTTP_REFERER']);
?>
