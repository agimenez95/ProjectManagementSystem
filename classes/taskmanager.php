<?php
class TaskManager {
  private $db;

  public function __construct(PDO $db){
    $this->db = $db;
  }

  public function save(Task $task){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        insert into Task (title, body)
        values (:title, :body)
    ");
    $worked = $r->execute(
      ['title' => $task->getTitle(),
       'body' => $task->getDescription()]
    );
    if (!$worked) {
      echo "failed";
      return false;
    }
    $task->setId($this->db->lastInsertId());
    $this->db->commit();
    // $task->setId($this->db->lastInsertId());
    // echo $this->db->lastInsertId();
    return $task;
  }

  public function associateTaskToUser($taskId, $userId) {
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        insert into User_Task (userId, taskId, progress)
        values (:userId, :taskId, :progress)
    ");
    $worked = $r->execute(
      ['userId' => $userId,
       'taskId' => $taskId,
       'progress' => "Not Started"]
    );
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    return true;
  }

  public function byId($id){
    $s = $this->db->prepare("
      select
          Task.id, Task.title, Task.body, User_Task.progress
      from Task
      inner join User_Task
      on Task.id = User_Task.taskId
      where Task.id = :id
    ");
    $s->execute(['id' => $id]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }
    $task = new Task($this->db);
    $task->fromArray($row);
    return $task;
  }

  public function allPending(){
    $tasks = [];
    $s = $this->db->prepare("
      select
          task.id, task.title, task.body, user_task.progress, user.firstname, user.surname, user.email
      from Task
      inner join user_task
      on task.id = user_task.taskId
      inner join user
      on user.id = user_task.userId
      where not user_task.progress = :completed
      order by user_task.progress desc
    ");
    $s->execute(['completed' => "Completed"]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }

    foreach ($s as $row) {
      var_dump($row['title']);
      array_push($tasks, ['taskId' => $row['id'],
                          'title' => $row['title'],
                          'description' => $row['body'],
                          'progress' => $row['progress'],
                          'firstname' => $row['firstname'],
                          'surname' => $row['surname'],
                          'email' => $row['email']]);
    }
    echo count($tasks);
    return $tasks;
  }

  public function allCompleted(){
    $tasks = [];
    $s = $this->db->prepare("
    select
        task.id, task.title, task.body, user_task.progress, user.firstname, user.surname, user.email
    from Task
    inner join user_task
    on task.id = user_task.taskId
    inner join user
    on user.id = user_task.userId
    where user_task.progress = :completed
    ");
    $s->execute(['completed' => "Completed"]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }
    foreach ($s as $row) {
      array_push($tasks, ['taskId' => $row['id'],
                          'title' => $row['title'],
                          'description' => $row['body'],
                          'progress' => $row['progress'],
                          'firstname' => $row['firstname'],
                          'surname' => $row['surname'],
                          'email' => $row['email']]);
    }
    return $tasks;
  }

  public function byUserId($id, $completed=false){
    $tasks = [];
    if ($completed) {
      $s = $this->db->prepare("
        select task.id, task.title, task.body, user_task.progress
        from Task
        inner join User_Task
        on task.id = user_task.taskId
        where (user_task.userId = :id and user_task.progress = :completed)
      ");
    } else {
      $s = $this->db->prepare("
        select task.id, task.title, task.body, user_task.progress
        from Task
        inner join User_Task
        on task.id = user_task.taskId
        where (user_task.userId = :id and not user_task.progress = :completed)
      ");
    }
    $s->execute(['id' => $id,
                 'completed' => "completed"]);
    $row = $s->fetch();
    if (!$row){
        return null;
    }
    foreach ($s as $row) {
      array_push($tasks, ['taskId' => $row['id'], 'title' => $row['title'], 'description' => $row['body'], 'progress' => $row['progress']]);

    }
    return $tasks;
  }

  public function updateProgress($userId, $taskId, $progress){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        update User_Task
        set progress = :progress
        where (userId = :userId and taskId = :taskId)
    ");
    $worked = $r->execute(
      ['userId' => $userId,
       'taskId' => $taskId,
       'progress' => $progress]
    );
    if (!$worked) {
      echo "hello";
      return false;
    }
    $this->db->commit();
    return true;
  }

  public function updateContent(Task $task){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        update Task
        set title = :title, body = :body
        where id = :taskId
    ");
    $worked = $r->execute(
      ['taskId' => $task->getId(),
       'title' => $task->getTitle(),
       'body' => $task->getDescription()]
    );
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    $_SESSION['upgraded'] = "The task has been updated.";
    return true;
  }

  public function deleteTask($taskId){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        delete from Task
        where id = :id
    ");
    $worked = $r->execute( ['id' => $taskId] );
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    return true;
  }

  public function deleteUserTask($taskId){
    $this->db->beginTransaction();
    $r = $this->db->prepare("
        delete from User_Task
        where taskId = :taskId
    ");
    $worked = $r->execute( ['taskId' => $taskId] );
    if (!$worked) {
      return false;
    }
    $this->db->commit();
    $_SESSION['upgraded'] = "The task has been deleted.";
    return true;
  }
}
?>
