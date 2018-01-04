<!-- <nav class="navbar navbar-default container-fluid"> -->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php
      if ($_SESSION['login'] == 1) {
        echo "<a class='navbar-brand' href='index.php'>New Starter Dashboard</a>";
      }
      elseif ($_SESSION['login'] == 2) {
        echo "<a class='navbar-brand' href='index.php'>Manager Dashboard</a>";
      }
      else {
        echo "<a class='navbar-brand' href='index.php'>New Starter Management System</a>";
      }
       ?>

    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="dropdown">
        <!--   <a class="dropdown-toggle" href="#">Page 1</a> -->

        <?php
        if ($_SESSION['login'] == 1) {
          echo '<li><a href="../sessionchanger/firstpage.php">In Progress</a></li>
                <li><a href="../sessionchanger/secondpage.php">Completed Tasks</a></li>';
        }
        elseif ($_SESSION['login'] == 2) {
          echo '<li><a href="../sessionchanger/firstpage.php">In Progress</a></li>
                <li><a href="../sessionchanger/secondpage.php">View Completed Tasks</a></li>
                <li><a href="../sessionchanger/thirdpage.php">Create Tasks</a></li>
                <li><a href="../sessionchanger/fourthpage.php">Add New Managers</a></li>
                <li><a href="../sessionchanger/fifthpage.php">All Users</a></li>';
        }
        ?>
      </ul>
      <!-- REGISTER -->
      <ul class="nav navbar-nav navbar-right">
        <?php
          if (!isset($_SESSION['login'])) {
            echo '<li><a href="registration.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>';
            echo '<li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-log-in"></span> Login <span class="caret"></span></a></a>
              <ul class="dropdown-menu">';
                include "login.php";
            echo '</ul>
            </li>';
          } else {
            echo '<li><a href="../logic/logoutaction.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>';
          }
        ?>
      </ul>
    </div>
  </div>
</nav>
