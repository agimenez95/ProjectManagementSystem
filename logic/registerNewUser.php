<?php
require 'prereq.php';
$pword = $_POST['pword'];
$pword2 = $_POST['pword2'];
passwordCheck($_POST['email'], $pword, $pword2, $_POST);

function passwordCheck($email, $pword, $pword2, $post){
  $usermanager = new UserManager(getDB());
  $user = $usermanager->byEmail($email);
  if ($user){
    $_SESSION['userExists'] = 1;
    populateSession($post);
    if ($pword !== $pword2) {
      $_SESSION['pwordMatch'] = 1;
      populateSession($post);
      header('Location: ../view/registration.php');
    }
    header('Location: ../view/registration.php');
  } else {
    if ($pword !== $pword2) {
      $_SESSION['pwordMatch'] = 1;
      populateSession($post);
      header('Location: ../view/registration.php');
    }
    else {
      $user = new User();
      $user->fromArray($post);
      $user->setPword(password_hash($pword, PASSWORD_DEFAULT));
      if ($usermanager->isItTheFirst() == null) {
        $usermanager->saveFirst($user);
        $_SESSION['login'] = 2;
      }
      else {
        $usermanager->save($user);
        $_SESSION['login'] = 1;
      }
      $_SESSION["userId"] = $user->getID();
      $_SESSION['registrationComplete'] = 1;
      $_SESSION['page'] = 1;
      header('Location: ../view/index.php');
    }
  }
}

function populateSession($post){
  $_SESSION['firstname'] = $post['firstname'];
  $_SESSION['surname'] = $post['surname'];
  $_SESSION['pword'] = $post['pword'];
  $_SESSION['pword2'] = $post['pword2'];
  $_SESSION['email'] = $post['email'];
}

?>
