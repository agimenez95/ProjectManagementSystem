<?php
include_once "../logic/prereq.php";
$taskId = -1;
$_SESSION['taskUserId'] = $_POST['taskUserId'];
foreach ($_POST as $key => $value) {
  if ($value === "View") { // if View was pressed
    $taskId = $key;
    $_SESSION['taskId'] = $taskId;
    header('Location: index.php');
  } elseif ($value === "Edit") { // if Edit was pressed
    $taskId = $key;
    $_SESSION['taskId'] = $taskId;
    $_SESSION['edit'] = 1;
    header('Location: index.php');
  }
}

?>
