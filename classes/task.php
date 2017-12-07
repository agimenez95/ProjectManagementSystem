<?php
class Task {
  private $db;
  private $id;
  private $title;
  private $description;
  private $progress;

  public function __construct(PDO $db = null){
    $this->db = $db;
  }
  public function fromArray($a){
    if (isset($a['taskId'])) {
      $this->id = $a['taskId'];
    } elseif(isset($a['id'])){
      $this->id = $a['id'];
    }
    $this->title = $a['title'];
    $this->progress = $a['progress'];
    if (isset($a['body'])) {
      $this->description = $a['body'];
    } else {
      $this->description = $a['description'];
    }

  }

  public function getTitle(){
    return $this->title;
  }

  public function getDescription(){
    return $this->description;
  }

  public function getId(){
    return $this->id;
  }

  public function setId($id){
    $this->id = $id;
  }

  public function getProgress(){
    return $this->progress;
  }

}
?>
