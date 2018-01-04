<?php
require '../logic/prereq.php';
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Starter Management System</title>
    <!-- Style sheets included below -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="../styling/customstyling.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-*.min.js"></script>
  </head>
  <body>
    <header>
      <?php
      if (isset($_SESSION['registrationComplete'])) {
        echo '<div class="alert alert-info" role="alert">
          Thank you for registering!
        </div>';
        unset($_SESSION['registrationComplete']);
      }
      if (isset($_SESSION['upgraded'])) {
    		echo '<div class="alert alert-info" role="alert">'.$_SESSION['upgraded'].'</div>';
        unset($_SESSION['upgraded']);
      }
      ?>
    </header>
      <?php
      if (isset($_SESSION['login'])) {
        if ($_SESSION['login'] == 1) {
          include_once "newuser/newstarterdashboard.php";
        }
        elseif ($_SESSION['login'] == 2) {
          include_once "manager/managerdashboard.php";
        }
      } else {
        include_once "navbar.php";
        echo "<div class='container'>";
        echo "<br><h4>Please log in to view your dashboard.</h4><br><br><br><br><br><br><br><br><br><br>";
      }

      if (isset($_SESSION['taskId']) && !isset($_SESSION['edit'])) {
        if ($_SESSION['taskId'] != -1 ) {
          $taskman = new TaskManager(getDB());
          $task = $taskman->byId($_SESSION['taskId']);
          echo "<div class='col-md-2'></div>";
          echo "<div class='col-md-5'>";
          echo "<h3>".$task->getTitle()."</h3>";
          echo "<p>".$task->getDescription()."</p>";
          $_SESSION['progress'] = $task->getProgress();
          echo "</div>";
          echo "<div class='col-md-3'>";

          echo "<br>";
          echo "<p>Completion:</p>";
          echo '<form class="progression" action="../logic/progressionupdate.php" method="post">';
            include "completiondropdown.php";
            if ($_SESSION['login'] == 1) { //new starter
              echo '<input type="hidden" name="userId" value="'.$_SESSION['userId'].'">';
            } elseif ($_SESSION['login'] == 2) { //manager
              echo '<input type="hidden" name="userId" value="'.$_SESSION['taskUserId'].'">';
            }
            echo '<input type="hidden" name="taskId" value="'.$task->getId().'">';
            echo '<input class="btn btn-success" type="submit" name="submit" value="Submit">';
          echo "</form>";
          echo "</div>";
        }
        unset($_SESSION['taskId']);
        unset($_SESSION['taskUserId']);
      }
      if (isset($_SESSION['edit'])) {
        $taskman = new TaskManager(getDB());
        $task = $taskman->byId($_SESSION['taskId']);
        $_SESSION['title'] = $task->getTitle();
        $_SESSION['description'] = $task->getDescription();

        include_once "manager/createtask.php";
        unset($_SESSION['edit']);
      }
      ?>
    </div>
  </body>
  <footer class="footer">
    <div class="container">
      <br><br>
      <p>Created by Adriano Gimenez</p>
    </div>
  </footer>
</html>
