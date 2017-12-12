<form class="" action="../logic/taskcreation.php" method="post">
  <div class="col-md-1"></div>
  <div class="col-md-10">
  <h4>Name of Task:</h4>
  <?php
  if (isset($_SESSION['title'])) {
    echo '<input type="text" name="title" value="'.$_SESSION['title'].'">';
  } else {
    echo '<input type="text" name="title" value="">';
  }
  ?>
  <br><br>
  <h4>Task Description:</h4>
  <?php
  if (isset($_SESSION['description'])) {
    echo '<textarea rows="4" cols="50" name="description">'.$_SESSION['description'].'</textarea>';
  } else {
    echo '<textarea rows="4" cols="50" name="description"></textarea>';
  }
  ?>
  <br><br>
  <?php
  if (!isset($_SESSION['edit'])) {
    if (isset($_SESSION['numberOfDropdowns'])) {
      if ($_SESSION['numberOfDropdowns'] !== 1) {
        for ($i=0; $i < $_SESSION['numberOfDropdowns']; $i++) {
          if ($i == 0) {
            include "../logic/userdropdown.php";
          } else {
            echo "<select name='option$i'>";
            $usermanager = new UserManager(getDB());
            $allUsers = $usermanager->allNewStarters();
            if ($allUsers) {
              foreach ($allUsers as $id => $user) {
                if ($_SESSION['option'.$i] == $id) {
                  echo "<option selected value =".$id.">$user</option>";
                } else {
                  echo "<option value =".$id.">$user</option>";
                }
              }
              echo "</select> ";
              echo '<input class="btn btn-sm btn-danger" type="submit" name="option'.$i.'" value="X">';
              echo "<br><br>";
            } else {
              unset($_SESSION['numberOfDropdowns']);
            }
          }
        }
      } else {
        include "../logic/userdropdown.php";
      }
    } else {
      include "../logic/userdropdown.php";
    }
  }
  $usermanager = new UserManager(getDB());
  $allUsers = $usermanager->allNewStarters();
  if ($allUsers) {
    if (!isset($_SESSION['edit'])) {
      $userman = new UserManager(getDB());
      $limit = $userman->notManager();
      if ($_SESSION['numberOfDropdowns'] != $limit) {
        echo '<input class="btn btn-info" type="submit" name="submit" value="Add Another User"><br><br>';
      }
    }
    if (isset($_SESSION['edit'])) {
      echo '<input class="btn btn-primary" type="submit" name="update" value="Update"> ';
      echo '<input class="btn btn-danger" type="submit" name="delete" value="Delete">';
    } else {
      echo '<input class="btn btn-success" type="submit" name="submit" value="Submit">';
    }
  }
  ?>
</form>
<?php
if (isset($_SESSION['title'])) {
  unset($_SESSION['title']);
}
if (isset($_SESSION['description'])) {
  unset($_SESSION['description']);
}
?>
</div>
