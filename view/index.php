<?php
require '../logic/prereq.php';
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>New Starter Management System</title>
  </head>
  <body>
    <header>
      <h1>New Starter Management System</h1>
      <?php
      if (isset($_SESSION['login'])) {
        if ($_SESSION['login'] == 1) {
          include_once "logout.php";
        }
        if ($_SESSION['login'] == 0) {
          include_once "login.php";
        }
      }
      else {
        include_once "login.php";
      }
      ?>
    </header>
    <div class="container">
      <p>New Starter Management System</p>
      <?php
      if (isset($_SESSION['registrationComplete'])) {
    		echo "<p>Thank you for registering!</p>";
      }
      ?>
    </div>
    <?php
    if (isset($_SESSION['registrationComplete'])) {
  		unset($_SESSION['registrationComplete']);
    }
    ?>
  </body>
</html>
