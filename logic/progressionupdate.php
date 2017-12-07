<?php
include_once "prereq.php";

$taskmanager = new TaskManager(getDB());
$task = $taskmanager->byId($_POST['taskId']);
$taskmanager->updateProgress($task, $_POST['progress']);

header('Location: ../view/index.php');
?>
