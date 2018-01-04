<?php
	include_once '../logic/prereq.php';
	include('../includes/sessions.inc.php');
	if(isset($_SESSION['login'])){
		header("location: ../view/index.php");
	}
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Starter Management System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  </head>
  <body>
    <header>
      <?php
      // if (isset($_SESSION['login'])) {
      //   if ($_SESSION['login'] == 1 || $_SESSION['login'] == 2)  {
      //     include_once "logout.php";
      //   }
      // }
      // else {
      //   include_once "login.php";
      // }
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
      }
      echo "";
      ?>
			<table id="regTable">
			  <form  action='../logic/registernewuser.php' method='post'>
			    <tr>
			      <td>First Name: </td>
						<?php
						if (isset($_SESSION['firstname'])) {
							echo "<td><input type='text' name='firstname' value='".$_SESSION['firstname']."' required/></td>";
						} else {
							echo "<td><input type='text' name='firstname' required/></td>";
						}
						?>
			    </tr>
			    <tr>
			      <td>Surame: </td>
						<?php
						if (isset($_SESSION['surname'])) {
							echo "<td><input type='text' name='surname' value='".$_SESSION['surname']."' required/></td>";
						} else {
							echo "<td><input type='text' name='surname' required/></td>";
						}
						?>
			    </tr>
			    <tr>
			      <td>Password: </td>
						<?php
						if (isset($_SESSION['pword'])) {
							echo "<td><input type='password' name='pword' value='".$_SESSION['pword']."' required/></td>";
						} else {
							echo "<td><input type='password' name='pword' required/></td>";
						}
						if (isset($_SESSION['pwordMatch'])) {
							echo "<td>These passwords do not match!</td>";
						}
						?>
			    </tr>
			    <tr>
			      <td>Re-enter password: </td>
						<?php
						if (isset($_SESSION['pword2'])) {
							echo "<td><input type='password' name='pword2' value='".$_SESSION['pword2']."' required/></td>";
						} else {
							echo "<td><input type='password' name='pword2' required/></td>";
						}
						?>
			    </tr>
			    <tr>
			      <td>Email address: </td>
						<?php
						if (isset($_SESSION['email'])) {
							echo "<td><input type='email' name='email' value='".$_SESSION['email']."' required/></td>";
						} else {
							echo "<td><input type='email' name='email' required/></td>";
						}
						if (isset($_SESSION['userExists'])) {
							echo "<td>This email address already exists in the system!</td>";
						}
						?>
			    </tr>
			    <tr >
			      <td><input class='btn btn-success' type='submit' class="btn" name='submit'/></td>
			    </tr>
			  </form>
			</table>
    </div>
  </body>
  <footer class="footer">
    <div class="container">
			<p>Created by Adriano Gimenez</p>
    </div>
  </footer>
</html>
<?php
if (isset($_SESSION['pwordMatch'])) {
	unset($_SESSION['pwordMatch']);
}
if (isset($_SESSION['userExists'])) {
	unset($_SESSION['userExists']);
}
if (isset($_SESSION['pword'])) {
	unset($_SESSION['firstname']);
  unset($_SESSION['surname']);
  unset($_SESSION['pword']);
  unset($_SESSION['pword2']);
  unset($_SESSION['email']);
}
?>
