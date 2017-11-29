<?php
class Customer {
  private $id;
  public $firstname;
  public $surname;
  public $pword;
  public $email;
  public $db;

  public function __construct(PDO $db = null){
    $this->db = $db;
  }

  public function passwordValid($pword){
    return password_verify($pword, $this->pword);
  }

  public function fromArray($a){
    if(isset($a['id'])){
      $this->id = $a['id'];
    }
    $this->pword = $a['pword'];
    $this->firstname = $a['firstname'];
    $this->surname = $a['surname'];
    $this->email = $a['email'];
  }

  public function setID($id){
    $this->id = $id;
  }

  public function getID(){
    return $this->id;
  }

  public function getFirstname(){
    return $this->firstname;
  }

  public function getSurname(){
    return $this->surname;
  }

  public function getUsername(){
    return $this->username;
  }

  public function getDOB(){
    return $this->dob;
  }

  public function getPword(){
    return $this->pword;
  }

  public function setPword($pword){
    $this->pword = $pword;
  }

  public function getEmail(){
    return $this->email;
  }
}
?>
