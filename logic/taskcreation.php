<?php
include_once "prereq.php";
if ($_POST['submit'] === 'Add Another User') {
  if (isset($_SESSION['numberOfDropdowns'])){
    $userman = new UserManager(getDB());
    $limit = $userman->notManager();
    if ($_SESSION['numberOfDropdowns'] < $limit) {
      for ($i=0; $i < $_SESSION['numberOfDropdowns']; $i++) {
        $_SESSION['option'.$i] = $_POST['option'.$i];
      }
      $_SESSION['numberOfDropdowns'] += 1;
    }
  }
  else {
    $_SESSION['numberOfDropdowns'] = 2;
    $_SESSION['option0'] = $_POST['option0'];
    $_SESSION['option1'] = $_POST['option1'];
  }
  $_SESSION['title'] = $_POST['title'];
  $_SESSION['description'] = $_POST['description'];
  header('Location: '.$_SERVER['HTTP_REFERER']);
} elseif ($_POST['submit'] === 'Submit') {
  //check to see if 2 values are the same
  $save = true;
  foreach ($_POST as $key1 => $value1) {
    foreach ($_POST as $key2 => $value2) {
      if ($value1 === $value2 && $key1 != $key2) {
        $_SESSION['upgraded'] = "Try Again. There are at least 2 fields with the same value!";
        // Let the fields remember their content
        $_SESSION['title'] = $_POST['title'];
        $_SESSION['description'] = $_POST['description'];
        $save = false;
        header('Location: '.$_SERVER['HTTP_REFERER']);
      }
    }
  }
  if ($save) {
    //save to the task table
    $taskmanager = new TaskManager(getDB());
    $task = new Task();
    $task->fromArray($_POST);
    $taskmanager->save($task);
    //get the task id
    if (!isset($_SESSION['numberOfDropdowns'])) {
     $_SESSION['numberOfDropdowns'] = 1;
    }
    for ($i=0; $i < $_SESSION['numberOfDropdowns']; $i++) {
     $userman = new UserManager(getDB());
     $user = $userman->byId($_POST['option'.$i]);
     //for each user save to the user_task table
     $taskmanager->associateTaskToUser($task->getId(), $user->getId());
    }
    if (isset($_SESSION['numberOfDropdowns'])) {
     unset($_SESSION['numberOfDropdowns']);
    }
    $_SESSION['page'] = 1;
    header('Location: ../view/index.php');
  }
}

foreach ($_POST as $key => $value) {
  if ($value === "X") {
    if (isset($_SESSION['numberOfDropdowns'])){
      // Let the fields remember their content
      $_SESSION['title'] = $_POST['title'];
      $_SESSION['description'] = $_POST['description'];
      $happened = false;
      for ($i=0; $i < $_SESSION['numberOfDropdowns']-1; $i++) {
        if ($key ===  "option".$i || $happened) {
          $happened = true;
          $x = $i + 1;
          $_SESSION['option'.$i] = $_POST['option'.$x];
        }
      }
      $_SESSION['numberOfDropdowns'] -= 1;
      $x = $i+1;
      header('Location: '.$_SERVER['HTTP_REFERER']);
    }
  } elseif ($value === "Update") {
    $taskmanager = new TaskManager(getDB());
    $task = new Task();
    $task->fromArray($_POST);
    $task->setId($_SESSION['taskId']);
    // Content is updated as well as the timestamp on the database.
    $taskmanager->updateContent($task);
    $taskmanager->updateTime($_SESSION['taskId']);
    header('Location: '.$_SERVER['HTTP_REFERER']);
  } elseif ($value === "Unassign Task") {
    $taskmanager = new TaskManager(getDB());
    // check to see if there is only one user assigned to the task
    $count = $taskmanager->howManyAssigned($_SESSION['taskId']);
    if ($count == 1) {
      $taskmanager->deleteTask($_SESSION['taskId']);
    }
    // deletes a single relation between task and user
    $taskmanager->removeUserFromTask($_SESSION['taskUserId'], $_SESSION['taskId']);
    unset($_SESSION['taskId']);
    header('Location: '.$_SERVER['HTTP_REFERER']);
  } elseif ($value === "Delete All") {
    $taskmanager = new TaskManager(getDB());
    // deletes all relations between a task and the users as well as deleting the task
    $taskmanager->deleteTask($_SESSION['taskId']);
    $taskmanager->deleteUserTask($_SESSION['taskId']);
    unset($_SESSION['taskId']);
    header('Location: '.$_SERVER['HTTP_REFERER']);
  }
}

?>
