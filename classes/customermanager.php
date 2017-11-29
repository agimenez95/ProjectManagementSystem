<?php
class CustomerManager {
  private $db;

  public function __construct(PDO $db){
    $this->db = $db;
  }

  public function byId($id){
    $s = $this->db->prepare("
      select
          id, username, pword, firstname, surname, DOB, email, datestarted
      from Customer
      where id = :id
    ");
    $s->execute(['id' => $id]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }
    $cust = new Customer($this->db);
    $cust->fromArray($row);
    return $cust;
  }

  public function byEmail($email){
    $s = $this->db->prepare("
          select
              id, pword, firstname, surname, email, datestarted
          from Manager
          where email = :email
    ");
    $s->execute(['email' => $email]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }
    $cust = new Customer($this->db);
    $cust->fromArray($row);
    return $cust;
  }

  public function save(Customer $cust){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        insert into Manager (firstname, surname, dateStarted, pword, email)
        values (:firstname, :surname, now(), :pword, :email)
    ");
    $worked = $r->execute(
      ['firstname' => $cust->getFirstname(),
       'surname' => $cust->getSurname(),
       'pword' => $cust->getPword(),
       'email' => $cust->getEmail()]
    );
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    $cust->setID($this->db->lastInsertId());
    return true;
  }
}
?>
