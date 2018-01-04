<?php
include_once "../logic/prereq.php";
$taskId = -1;
$_SESSION['taskUserId'] = $_POST['taskUserId'];
foreach ($_POST as $key => $value) {
  if ($value === "View") {
    $taskId = $key;
    $_SESSION['taskId'] = $taskId;
    header('Location: index.php');
  } elseif ($value === "Edit") {
    $taskId = $key;
    $_SESSION['taskId'] = $taskId;
    $_SESSION['edit'] = 1;
    header('Location: index.php');
  }
}

?>
