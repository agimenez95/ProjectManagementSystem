<?php
class UserManager {
  private $db;

  public function __construct(PDO $db){
    $this->db = $db;
  }

  // Return a user by its id.
  public function byId($id){
    $s = $this->db->prepare("
      select
          id, pword, firstname, surname, email, datestarted, isManager
      from User
      where id = :id
    ");
    $s->execute(['id' => $id]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }
    $cust = new User($this->db);
    $cust->fromArray($row);
    return $cust;
  }

  // Check if a user is a manager.
  public function isManagerById($id){
    $s = $this->db->prepare("
      select
          isManager
      from User
      where id = :id
    ");
    $s->execute(['id' => $id]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }
    return $row['isManager'];
  }

  // Retrieve a users details by its email.
  public function byEmail($email){
    $s = $this->db->prepare("
          select
              id, pword, firstname, surname, email, datestarted, isManager, disabled
          from User
          where email = :email
    ");
    $s->execute(['email' => $email]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }
    $cust = new User($this->db);
    $cust->fromArray($row);
    return $cust;
  }

  // Only get the id of the user by its email.
  public function idByEmail($email){
    $s = $this->db->prepare("
          select
              id
          from User
          where email = :email
    ");
    $s->execute(['email' => $email]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }
    $cust = new User($this->db);
    $cust->fromArray($row);
    return $cust;
  }

  // Store the users data from the registration.
  public function save(User $user){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        insert into User (firstname, surname, dateStarted, pword, email)
        values (:firstname, :surname, now(), :pword, :email)
    ");
    $worked = $r->execute(
      ['firstname' => $user->getFirstname(),
       'surname' => $user->getSurname(),
       'pword' => $user->getPword(),
       'email' => $user->getEmail()]
    );
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    $user->setID($this->db->lastInsertId());
    return true;
  }

  // The first user that will be saved onto the database will have administrator rights.
  public function saveFirst(User $user){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        insert into User (firstname, surname, dateStarted, pword, email, isManager)
        values (:firstname, :surname, now(), :pword, :email, 1)
    ");
    $worked = $r->execute(
      ['firstname' => $user->getFirstname(),
       'surname' => $user->getSurname(),
       'pword' => $user->getPword(),
       'email' => $user->getEmail()]
    );
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    $user->setID($this->db->lastInsertId());
    return true;
  }

  // Check to see if there are any users on the database.
  public function isItTheFirst(){
    $s = $this->db->prepare("
          select * from User
    ");
    $s->execute([]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }
    return $row;
  }

  // Returns a list of all of the new starters.
  public function allNewStarters(){
    $users = [];
    $r = $this->db->query("
          select * from User where isManager = 0
    ");
    if (!$r){
      return null;
    }
    foreach ($r as $row) {
      $users[$row['id']] = $row['firstname']." ".$row['surname']." - ".$row['email'];
    }
    return $users;
  }

  // Returns all of the users data.
  public function allUsers(){
    $users = [];
    $r = $this->db->query("
          select * from User
    ");
    $row = $r->fetchAll();
    if (!$row){
        return null;
    }
    return $row;
  }

  // Turns a new starter account into a manager account.
  public function upgradeUser(User $user){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        update User
        set isManager = 1
        where id = :userId
    ");
    $worked = $r->execute(
      ['userId' => $user->getId()]
    );
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    $_SESSION['upgraded'] = $user->getFirstname()." ".$user->getSurname()." - ".$user->getEmail()." is now a manager account.";
    return true;
  }

  // Counts how many users there are that are not managers.
  public function notManager() {
    $r = $this->db->query("
          select count(id) from User where isManager = 0
    ");
    if (!$r){
      return null;
    }
    $row = $r->fetch();
    return $row['count(id)'];
  }

  // This will disable an account but it will not delete it as it will still be associated to completed tasks.
  public function disableUserById($id) {
    $this->db->beginTransaction();
    $r = $this->db->prepare("
      update User
      set disabled = 1
      where id = :id
    ");
    $worked = $r->execute(['id' => $id]);
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    $_SESSION['upgraded'] = "The user has been disabled.";
    return true;
  }
}
?>
