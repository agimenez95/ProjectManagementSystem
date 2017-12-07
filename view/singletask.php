<?php
include_once "../logic/prereq.php";
$taskId = -1;
foreach ($_POST as $key => $value) {
  if ($value === "view") {
    $taskId = $key;
    $_SESSION['taskId'] = $taskId;
    header('Location: index.php');
  } elseif ($value === "edit") {
    $taskId = $key;
    $_SESSION['taskId'] = $taskId;
    $_SESSION['edit'] = 1;
    header('Location: index.php');
  }
}

?>
