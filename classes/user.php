<?php
class User {
  private $id;
  private $firstname;
  private $surname;
  private $pword;
  private $email;
  private $db;
  private $disabled;

  public function __construct(PDO $db = null){
    $this->db = $db;
  }

  public function passwordValid($pword){
    return password_verify($pword, $this->pword);
  }

  // This method will create a user.
  public function fromArray($a){
    if(isset($a['id'])){
      $this->id = $a['id'];
    }
    $this->pword = $a['pword'];
    $this->firstname = $a['firstname'];
    $this->surname = $a['surname'];
    $this->email = $a['email'];
    $this->disabled = $a['disabled'];
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

  public function getPword(){
    return $this->pword;
  }

  public function setPword($pword){
    $this->pword = $pword;
  }

  public function getEmail(){
    return $this->email;
  }

  public function getDisabled(){
    return $this->disabled;
  }
}
?>
