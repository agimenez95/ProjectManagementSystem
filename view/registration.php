<?php
	include_once '../logic/prereq.php';
	include('../includes/sessions.inc.php');
	if(isset($_SESSION['login'])){
		header("location: ../view/index.php");
	}
?>
<html><!-- This file is mainly code I have written in another project -->
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="container" >
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
  				?>
  				<?php
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
  				?>
					<?php
  				if (isset($_SESSION['userExists'])) {
  					echo "<td>This email address already exists in the system!</td>";
  				}
  				?>
        </tr>
        <tr >
          <td><input id="differentBtn" type='submit' class="btn" name='submit'/></td>
        </tr>
      </form>
    </table>
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
  </body>
</html>
