<?php
require 'prereq.php';
$pword = $_POST['pword'];
$pword2 = $_POST['pword2'];
passwordCheck($_POST['email'], $pword, $pword2, $_POST);

function passwordCheck($email, $pword, $pword2, $post){
  $custmanager = new CustomerManager(getDB());
  $customer = $custmanager->byEmail($email);
  if ($customer){
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
      $customer = new Customer();
      $customer->fromArray($post);
      $customer->setPword(password_hash($pword, PASSWORD_DEFAULT));
      $custmanager->save($customer);
      $_SESSION['registrationComplete'] = 1;
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
